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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('date');
            $table->text('purpose');
            $table->float('amount');
            $table->boolean('payment_status')->default(0);
            $table->boolean('approval_status')->default(0);
            $table->timestamps();

            $table->foreign('tenant_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreign('type_id')
                    ->references('id')
                    ->on('expense_types')
                    ->onDelete('cascade');

            $table->foreign('employee_id')
                    ->references('id')
                    ->on('employees')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
