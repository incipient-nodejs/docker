<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GridSetting;

class GridSettingSeeder extends Seeder
{
    public function run()
    {
        GridSetting::create([
            'cross_axis_count' => 2,
            'child_aspect_ratio' => 1.5,
            'main_axis_spacing' => 5.2,
            'cross_axis_spacing' => 5.4,
        ]);
    }
}

