<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GridSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'cross_axis_count',
        'child_aspect_ratio',
        'main_axis_spacing',
        'cross_axis_spacing'
    ];
}
