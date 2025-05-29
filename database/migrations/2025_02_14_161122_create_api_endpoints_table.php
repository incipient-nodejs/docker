<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Mapper\ConcreteField;
use App\Models\ApiEndpoint;
use App\Models\ApiType;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(ApiEndpoint::TABLE, function (Blueprint $table) {
            ConcreteField::create($table, function (Blueprint $table) {
                $table->unsignedBigInteger('api_type_id');
                $table->unsignedBigInteger('user_id');
                $table->string('url');
                $table->enum('authentication_type', ['JWT', 'FREE', 'TOKEN'])->default('JWT');
                $table->enum('method_http', ['GET', 'PUT', 'POST', 'PATCH', 'DELETE'])->default('GET');
                $table->string('query_parm')->nullable();
                $table->string('pagination_items')->nullable();
                $table->foreign('api_type_id')->references('id')->on(ApiType::TABLE);
                $table->foreign('user_id')->references('id')->on(User::TABLE);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ApiEndpoint::TABLE);
    }
};
