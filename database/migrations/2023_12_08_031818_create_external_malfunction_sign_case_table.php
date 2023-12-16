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
        Schema::create('external_malfunction_sign_case', function (Blueprint $table) {
            $table->id();
            $table->integer('case_id')->unsigned();
            $table->foreign('case_id')->references('id')->on('case')->onDelete('cascade');
            $table->integer('external_malfunction_sign_id')->unsigned();
            $table->foreign('external_malfunction_sign_id')
                ->references('id')
                ->on('external_malfunction_sign')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_malfunction_sign_case');
    }
};
