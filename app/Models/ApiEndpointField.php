<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiEndpointField extends Model
{
    const TABLE = "api_endpoint_fields";

    protected $table = ApiEndpointField::TABLE;

    protected $fillable = [
        'name',
        'uuid',
        'api_endpoint_id',
        'api_field_id'
    ];

    public function apiEndpoint(){
        return $this->belongsTo(ApiEndpoint::class);
    }
}
