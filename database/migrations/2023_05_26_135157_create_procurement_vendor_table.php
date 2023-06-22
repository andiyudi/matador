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
        Schema::create('procurement_vendor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('procurement_id');
            $table->unsignedBigInteger('vendor_id');
            $table->enum('is_selected', ['0', '1'])->default('0'); // 0: not selected and 1: selected
            //company to vendor
            $table->enum('evaluation', ['0', '1'])->nullable()->default(NULL); // 0: bad evaluation and 1: good evaluation
            $table->enum('value_cost', ['0', '1', '2'])->nullable()->default(NULL); // 0: 0<100JT, 1: 100JT<1M, 2: >1M
            //vendor to company
            $table->enum('contract_order', ['0', '1', '2'])->nullable()->default(NULL); // 0: cepat, 1: lama, 2: sangat lama
            $table->enum('work_implementation', ['0', '1', '2'])->nullable()->default(NULL); // 0: mudah, 1: sulit, 2: sangat sulit
            $table->enum('pre_handover', ['0', '1', '2'])->nullable()->default(NULL); // 0: cepat, 1: lama, 2: sangat lama
            $table->enum('final_handover', ['0', '1', '2'])->nullable()->default(NULL); // 0: cepat, 1: lama, 2: sangat lama
            $table->enum('invoice_payment', ['0', '1', '2'])->nullable()->default(NULL); // 0: cepat, 1: lama, 2: sangat lama
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('procurement_id')->references('id')->on('procurements')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');

            // Add unique constraint to prevent duplicate entries
            $table->unique(['procurement_id', 'vendor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_vendor');
    }
};
