<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Episode;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalUsers = User::count();
        $adminUsers = User::where('is_admin', true)->count();
        $premiumUsers = User::where('is_premium', true)->count();

        $totalMovies = Movie::count();
        $totalSeries = Series::count();
        $totalEpisodes = Episode::count();

        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $newUsersLastMonth = User::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $userGrowth = $newUsersLastMonth > 0
            ? round((($newUsersThisMonth - $newUsersLastMonth) / $newUsersLastMonth) * 100, 1)
            : 100;

        return [
            Stat::make(__('filament.analytics.total_users'), $totalUsers)
                ->description($newUsersThisMonth . ' ' . __('filament.analytics.new_users_this_month'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 12, 15, 18, 22, 25, $newUsersThisMonth]),

            Stat::make(__('filament.analytics.premium_users'), $premiumUsers)
                ->description(round(($premiumUsers / max($totalUsers, 1)) * 100, 1) . '% من المستخدمين')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),

            Stat::make(__('filament.analytics.total_content'), $totalMovies + $totalSeries + $totalEpisodes)
                ->description($totalMovies . ' ' . __('filament.resources.movies.plural_label') . ', ' . $totalSeries . ' ' . __('filament.resources.series.plural_label'))
                ->descriptionIcon('heroicon-m-film')
                ->color('info'),

            Stat::make(__('filament.analytics.total_episodes'), $totalEpisodes)
                ->description(__('filament.resources.episodes.plural_label'))
                ->descriptionIcon('heroicon-m-play-circle')
                ->color('success'),
        ];
    }
}
