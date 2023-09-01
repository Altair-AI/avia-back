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
        Schema::create('malfunction_cause_rule_then', function (Blueprint $table) {
            $table->id();
            $table->integer('malfunction_cause_rule_id')->unsigned();
            $table->foreign('malfunction_cause_rule_id')
                ->references('id')
                ->on('malfunction_cause_rule')
                ->onDelete('cascade');
            $table->integer('technical_system_id')->unsigned();
            $table->foreign('technical_system_id')
                ->references('id')
                ->on('technical_system')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('malfunction_cause_rule_then');
    }
};
