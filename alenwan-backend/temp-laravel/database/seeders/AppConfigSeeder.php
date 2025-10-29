<?php

namespace Database\Seeders;

use App\Models\AppConfig;
use Illuminate\Database\Seeder;

class AppConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $config = [
            // App Information
            'app_name' => 'Alenwan',
            'app_version' => '1.0.0',
            'api_version' => '1.0',
            'app_description' => 'أفضل منصة لمشاهدة الأفلام والمسلسلات',
            'app_logo' => null,
            'app_icon' => null,
            'splash_screen' => null,

            // Colors & Theme
            'primary_color' => '#FF5722',
            'secondary_color' => '#FFC107',
            'accent_color' => '#03A9F4',
            'background_color' => '#FFFFFF',
            'text_color' => '#000000',
            'dark_mode_enabled' => true,

            // Features Control
            'registration_enabled' => true,
            'social_login_enabled' => true,
            'guest_mode_enabled' => true,
            'download_enabled' => true,
            'sharing_enabled' => true,
            'comments_enabled' => true,
            'ratings_enabled' => true,
            'watchlist_enabled' => true,
            'continue_watching_enabled' => true,
            'search_enabled' => true,
            'filters_enabled' => true,

            // Content Control
            'movies_enabled' => true,
            'series_enabled' => true,
            'live_tv_enabled' => false,
            'podcasts_enabled' => false,
            'featured_content_limit' => 10,
            'home_categories_limit' => 5,

            // Subscription
            'free_content_enabled' => true,
            'premium_content_enabled' => true,
            'free_trial_enabled' => true,
            'free_trial_days' => 7,

            // Video Player
            'auto_play_next' => true,
            'skip_intro_enabled' => true,
            'skip_intro_duration' => 90,
            'video_qualities' => json_encode(['360p', '480p', '720p', '1080p']),
            'default_quality' => 'auto',
            'subtitles_enabled' => true,
            'pip_mode_enabled' => true,

            // Notifications
            'push_notifications_enabled' => true,
            'email_notifications_enabled' => true,
            'new_content_notification' => true,
            'subscription_expiry_notification' => true,

            // Ads Control
            'ads_enabled' => false,
            'ad_network' => null,
            'banner_ad_id' => null,
            'interstitial_ad_id' => null,
            'rewarded_ad_id' => null,
            'ads_frequency' => 3,

            // Social Links
            'facebook_url' => 'https://facebook.com/alenwan',
            'twitter_url' => 'https://twitter.com/alenwan',
            'instagram_url' => 'https://instagram.com/alenwan',
            'youtube_url' => 'https://youtube.com/@alenwan',
            'support_email' => 'support@alenwan.com',
            'support_phone' => '+966500000000',
            'website_url' => 'https://alenwan.com',

            // Legal
            'terms_of_service' => 'شروط الخدمة سيتم إضافتها هنا...',
            'privacy_policy' => 'سياسة الخصوصية سيتم إضافتها هنا...',
            'about_us' => 'نحن منصة رائدة في مجال البث المباشر للأفلام والمسلسلات العربية والعالمية.',
            'contact_info' => 'للتواصل معنا: support@alenwan.com',

            // Maintenance
            'maintenance_mode' => false,
            'maintenance_message' => 'نعمل حالياً على تحسين الخدمة. سنعود قريباً!',
            'minimum_app_version' => '1.0.0',
            'force_update' => false,
            'update_message' => 'يتوفر تحديث جديد! قم بتحديث التطبيق للحصول على أحدث الميزات.',
            'update_url' => null,
        ];

        AppConfig::updateOrCreate(['id' => 1], $config);

        $this->command->info('✅ تم إضافة إعدادات التطبيق بنجاح!');
        $this->command->info('✅ App configuration seeded successfully!');
    }
}
