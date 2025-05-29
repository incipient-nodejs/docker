<?php

namespace App\Module\Product\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;

class ProductApi extends Model
{
    protected $connection = 'mysql_product_api';

    protected $table = "products_api";

    protected $fillable = [
        'id',
        'name',
        'phone',
        'price',
        'category',
        'supplier',
        'link',
        'photo',
        'website',
        'latitude',
        'longitude',
        'rating',
        'promotion',
        'address',
        'email',
        'delivery',
        'market',
        'description',
        'user_id',
        'api_endpoint_id',
        'created_at',
        'updated_at',
    ];

    function toProduct(): Product {
        return new Product([
            'id' => $this->id ?? 0,
            'name' => $this->name ?? '',
            'image' => $this->photo ?? '',
            'description' => $this->description ?? '',
            'price' => $this->price ?? '',
            'user_id' => $this->user_id ?? '',
            'category_id' => $this->category ?? '',
            'address' => $this->address ?? '',
            'rating' => $this->rating ?? '',
            'created_at'  => $this->created_at ?? now(),
            'updated_at' => $this->updated_at ?? now(),
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
