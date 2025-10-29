# 🌍 دليل ترجمة لوحة التحكم الكامل

## 📋 نظرة عامة

دليل شامل لترجمة لوحة التحكم Filament بالكامل إلى العربية وإضافة زر اللغات والإشعارات في الـ Navbar.

---

## ✅ الخطوة 1: تحديث AdminPanelProvider

عدّل ملف `app/Providers/Filament/AdminPanelProvider.php`:

```php
<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandName('Alenwan')
            ->brandLogo(asset('images/logo.png'))
            ->brandLogoHeight('2rem')
            ->favicon(asset('favicon.ico'))

            // Language Configuration
            ->locale('ar')
            ->defaultLocale('ar')
            ->locales([
                'ar' => '🇸🇦 العربية',
                'en' => '🇺🇸 English',
            ])

            // Dark Mode
            ->darkMode(true)

            // RTL Support for Arabic
            ->rtl(fn () => app()->getLocale() === 'ar')

            // Top Navigation Items (Language & Notifications)
            ->topNavigation()
            ->userMenuItems([
                'profile' => NavigationItem::make()
                    ->label(fn () => __('Profile'))
                    ->url(fn () => route('filament.admin.pages.profile'))
                    ->icon('heroicon-o-user-circle'),

                'settings' => NavigationItem::make()
                    ->label(fn () => __('Settings'))
                    ->url(fn () => route('filament.admin.resources.settings.index'))
                    ->icon('heroicon-o-cog-6-tooth'),

                'logout' => NavigationItem::make()
                    ->label(fn () => __('Logout'))
                    ->url(fn () => route('filament.admin.auth.logout'))
                    ->icon('heroicon-o-arrow-right-on-rectangle'),
            ])

            // Database Notifications
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')

            // Navigation Groups
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Content Management')
                    ->icon('heroicon-o-film')
                    ->collapsed(),

                NavigationGroup::make()
                    ->label('User Management')
                    ->icon('heroicon-o-users')
                    ->collapsed(),

                NavigationGroup::make()
                    ->label('Configuration')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(),

                NavigationGroup::make()
                    ->label('Reports')
                    ->icon('heroicon-o-chart-bar')
                    ->collapsed(),
            ])

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
```

---

## ✅ الخطوة 2: إنشاء ملفات الترجمة العربية

### 2.1 ملف Filament الأساسي

أنشئ المجلد والملف:
```bash
mkdir -p lang/ar
```

ملف `lang/ar/filament.php`:

```php
<?php

return [
    // Navigation
    'navigation' => [
        'groups' => [
            'content' => 'إدارة المحتوى',
            'user_management' => 'إدارة المستخدمين',
            'configuration' => 'الإعدادات',
            'reports' => 'التقارير',
        ],
    ],

    // Actions
    'actions' => [
        'create' => 'إنشاء',
        'edit' => 'تعديل',
        'delete' => 'حذف',
        'save' => 'حفظ',
        'cancel' => 'إلغاء',
        'view' => 'عرض',
        'search' => 'بحث',
        'filter' => 'تصفية',
        'export' => 'تصدير',
        'import' => 'استيراد',
        'attach' => 'ربط',
        'detach' => 'فك الربط',
        'activate' => 'تفعيل',
        'deactivate' => 'إلغاء التفعيل',
        'bulk_actions' => 'إجراءات جماعية',
    ],

    // Messages
    'messages' => [
        'created' => 'تم الإنشاء بنجاح',
        'updated' => 'تم التحديث بنجاح',
        'deleted' => 'تم الحذف بنجاح',
        'saved' => 'تم الحفظ بنجاح',
        'error' => 'حدث خطأ',
        'confirm_delete' => 'هل أنت متأكد من الحذف؟',
        'no_records' => 'لا توجد سجلات',
        'loading' => 'جار التحميل...',
    ],

    // Fields
    'fields' => [
        'id' => 'الرقم',
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'phone' => 'الهاتف',
        'avatar' => 'الصورة الشخصية',
        'status' => 'الحالة',
        'active' => 'نشط',
        'inactive' => 'غير نشط',
        'created_at' => 'تاريخ الإنشاء',
        'updated_at' => 'تاريخ التحديث',
        'actions' => 'الإجراءات',
        'search_placeholder' => 'بحث...',
        'select_placeholder' => 'اختر...',
    ],

    // Resources
    'resources' => [
        'user' => [
            'label' => 'مستخدم',
            'plural' => 'المستخدمون',
        ],
        'category' => [
            'label' => 'فئة',
            'plural' => 'الفئات',
        ],
        'movie' => [
            'label' => 'فيلم',
            'plural' => 'الأفلام',
        ],
        'series' => [
            'label' => 'مسلسل',
            'plural' => 'المسلسلات',
        ],
        'episode' => [
            'label' => 'حلقة',
            'plural' => 'الحلقات',
        ],
        'language' => [
            'label' => 'لغة',
            'plural' => 'اللغات',
        ],
        'setting' => [
            'label' => 'إعداد',
            'plural' => 'الإعدادات',
        ],
        'device' => [
            'label' => 'جهاز',
            'plural' => 'الأجهزة',
        ],
    ],

    // Dashboard
    'dashboard' => [
        'title' => 'لوحة التحكم',
        'welcome' => 'مرحباً بك',
        'total_users' => 'إجمالي المستخدمين',
        'total_content' => 'إجمالي المحتوى',
        'total_revenue' => 'إجمالي الإيرادات',
        'recent_activity' => 'النشاط الأخير',
    ],

    // Auth
    'auth' => [
        'login' => 'تسجيل الدخول',
        'logout' => 'تسجيل الخروج',
        'register' => 'تسجيل',
        'forgot_password' => 'نسيت كلمة المرور؟',
        'remember_me' => 'تذكرني',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'failed' => 'بيانات الاعتماد هذه غير متطابقة مع البيانات المسجلة لدينا.',
    ],

    // Notifications
    'notifications' => [
        'title' => 'الإشعارات',
        'mark_all_read' => 'تحديد الكل كمقروء',
        'no_notifications' => 'لا توجد إشعارات',
        'view_all' => 'عرض الكل',
    ],

    // User Menu
    'user_menu' => [
        'profile' => 'الملف الشخصي',
        'settings' => 'الإعدادات',
        'logout' => 'تسجيل الخروج',
    ],
];
```

### 2.2 ملفات Laravel الأساسية

ملف `lang/ar/validation.php`:

```php
<?php

return [
    'required' => 'حقل :attribute مطلوب.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح.',
    'unique' => ':attribute مُستخدم من قبل.',
    'min' => [
        'string' => 'يجب أن يحتوي :attribute على الأقل :min حرف.',
    ],
    'max' => [
        'string' => 'يجب ألا يتجاوز :attribute :max حرف.',
    ],
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'numeric' => 'يجب أن يكون :attribute رقماً.',
    'string' => 'يجب أن يكون :attribute نصاً.',
    'image' => 'يجب أن يكون :attribute صورة.',
    'in' => ':attribute المحدد غير صحيح.',
    'boolean' => 'يجب أن تكون قيمة :attribute صحيحة أو خاطئة.',
    'date' => ':attribute ليس تاريخاً صحيحاً.',

    'attributes' => [
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'phone' => 'الهاتف',
        'title' => 'العنوان',
        'description' => 'الوصف',
        'image' => 'الصورة',
        'video' => 'الفيديو',
        'category' => 'الفئة',
        'status' => 'الحالة',
    ],
];
```

---

## ✅ الخطوة 3: إضافة Language Switcher Widget

أنشئ Widget لتبديل اللغة:

```bash
php artisan make:filament-widget LanguageSwitcher --type=Widget
```

ملف `app/Filament/Widgets/LanguageSwitcher.php`:

```php
<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class LanguageSwitcher extends Widget
{
    protected static string $view = 'filament.widgets.language-switcher';

    protected int | string | array $columnSpan = 'full';

    public function switchLanguage($locale)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }
}
```

أنشئ View: `resources/views/filament/widgets/language-switcher.blade.php`:

```blade
<x-filament-widgets::widget>
    <div class="flex items-center gap-2">
        <button
            wire:click="switchLanguage('ar')"
            class="px-3 py-2 rounded-lg {{ app()->getLocale() === 'ar' ? 'bg-primary-500 text-white' : 'bg-gray-100 dark:bg-gray-800' }}"
        >
            🇸🇦 العربية
        </button>

        <button
            wire:click="switchLanguage('en')"
            class="px-3 py-2 rounded-lg {{ app()->getLocale() === 'en' ? 'bg-primary-500 text-white' : 'bg-gray-100 dark:bg-gray-800' }}"
        >
            🇺🇸 English
        </button>
    </div>
</x-filament-widgets::widget>
```

---

## ✅ الخطوة 4: إضافة Middleware للغة

أنشئ Middleware: `app/Http/Middleware/SetLocale.php`:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', 'ar'); // Default to Arabic

        if (in_array($locale, ['ar', 'en'])) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
```

أضف إلى `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(\App\Http\Middleware\SetLocale::class);
})
```

---

## ✅ الخطوة 5: ترجمة Resources المخصصة

### مثال: UserDeviceResource

في `app/Filament/Resources/UserDeviceResource.php`:

```php
protected static ?string $navigationLabel = null;

protected static ?string $modelLabel = null;

protected static ?string $pluralModelLabel = null;

public static function getNavigationLabel(): string
{
    return __('filament.resources.device.plural');
}

public static function getModelLabel(): string
{
    return __('filament.resources.device.label');
}

public static function getPluralModelLabel(): string
{
    return __('filament.resources.device.plural');
}

protected static ?string $navigationGroup = null;

public static function getNavigationGroup(): ?string
{
    return __('filament.navigation.groups.user_management');
}
```

---

## ✅ الخطوة 6: إضافة Notifications في Navbar

أنشئ Migration للإشعارات (إذا لم تكن موجودة):

```bash
php artisan notifications:table
php artisan migrate
```

في AdminPanelProvider:

```php
// Already added in step 1
->databaseNotifications()
->databaseNotificationsPolling('30s')
```

إنشاء Notification مخصص:

```bash
php artisan make:notification AdminNotification
```

```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;

class AdminNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $title,
        public string $body,
        public string $icon = 'heroicon-o-bell',
        public string $iconColor = 'primary'
    ) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return FilamentNotification::make()
            ->title($this->title)
            ->body($this->body)
            ->icon($this->icon)
            ->iconColor($this->iconColor)
            ->getDatabaseMessage();
    }
}
```

إرسال إشعار:

```php
use App\Models\User;
use App\Notifications\AdminNotification;

$admin = User::where('is_admin', true)->first();

$admin->notify(new AdminNotification(
    title: 'مستخدم جديد',
    body: 'تم تسجيل مستخدم جديد في النظام',
    icon: 'heroicon-o-user-plus',
    iconColor: 'success'
));
```

---

## ✅ الخطوة 7: تخصيص الألوان والشكل

في AdminPanelProvider:

```php
->colors([
    'primary' => Color::Amber,
    'danger' => Color::Red,
    'gray' => Color::Zinc,
    'info' => Color::Blue,
    'success' => Color::Green,
    'warning' => Color::Orange,
])
```

---

## ✅ الخطوة 8: تشغيل التغييرات

```bash
php artisan optimize:clear
php artisan filament:cache-components
```

---

## 📸 النتيجة النهائية

عند الدخول على لوحة التحكم ستجد:

### في الـ Navbar (أعلى الصفحة):
- 🔔 **أيقونة الإشعارات** مع عداد
- 🌍 **قائمة اللغات** (🇸🇦 العربية / 🇺🇸 English)
- 👤 **قائمة المستخدم** مع خيارات

### في القائمة الجانبية:
جميع العناوين بالعربية:
- 📊 **لوحة التحكم**
- 📱 **إدارة المحتوى**
  - الأفلام
  - المسلسلات
  - الحلقات
- 👥 **إدارة المستخدمين**
  - المستخدمون
  - الأجهزة
- ⚙️ **الإعدادات**
  - اللغات
  - الإعدادات
- 📊 **التقارير**

### RTL Support:
- الواجهة تتحول تلقائياً لـ RTL عند اختيار العربية
- جميع النصوص والأزرار بالعربية
- جميع الرسائل والإشعارات بالعربية

---

## 🎯 ملاحظات مهمة

1. **الترجمة التلقائية**: يمكنك استخدام `__('filament.key')` في أي مكان
2. **التخزين**: اللغة المختارة تُحفظ في الـ session
3. **RTL**: يتفعل تلقائياً عند اختيار العربية
4. **الإشعارات**: تظهر في الـ Navbar مع عداد
5. **Dark Mode**: مفعّل افتراضياً

---

## 🚀 اختبار النظام

1. **افتح لوحة التحكم:**
   ```
   http://localhost:8000/admin
   ```

2. **سجل الدخول:**
   ```
   Email: admin@alenwan.com
   Password: Admin@2025
   ```

3. **جرب تبديل اللغة** من القائمة العلوية

4. **تحقق من الإشعارات** بالضغط على أيقونة الجرس

---

**آخر تحديث:** 28 أكتوبر 2025
