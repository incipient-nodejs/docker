<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('imagem');
            $table->enum('posicao_tela', ['tudo', 'produtos', 'servicos', 'fabricantes']);
            $table->integer('posicao_grupo')->unsigned();
            $table->integer('posicao_interna')->unsigned();
            $table->string('type')->default('horizontal')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banners');
    }
};
