<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regiaos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('bloco_id')->constrained('blocos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regiaos');
    }
};