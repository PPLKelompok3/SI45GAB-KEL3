<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\JobApplication;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function adminDashboard()
{
    $jobPostCount = JobPost::count();

    $jobPostStats = JobPost::whereNotNull('category')
    ->get()
    ->groupBy('category')
    ->map(function ($group, $category) {
        return [
            'category' => $category,
            'total' => $group->count(),
            'examples' => $group->pluck('title')->take(3)
        ];
    })->values();
    $categories = $jobPostStats->pluck('category');
    $categoryCounts = $jobPostStats->pluck('total');
    
     $applicationCount = JobApplication::count();

    // Get last 6 months in order with 0 fallback
    $monthlyApplications = JobApplication::select(
            DB::raw("DATE_FORMAT(created_at, '%b') as month"),
            DB::raw("COUNT(*) as count")
        )
        ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%b')"))
        ->orderByRaw("MIN(created_at)")
        ->pluck('count', 'month');

    // Fill missing months with 0
    $months = collect(
        range(1, 5)
    )->map(function ($i) {
        return Carbon::now()->subMonths(5 - $i)->format('M'); // Jan, Feb, ...
    });

    $applicationSeries = $months->map(fn($month) => $monthlyApplications->get($month, 0));


    return view('admin.dashboard', compact('jobPostStats', 'jobPostCount', 'categories', 'categoryCounts', 'applicationCount', 'applicationSeries', 'months'));

}
}