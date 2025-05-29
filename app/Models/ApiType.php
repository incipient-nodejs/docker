<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiType extends Model
{
    const TABLE = "api_types";

    protected $fillable = [
        'code',
        'name',
        'description',
        'deleted_at',
        'deleted_by',
    ];

    public function apiEndpoints(){
        return $this->hasMany(ApiEndpoint::class);
    }

    public function apiFields(){
        return $this->hasMany(ApiField::class);
    }
}
