<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class RevenueChartWidget extends ChartWidget
{
    protected static ?string $heading = 'إيرادات آخر 30 يوم';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = $this->getLast30DaysRevenue();

        return [
            'datasets' => [
                [
                    'label' => 'الإيرادات اليومية (ر.س)',
                    'data' => $data['revenues'],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
            ],
            'labels' => $data['dates'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getLast30DaysRevenue(): array
    {
        $dates = [];
        $revenues = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dates[] = $date->format('M d');

            $revenue = DB::table('subscriptions')
                ->whereDate('created_at', $date)
                ->where('status', 'active')
                ->sum('amount') ?? 0;

            $revenues[] = $revenue;
        }

        return [
            'dates' => $dates,
            'revenues' => $revenues,
        ];
    }
}
