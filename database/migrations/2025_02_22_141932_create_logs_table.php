<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('source'); // Exemplo: 'flutter' ou 'laravel'
            $table->string('event_type'); // Exemplo: 'login', 'register', 'error'
            $table->text('message')->nullable(); // Detalhes do evento
            $table->string('user_id')->nullable(); // ID do usuário (se aplicável)
            $table->ipAddress('ip_address')->nullable(); // IP do usuário
            $table->text('device_info')->nullable(); // Informações do dispositivo (para Flutter)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs');
    }
};
    
