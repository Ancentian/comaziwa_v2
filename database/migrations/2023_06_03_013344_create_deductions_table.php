<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('name');
            $table->string('type');
            $table->float('value');
            $table->timestamps();

            $table->foreign('tenant_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            // DB::statement("ALTER TABLE deductions ADD CONSTRAINT type_check CHECK (type IN ('fixed', 'percentage'))");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deductions');
        // DB::statement("ALTER TABLE deductions DROP CONSTRAINT type_check");
    }
};
