<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'batch_year',
        'role',
        'company',
        'quote',
        'photo_url',
        'sort_order',
    ];
}
