<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    const TABLE = "permissions";

    protected $table = Permission::TABLE;

    protected $fillable = [
        'id',
        'uuid',
        'name',
        'type',
        'concat',
        'description',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by',
    ];

}
