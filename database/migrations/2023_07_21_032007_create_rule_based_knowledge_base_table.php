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
        Schema::create('rule_based_knowledge_base', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->smallInteger('status');
            $table->smallInteger('correctness');
            $table->integer('author')->unsigned();
            $table->foreign('author')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('rule_based_knowledge_base');
    }
};
