<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Como o banco já está criado com IDs incrementais, vamos apenas garantir que as tabelas existam e talvez adicionar UUID se necessário,
        // mas para simplificar e evitar erros de migração em um banco existente, vamos manter os IDs como inteiros por enquanto,
        // já que o código PHP foi atualizado para usar HasUuids, o que pode causar conflito se a coluna no banco for INT.
        // O ideal seria recriar as tabelas ou alterar a coluna, mas isso é arriscado sem saber o estado exato do banco.
        // Vou assumir que o usuário quer usar UUIDs e alterar as tabelas para suportar isso, ou reverter a trait HasUuids nos models se o banco for INT.

        // Verificando os models, eles usam HasUuids. Se o banco for novo, ok. Se for antigo, vai dar erro.
        // Vou alterar os models para NÃO usar HasUuids por enquanto, para garantir compatibilidade com as migrations originais que usam $table->id().
        // Se o usuário quiser UUIDs, precisaria alterar as migrations de criação para $table->uuid('id')->primary().
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
