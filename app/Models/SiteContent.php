<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteContent extends Model
{
    protected $fillable = ['key', 'label', 'section', 'type', 'value'];

    public static function get(string $key, string $default = ''): string
    {
        return Cache::rememberForever("site_content.{$key}", function () use ($key, $default) {
            $content = static::where('key', $key)->first();
            return $content ? $content->value : $default;
        });
    }

    public static function isEpaycoConfigured(): bool
    {
        return !empty(static::get('epayco_public_key', ''))
            && !empty(static::get('epayco_private_key', ''))
            && !empty(static::get('epayco_p_cust_id', ''))
            && !empty(static::get('epayco_p_key', ''));
    }

    public static function isStreamingActive(): bool
    {
        return static::get('streaming_enabled', 'false') === 'true'
            && !empty(static::get('streaming_youtube_url', ''));
    }

    public static function getYoutubeEmbedUrl(string $url): string
    {
        $videoId = '';

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|live\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }

        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : '';
    }

    public static function clearCache(string $key = null): void
    {
        if ($key) {
            Cache::forget("site_content.{$key}");
        } else {
            $keys = static::pluck('key');
            foreach ($keys as $k) {
                Cache::forget("site_content.{$k}");
            }
        }
    }
}
