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
        Schema::create('malfunction_code', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->smallInteger('type');
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
        Schema::dropIfExists('malfunction_code');
    }
};
