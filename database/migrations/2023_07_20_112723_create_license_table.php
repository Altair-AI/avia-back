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
        Schema::create('license', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->smallInteger('type');
            $table->integer('organization_id')->unsigned();
            $table->foreign('organization_id')
                ->references('id')
                ->on('organization')
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
        Schema::dropIfExists('license');
    }
};
