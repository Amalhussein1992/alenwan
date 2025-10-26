<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Cartoon;
use App\Models\Documentary;
use App\Models\Sport;
use App\Models\Podcast;
use App\Models\LiveStream;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // Get statistics from database
        $stats = [
            'total_users' => User::count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'total_movies' => Movie::count(),
            'total_series' => Series::count(),
            'total_cartoons' => Cartoon::count(),
            'total_documentaries' => Documentary::count(),
            'total_sports' => Sport::count(),
            'total_podcasts' => Podcast::count(),
            'total_livestreams' => LiveStream::count(),
            'active_subscriptions' => 0, // Will be calculated when subscription tracking is implemented
            'total_revenue' => 0, // Will be calculated from subscriptions
        ];

        // Get top content by type
        $topMovies = Movie::where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        $topSeries = Series::where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // Get user growth data (last 6 months)
        $userGrowth = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $userGrowth[] = [
                'month' => $date->format('M'),
                'count' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            ];
        }

        // Get content distribution
        $contentDistribution = [
            ['type' => 'Movies', 'count' => Movie::count()],
            ['type' => 'Series', 'count' => Series::count()],
            ['type' => 'Cartoons', 'count' => Cartoon::count()],
            ['type' => 'Documentaries', 'count' => Documentary::count()],
            ['type' => 'Sports', 'count' => Sport::count()],
            ['type' => 'Podcasts', 'count' => Podcast::count()],
        ];

        // Recent users
        $recentUsers = User::orderBy('created_at', 'desc')->take(10)->get();

        return view('admin.analytics.index', compact(
            'stats',
            'topMovies',
            'topSeries',
            'userGrowth',
            'contentDistribution',
            'recentUsers'
        ));
    }

    public function exportReport(Request $request)
    {
        $period = $request->input('period', 'month');
        
        // Generate CSV report
        $filename = "analytics_report_" . $period . "_" . now()->format('Y-m-d') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Metric', 'Value']);
            
            // Data
            fputcsv($file, ['Total Users', User::count()]);
            fputcsv($file, ['Total Movies', Movie::count()]);
            fputcsv($file, ['Total Series', Series::count()]);
            fputcsv($file, ['Total Cartoons', Cartoon::count()]);
            fputcsv($file, ['Total Documentaries', Documentary::count()]);
            fputcsv($file, ['Total Sports', Sport::count()]);
            fputcsv($file, ['Total Podcasts', Podcast::count()]);
            fputcsv($file, ['Total Live Streams', LiveStream::count()]);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}