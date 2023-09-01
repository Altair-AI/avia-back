<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('concrete_operation_result', function (Blueprint $table) {
            $table->id();
            $table->integer('operation_id')->unsigned();
            $table->foreign('operation_id')
                ->references('id')
                ->on('operation')
                ->onDelete('cascade');
            $table->integer('operation_result_id')->unsigned();
            $table->foreign('operation_result_id')
                ->references('id')
                ->on('operation_result')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concrete_operation_result');
    }
};
