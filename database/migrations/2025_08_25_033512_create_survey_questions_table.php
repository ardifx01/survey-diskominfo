<?php
// database/migrations/2025_08_25_100001_create_survey_questions_table.php
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
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('survey_sections')->onDelete('cascade');
            $table->string('question_text');
            $table->enum('question_type', [
                'short_text',      // Jawaban singkat
                'long_text',       // Paragraf
                'multiple_choice', // Pilihan ganda
                'checkbox',        // Kotak centang
                'dropdown',        // Drop-down
                'file_upload',     // Upload file
                'linear_scale'     // Skala linier
            ]);
            $table->json('options')->nullable(); // Untuk menyimpan opsi pilihan
            $table->json('settings')->nullable(); // Untuk setting tambahan (required, min/max scale, dll)
            $table->integer('order_index')->default(0);
            $table->boolean('is_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
