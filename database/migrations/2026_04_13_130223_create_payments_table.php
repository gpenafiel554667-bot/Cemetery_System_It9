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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('burial_id')->constrained('burials')->onDelete('cascade');
        $table->decimal('amount', 10, 2);
        $table->enum('type', ['burial_fee', 'maintenance_fee', 'other']);
        $table->enum('status', ['paid', 'unpaid', 'partial'])->default('unpaid');
        $table->date('payment_date')->nullable();
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
