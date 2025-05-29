<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Mapper\ConcreteField;
use App\Models\ApiField;
use App\Models\ApiType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(ApiField::TABLE, function (Blueprint $table) {
            ConcreteField::create($table, function (Blueprint $table) {
                $table->unsignedBigInteger('api_type_id');
                $table->string('name');
                $table->integer('order')->nullable()->default(1);
                $table->boolean('required')->nullable()->default(false);
                $table->text('description')->nullable();
                $table->string('code_api_type')->nullable();
                $table->foreign('api_type_id')->references('id')->on(ApiType::TABLE);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ApiField::TABLE);
    }
};
