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
        Schema::table('property_views', function (Blueprint $table) {
            $table->string('referrer_url', 2048)->nullable()->after('user_agent');
            $table->string('utm_source')->nullable()->after('referrer_url');
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_views', function (Blueprint $table) {
            $table->dropColumn(['referrer_url', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_content']);
        });
    }
};
