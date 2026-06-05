<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracer_study_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Identitas
            $table->string('name');
            $table->string('nim')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('program');
            $table->unsignedSmallInteger('batch_year');
            $table->unsignedSmallInteger('graduation_year')->nullable();

            // Kondisi kerja
            $table->string('employment_status'); // Bekerja, Wirausaha, Melanjutkan S2, Belum Bekerja
            $table->string('employer')->nullable();
            $table->string('job_title')->nullable();
            $table->string('industry')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();

            // Kesesuaian
            $table->string('job_relevance')->nullable(); // Sangat Sesuai, Sesuai, Kurang Sesuai, Tidak Sesuai
            $table->unsignedTinyInteger('waiting_time_months')->nullable(); // lama cari kerja (bulan)

            // Evaluasi kurikulum
            $table->tinyInteger('curriculum_rating')->nullable(); // 1-5
            $table->text('suggestion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracer_study_responses');
    }
};
