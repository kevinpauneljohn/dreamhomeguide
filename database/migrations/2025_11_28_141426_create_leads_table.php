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
        Schema::create('leads', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('source');
            $table->string('source_url')->nullable();
            $table->string('status');
            $table->foreignUuid('user_id')->nullable()->constrained('users');
            $table->date('birthday')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('income_range')->nullable();
            $table->string('gender')->nullable();
            $table->enum('lead_type', ['buyer', 'seller','buyer-and-seller'])->default('buyer');
            $table->foreignId('property_id')->nullable()->constrained('properties')->cascadeOnDelete();
            $table->text('message')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
