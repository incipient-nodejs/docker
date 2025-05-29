<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ApiEndpoint;
use App\Models\ApiType;
use App\Models\User;

use Carbon\Carbon;

class ApiEndpointSeeder extends Seeder
{
    public const API_ENTERPRISE_MDB_STORE = [
        'url' => 'https://mdb-store.bitkabir.com/search',
        'query_parm' => 'q',
        'method_http' => 'GET',
        'authentication_type' => 'FREE',
        'api_type_code' => 'product',
    ];

    public const API_CELEIRO_DE_LUANDA = [
        'url' => 'https://celeirodeluanda.net/wp-json/wc-api-connector/v1/products',
        'method_http' => 'GET',
        'authentication_type' => 'FREE',
        'api_type_code' => 'product',
    ];

    public const API_SHOPIFY = [
        'url' => 'http://192.168.1.10/shopify_api.php?shop=zbfqdt-q7.myshopify.com',
        'method_http' => 'GET',
        'authentication_type' => 'FREE',
        'pagination_items' => "products",
        'api_type_code' => 'product',
    ];

    public const ITEMS = [
        self::API_ENTERPRISE_MDB_STORE,
        self::API_CELEIRO_DE_LUANDA,
        self::API_SHOPIFY
    ];

    public function run()
    {
        $users = User::inRandomOrder()->take(6)->get();
        $apiTypes = ApiType::all()->keyBy('code');

        foreach (self::ITEMS as $item) {
            $data = array_merge($item, [
                'api_type_id' => $apiTypes[$item['api_type_code']]->id ?? null,
                'uuid' => Str::uuid()->toString(),
            ]);
            $data['user_id'] = $users->random()->id;
            unset($data['api_type_code']);
            ApiEndpoint::updateOrCreate( ['url' => $item['url']], $data );
        }
    }
}
