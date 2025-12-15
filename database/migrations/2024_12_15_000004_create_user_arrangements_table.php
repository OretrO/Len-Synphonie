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
        Schema::create('user_arrangements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('arrangement_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Assurer qu'un utilisateur ne peut créer qu'un seul lien avec un arrangement
            $table->unique(['user_id', 'arrangement_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_arrangements');
    }
};

