<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'summary',
        'impact_target',
        'status',
        'sort_order',
    ];
}
