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
            $table->string('location')->comment('City, State, Country');
            $table->string('property_type')->comment('Residential, Commercial, Land, Office, Other');
            $table->string('property_category')->comment('Apartment, House, Villa, Office, Land, Other');
            $table->string('lot_area')->nullable();
            $table->string('floor_area')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('bedrooms');
            $table->string('bathrooms');
            $table->string('garage');
            $table->text('description');
            $table->string('youtube_video_id')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('status');
            $table->boolean('is_featured')->default(false);
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
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
