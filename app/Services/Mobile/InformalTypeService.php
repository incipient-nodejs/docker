<?php

namespace App\Services\Mobile;

use App\Util\Auditor;
use App\Models\User;
use App\Models\InformalType;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Services\BusinessDetailService;
use App\Services\PersonalDataService;
use App\Services\UserTypeService;
use App\Services\UserService;
use App\Util\FileUpload;

class InformalTypeService
{
    private $userService;
    private $companyDataService;
    private $businessDetailService;
    private $userTypeService;

    function __construct(){
        $this->userService =  new UserService();
        $this->userTypeService = new UserTypeService();
        $this->companyDataService = new PersonalDataService();
        $this->businessDetailService = new BusinessDetailService();
    }

    public function create($request, array $data): User
    {
        try {

            $user = $this->userService->findByIdOrUuid($data['user_id']);
            $data = $this->requestData($user, $data);

            $informalType = InformalType::where(array_merge(['user_id' => $user->id], Auditor::filter()))->first();

            FileUpload::uploadDocInformalData($request, $data);
            $data['concat'] = ($data['name'] ?? '' ).($data['nif'] ?? '' ).($data['phone'] ?? '' ).($data['whatsapp'] ?? '' );

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

            if(isset($informalType->id)){
                $informalType = InformalType::updateOrCreate(['user_id' => $user->id],Auditor::create($fields));
            }
            else{
                $informalType = InformalType::create(Auditor::create($fields));
            }

            $dataPerson = [
                'user_id' => $user->id,
                'uuid' => $informalType->uuid,
                'name' => $data['name'] ?? $user->name,
                'full_name' => $data['name'] ?? $user->name,
                'nif_bi' => $data['nif'],
                'phone' => $data['phone'] ?? $user->phone,
                'latitude' => $data['latitude'] ?? null,
                'longitude'  => $data['longitude'] ?? null,
                'location' => $data['location'] ?? null,
            ];
            if(isset($request->certification)) {
                $dataPerson['certification'] = $data['certification'];
            }

            $user->personalData()->updateOrCreate(['user_id' => $user->id ], $dataPerson);

            $dataBusinessDetail = [
                'uuid' => $informalType->uuid,
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

            $userType = $this->userTypeService->findUserTypeInformalOrCreate();

            $user->update([
                'user_type_id' => $userType->id,
                'name' => $data['name'] ?? $user->name,
                'category' => $data['category'] ?? null
            ]);

             if(isset($user->businessDetail->id) || isset($user->informalType->id)) return $user;

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
