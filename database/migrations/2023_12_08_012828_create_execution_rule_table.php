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
        Schema::create('execution_rule', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('status');
            $table->integer('operation_id')->unsigned();
            $table->foreign('operation_id')
                ->references('id')
                ->on('operation')
                ->onDelete('cascade');
            $table->smallInteger('operation_status');
            $table->integer('operation_result_id')->unsigned();
            $table->foreign('operation_result_id')
                ->references('id')
                ->on('operation_result')
                ->onDelete('cascade');
            $table->integer('operation_rule_list_id')->unsigned();
            $table->foreign('operation_rule_list_id')
                ->references('id')
                ->on('operation_rule_list')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('execution_rule');
    }
};
