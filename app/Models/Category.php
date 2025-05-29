<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const TABLE = "categories";

    protected $table = Category::TABLE;

    protected $fillable = [
        'id',
        'uuid',
        'code',
        'name',
        'icon',
        'type',
        'order',
        'description',
        'concat',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by',
    ];

    protected function products(){
        return $this->hasMany(Product::class)->where('type', 'product');
    }

    protected function services(){
        return $this->hasMany(Service::class)->where('type', 'service');
    }

}
