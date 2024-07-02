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
        Schema::table('leaves', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->after('id');
            $table->unsignedBigInteger('employee_id');
            $table->string('type');
            $table->string('date_from');
            $table->string('date_to');
            $table->text('reasons');
            $table->boolean('status')->default(0);

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
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropColumn('tenant_id');
            $table->dropColumn('employee_id');
            $table->dropColumn('type');
            $table->dropColumn('date_from');
            $table->dropColumn('date_to');
            $table->dropColumn('reasons');
            $table->dropColumn('status');
        });
    }
};
