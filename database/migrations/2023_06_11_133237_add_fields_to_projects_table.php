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
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id');
            $table->string('title');
            $table->string('start_date');
            $table->string('due_date');
            $table->string('priority');
            $table->unsignedBigInteger('team_leader');
            $table->text('project_team');
            $table->float('progress')->default(0.00);
            $table->text('notes')->nullable();

            $table->foreign('tenant_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                    
            $table->foreign('team_leader')
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
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('tenant_id');
            $table->dropColumn('title');
            $table->dropColumn('start_date');
            $table->dropColumn('due_date');
            $table->dropColumn('priority');
            $table->dropColumn('team_leader');
            $table->dropColumn('project_team');
            $table->dropColumn('progress');
            $table->dropColumn('notes');

            $table->dropForeign('tenant_id');
            $table->dropForeign('team_leader');

        });
    }
};
