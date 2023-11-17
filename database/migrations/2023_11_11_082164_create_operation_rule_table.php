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
        Schema::create('operation_rule', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->smallInteger('type');
            $table->smallInteger('repeat_voice');
            $table->string('context');
            $table->integer('priority');
            $table->integer('rule_based_knowledge_base_id')->unsigned();
            $table->foreign('rule_based_knowledge_base_id')
                ->references('id')
                ->on('rule_based_knowledge_base')
                ->onDelete('cascade');
            $table->integer('operation_id_if')->unsigned();
            $table->foreign('operation_id_if')
                ->references('id')
                ->on('operation')
                ->onDelete('cascade');
            $table->smallInteger('operation_status_if');
            $table->integer('operation_result_id')->unsigned()->nullable();
            $table->foreign('operation_result_id')
                ->references('id')
                ->on('operation_result')
                ->onDelete('cascade');
            $table->integer('operation_id_then')->unsigned();
            $table->foreign('operation_id_then')
                ->references('id')
                ->on('operation')
                ->onDelete('cascade');
            $table->smallInteger('operation_status_then');
            $table->integer('malfunction_cause_id')->unsigned()->nullable();
            $table->foreign('malfunction_cause_id')
                ->references('id')
                ->on('malfunction_cause')
                ->onDelete('cascade');
            $table->integer('malfunction_system_id')->unsigned();
            $table->foreign('malfunction_system_id')
                ->references('id')
                ->on('technical_system')
                ->onDelete('cascade');
            $table->integer('document_id')->unsigned();
            $table->foreign('document_id')
                ->references('id')
                ->on('document')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation_rule');
    }
};
