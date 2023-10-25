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
        Schema::create('operation', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->text('imperative_name')->nullable();
            $table->text('verbal_name');
            $table->string('designation')->nullable();
            $table->text('description')->nullable();
            $table->string('document_section');
            $table->string('document_subsection');
            $table->integer('start_document_page');
            $table->integer('end_document_page')->nullable();
            $table->integer('actual_document_page')->nullable();
            $table->integer('document_id')->unsigned();
            $table->foreign('document_id')
                ->references('id')
                ->on('document')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation');
    }
};
