<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Mapper\ConcreteField;
use App\Models\CompanyData;
use App\Models\User;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(CompanyData::TABLE, function (Blueprint $table) {
            ConcreteField::create($table, function (Blueprint $table) {
                $table->unsignedBigInteger('user_id');
                $table->text('image_url')->nullable();
                $table->string('name');
                $table->string('nif');
                $table->string('location');
                $table->text('latitude')->nullable();
                $table->text('longitude')->nullable();
                $table->string('certification')->nullable();
                $table->string('tipo_contacto')->nullable();
                $table->string('contacto')->nullable();
                $table->integer('counter_view')->default(0);
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
        Schema::dropIfExists(CompanyData::TABLE);
    }
};
