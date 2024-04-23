<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Users_id')->nullable();
            $table->unsignedBigInteger('apartements_id'); 
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('duration')->nullable();
            $table->string('status')->default('pending');
            $table->longText('content');
            $table->timestamps();
            
            // Foreign keys for client and apartment relation.
            $table->foreign('Users_id')->references('id')->on('Users')->cascadeOnDelete();
            $table->foreign('appartements_id')->references('id')->on('appartements')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
}
