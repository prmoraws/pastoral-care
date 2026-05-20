<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('igrejas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('regiao_id')->constrained('regiaos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('igrejas');
    }
};