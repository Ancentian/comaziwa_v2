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
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('project_id');
            $table->string('title');
            $table->unsignedBigInteger('assigned_to');
            $table->string('priority');
            $table->string('status');
            $table->text('notes')->nullable;

            $table->foreign('tenant_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreign('project_id')
                    ->references('id')
                    ->on('projects')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('tenant_id');
            $table->dropColumn('project_id');
            $table->dropColumn('title');
            $table->dropColumn('assigned_to');
            $table->dropColumn('priority');
            $table->dropColumn('status');
            $table->dropColumn('notes');

            $table->dropForeign('tenant_id');
            $table->dropForeign('project_id');
        });
    }
};
