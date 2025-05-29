<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ApiType;

class ApiTypeSeeder extends Seeder
{
    public const API_TYPE_PRODUCT = [
        'code' => 'product',
        'name' => 'Produto',
        'description' => 'Estrutura de retorno de uma API de produto',
    ];

    public const API_TYPE_SERVICE = [
        'code' => 'service',
        'name' => 'Serviço',
        'description' => 'Estrutura de retorno de uma API de serviço',
    ];

    public const ITEMS = [
        self::API_TYPE_PRODUCT,
        //self::API_TYPE_SERVICE,
    ];

    public function run()
    {
        foreach (self::ITEMS as $item) {
            $data = array_merge($item, ['uuid' => Str::uuid()->toString(),]);
            ApiType::updateOrCreate(['code' => $item['code'], 'name' => $item['name'] ], $data);
        }
    }
}
