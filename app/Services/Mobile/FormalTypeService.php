<?php

namespace App\Services\Mobile;

use App\Util\Auditor;
use App\Models\User;
use App\Models\FormalType;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Services\BusinessDetailService;
use App\Services\CompanyDataService;
use App\Services\UserTypeService;
use App\Services\UserService;
use App\Util\FileUpload;

class FormalTypeService
{
    private $userService;
    private $companyDataService;
    private $businessDetailService;
    private $userTypeService;

    function __construct(){
        $this->userService =  new UserService();
        $this->userTypeService = new UserTypeService();
        $this->companyDataService = new CompanyDataService();
        $this->businessDetailService = new BusinessDetailService();
    }

    public function create($request, array $data): User
    {
        try {

            $user = $this->userService->findByIdOrUuid($data['user_id']);

            $data = $this->requestData($user, $data);

            $formalType = FormalType::where(array_merge(['user_id' => $user->id], Auditor::filter()))->first();

            $data['concat'] = ($data['name'] ?? '' ).($data['nif'] ?? '' ).($data['phone'] ?? '' ).($data['whatsapp'] ?? '' );

            FileUpload::uploadDocFormalData($request, $data);

            $user->personalData()->updateOrCreate(['user_id' => $user->id ], [
                'uuid' => $user->uuid,
                'name' => $request->personName  ?? $user->name,
                'full_name' => $request->personName  ?? $user->name,
                'nif_bi' => $request->personNif  ?? $data['nif'] ?? '',
                'phone' => $request->personPhone  ?? $data['phone'] ?? $user->phone,
                'image' => $data['docs'] ?? $user->image ?? '',
            ]);

            $fields = [
                'user_id' => $user->id,
                'name' => $data['name'] ?? $user->name,
                'nif' => $data['nif'] ?? '',
                'docs' => $data['docs'] ?? '',
                'website'  => $data['website'] ?? '',
                'whatsapp'  => $data['whatsapp'] ?? '',
                'phone'  => $data['phone'] ?? '',
                'offers' => $data['offers'] ?? '',
                'concat' => $data['concat'] ?? ''
            ];

            if(isset($formalType->id))
                $formalType = FormalType::updateOrCreate(['user_id' => $user->id], Auditor::create($fields));
            else
                $formalType = FormalType::create(Auditor::create($fields));

            FileUpload::uploadImageUrlCompanyData($request, $data, $user->companyData ?? null);

            $dataCompany = [
                'user_id' => $user->id,
                'uuid' => $formalType->uuid,
                'name' => $data['name'] ?? $user->name,
                'nif' => $data['nif'],
                'image_url' => $data['image_url'] ?? null,
                'certification' => $data['docs'] ?? '',
                'latitude' => $data['latitude'] ?? null,
                'longitude'  => $data['longitude'] ?? null,
                'tipo_contacto'  => $data['tipo_contacto'] ?? null,
                'contacto'  => $data['contacto'] ?? null,
                'location' => $data['location'] ?? null,
            ];

            if(isset($request->certification)) {
                $dataCompany['certification'] = $data['docs'] ?? '';
            }

            $user->companyData()->updateOrCreate(['user_id' => $user->id ], $dataCompany);

            $dataBusinessDetail = [
                'uuid' => $formalType->uuid,
                'phone' => $user->phone,
                'user_id' => $user->id,
                'phone_preference' => $data['whatsapp'] ?? $user->phone,
                'whatsapp' => $data['whatsapp'] ?? $user->phone,
                'email' => $data['email'] ?? $user->email ?? '',
                'category' => $data['offers'] ?? ""
            ];

            if(isset($data['offers'])){  $dataBusinessDetail['is_sell_product'] =  $data['offers'] == 'Produtos'; }
            if(isset($data['website'])){ $dataBusinessDetail['website_url'] = $data['website']; }

            $user->businessDetail()->updateOrCreate(['user_id' => $user->id ], $dataBusinessDetail);

            $userType = $this->userTypeService->findUserTypeFormalOrCreate();

            $user->update([
                'user_type_id' => $userType->id,
                'category' => $data['category'] ?? null
            ]);

             if(isset($user->businessDetail->id) || isset($user->formalType->id)) return $user;

             return $this->userService->findByIdOrUuid($data['user_id']);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function requestData($user, $data)
    {
        if (!isset($data['name'])) $data['name'] = $user->name;
        if (!isset($data['phone'])) $data['phone'] = $user->phone;
        if (!isset($data['whatsapp'])) $data['whatsapp'] = $user->phone;

        $data['concat'] = $data['name'].$data['phone'].$data['whatsapp'];
        $data['user_id'] = $user->id;

        if (isset($data['website'])) $data['concat'] .= $data['website'];
        if (isset($data['offers'])) $data['concat'] .= $data['offers'];

        return $data;
    }

}
