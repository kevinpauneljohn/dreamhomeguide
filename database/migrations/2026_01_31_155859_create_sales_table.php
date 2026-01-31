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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('reservation_date');
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('lead_id')->constrained()->cascadeOnDelete();
            $table->foreignId('model_unit_id')->constrained()->cascadeOnDelete();
            $table->float('lot_area')->nullable();
            $table->float('floor_area')->nullable();
            $table->string('phase')->nullable();
            $table->string('block_no')->nullable();
            $table->string('lot_no')->nullable();
            $table->decimal('total_contract_price', 12, 2);
            $table->decimal('down_payment', 12, 2)->nullable();
            $table->string('financing')->nullable();
            $table->unsignedInteger('dp_terms')->nullable();
            $table->float('commission_rate');
            $table->enum('status', ['reserved', 'cancelled', 'completed'])->default('reserved');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
