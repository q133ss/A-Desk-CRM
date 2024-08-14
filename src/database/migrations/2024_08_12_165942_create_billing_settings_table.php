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
        Schema::create('billing_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id');
            $table->string('ceo_name')->nullable()->comment('ФИО руководителя на счете');
            $table->string('ceo_position')->nullable()->comment('Должность руководителя');
            $table->string('invoice_prefix')->nullable()->comment('Префикс перед номером счета');
            $table->string('starting_number')->nullable()->comment('Начальный номер');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_settings');
    }
};
