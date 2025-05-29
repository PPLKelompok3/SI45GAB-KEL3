<?php

namespace App\Http\Controllers;
use App\Models\JobApplication;
use App\Models\Notification;


use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function updateStatus(Request $request, $id)
{
    $application = JobApplication::findOrFail($id);

    $validated = $request->validate([
           'status' => 'required|in:Pending,Processed,Interview,Accepted,Rejected',
            'interview_date' => 'nullable|date',
            'score' => 'nullable|integer|min:1|max:100',
            'feedback' => 'nullable|string|min:5',
    ]);
    

    $application->status = $validated['status'];

    if (in_array($validated['status'], ['Accepted', 'Rejected'])) {
    if (!$request->filled('score') || !$request->filled('feedback')) {
        return back()->withErrors(['score' => 'Score and feedback are required.']);
    }

    $application->score = $validated['score'];
    $application->feedback = $validated['feedback'];
    $application->interview_date = null;
} elseif ($validated['status'] === 'Interview') {
    $application->interview_date = $validated['interview_date'];
    $application->score = null;
    $application->feedback = null;
} else {
    $application->interview_date = null;
    $application->score = null;
    $application->feedback = null;
}


    $application->save();

    // Notify applicant
    Notification::create([
        'user_id' => $application->user_id,
        'type' => 'Application Status',
        'content' => 'Your application for "' . $application->job->title . '" at "' . $application->job->company->company_name . '" is now "' . $application->status . '".',
        'is_read' => false,
        'company_logo_url' => $application->job->company->logo_url ?? null
    ]);

    return redirect()->back()->with('success', 'Application status updated successfully.');
    // dd($request->all());
}


public function show($id)
{
    $application = JobApplication::with(['user', 'job.company'])->findOrFail($id);

    return view('recruiter.applicationdetails', compact('application'));
}


}