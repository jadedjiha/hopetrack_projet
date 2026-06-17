<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Type de demande
            $table->enum('type', ['conge', 'permission'])->default('conge');

            // Motif de la demande
            $table->string('motif');
            $table->text('description')->nullable();

            // Période demandée
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('nombre_jours')->default(1);

            // Pour les permissions (demi-journée ou quelques heures)
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();

            // Statut de validation
            $table->enum('statut', ['en_attente', 'approuve', 'refuse'])->default('en_attente');

            // Admin qui a traité la demande
            $table->foreignId('traite_par')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('traite_le')->nullable();
            $table->text('commentaire_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};
