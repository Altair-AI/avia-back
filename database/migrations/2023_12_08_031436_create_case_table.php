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
        Schema::create('case', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->string('card_number');
            $table->integer('operation_time_from_start')->nullable();
            $table->integer('operation_time_from_last_repair')->nullable();
            $table->integer('malfunction_detection_stage_id')->unsigned();
            $table->foreign('malfunction_detection_stage_id')
                ->references('id')
                ->on('malfunction_detection_stage')
                ->onDelete('cascade');
            $table->integer('malfunction_cause_id')->unsigned();
            $table->foreign('malfunction_cause_id')
                ->references('id')
                ->on('malfunction_cause')
                ->onDelete('cascade');
            $table->integer('system_id_for_repair')->unsigned();
            $table->foreign('system_id_for_repair')
                ->references('id')
                ->on('real_time_technical_system')
                ->onDelete('cascade');
            $table->integer('initial_completed_operation_id')->unsigned()->nullable();
            $table->foreign('initial_completed_operation_id')
                ->references('id')
                ->on('completed_operation')
                ->onDelete('cascade');
            $table->integer('case_based_knowledge_base_id')->unsigned();
            $table->foreign('case_based_knowledge_base_id')
                ->references('id')
                ->on('case_based_knowledge_base')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case');
    }
};
