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
        // Cette migration est obsolète - la table likes est remplacée par appreciations
        // Aucune table à créer ici
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Aucune table à supprimer
    }
};

