<?php
// database/migrations/2025_09_05_000001_create_contact_info_table.php
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
        Schema::create('contact_info', function (Blueprint $table) {
            $table->id();
            $table->string('department_name')->default('Dinas Komunikasi dan Informatika');
            $table->string('regency_name')->default('Kabupaten Lamongan');
            $table->string('address')->default('Jl. Basuki Rahmat No. 1, Lamongan');
            $table->string('province')->default('Jawa Timur 62211');
            $table->string('whatsapp')->default('+628113021708');
            $table->string('email')->default('diskominfo@lamongankab.go.id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_info');
    }
};