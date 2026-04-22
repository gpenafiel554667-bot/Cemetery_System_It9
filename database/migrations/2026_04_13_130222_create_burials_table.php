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
    Schema::create('burials', function (Blueprint $table) {
        $table->id();
        $table->foreignId('deceased_id')->constrained('deceaseds')->onDelete('cascade');
        $table->foreignId('lot_id')->constrained('lots')->onDelete('cascade');
        $table->date('burial_date');
        $table->enum('burial_type', ['ground', 'mausoleum', 'columbarium']);
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('burials');
    }
};
