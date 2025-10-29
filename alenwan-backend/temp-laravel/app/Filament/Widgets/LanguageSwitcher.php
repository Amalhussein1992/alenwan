<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher extends Widget
{
    protected static string $view = 'filament.widgets.language-switcher';

    protected int | string | array $columnSpan = 'full';

    public function switchLanguage(string $locale): void
    {
        Session::put('locale', $locale);
        app()->setLocale($locale);

        // Redirect to refresh the page with new locale
        redirect()->to(request()->header('Referer') ?? '/admin');
    }

    public function getCurrentLocale(): string
    {
        return app()->getLocale();
    }

    public function getAvailableLocales(): array
    {
        return [
            'ar' => [
                'name' => 'العربية',
                'flag' => '🇸🇦',
                'direction' => 'rtl',
            ],
            'en' => [
                'name' => 'English',
                'flag' => '🇬🇧',
                'direction' => 'ltr',
            ],
        ];
    }
}
