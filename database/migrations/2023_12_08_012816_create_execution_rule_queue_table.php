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
        Schema::create('execution_rule_queue', function (Blueprint $table) {
            $table->id();
            $table->integer('operation_rule_list_id')->unsigned();
            $table->foreign('operation_rule_list_id')
                ->references('id')
                ->on('operation_rule_list')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('execution_rule_queue');
    }
};
