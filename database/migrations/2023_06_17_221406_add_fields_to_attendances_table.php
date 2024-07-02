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
        Schema::table('attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('date');
            $table->text('punch_in');
            //$table->boolean('punch_in_status')->default(0);
            $table->text('punch_out')->nullable();
            //$table->boolean('punch_out_status')->default(0);

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
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('tenant_id');
            $table->dropColumn('employee_id');
            $table->dropColumn('date');
            $table->dropColumn('punch_in');
            $table->dropColumn('punch_in_status');
            $table->dropColumn('punch_out');
            $table->dropColumn('punch_out_status');
        });
    }
};
