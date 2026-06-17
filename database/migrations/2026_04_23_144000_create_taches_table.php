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
        Schema::create('taches', function (Blueprint $table) {

            $table->id();

            // employé concerné
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // admin qui crée
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('titre');

            $table->text('description');

            $table->enum('priorite', [
                'faible',
                'moyenne',
                'haute'
            ])->default('moyenne');

            $table->enum('statut', [
                'en_attente',
                'en_cours',
                'terminee',
                'rejetee'
            ])->default('en_attente');

            $table->date('date_limite')->nullable();

            $table->text('commentaire')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
