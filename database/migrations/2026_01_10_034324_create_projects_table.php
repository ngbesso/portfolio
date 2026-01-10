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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // Informations de base
            $table->string('title', 200);
            $table->string('slug', 200)->unique();
            $table->text('description');

            // Image
            $table->string('image')->nullable();

            // Technologies (stockées en JSON)
            $table->json('technologies');

            // URLs
            $table->string('url')->nullable();
            $table->string('github_url')->nullable();

            // Statut et options
            $table->enum('status', ['draft', 'published', 'archived'])
                ->default('draft')
                ->index();
            $table->boolean('featured')->default(false)->index();

            // Ordre d'affichage
            $table->integer('order')->default(0);

            $table->timestamps();
            // Index pour améliorer les performances
            $table->index(['status', 'featured', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
