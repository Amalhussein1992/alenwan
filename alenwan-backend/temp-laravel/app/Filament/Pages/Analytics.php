<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\User;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Episode;
use App\Models\Category;
use Filament\Support\Enums\IconPosition;

class Analytics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.pages.analytics';
    
    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('filament.pages.analytics.navigation_label');
    }

    public function getTitle(): string
    {
        return __('filament.pages.analytics.title');
    }

    public function getHeading(): string
    {
        return __('filament.pages.analytics.heading');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.reports');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverviewWidget::class,
            \App\Filament\Widgets\UserGrowthChart::class,
            \App\Filament\Widgets\LatestUsersWidget::class,
        ];
    }

    public function getAnalyticsData(): array
    {
        return [
            'users' => [
                'total' => User::count(),
                'admin' => User::where('is_admin', true)->count(),
                'premium' => User::where('is_premium', true)->count(),
                'new_today' => User::whereDate('created_at', today())->count(),
                'new_this_week' => User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'new_this_month' => User::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            ],
            'content' => [
                'total_movies' => Movie::count(),
                'total_series' => Series::count(),
                'total_episodes' => Episode::count(),
                'premium_content' => Movie::where('is_premium', true)->count() + Series::where('is_premium', true)->count(),
            ],
            'categories' => Category::withCount(['movies', 'series'])
                ->orderBy('movies_count', 'desc')
                ->limit(5)
                ->get(),
            'popular_movies' => Movie::orderBy('views_count', 'desc')->limit(5)->get(),
            'popular_series' => Series::orderBy('views_count', 'desc')->limit(5)->get(),
        ];
    }
}
