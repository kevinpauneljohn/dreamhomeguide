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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('address');
            $table->string('type');
            $table->string('category');
            $table->string('lot_area')->nullable();
            $table->string('floor_area')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('bedrooms');
            $table->string('bathrooms');
            $table->string('garage');
            $table->text('description');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
