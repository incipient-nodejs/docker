<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeleteAccount extends Model
{
    protected $fillable = [
        'id',
        'name',
        'phone',
        'feedback',
        'user_id',
        'send_data',
    ];
}
