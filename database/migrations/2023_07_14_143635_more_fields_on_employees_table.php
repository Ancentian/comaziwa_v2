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
        //
        Schema::table('employees', function (Blueprint $table) {
            //
            $table->string('nok_name')->nullable();
            $table->string('nok_phone')->nullable();
            $table->string('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('training_requests', function (Blueprint $table) {
            //
            $table->dropColumn('nok_name');
            $table->dropColumn('nok_phone');
            $table->dropColumn('address');
        });
    }
};
