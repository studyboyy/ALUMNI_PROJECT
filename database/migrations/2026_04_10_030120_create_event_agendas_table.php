<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->text('summary');
            $table->string('location');
            $table->timestamp('starts_at');
            $table->string('registration_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index(['category', 'starts_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_agendas');
    }
};
