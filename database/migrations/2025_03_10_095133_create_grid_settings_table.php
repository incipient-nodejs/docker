<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('grid_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('cross_axis_count')->default(2);
            $table->decimal('child_aspect_ratio', 8, 1)->default(0.6);
            $table->decimal('main_axis_spacing', 8, 1)->default(5.2);
            $table->decimal('cross_axis_spacing', 8, 1)->default(5.3);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grid_settings');
    }
};

