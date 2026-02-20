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
        Schema::table('users', function (Blueprint $table) {
            $table->string('tipo_documento')->after('name');
            $table->string('numero_documento')->after('tipo_documento');
            $table->string('celular')->after('numero_documento');
            $table->string('organizacion')->nullable()->after('celular');
            $table->boolean('acepta_tratamiento_datos')->default(false)->after('organizacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tipo_documento', 'numero_documento', 'celular', 'organizacion', 'acepta_tratamiento_datos']);
        });
    }
};
