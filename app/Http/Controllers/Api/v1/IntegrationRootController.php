<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\IntegrationService;
use App\Services\ApiTypeService;
use App\Services\UserService;
use App\Models\ApiEndpointField;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ApiField;

class IntegrationRootController extends Controller
{
    private $integrationService;
    private $apiTypeService;
    private $userService;

    function __construct(){
        $this->integrationService =  new IntegrationService();
        $this->apiTypeService = new ApiTypeService();
        $this->userService  = new UserService();;
    }

    public function create(Request $request){
        try{
            $request->validate([
                'url' => 'required|url',
                'user_id' => 'required',
                'name'  => 'required',
                'price'  => 'required',
                'image'  => 'required',
                'supplier'  => 'nullable',
                'promotion'  => 'nullable',
                'delivery'  => 'nullable',
                'address'  => 'nullable',
                'description'  => 'required',
            ]);

            $data = $request->all();
            $user = $this->userService->findByIdOrUuid($data['user_id']);

            $apiEndpoint = $this->integrationService->createApiEndpoint($data);
            $apiType = $this->apiTypeService->findApiTypeProductOrFail();

            $this->createApiEndpointField($apiEndpoint, $apiType, "name", $request->name);
            $this->createApiEndpointField($apiEndpoint, $apiType, "price", $request->price);
            $this->createApiEndpointField($apiEndpoint, $apiType, "photo", $request->image);
            $this->createApiEndpointField($apiEndpoint, $apiType, "supplier", $request->supplier ?? $user->name);
            if(isset($request->promotion)) $this->createApiEndpointField($apiEndpoint, $apiType, "promotion", $request->promotion);
            if(isset($request->delivery)) $this->createApiEndpointField($apiEndpoint, $apiType, "delivery", $request->delivery);
            if(isset($request->address)) $this->createApiEndpointField($apiEndpoint, $apiType, "address", $request->address);
            $this->createApiEndpointField($apiEndpoint, $apiType, "description", $request->description);

            return response()->json([], 200);
        }catch(\Exception $e){
            return response()->json([], 409);
        }
    }

    private function createApiEndpointField($apiEndpoint, $apiType, $fieldCode, $value){
       $field = ApiField::where('api_type_id', $apiType->id)->where('name', $fieldCode)->first();

       $data = [ 'api_endpoint_id' => $apiEndpoint->id , 'api_field_id' => $field->id ];

       $apiEndpointField = ApiEndpointField::where($data)->first();

       if(isset($apiEndpointField->id)){
            $apiEndpointField->update([ "name" => $value ]);
            return;
       }

       ApiEndpointField::create(array_merge($data, [
            "name" => $value, "uuid" => Str::uuid()->toString(),
       ]));

    }
}
