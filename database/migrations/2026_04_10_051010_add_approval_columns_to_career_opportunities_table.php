<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('career_opportunities', function (Blueprint $table) {
            $table->foreignId('submitted_by')->nullable()->after('is_featured')->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->after('submitted_by')->constrained('users')->nullOnDelete();
            $table->string('approval_status')->default('pending')->after('approved_by');
            $table->text('approval_notes')->nullable()->after('approval_status');
            $table->timestamp('approved_at')->nullable()->after('approval_notes');

            $table->index(['approval_status', 'closes_at']);
        });
    }

    public function down(): void
    {
        Schema::table('career_opportunities', function (Blueprint $table) {
            $table->dropIndex(['approval_status', 'closes_at']);
            $table->dropConstrainedForeignId('approved_by');
            $table->dropConstrainedForeignId('submitted_by');
            $table->dropColumn(['approval_status', 'approval_notes', 'approved_at']);
        });
    }
};
