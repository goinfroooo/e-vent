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
        Schema::table('paniers', function (Blueprint $table) {
            // Ajouter la colonne "standby" de type booléen avec une valeur par défaut de false
            $table->boolean('standby')->default(false)->after("qte");
        });

        // Mettre à jour toutes les lignes existantes pour définir la valeur de la colonne "standby" sur false
        DB::table('paniers')->update(['standby' => false]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paniers', function (Blueprint $table) {
            // Supprimer la colonne "standby" si la migration est annulée
            $table->dropColumn('standby');
        });
    }
};
