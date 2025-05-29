<?php

namespace App\Mapper;

use Illuminate\Database\Schema\Blueprint;

class ConcreteField{

    static function create(Blueprint $table, callable $callback) {
        CommonField::create($table, function (Blueprint $table) use ($callback) {
            $callback($table);
            $table->timestamp('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
        });
    }

}
