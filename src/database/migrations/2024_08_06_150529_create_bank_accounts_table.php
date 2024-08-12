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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name');
            $table->foreignId('group_id')->nullable()->comment('группа');
            $table->foreignId('entity_id')->comment('юр лицо');
            $table->string('bank')->nullable()->comment('Название банка');
            $table->string('bik')->nullable();
            $table->string('ks')->nullable()->comment('К/с');
            $table->string('number')->nullable()->comment('Номер счета');
            $table->foreignId('currency_id')->default(1);

            $table->foreignId('commission_article_id')->nullable()->comment('Статья комиссии');
            $table->foreignId('return_clause_id')->nullable()->comment('Статья возврата');

            $table->double('initial_amount')->nullable()->comment('начальный остаток');
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
