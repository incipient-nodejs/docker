<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'event_type',
        'message',
        'user_id',
        'ip_address',
        'device_info'
    ];
}

