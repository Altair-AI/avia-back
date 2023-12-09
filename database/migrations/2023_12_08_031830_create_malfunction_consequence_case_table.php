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
        Schema::create('malfunction_consequence_case', function (Blueprint $table) {
            $table->id();
            $table->integer('case_id')->unsigned();
            $table->foreign('case_id')->references('id')->on('case')->onDelete('cascade');
            $table->integer('malfunction_consequence_id')->unsigned();
            $table->foreign('malfunction_consequence_id')
                ->references('id')
                ->on('malfunction_consequence')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('malfunction_consequence_case');
    }
};
