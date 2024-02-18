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
        Schema::create('malfunction_cause_operation', function (Blueprint $table) {
            $table->id();
            $table->integer('source_priority')->nullable();
            $table->integer('case_priority')->nullable();
            $table->integer('operation_id')->unsigned();
            $table->foreign('operation_id')
                ->references('id')
                ->on('operation')
                ->onDelete('cascade');
            $table->integer('malfunction_cause_id')->unsigned();
            $table->foreign('malfunction_cause_id')
                ->references('id')
                ->on('malfunction_cause')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('malfunction_cause_operation');
    }
};
