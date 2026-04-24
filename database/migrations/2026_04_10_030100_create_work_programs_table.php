<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->text('summary');
            $table->string('impact_target')->nullable();
            $table->string('status')->default('Berjalan');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_programs');
    }
};
