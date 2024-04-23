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
        Schema::drop('reservations'); 
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Si vous souhaitez inverser cette migration, vous pouvez ajouter le code ici.
        // Cependant, cela dépend de vos besoins spécifiques.
    }
};

