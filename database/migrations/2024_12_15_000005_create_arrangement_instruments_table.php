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
        Schema::create('arrangement_instruments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arrangement_id')->constrained()->onDelete('cascade');
            $table->foreignId('instrument_id')->constrained()->onDelete('cascade');
            $table->integer('track_number');
            $table->timestamps();

            // Assurer qu'un instrument ne peut être utilisé qu'une seule fois par piste dans un arrangement
            $table->unique(['arrangement_id', 'track_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arrangement_instruments');
    }
};

