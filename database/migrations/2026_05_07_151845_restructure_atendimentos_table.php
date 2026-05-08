<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            // Remove chave estrangeira e coluna pessoa_id
            $table->dropForeign(['pessoa_id']);
            $table->dropColumn('pessoa_id');

            // Remove imagem antiga (será readicionada com novo nome)
            $table->dropColumn('imagem');

            // Adiciona dados do assistido
            $table->string('nome_assistido')->after('user_id');
            $table->string('contato')->after('nome_assistido');
            $table->string('endereco')->after('contato');
            $table->string('bairro')->after('endereco');
            $table->string('cidade')->after('bairro');
            $table->string('foto')->nullable()->after('cidade');
            $table->string('imagem')->nullable()->after('foto')->comment('Imagem do atendimento');
        });
    }

    public function down(): void
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            $table->foreignId('pessoa_id')->after('id')->constrained('pessoas')->cascadeOnDelete();
            $table->dropColumn(['nome_assistido', 'contato', 'endereco', 'bairro', 'cidade', 'foto', 'imagem']);
            $table->string('imagem')->nullable();
        });
    }
};