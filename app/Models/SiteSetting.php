<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Throwable;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'array',
        ];
    }

    public static function getValue(string $key, mixed $default = null): mixed
    {
        if (! Schema::hasTable('site_settings')) {
            return $default;
        }

        try {
            return static::query()->where('key', $key)->value('value') ?? $default;
        } catch (Throwable) {
            return $default;
        }
    }

    public static function setValue(string $key, mixed $value): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        try {
            static::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        } catch (Throwable) {
            // Ignore write when table is not ready yet.
        }
    }
}
