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
        Schema::create('store_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('center_id');
            $table->unsignedBigInteger('farmer_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('item_id');
            $table->date('order_date');
            $table->integer('qty');
            $table->decimal('unit_cost', 8, 2);
            $table->decimal('total_cost', 10, 2);
            $table->string('payment_mode');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('center_id')->references('id')->on('collection_centers')->onDelete('cascade');
            $table->foreign('farmer_id')->references('id')->on('farmers')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('inventories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_sales');
    }
};
