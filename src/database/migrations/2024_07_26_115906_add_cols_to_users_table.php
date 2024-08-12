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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id');
            $table->string('phone');

            $table->string('company_name')->nullable();
            $table->string('subdomain')->nullable();

            $table->foreignId('currency_id')->default(1);

            $table->foreignId('timezone_id')->nullable();
            $table->enum('date_format', [
                'd.m.Y',
                'm.d.Y',
                'd/m/Y',
                'm/d/Y'
            ])->default('d.m.Y');

            $table->enum('time_format', [
                'H:i',
                'h:i A'
            ])->default('H:i');

            $table->boolean('show_pennies')->default(true);
            $table->boolean('show_description')->default(true);

            $table->boolean('logged_in')->default(true);
            $table->string('hash')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
