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

        Schema::create('cessation_activites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained();
            $table->date('date_entree');
            $table->date('date_sortie');
            $table->foreignId('motif_id')->constrained();
            $table->text('description');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cessation_activites');
    }
};
