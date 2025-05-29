<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiField extends Model
{
    const TABLE = "api_fields";

    protected $table = ApiField::TABLE;

    public function apiType(){
        return $this->belongsTo(ApiType::class);
    }
}
