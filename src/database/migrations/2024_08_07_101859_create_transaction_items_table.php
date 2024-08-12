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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name');
            $table->foreignId('group_id')->nullable();
            $table->string('description')->nullable();
            $table->enum('category', ['income', 'consumption'])->comment('Доход или расход');
            $table->enum('type', [
                'primary_activity',
                'purchase_of_goods',
                'basis_of_funds',
                'fixed_assets',
                'repayment_of_the_loan_body',
                'withdrawal_of_profit',
                // Ниже доходы
                'income_primary_activity',
                'income_sale_of_fixed_assets',
                'income_credit',
                'income_putting_money'
            ])->comment('Сверху вниз: РАСХОД. основная деятельность, закупка товара, основные средства, на выплату тела кредита, вывод прибыли. ДОХОД. От основной деят., от продажи основ средств., получение кредита, ввод денег');
            $table->integer('position')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
