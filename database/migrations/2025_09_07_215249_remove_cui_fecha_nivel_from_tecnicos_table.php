<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tecnicos', function (Blueprint $table) {
            $table->dropColumn(['cui', 'fecha_contratacion', 'nivel_experiencia']);
        });
    }

    public function down(): void
    {
        Schema::table('tecnicos', function (Blueprint $table) {
            $table->string('cui')->nullable();
            $table->date('fecha_contratacion')->nullable();
            $table->string('nivel_experiencia')->nullable();
        });
    }
};
