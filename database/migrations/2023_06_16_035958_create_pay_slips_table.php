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
        Schema::create('pay_slips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('employee_id');
            $table->float('basic_salary');
            $table->float('paye');
            $table->float('net_pay');
            $table->string('pay_period');
            $table->timestamp('paid_on')->nullable();
            $table->unsignedBigInteger('paid_status')->default(0); 
            $table->text('allowances')->nullable();
            $table->text('benefits')->nullable();
            $table->text('statutory_deductions')->nullable();
            $table->text('nonstatutory_deductions')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('pay_slips');
    }
};
