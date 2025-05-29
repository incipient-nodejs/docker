<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingService extends Model
{
    protected $fillable = [
        'service_id',
        'user_id',
        'value',
        'comment'
    ];
}
