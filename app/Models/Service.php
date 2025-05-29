<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    const TABLE = "services";

    protected $table = Service::TABLE;

    protected $fillable = [
        'uuid',
        'name',
        'image',
        'video',
        'description',
        'rating',
        'rated_user_count',
        'address',
        'user_id',
        'concat',
        'category_id',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
