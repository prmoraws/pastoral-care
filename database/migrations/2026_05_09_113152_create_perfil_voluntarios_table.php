<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfil_voluntarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('condicao')->nullable()->comment('Bispo|Pastor|Esposa|Obreiro|Evangelista|Lider de Grupo|Membro');
            $table->string('contato')->nullable();
            $table->string('avatar')->nullable();
            $table->string('igreja')->nullable()->comment('Igreja/Região/Bloco');
            $table->boolean('ativo')->default(true);
            $table->string('registration_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfil_voluntarios');
    }
};
