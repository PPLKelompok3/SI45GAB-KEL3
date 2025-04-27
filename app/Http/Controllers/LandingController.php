<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Skill;
use App\Models\JobPost;

class LandingController extends Controller
{
    public function index()
    {
        // Trending: take 3 random categories
        $trendingKeywords = JobPost::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->inRandomOrder()
            ->limit(3)
            ->pluck('category');

        // Recommended: show skills from applicant profile if logged in
        $recommendedSkills = [];

        if (Auth::check() && Auth::user()->role === 'applicant') {
            $recommendedSkills = Auth::user()->skills->pluck('name'); // ⬅️ only get the names
        }
        $jobs = JobPost::with('company')
        ->where('status', 'Active')
        ->latest()
        ->paginate(5)
        ->withPath('/ajax/jobs') // 🔁 show 2 per page for now
        ->appends(request()->query());

        $totalJobs = JobPost::count(); // For job count display

       
        

        return view('index', compact('trendingKeywords', 'recommendedSkills', 'jobs', 'totalJobs'));
    }
    public function jobListPartial()
{
    $jobs = JobPost::with('company')
        ->where('status', 'Active')
        ->latest()
        ->paginate(5)
        ->withPath('/ajax/jobs')
        ->appends(request()->query());
    return view('partials.job-list', compact('jobs'))->render(); // returns HTML string
}

}