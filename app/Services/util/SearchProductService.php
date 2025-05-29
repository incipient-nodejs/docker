<?php

namespace App\Services\Util;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\ApiEndpoint;
use App\Models\Product;
use App\Models\Log;
use App\Util\Auditor;
use App\Services\ProductService;

class SearchProductService
{

    function __construct(){
        $this->productService = new ProductService();
    }

    public function search(Request $request, $text)
    {
        $array = [];

        try {
            $apiEndpoints = ApiEndpoint::with(
                'apiType.apiFields', 'apiEndpointFields',
                'user.personalData', 'user.companyData',
                'user.businessDetail'
            )
            ->where(Auditor::filter())
            //->where('id', 3)
            ->limit(100)
            ->get();

            foreach ($apiEndpoints as $item) {
                $array = array_merge($array, $this->getRequest($request, $item, $text));
            }

            $query = $this->productService->search($text)->items();

            $products = array_merge($query, $array);

            $page = request()->get('page', 1);
            $perPage = 100;
            $offset = ($page - 1) * $perPage;

            $paginatedItems = array_slice($products, $offset, $perPage);


            $paginator = new LengthAwarePaginator($paginatedItems, count($products), $perPage, $page, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);

            return $paginator;

        } catch (\Exception $e) {
            Log::create([
                'source' => 'laravel',
                'event_type' => 'search_failed',
                'message' => "Erro ao buscar produtos: " . $e->getMessage(),
                'ip_address' => request()->ip()
            ]);

            throw $e;
        }
    }

    private function getRequest(Request $request, ApiEndpoint $apiEndpoint, $search)
    {
        $url = $apiEndpoint->url;
        if (isset($apiEndpoint->query_parm)) {
            $url .= "?{$apiEndpoint->query_parm}={$search}";
        }

        $response = null;
        try {
            switch (strtoupper($apiEndpoint->method_http)) {
                case "GET":
                    $response = Http::get($url);
                    break;
                case "POST":
                    $response = Http::post($url);
                    break;
            }

            if (!isset($response)) return [];

            if ($response->successful()) {
                $data = $response->object();

                if (is_array($data)) {
                    return $this->buildItems($request, $apiEndpoint, $search, $data);
                }

                if (isset($data->{$apiEndpoint->pagination_items})) {
                    return $this->buildItems($request, $apiEndpoint, $search, $data->{$apiEndpoint->pagination_items});
                }

                return [];
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    private function buildItems(Request $request, ApiEndpoint $apiEndpoint, $search, $data)
    {

        try {
            $items = [];
            $fields = $apiEndpoint->apiType->apiFields;
            $apiEndpointFields = $apiEndpoint->apiEndpointFields;

            foreach ($data as $item) {
                $it = ['concat' => ''];
                foreach ($fields as $field) {
                    $it[$field->name] = $this->getItem($apiEndpointFields, $field, $item);
                    $it['concat'] .= $it[$field->name];
                }

                if (str_contains(strtolower($it['concat']), strtolower($search))) {
                    $product = new Product([
                        "name" => $it['name'],
                        "image" => $it['photo'],
                        "price" => $it['price'],
                        "user_id" => $it['user_id'] ?? null,
                        "category_id" => $it['category_id'] ?? null,
                        "concat" => $it['concat'],
                    ]);
                    $product->user = $apiEndpoint->user;
                    array_push($items, $product);
                }
            }

            Log::create([
                'source' => 'external_api',
                'event_type' => 'api_response_processing',
                'message' => "Itens processados após requisição à API externa para busca por '{$search}'.",
                'ip_address' => request()->ip()
            ]);

            return $items;
        } catch (\Exception $e) {
            Log::create([
                'source' => 'external_api',
                'event_type' => 'api_response_processing_failed',
                'message' => "Erro ao processar itens da API externa: " . $e->getMessage(),
                'ip_address' => request()->ip()
            ]);

            throw $e;
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
