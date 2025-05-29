<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    const TABLE = "products";

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'image',
        'image_traseiro',
        'image_esquerda',
        'image_direita',
        'video',
        'description',
        'price',
        'user_id',
        'category_id',
        'concat',
        'address',
        'min_qtd',
        'rating',
        'rated_user_count',
        'counter_view',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function ratingProducts(){
        return $this->hasMany(RatingProduct::class);
    }

    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }

    public function favorites(): BelongsTo{
        return $this->belongsTo(Favorite::class);
    }

}
