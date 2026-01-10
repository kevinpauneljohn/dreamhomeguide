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
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('appointment_id')->nullable()->after('lead_id')->constrained('appointments')->cascadeOnDelete();
            $table->string('type')->comment('Appointment, Follow Up, Call, Email, Note, documentation, internal task');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']); // 👈 DROP FK FIRST
            $table->dropColumn('appointment_id');     // 👈 THEN DROP COLUMN
            $table->dropColumn('type');
        });
    }
};
