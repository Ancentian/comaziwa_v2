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
        Schema::table('training_requests', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('training_id');
            $table->integer('approval_status')->default(0);
            $table->integer('completion_status')->default(0);
            $table->string('certificate')->nullable();

            $table->foreign('training_id')
                    ->references('id')
                    ->on('trainings')
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
        Schema::table('training_requests', function (Blueprint $table) {
            //
            $table->dropColumn('employee_id');
            $table->dropColumn('training_id');
            $table->dropColumn('approval_status');
            $table->dropColumn('completion_status');
            $table->dropColumn('certificate');
        });
    }
};
