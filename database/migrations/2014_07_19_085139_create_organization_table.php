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
        Schema::create('organization', function (Blueprint $table) {$table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->text('actual_address')->nullable()->comment('Фактический адрес организации');
            $table->text('legal_address')->nullable()->comment('Юридический адрес организации');
            $table->string('phone')->nullable();
            $table->string('tin')->nullable()->comment('ИНН/КПП');
            $table->string('rboc')->nullable()->comment('ОКПО');
            $table->string('psrn')->nullable()->comment('ОГРН');
            $table->string('bank_account')->nullable()->comment('Банковский счет');
            $table->string('bank_name')->nullable()->comment('Название банка');
            $table->string('bik')->nullable()->comment('БИК');
            $table->string('correspondent_account')->nullable()->comment('Корреспондентский счет');
            $table->string('full_director_name')->nullable();
            $table->string('treaty_number')->nullable()->comment('Номер договора с организацией');
            $table->timestamp('treaty_date')->nullable()->comment('Дата договора с организацией');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization');
    }
};
