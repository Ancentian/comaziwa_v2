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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('category_id');
            $table->string('asset_name')->unique();
            $table->date('purchase_date');
            $table->decimal('purchase_price', 15, 2);
            $table->decimal('current_value', 15, 2);
            $table->string('location')->nullable();
            $table->string('status')->default(1);
            $table->text('description')->nullable();
            $table->text('file')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('asset_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
