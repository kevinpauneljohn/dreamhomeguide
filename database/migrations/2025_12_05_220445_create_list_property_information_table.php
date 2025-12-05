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
        Schema::create('list_property_information', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('lead_id')->constrained()->cascadeOnDelete();
            $table->string('location')->comment('City, State, Country');
            $table->string('property_category');
            $table->text('additional_details')->nullable()->comment('Bedrooms, Bathrooms, Garage, Floors, Area, Lot Area, Floor Area, Year Built, Description,');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_property_information');
    }
};
