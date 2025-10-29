<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_configs', function (Blueprint $table) {
            $table->id();

            // App Information
            $table->string('app_name')->default('Alenwan');
            $table->string('app_version')->default('1.0.0');
            $table->string('api_version')->default('1.0');
            $table->text('app_description')->nullable();
            $table->string('app_logo')->nullable();
            $table->string('app_icon')->nullable();
            $table->string('splash_screen')->nullable();

            // Colors & Theme
            $table->string('primary_color')->default('#FF5722');
            $table->string('secondary_color')->default('#FFC107');
            $table->string('accent_color')->default('#03A9F4');
            $table->string('background_color')->default('#FFFFFF');
            $table->string('text_color')->default('#000000');
            $table->boolean('dark_mode_enabled')->default(true);

            // Features Control
            $table->boolean('registration_enabled')->default(true);
            $table->boolean('social_login_enabled')->default(true);
            $table->boolean('guest_mode_enabled')->default(true);
            $table->boolean('download_enabled')->default(true);
            $table->boolean('sharing_enabled')->default(true);
            $table->boolean('comments_enabled')->default(true);
            $table->boolean('ratings_enabled')->default(true);
            $table->boolean('watchlist_enabled')->default(true);
            $table->boolean('continue_watching_enabled')->default(true);
            $table->boolean('search_enabled')->default(true);
            $table->boolean('filters_enabled')->default(true);

            // Content Control
            $table->boolean('movies_enabled')->default(true);
            $table->boolean('series_enabled')->default(true);
            $table->boolean('live_tv_enabled')->default(false);
            $table->boolean('podcasts_enabled')->default(false);
            $table->integer('featured_content_limit')->default(10);
            $table->integer('home_categories_limit')->default(5);

            // Subscription
            $table->boolean('free_content_enabled')->default(true);
            $table->boolean('premium_content_enabled')->default(true);
            $table->boolean('free_trial_enabled')->default(true);
            $table->integer('free_trial_days')->default(7);

            // Video Player
            $table->boolean('auto_play_next')->default(true);
            $table->boolean('skip_intro_enabled')->default(true);
            $table->integer('skip_intro_duration')->default(90);
            $table->json('video_qualities')->nullable(); // ["360p", "480p", "720p", "1080p"]
            $table->string('default_quality')->default('auto');
            $table->boolean('subtitles_enabled')->default(true);
            $table->boolean('pip_mode_enabled')->default(true);

            // Notifications
            $table->boolean('push_notifications_enabled')->default(true);
            $table->boolean('email_notifications_enabled')->default(true);
            $table->boolean('new_content_notification')->default(true);
            $table->boolean('subscription_expiry_notification')->default(true);

            // Ads Control
            $table->boolean('ads_enabled')->default(false);
            $table->string('ad_network')->nullable(); // admob, facebook, custom
            $table->string('banner_ad_id')->nullable();
            $table->string('interstitial_ad_id')->nullable();
            $table->string('rewarded_ad_id')->nullable();
            $table->integer('ads_frequency')->default(3); // show ad every X minutes

            // Social Links
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('support_email')->nullable();
            $table->string('support_phone')->nullable();
            $table->string('website_url')->nullable();

            // Legal
            $table->text('terms_of_service')->nullable();
            $table->text('privacy_policy')->nullable();
            $table->text('about_us')->nullable();
            $table->text('contact_info')->nullable();

            // Maintenance
            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message')->nullable();
            $table->string('minimum_app_version')->nullable();
            $table->boolean('force_update')->default(false);
            $table->text('update_message')->nullable();
            $table->string('update_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_configs');
    }
};
