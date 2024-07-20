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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('farmer_id');
            $table->unsignedBigInteger('center_id');
            $table->float('total_milk');
            $table->float('milk_rate');
            $table->float('store_deductions');
            $table->float('individual_deductions');
            $table->float('general_deductions');
            $table->float('shares_contribution')->nullable();
            $table->float('previous_dues')->nullable();
            $table->string('pay_period');
            $table->float('bonus_rate')->nullable();
            $table->unsignedBigInteger('generated_by')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('farmer_id')->references('id')->on('farmers')->onDelete('cascade');
            $table->foreign('center_id')->references('id')->on('collection_centers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
