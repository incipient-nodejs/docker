<?php

namespace App\Services;

use App\Module\Product\Services\ProductApiService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\ApiEndpoint;
use App\Models\Log;
use App\Util\Auditor;

class ApiSyncProductService
{

    function __construct(){
        $this->productApiService = new ProductApiService();
    }

    public function getProduct()
    {
        $apiEndpoints = ApiEndpoint::with(
            'user.personalData', 'user.companyData', 'user.businessDetail',
            'apiType.apiFields', 'apiEndpointFields',
        )->where(Auditor::filter())->limit(100)->get();

        foreach ($apiEndpoints as $item) {
            $this->getRequest($item);
        }
    }

    private function requestUrl($apiEndpoint){
        try{
            $url = $apiEndpoint->url;
            switch (strtoupper($apiEndpoint->method_http)) {
                case "GET":
                    return Http::get($url);
                case "POST":
                    return Http::post($url);
            }
        }catch(\Exception){
            return null;
        }
    }

    private function getRequest(ApiEndpoint $apiEndpoint)
    {
        $response = $this->requestUrl($apiEndpoint);
        if (!isset($response)) return false;

        if ($response->successful()) {

            $data = $response->object();

            if (is_array($data)) return $this->buildItems($apiEndpoint, $data);

            if (isset($data->{$apiEndpoint->pagination_items}))
                return $this->buildItems($apiEndpoint, $data->{$apiEndpoint->pagination_items});

            return false;
        }

        return false;
    }

    private function buildItems(ApiEndpoint $apiEndpoint, $data)
    {

        try {
            $items = [];
            $fields = $apiEndpoint->apiType->apiFields;
            $apiEndpointFields = $apiEndpoint->apiEndpointFields;

            foreach ($data as $item) {
                $it = ['concat' => ''];
                foreach ($fields as $field) {
                    $it[$field->name] = $this->getItem($apiEndpointFields, $field, $item);
                }

                $it['concat'] = $it['name'] . ($it['price'] ?? '') ;

                $item = $this->productApiService->save([
                    "name" => $it['name'],
                    "photo" => $it['photo'],
                    "price" => $it['price'],
                    "phone" => $it['phone'] ?? null,
                    "category" => $it['category'] ?? null,
                    "supplier" => $it['supplier'] ?? null,
                    "link" => $it['link'] ?? null,
                    "website" => $it['website'] ?? null,
                    "latitude" => $it['latitude'] ?? null,
                    "longitude" => $it['longitude'] ?? null,
                    "rating" => $it['rating'] ?? null,
                    "promotion" => $it['promotion'] ?? false,
                    "address" => $it['address'] ?? null,
                    "email" => $it['email'] ?? null,
                    "delivery" => $it['delivery'] ?? false,
                    "market" => $it['market'] ?? null,
                    "description" => $it['description'] ?? null,
                    "user_id" => $apiEndpoint->user->id,
                    "api_endpoint_id" => $apiEndpoint->id,
                ]);

            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getItem($apiEndpointFields, $field, $item)
    {
        foreach ($apiEndpointFields as $apiEndpointField) {
            if ($apiEndpointField->api_field_id == $field->id) {
                $fieldName = $apiEndpointField->name;

                if (preg_match('/^(\w+)\[(\d+)\](\w+)$/', $fieldName, $matches)) {
                    $arrayName = $matches[1];
                    $index = (int) $matches[2] - 1;
                    $attribute = $matches[3];

                    if (isset($item->$arrayName[$index]) && isset($item->$arrayName[$index]->$attribute)) {
                        return $item->$arrayName[$index]->$attribute;
                    }

                    return '';
                }

                if (preg_match('/^(\w+)\.(\w+)$/', $fieldName, $matches)) {
                    $objectName = $matches[1];
                    $attribute = $matches[2];

                    if (isset($item->$objectName) && isset($item->$objectName->$attribute)) {
                        return $item->$objectName->$attribute;
                    }
                    return '';
                }

                return $item->{$fieldName} ?? '';
            }
        }
        return "";
    }

}
