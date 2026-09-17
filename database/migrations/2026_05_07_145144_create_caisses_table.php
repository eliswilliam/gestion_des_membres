<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('caisses', function (Blueprint $table) {
            $table->id();
            $table->decimal('solde_global', 15, 2)->default(0);
            $table->timestamps();
        });

        // Insérer la ligne de caisse par défaut
        DB::table('caisses')->insert([
            'solde_global' => 0,
            'created_at' => now(),
            'updated_at' => now(),
            
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caisses');
    }
};
