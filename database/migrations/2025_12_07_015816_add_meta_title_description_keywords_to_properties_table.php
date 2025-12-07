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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('user_id')->comment('Meta title for SEO. If not set, it will be generated from the title.');
            $table->string('meta_keywords')->nullable()->after('meta_title')->comment('Meta keywords for SEO. If not set, it will be generated from the title and description. Separate keywords with a comma.');
            $table->string('meta_description')->nullable()->after('meta_keywords')->comment('Meta description for SEO. If not set, it will be generated from the description.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_keywords', 'meta_description']);
        });
    }
};
