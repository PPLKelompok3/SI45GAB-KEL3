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

        //Check for inappropriate words
        $badWords = [
            'anjing',
            'babi',
            'kunyuk',
            'bajingan',
            'asu',
            'bangsat',
            'kampret',
            'kontol',
            'memek',
            'ngentot',
            'pentil',
            'perek',
            'pepek',
            'pecun',
            'bencong',
            'banci',
            'maho',
            'gila',
            'sinting',
            'tolol',
            'sarap',
            'setan',
            'lonte',
            'hencet',
            'taptei',
            'kampang',
            'pilat',
            'keparat',
            'bejad',
            'gembel',
            'brengsek',
            'tai',
            'anjrit',
            'fuck',
            'tetek',
            'ngulum',
            'jembut',
            'totong',
            'kolop',
            'pukimak',
            'bodat',
            'heang',
            'jancuk',
            'burit',
            'titit',
            'nenen',
            'silit',
            'sempak',
            'fucking',
            'asshole',
            'bitch',
            'penis',
            'vagina',
            'klitoris',
            'kelentit',
            'borjong',
            'dancuk',
            'pantek',
            'taek',
            'itil',
            'teho',
            'pantat',
            'bagudung',
            'babami',
            'kanciang',
            'bungul',
            'idiot',
            'kimak',
            'henceut',
            'kacuk',
            'blowjob',
            'pussy',
            'dick',
            'damn',
            'ass'
        ]; //Fill this with your list later
        $content = strtolower($request->content);

        foreach ($badWords as $word) {
            if (stripos($content, $word) !== false) {
                return back()->withErrors([
                    'comment' => 'Your review contains inappropriate language and cannot be submitted.'
                ])->withInput();
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
    public function toggleUseful($id)
    {
        $review = CompanyReview::findOrFail($id);

        // Only recruiters of the company can do this (optional auth check)
        $recruiter = auth::user();
        if ($recruiter->role !== 'recruiter' || $review->company_id !== $recruiter->company_id) {
            abort(403, 'Unauthorized action.');
        }

        $review->is_useful = !$review->is_useful;
        $review->save();

        return back()->with('success', $review->is_useful ? 'Marked as useful.' : 'Unmarked as useful.');
    }
    public function destroy($id)
    {
        $review = CompanyReview::findOrFail($id);

        // Authorization check
        $recruiter = auth::user();
        if ($recruiter->role !== 'recruiter' || $review->company_id !== $recruiter->company_id) {
            abort(403, 'Unauthorized action.');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }


    public function index()
    {
        $recruiter = auth::user();

        $reviews = CompanyReview::with(['user', 'user.profile', 'user.applications.job'])
            ->where('company_id', $recruiter->company_id)
            ->latest()
            ->paginate(10);

        return view('recruiter.review', compact('reviews'));
    }
}
