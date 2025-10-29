<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class UserGrowthChart extends ChartWidget
{
    protected static ?string $heading = null;
    
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 'full';

    public function getHeading(): string
    {
        return __('filament.analytics.user_growth');
    }

    protected function getData(): array
    {
        $data = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        return [
            'datasets' => [
                [
                    'label' => __('filament.analytics.new_users_this_month'),
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                    'fill' => true,
                ],
            ],
            'labels' => $data->pluck('date')->map(function($date) {
                return \Carbon\Carbon::parse($date)->format('M d');
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
