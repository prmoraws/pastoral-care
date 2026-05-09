<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('convites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criado_por')->constrained('users')->cascadeOnDelete();
            $table->string('token', 64)->unique();
            $table->enum('papel', ['editor', 'author'])->comment('editor=Coordenador, author=Voluntário');
            $table->boolean('usado')->default(false);
            $table->foreignId('usado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('convites');
    }
};
