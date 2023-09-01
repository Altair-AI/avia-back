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
        Schema::create('technical_system', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->text('name');
            $table->text('description')->nullable();
            $table->integer('parent_technical_system_id')->unsigned()->nullable();
            $table->foreign('parent_technical_system_id')
                ->references('id')
                ->on('technical_system');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical_system');
    }
};
