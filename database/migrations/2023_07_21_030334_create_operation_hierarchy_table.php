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
        Schema::create('operation_hierarchy', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_operation_id')->unsigned();
            $table->foreign('parent_operation_id')
                ->references('id')
                ->on('operation')
                ->onDelete('cascade');
            $table->integer('child_operation_id')->unsigned();
            $table->foreign('child_operation_id')
                ->references('id')
                ->on('operation')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation_hierarchy');
    }
};
