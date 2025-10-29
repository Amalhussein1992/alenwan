<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class RevenueStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        // Calculate statistics
        $totalRevenue = $this->getTotalRevenue();
        $monthlyRevenue = $this->getMonthlyRevenue();
        $activeSubscriptions = $this->getActiveSubscriptions();
        $churnRate = $this->getChurnRate();

        return [
            Stat::make('إجمالي الإيرادات', 'ر.س ' . number_format($totalRevenue, 2))
                ->description('إجمالي الإيرادات منذ البداية')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart($this->getRevenueChartData()),

            Stat::make('إيرادات الشهر الحالي', 'ر.س ' . number_format($monthlyRevenue, 2))
                ->description($this->getMonthlyGrowth() . '% من الشهر الماضي')
                ->descriptionIcon($this->getMonthlyGrowth() > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($this->getMonthlyGrowth() > 0 ? 'success' : 'danger'),

            Stat::make('الاشتراكات النشطة', number_format($activeSubscriptions))
                ->description('اشتراكات مدفوعة حالياً')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('معدل الإلغاء (Churn)', number_format($churnRate, 1) . '%')
                ->description('نسبة الإلغاءات الشهرية')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($churnRate < 5 ? 'success' : ($churnRate < 10 ? 'warning' : 'danger')),
        ];
    }

    protected function getTotalRevenue(): float
    {
        // TODO: Calculate from actual payment/subscription tables
        // This is a placeholder - replace with actual query
        return DB::table('subscriptions')
            ->where('status', 'active')
            ->sum('amount') ?? 0;
    }

    protected function getMonthlyRevenue(): float
    {
        // TODO: Calculate from actual payment/subscription tables
        return DB::table('subscriptions')
            ->where('status', 'active')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->sum('amount') ?? 0;
    }

    protected function getActiveSubscriptions(): int
    {
        // TODO: Count from actual subscription table
        return DB::table('subscriptions')
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->count() ?? 0;
    }

    protected function getChurnRate(): float
    {
        // TODO: Calculate actual churn rate
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $totalStart = DB::table('subscriptions')
            ->where('created_at', '<', $startOfMonth)
            ->where('status', 'active')
            ->count() ?? 1;

        $cancelled = DB::table('subscriptions')
            ->whereBetween('cancelled_at', [$startOfMonth, $endOfMonth])
            ->count() ?? 0;

        return ($cancelled / $totalStart) * 100;
    }

    protected function getMonthlyGrowth(): float
    {
        $currentMonth = $this->getMonthlyRevenue();

        $lastMonth = DB::table('subscriptions')
            ->where('status', 'active')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m') - 1)
            ->sum('amount') ?? 1;

        if ($lastMonth == 0) return 100;

        return (($currentMonth - $lastMonth) / $lastMonth) * 100;
    }

    protected function getRevenueChartData(): array
    {
        // Get last 7 days revenue
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = DB::table('subscriptions')
                ->whereDate('created_at', $date)
                ->where('status', 'active')
                ->sum('amount') ?? 0;
            $data[] = $revenue;
        }
        return $data;
    }
}
