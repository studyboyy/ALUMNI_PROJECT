<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'name',
        'slug',
        'email',
        'phone',
        'program',
        'campus_name',
        'batch_year',
        'graduation_year',
        'employer',
        'job_title',
        'city',
        'province',
        'industry',
        'employment_status',
        'bio',
        'achievements',
        'linkedin_url',
        'photo_url',
        'testimonial_quote',
    ];

    protected function casts(): array
    {
        return [
            'achievements' => 'array',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getInitialsAttribute(): string
    {
        $name = trim((string) $this->name);

        if ($name === '') {
            return 'AL';
        }

        $parts = preg_split('/\s+/', $name) ?: [];
        $initials = collect($parts)
            ->filter()
            ->take(2)
            ->map(fn (string $part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');

        return $initials !== '' ? $initials : 'AL';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where(function (Builder $query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('campus_name', 'like', "%{$search}%")
                        ->orWhere('employer', 'like', "%{$search}%")
                        ->orWhere('job_title', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%");
                });
            })
            ->when($filters['program'] ?? null, fn (Builder $query, string $program) => $query->where('program', $program))
            ->when($filters['batch_year'] ?? null, fn (Builder $query, string $batchYear) => $query->where('batch_year', $batchYear))
            ->when($filters['employer'] ?? null, fn (Builder $query, string $employer) => $query->where('employer', 'like', "%{$employer}%"));
    }
}
