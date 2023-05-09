<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('core_business_vendor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('core_business_id');
            $table->unsignedBigInteger('vendor_id');
            $table->timestamps();

            $table->foreign('core_business_id')->references('id')->on('core_businesses')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('core_business_vendor');
    }
};
