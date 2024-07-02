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
        Schema::table('company_profiles', function (Blueprint $table) {
            //
            $table->string('tin')->nullable();
            $table->string('secondary_email')->nullable();
            $table->string('land_line')->nullable();
            
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            //
            $table->dropColumn('tin');
            $table->dropColumn('land_line');
            $table->dropColumn('secondary_email');
        });
    }
};
