<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group'];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        // Cast value based on type
        return match($setting->type) {
            'boolean' => (bool) $setting->value,
            'integer' => (int) $setting->value,
            'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $type = 'string', $group = 'general')
    {
        // Convert value to string for storage
        $stringValue = match($type) {
            'boolean' => $value ? '1' : '0',
            'json' => json_encode($value),
            default => (string) $value,
        };

        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $stringValue,
                'type' => $type,
                'group' => $group
            ]
        );
    }

    /**
     * Get all settings as key-value pairs
     */
    public static function getAll($group = null)
    {
        $query = self::query();

        if ($group) {
            $query->where('group', $group);
        }

        return $query->get()->mapWithKeys(function ($setting) {
            return [$setting->key => self::get($setting->key)];
        });
    }
}
