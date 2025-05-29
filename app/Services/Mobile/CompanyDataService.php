<?php

namespace App\Services\Mobile;

use App\Util\Auditor;
use App\Models\CompanyData;
use App\Models\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Util\FileUpload;

class CompanyDataService
{
    private $userService;
    private $companyDataService;

    function __construct(){
        $this->userService = new \App\Services\UserService();
        $this->companyDataService = new \App\Services\CompanyDataService();
    }

    function updateMobile($request, $data){
        $user = $this->userService->findByIdOrUuid($data['user_id']);
        FileUpload::uploadImageUser($request, $data, $user->companyData);

        // if(isset($data['image'])) $user->update([ 'image' => $data['image'] ]);

        $formalType = $user->formalType;
        $companyData = $user->companyData;

        // formal type
        if(isset($formalType->id)){
            $user->formalType->update([
                'nif' => $data['personalNif'] ?? $formalType->nif,
                'offers' => $data['category'] ?? $formalType->offers,
                'website' => $data['website'] ?? $formalType->website,
                'whatsapp' => $data['contact'] ?? $formalType->whatsapp,
            ]);
        }

        if(isset($companyData->id)){

            if (!empty($companyData->image_url)) {
                if(isset($data['image_url_remove']) && $data['image_url_remove'] == "true"){

                    $relativePath = str_replace(url('/storage') . '/', '', $companyData->image_url);

                    if (\Storage::exists($relativePath)) {
                        \Storage::delete($companyData->image_url);
                    }
                    $companyData->update(['image_url' => null]);
                }
            }

            FileUpload::uploadCertificationCompanyData($request, $data, $user->companyData);

            $dataRequest = [
                'name' => $data['companyName'] ?? $companyData->name,
                'location' => $data['address'] ?? $companyData->location,
                'latitude' => $data['latitude'] ?? $companyData->latitude,
                'longitude' => $data['longitude'] ?? $companyData->longitude,
                'nif' => $data['nif'] ?? $companyData->nif,
                'tipo_contacto' => $data['contactMethod'] ??$companyData->tipo_contacto,
            ];

            if(isset($data['image_url'])){
                FileUpload::uploadImageUrlCompanyData($request, $data, $user->companyData);
                $dataRequest['image_url'] = $data['image_url'];
            }

            $user->companyData->update($dataRequest);

            return $user;
        }

        // informal type
        $informalType = $user->informalType;
        $personalData = $user->personalData;

        if(isset($informalType->id)){
            $user->informalType->update([
                'nif' => $data['nif'] ?? $informalType->nif,
                'offers' => $data['category'] ?? $informalType->offers,
                'website' => $data['website'] ?? $informalType->website,
                'whatsapp' => $data['contact'] ?? $informalType->whatsapp,
            ]);
        }

        if(isset($personalData->id)){
            if (!empty($personalData->image) && $data['image_remove'] == "true") {
                $relativePath = str_replace(url('/storage') . '/', '', $personalData->image);

                if (\Storage::exists($relativePath)) {
                    \Storage::delete($personalData->image);
                }
                $personalData->update(['image' => null]);
            }

            $dataRequest = [
                'name' => $data['companyName'] ?? $personalData->name,
                'location' => $data['address'] ?? $personalData->location,
                'latitude' => $data['latitude'] ?? $personalData->latitude,
                'longitude' => $data['longitude'] ?? $personalData->longitude,
                'nif_bi' => $data['personalNif'] ?? $personalData->nif_bi,
                'tipo_contacto' => $data['contactMethod'] ??$personalData->tipo_contacto,
            ];

            if(isset($data['image'])){
                FileUpload::uploadImageUrlPersonalData($request, $data, $user->personalData);
                $dataRequest['image'] = $data['image'];
            }
            $user->personalData->update($dataRequest);

            return $user;
        }
        return $user;
    }

}
