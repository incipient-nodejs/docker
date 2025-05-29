<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    const TABLE = "personal_data";

    protected $table = PersonalData::TABLE;

    protected $fillable = [
        'uuid',
        'name',
        'full_name',
        'nif_bi',
        'phone',
        'image',
        'user_id',
        'tipo_contacto',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by',
        'longitude',
        'latitude',
        'location'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
