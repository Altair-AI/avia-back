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
        Schema::create('work_session', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('status');
            $table->timestamp('stop_time')->nullable();
            $table->integer('malfunction_cause_rule_id')->unsigned();
            $table->foreign('malfunction_cause_rule_id')
                ->references('id')
                ->on('malfunction_cause_rule')
                ->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_session');
    }
};
