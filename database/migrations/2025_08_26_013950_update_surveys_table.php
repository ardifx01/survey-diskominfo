<?php
// database/migrations/2025_08_21_045023_update_surveys_table.php
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
            // Drop unused columns
            $table->dropColumn(['nama', 'jenis_kelamin', 'usia']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            // Add back the columns if rollback
            $table->string('nama');
            $table->enum('jenis_kelamin', ['perempuan', 'laki_laki']);
            $table->integer('usia');
        });
    }
};