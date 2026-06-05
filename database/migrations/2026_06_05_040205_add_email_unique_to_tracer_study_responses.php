<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tracer_study_responses', function (Blueprint $table) {
            // Satu email hanya boleh submit satu kali
            $table->unique('email');
            // Index untuk query user_id
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('tracer_study_responses', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->dropIndex(['user_id']);
        });
    }
};
