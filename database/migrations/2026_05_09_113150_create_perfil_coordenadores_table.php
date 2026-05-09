<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfil_coordenadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('cargo')->nullable()->comment('Bispo|Pastor|Esposa|Obreiro');
            $table->string('contato')->nullable();
            $table->string('avatar')->nullable();
            $table->string('igreja')->nullable()->comment('Igreja/Região/Bloco');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfil_coordenadores');
    }
};
