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
        Schema::create('milk_consumptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('category_id');
            $table->string('transaction_id')->nullable();
            $table->float('quantity');
            $table->float('rate');
            $table->float('total_cost')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('consumer_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_consumptions');
    }
};
