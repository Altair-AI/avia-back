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
        Schema::create('malfunction_cause_rule', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->integer('document_id')->unsigned();
            $table->foreign('document_id')
                ->references('id')
                ->on('document')
                ->onDelete('cascade');
            $table->integer('rule_based_knowledge_base_id')->unsigned();
            $table->foreign('rule_based_knowledge_base_id')
                ->references('id')
                ->on('rule_based_knowledge_base')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('malfunction_cause_rule');
    }
};
