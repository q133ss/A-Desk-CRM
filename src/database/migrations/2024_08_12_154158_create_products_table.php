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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['product', 'service'])->default('product');
            $table->foreignId('user_id');
            $table->enum('unit',[
                'piece',
                'gram',
                'hectare',
                'year',
                'decimeter'
            ])->nullable();
            $table->string('name');
            $table->string('sku')->nullable()->comment('Артикул');
            $table->string('description')->nullable();
            $table->double('default_price')->nullable()->comment('Цена по умолчанию');
            // Указать цену продажи по умолчанию
            $table->foreignId('currency_id')->nullable();
            // Указать начальный остаток на складе
            $table->string('qty')->nullable();
            $table->date('date_of_receipt')->nullable()->comment('Дата поступления');
            $table->double('avg_price')->nullable()->comment('Средняя цена закупки');
            $table->foreignId('entity_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
