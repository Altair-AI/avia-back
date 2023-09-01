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
        Schema::create('real_time_technical_system', function (Blueprint $table) {
            $table->id();
            $table->string('registration_code')->unique();
            $table->text('registration_description')->nullable();
            $table->integer('operation_time_from_start')->nullable();
            $table->integer('operation_time_from_last_repair')->nullable();
            $table->integer('technical_system_id')->unsigned();
            $table->foreign('technical_system_id')
                ->references('id')
                ->on('technical_system')
                ->onDelete('cascade');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')
                ->references('id')
                ->on('project')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_time_technical_system');
    }
};
