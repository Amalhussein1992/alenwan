<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\AppSetting;

echo "⚙️ إضافة إعدادات التطبيق...

";

$settings = [
    // ==================== الإعدادات العامة ====================
    [
        'key' => 'app_name',
        'value' => 'Alenwan',
        'type' => 'string',
        'group' => 'general',
        'label' => ['ar' => 'اسم التطبيق', 'en' => 'App Name'],
        'description' => ['ar' => 'اسم التطبيق الذي يظهر في كل مكان', 'en' => 'The app name that appears everywhere'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 1,
    ],
    [
        'key' => 'app_url',
        'value' => 'https://alenwan.com',
        'type' => 'string',
        'group' => 'general',
        'label' => ['ar' => 'رابط التطبيق', 'en' => 'App URL'],
        'description' => ['ar' => 'الرابط الأساسي للتطبيق', 'en' => 'The main URL of the app'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 2,
    ],
    [
        'key' => 'app_logo',
        'value' => '/images/logo.png',
        'type' => 'file',
        'group' => 'general',
        'label' => ['ar' => 'شعار التطبيق', 'en' => 'App Logo'],
        'description' => ['ar' => 'شعار التطبيق الرئيسي', 'en' => 'Main app logo'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 3,
    ],
    [
        'key' => 'app_description',
        'value' => 'منصة بث محتوى متكاملة',
        'type' => 'string',
        'group' => 'general',
        'label' => ['ar' => 'وصف التطبيق', 'en' => 'App Description'],
        'description' => ['ar' => 'وصف مختصر عن التطبيق', 'en' => 'Brief description about the app'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 4,
    ],
    [
        'key' => 'default_language',
        'value' => 'ar',
        'type' => 'string',
        'group' => 'general',
        'label' => ['ar' => 'اللغة الافتراضية', 'en' => 'Default Language'],
        'description' => ['ar' => 'اللغة الافتراضية للتطبيق', 'en' => 'Default language for the app'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 5,
    ],
    [
        'key' => 'timezone',
        'value' => 'Asia/Riyadh',
        'type' => 'string',
        'group' => 'general',
        'label' => ['ar' => 'المنطقة الزمنية', 'en' => 'Timezone'],
        'description' => ['ar' => 'المنطقة الزمنية للتطبيق', 'en' => 'App timezone'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 6,
    ],
    [
        'key' => 'currency',
        'value' => 'SAR',
        'type' => 'string',
        'group' => 'general',
        'label' => ['ar' => 'العملة', 'en' => 'Currency'],
        'description' => ['ar' => 'العملة المستخدمة', 'en' => 'Currency used'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 7,
    ],
    [
        'key' => 'contact_email',
        'value' => 'info@alenwan.com',
        'type' => 'string',
        'group' => 'general',
        'label' => ['ar' => 'البريد الإلكتروني للتواصل', 'en' => 'Contact Email'],
        'description' => ['ar' => 'البريد الإلكتروني الرئيسي', 'en' => 'Main contact email'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 8,
    ],
    [
        'key' => 'contact_phone',
        'value' => '920000000',
        'type' => 'string',
        'group' => 'general',
        'label' => ['ar' => 'رقم الهاتف', 'en' => 'Phone Number'],
        'description' => ['ar' => 'رقم الهاتف للتواصل', 'en' => 'Contact phone number'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 9,
    ],
    [
        'key' => 'maintenance_mode',
        'value' => 'false',
        'type' => 'boolean',
        'group' => 'general',
        'label' => ['ar' => 'وضع الصيانة', 'en' => 'Maintenance Mode'],
        'description' => ['ar' => 'تفعيل وضع الصيانة', 'en' => 'Enable maintenance mode'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 10,
    ],

    // ==================== بوابة الدفع TAP ====================
    [
        'key' => 'tap_enabled',
        'value' => 'true',
        'type' => 'boolean',
        'group' => 'payment_tap',
        'label' => ['ar' => 'تفعيل TAP', 'en' => 'Enable TAP'],
        'description' => ['ar' => 'تفعيل بوابة الدفع TAP', 'en' => 'Enable TAP payment gateway'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 1,
    ],
    [
        'key' => 'tap_secret_key',
        'value' => 'your_tap_secret_key_here',
        'type' => 'string',
        'group' => 'payment_tap',
        'label' => ['ar' => 'TAP Secret Key', 'en' => 'TAP Secret Key'],
        'description' => ['ar' => 'مفتاح TAP السري', 'en' => 'TAP Secret Key'],
        'is_public' => false,
        'is_encrypted' => true,
        'order' => 2,
    ],
    [
        'key' => 'tap_public_key',
        'value' => 'your_tap_public_key_here',
        'type' => 'string',
        'group' => 'payment_tap',
        'label' => ['ar' => 'TAP Public Key', 'en' => 'TAP Public Key'],
        'description' => ['ar' => 'مفتاح TAP العام', 'en' => 'TAP Public Key'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 3,
    ],
    [
        'key' => 'tap_merchant_id',
        'value' => '',
        'type' => 'string',
        'group' => 'payment_tap',
        'label' => ['ar' => 'TAP Merchant ID', 'en' => 'TAP Merchant ID'],
        'description' => ['ar' => 'معرف التاجر في TAP', 'en' => 'TAP Merchant ID'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 4,
    ],
    [
        'key' => 'tap_mode',
        'value' => 'test',
        'type' => 'string',
        'group' => 'payment_tap',
        'label' => ['ar' => 'وضع TAP', 'en' => 'TAP Mode'],
        'description' => ['ar' => 'test أو live', 'en' => 'test or live'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 5,
    ],

    // ==================== بوابة الدفع Stripe ====================
    [
        'key' => 'stripe_enabled',
        'value' => 'false',
        'type' => 'boolean',
        'group' => 'payment_stripe',
        'label' => ['ar' => 'تفعيل Stripe', 'en' => 'Enable Stripe'],
        'description' => ['ar' => 'تفعيل بوابة الدفع Stripe', 'en' => 'Enable Stripe payment gateway'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 1,
    ],
    [
        'key' => 'stripe_secret_key',
        'value' => '',
        'type' => 'string',
        'group' => 'payment_stripe',
        'label' => ['ar' => 'Stripe Secret Key', 'en' => 'Stripe Secret Key'],
        'description' => ['ar' => 'مفتاح Stripe السري', 'en' => 'Stripe Secret Key'],
        'is_public' => false,
        'is_encrypted' => true,
        'order' => 2,
    ],
    [
        'key' => 'stripe_publishable_key',
        'value' => '',
        'type' => 'string',
        'group' => 'payment_stripe',
        'label' => ['ar' => 'Stripe Publishable Key', 'en' => 'Stripe Publishable Key'],
        'description' => ['ar' => 'مفتاح Stripe القابل للنشر', 'en' => 'Stripe Publishable Key'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 3,
    ],
    [
        'key' => 'stripe_webhook_secret',
        'value' => '',
        'type' => 'string',
        'group' => 'payment_stripe',
        'label' => ['ar' => 'Stripe Webhook Secret', 'en' => 'Stripe Webhook Secret'],
        'description' => ['ar' => 'مفتاح Webhook السري', 'en' => 'Webhook Secret Key'],
        'is_public' => false,
        'is_encrypted' => true,
        'order' => 4,
    ],

    // ==================== بوابة الدفع PayPal ====================
    [
        'key' => 'paypal_enabled',
        'value' => 'false',
        'type' => 'boolean',
        'group' => 'payment_paypal',
        'label' => ['ar' => 'تفعيل PayPal', 'en' => 'Enable PayPal'],
        'description' => ['ar' => 'تفعيل بوابة الدفع PayPal', 'en' => 'Enable PayPal payment gateway'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 1,
    ],
    [
        'key' => 'paypal_client_id',
        'value' => '',
        'type' => 'string',
        'group' => 'payment_paypal',
        'label' => ['ar' => 'PayPal Client ID', 'en' => 'PayPal Client ID'],
        'description' => ['ar' => 'معرف عميل PayPal', 'en' => 'PayPal Client ID'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 2,
    ],
    [
        'key' => 'paypal_client_secret',
        'value' => '',
        'type' => 'string',
        'group' => 'payment_paypal',
        'label' => ['ar' => 'PayPal Client Secret', 'en' => 'PayPal Client Secret'],
        'description' => ['ar' => 'سر عميل PayPal', 'en' => 'PayPal Client Secret'],
        'is_public' => false,
        'is_encrypted' => true,
        'order' => 3,
    ],
    [
        'key' => 'paypal_mode',
        'value' => 'sandbox',
        'type' => 'string',
        'group' => 'payment_paypal',
        'label' => ['ar' => 'وضع PayPal', 'en' => 'PayPal Mode'],
        'description' => ['ar' => 'sandbox أو live', 'en' => 'sandbox or live'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 4,
    ],

    // ==================== إعدادات البريد الإلكتروني ====================
    [
        'key' => 'mail_mailer',
        'value' => 'smtp',
        'type' => 'string',
        'group' => 'email',
        'label' => ['ar' => 'نوع البريد', 'en' => 'Mail Mailer'],
        'description' => ['ar' => 'smtp, sendmail, mailgun, etc', 'en' => 'smtp, sendmail, mailgun, etc'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 1,
    ],
    [
        'key' => 'mail_host',
        'value' => 'smtp.gmail.com',
        'type' => 'string',
        'group' => 'email',
        'label' => ['ar' => 'خادم البريد', 'en' => 'Mail Host'],
        'description' => ['ar' => 'عنوان خادم البريد', 'en' => 'Mail server address'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 2,
    ],
    [
        'key' => 'mail_port',
        'value' => '587',
        'type' => 'number',
        'group' => 'email',
        'label' => ['ar' => 'منفذ البريد', 'en' => 'Mail Port'],
        'description' => ['ar' => 'رقم منفذ خادم البريد', 'en' => 'Mail server port number'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 3,
    ],
    [
        'key' => 'mail_username',
        'value' => '',
        'type' => 'string',
        'group' => 'email',
        'label' => ['ar' => 'اسم مستخدم البريد', 'en' => 'Mail Username'],
        'description' => ['ar' => 'اسم المستخدم لخادم البريد', 'en' => 'Mail server username'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 4,
    ],
    [
        'key' => 'mail_password',
        'value' => '',
        'type' => 'string',
        'group' => 'email',
        'label' => ['ar' => 'كلمة مرور البريد', 'en' => 'Mail Password'],
        'description' => ['ar' => 'كلمة المرور لخادم البريد', 'en' => 'Mail server password'],
        'is_public' => false,
        'is_encrypted' => true,
        'order' => 5,
    ],
    [
        'key' => 'mail_encryption',
        'value' => 'tls',
        'type' => 'string',
        'group' => 'email',
        'label' => ['ar' => 'تشفير البريد', 'en' => 'Mail Encryption'],
        'description' => ['ar' => 'tls أو ssl', 'en' => 'tls or ssl'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 6,
    ],
    [
        'key' => 'mail_from_address',
        'value' => 'noreply@alenwan.com',
        'type' => 'string',
        'group' => 'email',
        'label' => ['ar' => 'البريد المرسل', 'en' => 'Mail From Address'],
        'description' => ['ar' => 'عنوان البريد المرسل', 'en' => 'From email address'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 7,
    ],
    [
        'key' => 'mail_from_name',
        'value' => 'Alenwan',
        'type' => 'string',
        'group' => 'email',
        'label' => ['ar' => 'اسم المرسل', 'en' => 'Mail From Name'],
        'description' => ['ar' => 'اسم المرسل الظاهر', 'en' => 'From name displayed'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 8,
    ],

    // ==================== API Keys ====================
    [
        'key' => 'vimeo_access_token',
        'value' => '',
        'type' => 'string',
        'group' => 'api_keys',
        'label' => ['ar' => 'Vimeo Access Token', 'en' => 'Vimeo Access Token'],
        'description' => ['ar' => 'رمز الوصول لـ Vimeo API', 'en' => 'Vimeo API access token'],
        'is_public' => false,
        'is_encrypted' => true,
        'order' => 1,
    ],
    [
        'key' => 'vimeo_client_id',
        'value' => '',
        'type' => 'string',
        'group' => 'api_keys',
        'label' => ['ar' => 'Vimeo Client ID', 'en' => 'Vimeo Client ID'],
        'description' => ['ar' => 'معرف عميل Vimeo', 'en' => 'Vimeo Client ID'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 2,
    ],
    [
        'key' => 'vimeo_client_secret',
        'value' => '',
        'type' => 'string',
        'group' => 'api_keys',
        'label' => ['ar' => 'Vimeo Client Secret', 'en' => 'Vimeo Client Secret'],
        'description' => ['ar' => 'سر عميل Vimeo', 'en' => 'Vimeo Client Secret'],
        'is_public' => false,
        'is_encrypted' => true,
        'order' => 3,
    ],
    [
        'key' => 'youtube_api_key',
        'value' => '',
        'type' => 'string',
        'group' => 'api_keys',
        'label' => ['ar' => 'YouTube API Key', 'en' => 'YouTube API Key'],
        'description' => ['ar' => 'مفتاح YouTube API', 'en' => 'YouTube API Key'],
        'is_public' => false,
        'is_encrypted' => true,
        'order' => 4,
    ],
    [
        'key' => 'google_maps_api_key',
        'value' => '',
        'type' => 'string',
        'group' => 'api_keys',
        'label' => ['ar' => 'Google Maps API Key', 'en' => 'Google Maps API Key'],
        'description' => ['ar' => 'مفتاح Google Maps', 'en' => 'Google Maps API Key'],
        'is_public' => false,
        'is_encrypted' => true,
        'order' => 5,
    ],
    [
        'key' => 'firebase_server_key',
        'value' => '',
        'type' => 'string',
        'group' => 'api_keys',
        'label' => ['ar' => 'Firebase Server Key', 'en' => 'Firebase Server Key'],
        'description' => ['ar' => 'مفتاح خادم Firebase', 'en' => 'Firebase Server Key'],
        'is_public' => false,
        'is_encrypted' => true,
        'order' => 6,
    ],
    [
        'key' => 'onesignal_app_id',
        'value' => '',
        'type' => 'string',
        'group' => 'api_keys',
        'label' => ['ar' => 'OneSignal App ID', 'en' => 'OneSignal App ID'],
        'description' => ['ar' => 'معرف تطبيق OneSignal', 'en' => 'OneSignal App ID'],
        'is_public' => false,
        'is_encrypted' => false,
        'order' => 7,
    ],
    [
        'key' => 'onesignal_api_key',
        'value' => '',
        'type' => 'string',
        'group' => 'api_keys',
        'label' => ['ar' => 'OneSignal API Key', 'en' => 'OneSignal API Key'],
        'description' => ['ar' => 'مفتاح OneSignal API', 'en' => 'OneSignal API Key'],
        'is_public' => false,
        'is_encrypted' => true,
        'order' => 8,
    ],

    // ==================== وسائل التواصل الاجتماعي ====================
    [
        'key' => 'facebook_url',
        'value' => 'https://facebook.com/alenwan',
        'type' => 'string',
        'group' => 'social',
        'label' => ['ar' => 'رابط فيسبوك', 'en' => 'Facebook URL'],
        'description' => ['ar' => 'رابط صفحة فيسبوك', 'en' => 'Facebook page URL'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 1,
    ],
    [
        'key' => 'twitter_url',
        'value' => 'https://twitter.com/alenwan',
        'type' => 'string',
        'group' => 'social',
        'label' => ['ar' => 'رابط تويتر', 'en' => 'Twitter URL'],
        'description' => ['ar' => 'رابط حساب تويتر', 'en' => 'Twitter account URL'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 2,
    ],
    [
        'key' => 'instagram_url',
        'value' => 'https://instagram.com/alenwan',
        'type' => 'string',
        'group' => 'social',
        'label' => ['ar' => 'رابط إنستغرام', 'en' => 'Instagram URL'],
        'description' => ['ar' => 'رابط حساب إنستغرام', 'en' => 'Instagram account URL'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 3,
    ],
    [
        'key' => 'youtube_url',
        'value' => 'https://youtube.com/@alenwan',
        'type' => 'string',
        'group' => 'social',
        'label' => ['ar' => 'رابط يوتيوب', 'en' => 'YouTube URL'],
        'description' => ['ar' => 'رابط قناة يوتيوب', 'en' => 'YouTube channel URL'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 4,
    ],
    [
        'key' => 'linkedin_url',
        'value' => '',
        'type' => 'string',
        'group' => 'social',
        'label' => ['ar' => 'رابط لينكد إن', 'en' => 'LinkedIn URL'],
        'description' => ['ar' => 'رابط صفحة لينكد إن', 'en' => 'LinkedIn page URL'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 5,
    ],
    [
        'key' => 'tiktok_url',
        'value' => '',
        'type' => 'string',
        'group' => 'social',
        'label' => ['ar' => 'رابط تيك توك', 'en' => 'TikTok URL'],
        'description' => ['ar' => 'رابط حساب تيك توك', 'en' => 'TikTok account URL'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 6,
    ],
    [
        'key' => 'snapchat_url',
        'value' => '',
        'type' => 'string',
        'group' => 'social',
        'label' => ['ar' => 'رابط سناب شات', 'en' => 'Snapchat URL'],
        'description' => ['ar' => 'رابط حساب سناب شات', 'en' => 'Snapchat account URL'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 7,
    ],

    // ==================== إعدادات التطبيق ====================
    [
        'key' => 'app_version',
        'value' => '1.0.0',
        'type' => 'string',
        'group' => 'app',
        'label' => ['ar' => 'إصدار التطبيق', 'en' => 'App Version'],
        'description' => ['ar' => 'رقم إصدار التطبيق الحالي', 'en' => 'Current app version number'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 1,
    ],
    [
        'key' => 'force_update',
        'value' => 'false',
        'type' => 'boolean',
        'group' => 'app',
        'label' => ['ar' => 'فرض التحديث', 'en' => 'Force Update'],
        'description' => ['ar' => 'إجبار المستخدمين على تحديث التطبيق', 'en' => 'Force users to update the app'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 2,
    ],
    [
        'key' => 'min_app_version',
        'value' => '1.0.0',
        'type' => 'string',
        'group' => 'app',
        'label' => ['ar' => 'الحد الأدنى للإصدار', 'en' => 'Minimum App Version'],
        'description' => ['ar' => 'أقل إصدار مقبول للتطبيق', 'en' => 'Minimum acceptable app version'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 3,
    ],
    [
        'key' => 'max_devices_per_user',
        'value' => '5',
        'type' => 'number',
        'group' => 'app',
        'label' => ['ar' => 'عدد الأجهزة المسموح', 'en' => 'Max Devices Per User'],
        'description' => ['ar' => 'الحد الأقصى للأجهزة لكل مستخدم', 'en' => 'Maximum devices allowed per user'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 4,
    ],
    [
        'key' => 'enable_downloads',
        'value' => 'true',
        'type' => 'boolean',
        'group' => 'app',
        'label' => ['ar' => 'تفعيل التحميل', 'en' => 'Enable Downloads'],
        'description' => ['ar' => 'السماح بتحميل المحتوى', 'en' => 'Allow content downloads'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 5,
    ],
    [
        'key' => 'enable_chat',
        'value' => 'true',
        'type' => 'boolean',
        'group' => 'app',
        'label' => ['ar' => 'تفعيل الدردشة', 'en' => 'Enable Chat'],
        'description' => ['ar' => 'تفعيل الدردشة في البث المباشر', 'en' => 'Enable chat in live streams'],
        'is_public' => true,
        'is_encrypted' => false,
        'order' => 6,
    ],
];

$createdCount = 0;
foreach ($settings as $setting) {
    AppSetting::updateOrCreate(
        ['key' => $setting['key']],
        $setting
    );
    $createdCount++;
    echo "✅ تم إضافة إعداد: {$setting['key']}\n";
}

echo "\n🎉 تم إضافة {$createdCount} إعداد بنجاح!\n";
echo "✨ يمكنك الآن إدارة الإعدادات من لوحة التحكم\n";
