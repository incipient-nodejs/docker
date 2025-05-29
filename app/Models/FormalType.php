<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormalType extends Model
{
    const TABLE = "formal_types";

    protected $table = FormalType::TABLE;

    protected $fillable = [
        'name',
        'uuid',
        'nif',
        'docs',
        'website',
        'whatsapp',
        'phone',
        'offers',
        'user_id',
        'concat',
        'certification',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
