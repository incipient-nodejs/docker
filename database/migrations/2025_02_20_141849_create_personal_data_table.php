<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Mapper\ConcreteField;
use App\Models\PersonalData;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(PersonalData::TABLE, function (Blueprint $table) {
            ConcreteField::create($table, function (Blueprint $table) {
                $table->unsignedBigInteger('user_id');
                $table->string('name');
                $table->string('full_name');
                $table->string('nif_bi');
                $table->string('phone');
                $table->string('image')->nullable();
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
        Schema::dropIfExists(PersonalData::TABLE);
    }
};
