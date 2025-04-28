<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Support\Facades\Auth;

class RecruiterDashboardController extends Controller
{
    public function recruiterDashboard()
    {
        $companyId = Auth::user()->company_id;

        // Small Dashboard Cards
        $totalApplicants = JobApplication::whereHas('job', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->count();

        $acceptedApplicants = JobApplication::whereHas('job', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->where('status', 'Accepted')->count();

        $rejectedApplicants = JobApplication::whereHas('job', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->where('status', 'Rejected')->count();

        return view('recruiter.dashboard', compact(
            'totalApplicants',
            'acceptedApplicants',
            'rejectedApplicants'
        ));
    }
}
