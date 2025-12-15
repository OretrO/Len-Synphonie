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
        Schema::create('appreciations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('arrangement_id')->constrained()->onDelete('cascade');
            $table->boolean('is_like'); // true for like, false for dislike
            $table->timestamps();

            // Un utilisateur ne peut apprécier un arrangement qu'une seule fois
            $table->unique(['user_id', 'arrangement_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appreciations');
    }
};

