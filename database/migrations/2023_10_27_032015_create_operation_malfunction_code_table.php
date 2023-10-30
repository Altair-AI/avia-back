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
        Schema::create('operation_malfunction_code', function (Blueprint $table) {
            $table->id();
            $table->integer('operation_id')->unsigned();
            $table->foreign('operation_id')
                ->references('id')
                ->on('operation')
                ->onDelete('cascade');
            $table->integer('malfunction_code_id')->unsigned();
            $table->foreign('malfunction_code_id')
                ->references('id')
                ->on('malfunction_code')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation_malfunction_code');
    }
};
