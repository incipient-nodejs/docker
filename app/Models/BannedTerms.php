<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannedTerms extends Model
{
    protected $fillable = [
        'id',
        'text_en',
        'text_pt',
        'concat',
    ];
}
