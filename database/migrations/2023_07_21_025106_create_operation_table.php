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
            $table->string('code')->unique();
            $table->text('imperative_name');
            $table->text('verbal_name');
            $table->text('description')->nullable();
            $table->string('document_indication_number');
            $table->integer('start_document_page');
            $table->integer('end_document_page');
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
