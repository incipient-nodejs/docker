<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ApiEndpointField;
use App\Models\ApiEndpoint;
use App\Models\ApiField;
use App\Mapper\CommonField;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(ApiEndpointField::TABLE, function (Blueprint $table) {
            CommonField::create($table, function (Blueprint $table) {
                $table->string('name');
                $table->foreignId('api_endpoint_id')->constrained(ApiEndpoint::TABLE);
                $table->foreignId('api_field_id')->constrained(ApiField::TABLE);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ApiEndpointField::TABLE);
    }
};
