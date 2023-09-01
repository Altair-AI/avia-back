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
        Schema::create('real_time_technical_system_user', function (Blueprint $table) {
            $table->id();
            $table->integer('real_time_technical_system_id')->unsigned();
            $table->foreign('real_time_technical_system_id')
                ->references('id')
                ->on('real_time_technical_system')
                ->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_time_technical_system_user');
    }
};
