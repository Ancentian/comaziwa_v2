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
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('id_number')->nullable();
            $table->string('farmerID')->unique();
            $table->string('contact1')->nullable();
            $table->string('contact2')->nullable();
            $table->string('gender');
            $table->date('join_date')->nullable();
            $table->date('dob');
            $table->unsignedBigInteger('center_id');
            $table->string('location')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('status');
            $table->string('education_level')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('acc_name')->nullable();
            $table->string('acc_number')->nullable();
            $table->string('mpesa_number')->nullable();
            $table->string('nok_name'); // Kin Name
            $table->string('nok_phone')->nullable(); // Kin Phone
            $table->string('relationship')->nullable(); // Kin Relationship
            $table->timestamps();

            $table->foreign('tenant_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('center_id')
                ->references('id')
                ->on('collection_centers')
                ->onDelete('cascade');
            
            $table->foreign('bank_id')
                ->references('id')
                ->on('banks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmers');
    }
};
