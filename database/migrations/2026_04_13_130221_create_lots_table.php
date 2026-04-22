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
    Schema::create('lots', function (Blueprint $table) {
        $table->id();
        $table->string('lot_number');
        $table->string('section');
        $table->string('row');
        $table->enum('type', ['ground', 'mausoleum', 'columbarium']);
        $table->enum('status', ['available', 'occupied', 'reserved'])->default('available');
        $table->decimal('price', 10, 2);
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
