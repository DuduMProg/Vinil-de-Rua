<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefone')->nullable()->after('email');
            $table->string('cep')->nullable()->after('telefone');
            $table->string('endereco')->nullable()->after('cep');
            $table->string('complemento')->nullable()->after('endereco');
            $table->string('cidade')->nullable()->after('complemento');
            $table->string('estado')->nullable()->after('cidade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telefone', 'cep', 'endereco', 'complemento', 'cidade', 'estado']);
        });
    }
};