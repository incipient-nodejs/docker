<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformalType extends Model
{
    const TABLE = "informal_types";

    protected $table = InformalType::TABLE;

    protected $fillable = [
        'name',
        'nif',
        'uuid',
        'docs',
        'website',
        'whatsapp',
        'phone',
        'offers',
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
