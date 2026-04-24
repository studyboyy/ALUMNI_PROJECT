<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerOpportunity extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'company',
        'location',
        'employment_type',
        'summary',
        'apply_url',
        'closes_at',
        'is_featured',
        'submitted_by',
        'approved_by',
        'approval_status',
        'approval_notes',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'closes_at' => 'date',
            'is_featured' => 'boolean',
            'approved_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query
            ->where('approval_status', self::STATUS_APPROVED)
            ->whereDate('closes_at', '>=', now()->toDateString())
            ->orderBy('closes_at');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query
            ->where('approval_status', self::STATUS_PENDING)
            ->orderByDesc('created_at');
    }
}
