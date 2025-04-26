<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\JobApplication;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function create()
{
    return view('jobsmanagement.create');
}


public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string',
        'description' => 'required|string',
        'employment_type' => 'required|string',
        'location' => 'nullable|string',
        'salary_min' => 'nullable|integer',
        'salary_max' => 'nullable|integer|gte:salary_min',
        'experience_level' => 'nullable|string',
        'skills' => 'nullable|string',
        'category' => 'nullable|string',
    ]);

    $data['company_id'] = Auth::user()->company_id;

    // ✅ Decode Tagify JSON string → extract skill names
    $skills = collect(json_decode($request->skills, true))
        ->pluck('value')
        ->filter()
        ->map(fn($skill) => ucfirst(strtolower(trim($skill))))
        ->unique()
        ->values();

    // Save skills as comma-separated or JSON string
    $data['skills'] = $skills->implode(','); // or ->toJson() for JSON storage

    $categoryRaw = $request->input('category');
    $decoded = json_decode($categoryRaw, true);
    $data['category'] = is_array($decoded) && isset($decoded[0]['value'])
        ? $decoded[0]['value']
        : null;



    // ✅ Save job post
    $job = JobPost::create($data);

    // ✅ Store new skills to DB
    foreach ($skills as $skillName) {
        \App\Models\Skill::firstOrCreate(['name' => $skillName]);
    }

    return redirect()->route('dashboard')->with('success', 'Job posted!');
}


public function edit(JobPost $job)
{
    return view('jobsmanagement.edit', compact('job'));
}


public function update(Request $request, JobPost $job)
{
    $data = $request->validate([
        'title' => 'required|string',
        'description' => 'required|string',
        'employment_type' => 'required|string',
        'location' => 'nullable|string',
        'salary_min' => 'nullable|integer',
        'salary_max' => 'nullable|integer|gte:salary_min',
        'experience_level' => 'nullable|string',
        'skills' => 'nullable|string',
        'category' => 'nullable|string',
    ]);

    // 🔁 Handle skills from Tagify JSON array
    $skills = collect(json_decode($request->skills, true))
        ->pluck('value')
        ->filter()
        ->map(fn($skill) => ucfirst(strtolower(trim($skill))))
        ->unique()
        ->values();

    $data['skills'] = $skills->implode(',');

    // 💾 Optionally update skill list in DB
    foreach ($skills as $skillName) {
        \App\Models\Skill::firstOrCreate(['name' => $skillName]);
    }

    // 🔁 Handle category from Tagify JSON (single object array)
    $categoryRaw = $request->input('category');
    $decoded = json_decode($categoryRaw, true);
    $data['category'] = is_array($decoded) && isset($decoded[0]['value'])
        ? $decoded[0]['value']
        : null;

    // ✅ Update the job
    $job->update($data);

    return redirect()->route('dashboard')->with('success', 'Job updated successfully.');
}


public function destroy(JobPost $job)
{
    $job->delete();
    return redirect()->route('dashboard')->with('success', 'Job deleted!');
}
public function toggleStatus(JobPost $job)
{
    $job->status = $job->status === 'Active' ? 'Not Active' : 'Active';
    $job->save();

    return back()->with('success', 'Job status updated to ' . $job->status);
}

public function index()
{
    $jobs = JobPost::where('company_id', Auth::user()->company_id)
        ->latest()
        ->get();
    return view('jobsmanagement.index', compact('jobs'));
}
}