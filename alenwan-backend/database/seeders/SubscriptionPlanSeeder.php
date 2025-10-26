<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Basic access to limited content with ads. Perfect for casual viewers.',
                'price_monthly' => 0.00,
                'price_yearly' => 0.00,
                'price_lifetime' => null,
                'currency' => 'USD',
                'features' => json_encode([
                    'SD quality streaming',
                    '1 screen at a time',
                    'Limited content library',
                    'Ad-supported viewing',
                    'Mobile & web access'
                ]),
                'max_devices' => 1,
                'max_downloads' => 0,
                'max_profiles' => 1,
                'supports_4k' => false,
                'supports_hdr' => false,
                'supports_offline' => false,
                'no_ads' => false,
                'trial_days' => 0,
                'sort_order' => 1,
                'is_popular' => false,
                'is_active' => true,
                'stripe_product_id' => null,
                'stripe_price_monthly_id' => null,
                'stripe_price_yearly_id' => null,
                'apple_product_id' => 'com.alenwan.free',
                'google_product_id' => 'com.alenwan.free',
                'metadata' => json_encode([
                    'recommended_for' => 'Casual viewers',
                    'color' => '#6B7280'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'description' => 'HD streaming on 2 devices with no ads. Great for individuals and couples.',
                'price_monthly' => 9.99,
                'price_yearly' => 99.99,
                'price_lifetime' => null,
                'currency' => 'USD',
                'features' => json_encode([
                    'HD quality streaming (1080p)',
                    '2 screens simultaneously',
                    'Full content library',
                    'Ad-free experience',
                    'Mobile, web & TV access',
                    '7-day free trial'
                ]),
                'max_devices' => 2,
                'max_downloads' => 0,
                'max_profiles' => 2,
                'supports_4k' => false,
                'supports_hdr' => false,
                'supports_offline' => false,
                'no_ads' => true,
                'trial_days' => 7,
                'sort_order' => 2,
                'is_popular' => false,
                'is_active' => true,
                'stripe_product_id' => 'prod_basic',
                'stripe_price_monthly_id' => 'price_basic_monthly',
                'stripe_price_yearly_id' => 'price_basic_yearly',
                'apple_product_id' => 'com.alenwan.basic',
                'google_product_id' => 'com.alenwan.basic',
                'metadata' => json_encode([
                    'recommended_for' => 'Individuals & couples',
                    'color' => '#3B82F6',
                    'savings_yearly' => '17%'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'description' => '4K Ultra HD on 4 devices with download capability. Most popular for families.',
                'price_monthly' => 15.99,
                'price_yearly' => 159.99,
                'price_lifetime' => 499.99,
                'currency' => 'USD',
                'features' => json_encode([
                    '4K Ultra HD quality',
                    'HDR & Dolby Atmos',
                    '4 screens simultaneously',
                    'Unlimited downloads',
                    'Offline viewing',
                    'Ad-free experience',
                    'All devices supported',
                    '14-day free trial',
                    'Early access to new releases'
                ]),
                'max_devices' => 4,
                'max_downloads' => 0, // 0 means unlimited
                'max_profiles' => 4,
                'supports_4k' => true,
                'supports_hdr' => true,
                'supports_offline' => true,
                'no_ads' => true,
                'trial_days' => 14,
                'sort_order' => 3,
                'is_popular' => true,
                'is_active' => true,
                'stripe_product_id' => 'prod_premium',
                'stripe_price_monthly_id' => 'price_premium_monthly',
                'stripe_price_yearly_id' => 'price_premium_yearly',
                'apple_product_id' => 'com.alenwan.premium',
                'google_product_id' => 'com.alenwan.premium',
                'metadata' => json_encode([
                    'recommended_for' => 'Families',
                    'color' => '#8B5CF6',
                    'savings_yearly' => '17%',
                    'badge' => 'MOST POPULAR'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Ultimate streaming experience with 8 screens and priority support for large households.',
                'price_monthly' => 29.99,
                'price_yearly' => 299.99,
                'price_lifetime' => 899.99,
                'currency' => 'USD',
                'features' => json_encode([
                    '4K Ultra HD quality',
                    'HDR & Dolby Atmos',
                    '8 screens simultaneously',
                    'Unlimited downloads',
                    'Offline viewing',
                    'Ad-free experience',
                    'All devices supported',
                    'Priority customer support',
                    'Exclusive content',
                    '30-day free trial',
                    'Early access to new releases',
                    'Behind-the-scenes content'
                ]),
                'max_devices' => 8,
                'max_downloads' => 0, // 0 means unlimited
                'max_profiles' => 8,
                'supports_4k' => true,
                'supports_hdr' => true,
                'supports_offline' => true,
                'no_ads' => true,
                'trial_days' => 30,
                'sort_order' => 4,
                'is_popular' => false,
                'is_active' => true,
                'stripe_product_id' => 'prod_enterprise',
                'stripe_price_monthly_id' => 'price_enterprise_monthly',
                'stripe_price_yearly_id' => 'price_enterprise_yearly',
                'apple_product_id' => 'com.alenwan.enterprise',
                'google_product_id' => 'com.alenwan.enterprise',
                'metadata' => json_encode([
                    'recommended_for' => 'Large households & businesses',
                    'color' => '#F59E0B',
                    'savings_yearly' => '17%',
                    'badge' => 'BEST VALUE'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('subscription_plans')->insert($plans);
    }
}
