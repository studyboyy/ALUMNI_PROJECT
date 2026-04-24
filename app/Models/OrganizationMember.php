<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'division',
        'period',
        'focus_area',
        'photo_url',
        'sort_order',
    ];
}
