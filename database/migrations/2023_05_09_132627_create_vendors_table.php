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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('area');
            $table->string('director');
            $table->string('phone');
            $table->string('email');
            $table->string('capital');
            $table->string('grade');
            $table->enum('is_blacklist', ['0', '1'])->default('0'); // 0: not blacklisted and 1: blacklisted
            $table->dateTime('blacklist_at')->nullable()->default(null);
            $table->enum('status', ['0', '1', '2'])->default('0'); //0:registered, 1:active, 2:expired
            $table->dateTime('expired_at')->nullable()->default(date('Y') . '-12-31 23:59:59');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
