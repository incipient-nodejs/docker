<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Mapper\ConcreteField;
use App\Models\FormalType;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(FormalType::TABLE, function (Blueprint $table) {
            ConcreteField::create($table, function (Blueprint $table) {
                $table->unsignedBigInteger('user_id');
                $table->string('name');
                $table->string('nif');
                $table->string('docs')->nullable();
                $table->string('website')->nullable();
                $table->string('whatsapp')->nullable();
                $table->string('phone')->nullable();
                $table->text('offers')->nullable();
                $table->foreign('user_id')->references('id')->on(User::TABLE);
                $table->unique(['user_id']);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(FormalType::TABLE);
    }
};
