<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Spatie\Translatable\HasTranslations;

class AppSetting extends Model
{
    use HasTranslations;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'is_public',
        'is_encrypted',
        'order',
    ];

    public $translatable = ['label', 'description'];

    protected $casts = [
        'is_public' => 'boolean',
        'is_encrypted' => 'boolean',
        'order' => 'integer',
    ];

    // Accessor للقيمة مع فك التشفير إذا لزم الأمر
    public function getValueAttribute($value)
    {
        if ($this->is_encrypted && $value) {
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                return $value;
            }
        }
        return $value;
    }

    // Mutator للقيمة مع التشفير إذا لزم الأمر
    public function setValueAttribute($value)
    {
        if ($this->is_encrypted && $value) {
            $this->attributes['value'] = Crypt::encryptString($value);
        } else {
            $this->attributes['value'] = $value;
        }
    }

    // Helper Methods
    public static function get($key, $default = null)
    {
        return Cache::remember("app_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set($key, $value, $type = 'string', $group = 'general')
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
            ]
        );

        Cache::forget("app_setting_{$key}");
        return $setting;
    }

    public static function getByGroup($group)
    {
        return static::where('group', $group)->orderBy('order')->get();
    }

    public static function getPublic()
    {
        return Cache::remember('app_settings_public', 3600, function () {
            return static::where('is_public', true)->get()->pluck('value', 'key');
        });
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Boot method لمسح الكاش عند التحديث
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($setting) {
            Cache::forget("app_setting_{$setting->key}");
            Cache::forget('app_settings_public');
        });

        static::deleted(function ($setting) {
            Cache::forget("app_setting_{$setting->key}");
            Cache::forget('app_settings_public');
        });
    }
}
