<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('atendimentos', 'assistidos');
    }

    public function down(): void
    {
        Schema::rename('assistidos', 'atendimentos');
    }
};
