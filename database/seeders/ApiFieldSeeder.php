<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\ApiField;
use App\Models\ApiType;

class ApiFieldSeeder extends Seeder
{
    public const API_FIELD_PRODUCT_NAME = [
        'name' => 'name', 'description' => 'Produto nome', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_PHONE = [
        'name' => 'phone', 'description' => 'Produto contacto', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_PRICE = [
        'name' => 'price', 'description' => 'Produto preço', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_CATEGORY = [
        'name' => 'category',  'description' => 'Produto categoria', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_SUPPLIER = [
        'name' => 'supplier', 'description' => 'Produto fornecedor', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_LINK = [
        'name' => 'link', 'description' => 'Link de redirecionamento do produto', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_PHOTO = [
        'name' => 'photo', 'description' => 'Imagem do produto', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_WEBSITE = [
        'name' => 'website', 'description' => 'Link do website do produto', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_LATITUDE = [
        'name' => 'latitude', 'description' => 'Latitude da empresa que tem o produto', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_LONGITUDE = [
        'name' => 'longitude', 'description' => 'Longitude da empresa que tem o produto', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_RATING = [
        'name' => 'rating', 'description' => 'Avaliação do produto', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_PROMOTION = [
        'name' => 'promotion', 'description' => 'Produto em promoção', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_ADDRESS = [
        'name' => 'address', 'description' => 'Produto em endereço', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_EMAIL = [
        'name' => 'email', 'description' => 'Produto email de contacto', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_DELIVERY = [
        'name' => 'delivery', 'description' => 'Se o produto tem entrega', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_MARKET = [
        'name' => 'market', 'description' => 'O mercado que o produto pertence', 'api_type' => 'PRODUCT',
    ];

    public const API_FIELD_PRODUCT_DESCRIPTION = [
        'name' => 'description', 'description' => 'Produto em descrição', 'api_type' => 'PRODUCT',
    ];

    public const ITEMS = [
         /* API of product */
        self::API_FIELD_PRODUCT_NAME,
        self::API_FIELD_PRODUCT_PHONE,
        self::API_FIELD_PRODUCT_PRICE,
        self::API_FIELD_PRODUCT_CATEGORY,
        self::API_FIELD_PRODUCT_SUPPLIER,
        self::API_FIELD_PRODUCT_LINK,
        self::API_FIELD_PRODUCT_PHOTO,
        self::API_FIELD_PRODUCT_WEBSITE,
        self::API_FIELD_PRODUCT_LATITUDE,
        self::API_FIELD_PRODUCT_LONGITUDE,
        self::API_FIELD_PRODUCT_RATING,
        self::API_FIELD_PRODUCT_PROMOTION,
        self::API_FIELD_PRODUCT_ADDRESS,
        self::API_FIELD_PRODUCT_EMAIL,
        self::API_FIELD_PRODUCT_DELIVERY,
        self::API_FIELD_PRODUCT_MARKET,
        self::API_FIELD_PRODUCT_DESCRIPTION,
    ];

    public function run()
    {
        $apiTypes = ApiType::all()->keyBy('code');

        foreach (self::ITEMS as $item) {
            ApiField::updateOrCreate(
                ['name' => $item['name'], 'api_type_id' => $apiTypes[  strtolower($item['api_type']) ]->id ?? null],
                [
                 'code_api_type' => $apiTypes[ strtolower($item['api_type']) ]->code ?? null,
                 'description' => $item['description'],
                 'uuid' => Str::uuid()->toString(),
                 ]
            );
        }
    }
}
