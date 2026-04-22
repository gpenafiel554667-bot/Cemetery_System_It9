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
    Schema::create('families', function (Blueprint $table) {
        $table->id();
        $table->foreignId('deceased_id')->constrained('deceaseds')->onDelete('cascade');
        $table->string('first_name');
        $table->string('last_name');
        $table->string('relationship');
        $table->string('contact_number');
        $table->string('email')->nullable();
        $table->text('address')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
