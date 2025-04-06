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
        Schema::disableForeignKeyConstraints();

        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('matricule');
            $table->string('nom');
            $table->string('prenom');
            $table->string('genre');
            $table->string('adresse');
            $table->string('email');
            $table->string('profil');
            $table->string('phone');
            $table->boolean('is_active');
            $table->integer('location_id')->nullable();
            $table->foreignId('fonction_id')->constrained();
            $table->foreignId('direction_id')->constrained();
            $table->foreignId('commissariat_id')->constrained();
            $table->foreignId('application_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
