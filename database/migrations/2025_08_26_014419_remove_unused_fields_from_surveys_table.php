<?php
// database/migrations/xxxx_xx_xx_xxxxxx_remove_unused_fields_from_surveys_table.php
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
        Schema::table('surveys', function (Blueprint $table) {
            // Cek apakah kolom ada sebelum menghapus
            if (Schema::hasColumn('surveys', 'nama')) {
                $table->dropColumn('nama');
            }
            if (Schema::hasColumn('surveys', 'jenis_kelamin')) {
                $table->dropColumn('jenis_kelamin');
            }
            if (Schema::hasColumn('surveys', 'usia')) {
                $table->dropColumn('usia');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            // Tambah kembali kolom jika rollback
            $table->string('nama')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->integer('usia')->nullable();
        });
    }
};