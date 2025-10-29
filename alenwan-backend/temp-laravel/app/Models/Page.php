<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'type',
        'icon',
        'banner_image',
        'order',
        'is_published',
        'show_in_menu',
        'show_in_footer',
    ];

    public $translatable = ['title', 'content', 'meta_title', 'meta_description', 'meta_keywords'];

    protected $casts = [
        'is_published' => 'boolean',
        'show_in_menu' => 'boolean',
        'show_in_footer' => 'boolean',
        'order' => 'integer',
    ];

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeInMenu($query)
    {
        return $query->where('show_in_menu', true);
    }

    public function scopeInFooter($query)
    {
        return $query->where('show_in_footer', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Helper Methods
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getPageUrl()
    {
        return route('pages.show', $this->slug);
    }

    public static function getTypes()
    {
        return [
            'about' => __('من نحن'),
            'features' => __('الميزات'),
            'pricing' => __('الأسعار'),
            'support' => __('الدعم'),
            'help_center' => __('مركز المساعدة'),
            'faq' => __('الأسئلة الشائعة'),
            'contact' => __('اتصل بنا'),
            'terms' => __('الشروط والأحكام'),
            'privacy' => __('سياسة الخصوصية'),
            'security' => __('الأمان والخصوصية'),
            'cancellation' => __('سياسة الإلغاء'),
            'refund' => __('سياسة الاسترداد'),
            'subscription_delete' => __('سياسة حذف الاشتراك'),
            'custom' => __('صفحة مخصصة'),
        ];
    }
}
