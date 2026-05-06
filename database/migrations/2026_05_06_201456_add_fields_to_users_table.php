<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email');
            $table->string('cargo')->nullable()->after('avatar')->comment('Bispo|Pastor|Esposa|Obreiro - apenas coordenadores');
            $table->string('condicao')->nullable()->after('cargo')->comment('obreiro|evangelista|membro - apenas voluntários');
            $table->string('contato')->nullable()->after('condicao');
            $table->boolean('ativo')->default(true)->after('contato');
            $table->string('registration_token')->nullable()->after('ativo');
            $table->timestamp('token_expires_at')->nullable()->after('registration_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'cargo', 'condicao', 'contato', 'ativo', 'registration_token', 'token_expires_at']);
        });
    }
};