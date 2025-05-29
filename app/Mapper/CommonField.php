<?php

namespace App\Mapper;

use Illuminate\Database\Schema\Blueprint;

class CommonField{

    static function create(Blueprint $table, callable $callback) {
        $table->id();
        $table->string('uuid')->unique();
        $callback($table);
        $table->text('concat')->nullable();
        $table->string('created_by')->nullable();
        $table->string('updated_by')->nullable();
        $table->timestamps();
    }

}
