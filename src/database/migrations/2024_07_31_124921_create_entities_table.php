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
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('entity_name');
            $table->string('full_name');
            $table->string('inn');
            $table->string('kpp');
            $table->string('ogrn');
            $table->string('ur_address');
            $table->string('phone');
            $table->boolean('with_nds')->default(false)->comment('Юр лицо работает с НДС');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};
