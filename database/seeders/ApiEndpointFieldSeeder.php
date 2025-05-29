<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApiEndpointField;
use Illuminate\Support\Str;
use App\Models\ApiEndpoint;
use App\Models\ApiField;
use Carbon\Carbon;

class ApiEndpointFieldSeeder extends Seeder
{
    public function run()
    {
        // Obter os ApiFields e ApiEndpoints correspondentes
        $apiFields = ApiField::all();
        $apiEndpoints = ApiEndpoint::all();

        $data = collect([
            ['name' => 'name', 'api_field' => 'PRODUCT_NAME', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'price', 'api_field' => 'PRODUCT_PRICE', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'phone', 'api_field' => 'PRODUCT_PHONE', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'link', 'api_field' => 'PRODUCT_LINK', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'website', 'api_field' => 'PRODUCT_WEBSITE', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'latitude', 'api_field' => 'PRODUCT_LATITUDE', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'longitude', 'api_field' => 'PRODUCT_LONGITUDE', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'photo', 'api_field' => 'PRODUCT_PHOTO', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'supplier', 'api_field' => 'PRODUCT_SUPPLIER', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'promotion', 'api_field' => 'PRODUCT_PROMOTION', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'category', 'api_field' => 'PRODUCT_CATEGORY', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'delivery', 'api_field' => 'PRODUCT_DELIVERY', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'rating', 'api_field' => 'PRODUCT_RATING', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'address', 'api_field' => 'PRODUCT_ADDRESS', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],
            ['name' => 'market', 'api_field' => 'PRODUCT_MARKET', 'url' => ApiEndpointSeeder::API_ENTERPRISE_MDB_STORE['url'] ],

            ['name' => 'name', 'api_field' => 'PRODUCT_NAME', 'url' => ApiEndpointSeeder::API_CELEIRO_DE_LUANDA['url'] ],
            ['name' => 'price', 'api_field' => 'PRODUCT_PRICE', 'url' => ApiEndpointSeeder::API_CELEIRO_DE_LUANDA['url'] ],
            ['name' => 'description', 'api_field' => 'PRODUCT_DESCRIPTION', 'url' => ApiEndpointSeeder::API_CELEIRO_DE_LUANDA['url'] ],
            ['name' => 'image_url', 'api_field' => 'PRODUCT_PHOTO', 'url' => ApiEndpointSeeder::API_CELEIRO_DE_LUANDA['url'] ],

            ['name' => 'title', 'api_field' => 'PRODUCT_NAME', 'url' => ApiEndpointSeeder::API_SHOPIFY['url'] ],
            ['name' => 'variants[1]price', 'api_field' => 'PRODUCT_PRICE', 'url' => ApiEndpointSeeder::API_SHOPIFY['url'] ],
            ['name' => 'body_html', 'api_field' => 'PRODUCT_DESCRIPTION', 'url' => ApiEndpointSeeder::API_SHOPIFY['url'] ],
            ['name' => 'image.src', 'api_field' => 'PRODUCT_PHOTO', 'url' => ApiEndpointSeeder::API_SHOPIFY['url'] ],

        ]);

        foreach ($apiEndpoints as $apiEndpoint){
            $fields = $data->filter(function($it) use ($apiEndpoint){
                return $it['url'] == $apiEndpoint->url;
            })->all();

            foreach ($fields as $item) {
                $produt_fields = explode("_", strtolower($item['api_field']));
                $apiField = $apiFields->where('name', $produt_fields[1])->where('code_api_type', $produt_fields[0])->first();
                if ($apiField && $apiEndpoint) {
                    ApiEndpointField::updateOrCreate([
                        'name' => $item['name'], 'api_endpoint_id' => $apiEndpoint->id, 'api_field_id' => $apiField->id
                    ], [
                        'name' => $item['name'], 'updated_at' => now(), 'uuid' => Str::uuid()->toString(),
                    ]);
                }
            }
        }
    }
}
