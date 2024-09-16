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

        Schema::table('commandes', function (Blueprint $table) {
            // Ajouter la colonne "standby" de type booléen avec une valeur par défaut de false
            $table->string('token')->unique()->after('livraison_estimee');
            $table->string('status')->default("unpayed")->after('token');
            
        });

        // Mettre à jour toutes les lignes existantes pour définir la valeur de la colonne "standby" sur false
        DB::table('commandes')->update(['status' => "unpayed"]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {

            $table->dropColumn('status');
            $table->dropColumn('token');
        });
    }
};
