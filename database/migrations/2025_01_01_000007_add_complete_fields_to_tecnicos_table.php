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
            Schema::table('tecnicos', function (Blueprint $table) {
                $table->string('nombres')->nullable()->after('user_id');
                $table->string('apellidos')->nullable()->after('nombres');
                $table->string('telefono', 20)->nullable()->after('apellidos');
                $table->string('email_personal')->nullable()->after('telefono');
                $table->string('dpi', 20)->nullable()->after('email_personal');
                $table->string('foto')->nullable()->after('dpi');
                $table->text('direccion')->nullable()->after('foto');
                $table->date('fecha_nacimiento')->nullable()->after('direccion');
                $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable()->after('fecha_nacimiento');
                $table->string('estado_civil')->nullable()->after('genero');
                            $table->text('contacto_emergencia')->nullable()->after('estado_civil');
            $table->date('fecha_contratacion')->nullable()->after('contacto_emergencia');
                $table->enum('nivel_experiencia', ['principiante', 'intermedio', 'avanzado', 'experto'])->nullable()->after('fecha_contratacion');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('tecnicos', function (Blueprint $table) {
                $table->dropColumn([
                    'nombres',
                    'apellidos',
                    'telefono',
                    'email_personal',
                    'dpi',
                    'foto',
                    'direccion',
                    'fecha_nacimiento',
                    'genero',
                                    'estado_civil',
                'contacto_emergencia',
                'fecha_contratacion',
                    'nivel_experiencia'
                ]);
            });
        }
    };
