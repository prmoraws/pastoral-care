<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atualizacoes', function (Blueprint $table) {
            $table->unsignedInteger('curtidas_count')->default(0)->after('foto');
            $table->unsignedInteger('comentarios_count')->default(0)->after('curtidas_count');
        });

        Schema::create('atualizacao_curtidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('atualizacao_id')->constrained('atualizacoes')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['user_id', 'atualizacao_id']);
        });

        Schema::create('atualizacao_comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('atualizacao_id')->constrained('atualizacoes')->cascadeOnDelete();
            $table->text('comentario');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atualizacao_curtidas');
        Schema::dropIfExists('atualizacao_comentarios');
        Schema::table('atualizacoes', function (Blueprint $table) {
            $table->dropColumn(['curtidas_count', 'comentarios_count']);
        });
    }
};