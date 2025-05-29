<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingProduct extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'value',
        'comment'
    ];
}
