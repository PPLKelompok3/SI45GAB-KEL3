<?php

namespace App\Http\Controllers;
use App\Models\JobApplication;
use App\Models\Notification;
use App\Models\AssessmentSubmission;



use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function updateStatus(Request $request, $id)
{
    $application = JobApplication::with('job.company')->findOrFail($id);

$status = $request->input('status');
$validStatuses = ['Pending', 'Processed', 'Interview', 'Accepted', 'Rejected'];

if (!in_array($status, $validStatuses)) {
    return back()->withErrors(['status' => 'Invalid status.']);
}

// Case: From Waiting_for_review → Interview
if ($application->status === 'Waiting_for_review' && $status === 'Interview') {
    $request->validate([
        'feedback' => 'required|string',
        'interview_date' => 'required|date',
    ]);
    $application->feedback = $request->input('feedback');
    $application->interview_date = $request->input('interview_date');
    $application->score = null;

// Case: From Waiting_for_review → Rejected
} elseif ($application->status === 'Waiting_for_review' && $status === 'Rejected') {
    $request->validate([
        'feedback' => 'required|string',
    ]);
    $application->feedback = $request->input('feedback');
    $application->interview_date = null;
    $application->score = null;

// Case: To Interview (normal flow)
} elseif ($status === 'Interview') {
    $request->validate([
        'interview_date' => 'required|date',
    ]);
    $application->interview_date = $request->input('interview_date');
    $application->feedback = null;
    $application->score = null;

// Case: To Accepted or Rejected (after Interview)
} elseif (in_array($status, ['Accepted', 'Rejected'])) {
    $request->validate([
        'score' => 'required|integer|min:1|max:100',
        'feedback' => 'required|string',
    ]);
    $application->score = $request->input('score');
    $application->feedback = $request->input('feedback');
    $application->interview_date = $application->interview_date ?? null;
}

// Update status
$application->status = $status;
$application->save();

// Store feedback in assessment submission if exists
if ($application->status !== 'Under_assessment') {
    \App\Models\AssessmentSubmission::where('job_post_id', $application->job_id)
        ->where('user_id', $application->user_id)
        ->update([
            'review_note' => $application->feedback,
            'reviewed_at' => now(),
        ]);
}


    // Notify applicant
    Notification::create([
        'user_id' => $application->user_id,
        'type' => 'Application Status',
        'content' => 'Your application for "' . $application->job->title . '" at "' . $application->job->company->company_name . '" is now "' . $application->status . '".',
        'is_read' => false,
        'company_logo_url' => $application->job->company->logo_url ?? null
    ]);

    return back()->with('success', 'Application status updated successfully.');
}



public function show($id)
{
    $application = JobApplication::with(['user', 'job.company'])->findOrFail($id);

    $submission = \App\Models\AssessmentSubmission::where('job_post_id', $application->job_id)
        ->where('user_id', $application->user_id)
        ->first();

    return view('recruiter.applicationdetails', compact('application', 'submission'));
}



}