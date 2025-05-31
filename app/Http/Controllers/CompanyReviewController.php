<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;

class CompanyReviewController extends Controller
{
public function store(Request $request, $companyId)
{
    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    $user = Auth::user();

    // 🔍 Check if the user has an accepted application with this company
    $hasAccepted = JobApplication::where('user_id', $user->id)
        ->where('status', 'Accepted')
        ->whereHas('job', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->exists();

    if (!$hasAccepted) {
        return back()->withErrors(['error' => 'You can only leave a review after being accepted by the company.']);
    }

    // 🚫 Check for inappropriate words
    $badWords = ['bodoh', 'sialan', 'kasar']; // ⬅️ Fill this with your list later
    $content = strtolower($request->content);

    foreach ($badWords as $badWord) {
        if (str_contains($content, $badWord)) {
            return back()->withErrors(['error' => 'Your review contains inappropriate content. Please revise it.']);
        }
    }

    // ✅ Store review
    CompanyReview::create([
        'user_id' => $user->id,
        'company_id' => $companyId,
        'comment' => $request->content,
        'is_useful' => false, // default not pinned
    ]);

    return back()->with('success', 'Thank you! Your review has been submitted for moderation.');
}


}