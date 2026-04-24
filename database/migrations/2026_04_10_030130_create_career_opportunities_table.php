<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company');
            $table->string('location');
            $table->string('employment_type');
            $table->text('summary');
            $table->string('apply_url');
            $table->date('closes_at');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index(['closes_at', 'employment_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_opportunities');
    }
};
