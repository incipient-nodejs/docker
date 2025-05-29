<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyData extends Model
{
    const TABLE = "company_data";

    protected $table = CompanyData::TABLE;

    protected $fillable = [
        'uuid',
        'name',
        'nif',
        'location',
        'image_url',
        'latitude',
        'longitude',
        'tipo_contacto',
        'contacto',
        'certification',
        'counter_view',
        'user_id',
        'concat',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
