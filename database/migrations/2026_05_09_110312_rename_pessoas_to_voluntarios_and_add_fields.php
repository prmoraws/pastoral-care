<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Renomear tabela
        Schema::rename('pessoas', 'voluntarios');

        // Adicionar novos campos
        Schema::table('voluntarios', function (Blueprint $table) {
            $table->string('email')->nullable()->after('nome');
            $table->string('igreja')->nullable()->after('email')->comment('Igreja/Região/Bloco');
            $table->string('condicao')->nullable()->after('igreja')->comment('Bispo|Pastor|Obreiro|Evangelista|Lider de Grupo|Membro');
            $table->dropColumn('observacoes');
        });
    }

    public function down(): void
    {
        Schema::table('voluntarios', function (Blueprint $table) {
            $table->dropColumn(['email', 'igreja', 'condicao']);
            $table->text('observacoes')->nullable();
        });

        Schema::rename('voluntarios', 'pessoas');
    }
};
