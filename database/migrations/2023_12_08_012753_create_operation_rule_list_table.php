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
        Schema::create('operation_rule_list', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('status');
            $table->integer('work_session_id')->unsigned();
            $table->foreign('work_session_id')
                ->references('id')
                ->on('work_session')
                ->onDelete('cascade');
            $table->integer('operation_rule_id')->unsigned();
            $table->foreign('operation_rule_id')
                ->references('id')
                ->on('operation_rule')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation_rule_list');
    }
};
