<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    const TABLE = "user_types";

    protected $table = UserType::TABLE;

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'code',
        'description',
        'concat',
        'user_type_id',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'user_type_id');
    }    

}
