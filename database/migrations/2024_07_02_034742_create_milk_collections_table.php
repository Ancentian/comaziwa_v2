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
        Schema::create('milk_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('farmer_id');
            $table->unsignedBigInteger('center_id');
            $table->date('collection_date');
            $table->float('morning')->nullable();
            $table->float('evening')->nullable();
            $table->float('rejected')->nullable();
            $table->float('total');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            $table->foreign('tenant_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('farmer_id')->references('id')->on('farmers')->onDelete('cascade');
            $table->foreign('center_id')->references('id')->on('collection_centers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_collections');
    }
};
