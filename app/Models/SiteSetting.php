<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    /**
     * Default values used when no row exists in the database yet.
     * These are also the values seeded by DatabaseSeeder.
     */
    public const DEFAULTS = [
        'hero_title'        => 'Find The Best Lawyers',
        'hero_subtitle'     => 'Search lawyers by specialization and city. Book appointments online.',
        'stat_online_label' => 'Online Booking',
        'stat_online_value' => '24/7',
        'footer_about'      => 'Find the best lawyers in your city. Book appointments online easily and quickly.',
        'footer_email'      => 'info@lawyerconnect.com',
        'footer_phone'      => '+92 300 1234567',
        'footer_address'    => 'Karachi, Pakistan',
    ];

    /**
     * Get a single setting value by key (with cache + fallback to default).
     */
    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("site_setting:{$key}", function () use ($key, $default) {
            $row = self::where('key', $key)->first();
            return $row?->value ?? self::DEFAULTS[$key] ?? $default;
        });
    }

    /**
     * Set a single setting value (and bust the cache).
     */
    public static function set(string $key, string $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value],
        );
        Cache::forget("site_setting:{$key}");
    }

    /**
     * Bulk-set multiple settings at once.
     */
    public static function setMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            self::set($key, $value);
        }
    }

    /**
     * Forget all cached settings (called when admin updates content).
     */
    public static function flushCache(): void
    {
        foreach (array_keys(self::DEFAULTS) as $key) {
            Cache::forget("site_setting:{$key}");
        }
    }
}
