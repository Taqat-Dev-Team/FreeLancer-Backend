<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Setting extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['key', 'value'];

    public $timestamps = false;



    public static function getValue($key, $default = null)
    {
        return setting($key, $default); // استخدم الهيلبر مباشرةً
    }

    public static function setValue($key, $value)
    {
        $setting = static::updateOrCreate(['key' => $key], ['value' => $value]);

        // تحديث الكاش بعد التغيير
        Cache::forget('settings_cache');
        return $setting;
    }

}
