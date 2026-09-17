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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('numero_membre')->unique();
            $table->string('nom');
            $table->string('prenoms');
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('nom_pere')->nullable();
            $table->string('nom_mere')->nullable();
            $table->string('profession')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('situation_matrimoniale')->nullable();
            $table->text('adresse')->nullable();
            $table->text('photo')->nullable(); // contenu photo en Base64
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
