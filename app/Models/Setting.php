<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public const DEFAULTS = [
        'store_name'         => 'خرازی پرنسا',
        'store_phone'        => '۰۲۱-۴۴۵۵۶۶۷۷',
        'store_address'      => 'تهران، خیابان آزادی',
        'shipping_cost'      => '45000',
        'free_ship_min'      => '500000',
        'gateway_mode'       => 'demo',        // demo | zarinpal
        'gateway_merchant'   => '',
    ];

    public static function get(string $key): string
    {
        $val = Cache::rememberForever('settings.all', fn () => static::pluck('value', 'key')->all())[$key] ?? null;
        return $val ?? (self::DEFAULTS[$key] ?? '');
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings.all');
    }

    public static function setMany(array $pairs): void
    {
        foreach ($pairs as $k => $v) {
            static::updateOrCreate(['key' => $k], ['value' => $v]);
        }
        Cache::forget('settings.all');
    }
}
