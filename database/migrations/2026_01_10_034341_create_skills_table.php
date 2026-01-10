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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            // Informations de base
            $table->string('name', 50);
            $table->string('slug', 50)->unique();
            $table->string('category', 50)->index();

            // Niveau de maîtrise
            $table->enum('level', ['beginner', 'intermediate', 'advanced', 'expert'])
                ->default('intermediate');

            // Icône (nom de l'icône ou classe CSS)
            $table->string('icon')->nullable();

            // Ordre d'affichage
            $table->integer('order')->default(0);

            // Timestamps
            $table->timestamps();

            // Index composé pour les requêtes par catégorie
            $table->index(['category', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
