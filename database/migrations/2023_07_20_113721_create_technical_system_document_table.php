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
        Schema::create('technical_system_document', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id')->unsigned();
            $table->foreign('document_id')
                ->references('id')
                ->on('document')
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
        Schema::dropIfExists('technical_system_document');
    }
};
