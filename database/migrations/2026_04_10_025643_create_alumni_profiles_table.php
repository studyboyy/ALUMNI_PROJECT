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
        Schema::create('alumni_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('program');
            $table->unsignedSmallInteger('batch_year');
            $table->unsignedSmallInteger('graduation_year')->nullable();
            $table->string('employer')->nullable();
            $table->string('job_title')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('industry')->nullable();
            $table->string('employment_status')->default('Bekerja');
            $table->text('bio')->nullable();
            $table->json('achievements')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('photo_url')->nullable();
            $table->text('testimonial_quote')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index(['program', 'batch_year']);
            $table->index(['employment_status', 'city']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_profiles');
    }
};
