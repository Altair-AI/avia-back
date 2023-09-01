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
        Schema::create('rule_based_knowledge_base_project', function (Blueprint $table) {
            $table->id();
            $table->integer('rule_based_knowledge_base_id')->unsigned();
            $table->foreign('rule_based_knowledge_base_id')
                ->references('id')
                ->on('rule_based_knowledge_base')
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
        Schema::dropIfExists('rule_based_knowledge_base_project');
    }
};
