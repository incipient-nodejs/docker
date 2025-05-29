<?php

namespace App\Services\Util;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\ApiEndpointField;
use App\Models\ApiEndpoint;
use App\Models\ApiField;
use App\Util\Auditor;
use App\Models\User;
use App\Services\UserService;

class IntegrationService
{

    private $integrationService;
    private $apiTypeService;
    private $userService;

    function __construct(){
        $this->apiTypeService = new ApiTypeService();
        $this->userService = new UserService();
    }

    function createApiEndpoint($data){

      $apiType =  $this->apiTypeService->findApiTypeProductOrFail();
      $user =  $this->userService->findByIdOrUuid($data['user_id']);

      $apiEndpoint = ApiEndpoint::where('url', $data['url'])->first();
      if(isset($apiEndpoint->id)) return $apiEndpoint;

      return  ApiEndpoint::create([
            'url' => $data['url'],
            'user_id' => $user->id,
            'api_type_id' => $apiType->id,
            'authentication_type' => 'FREE',
            'uuid' => Str::uuid()->toString(),
            'method_http' => $data['method'] ?? 'GET',
            'pagination_items' => $data['paginate'] ?? null,
        ]);
    }

    function request($request, $fields){
        try{
            $apiEndpoint = $this->createApiEndpoint($request->all());

            $apiFields = ApiField::all();

            foreach ($fields as $item) {
                $produt_fields = explode("_", strtolower($item['api_field']));
                $apiField = $apiFields->where('name', $produt_fields[1])->where('code_api_type', $produt_fields[0])->first();

                if ($apiField && $apiEndpoint) {

                    $apiEndpointField = ApiEndpointField::where(['name' => $item['name'], 'api_endpoint_id' => $apiEndpoint->id, 'api_field_id' => $apiField->id])->first();

                    if(!isset($apiEndpointField->id)){
                        ApiEndpointField::create([
                            'name' => $item['name'], 'api_endpoint_id' => $apiEndpoint->id, 'api_field_id' => $apiField->id, 'uuid' => Str::uuid()->toString(),
                        ]);
                    }else{
                        $apiEndpointField->update([ 'name' => $item['name'] ]);
                    }
                }

            }
            return response()->json([], 200);
        }catch(\Exception $e){
            return response()->json([], 409);
        }
    }

}
