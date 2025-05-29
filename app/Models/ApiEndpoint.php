<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiEndpoint extends Model
{
    const TABLE = "api_endpoints";

    protected $table = ApiEndpoint::TABLE;

    protected $fillable = [
        'url',
        'uuid',
        'api_type_id',
        'user_id',
        'authentication_type',
        'method_http',
        'query_parm',
        'pagination_items',
        'deleted_at',
        'deleted_by',
    ];

    public function apiType(){
        return $this->belongsTo(ApiType::class);
    }

    public function apiEndpointFields(){
        return $this->hasMany(ApiEndpointField::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
