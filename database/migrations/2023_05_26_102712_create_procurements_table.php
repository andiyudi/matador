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
        Schema::create('procurements', function (Blueprint $table) {
            $table->id();
            $table->year('periode');
            $table->string('name');
            $table->string('number');
            $table->string('estimation_time');
            $table->unsignedBigInteger('division_id');
            $table->string('person_in_charge');
            $table->enum('status', ['0', '1', '2', '3'])->default('0'); // 0:process, 1:success, 2:cancelled, 3.repeated
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurements');
    }
};
