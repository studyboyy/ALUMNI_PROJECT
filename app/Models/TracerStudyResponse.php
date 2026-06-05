<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerStudyResponse extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'nim',
        'email',
        'phone',
        'program',
        'batch_year',
        'graduation_year',
        'employment_status',
        'employer',
        'job_title',
        'industry',
        'city',
        'province',
        'job_relevance',
        'waiting_time_months',
        'curriculum_rating',
        'suggestion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
