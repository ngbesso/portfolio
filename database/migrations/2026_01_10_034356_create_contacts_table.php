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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            // Informations de contact
            $table->string('name', 100);
            $table->string('email', 254)->index();
            $table->string('subject', 200);
            $table->text('message');

            // Statut de lecture
            $table->timestamp('read_at')->nullable()->index();

            // Timestamps
            $table->timestamp('created_at')->useCurrent();

            // Index pour les requêtes courantes
            $table->index(['read_at', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
