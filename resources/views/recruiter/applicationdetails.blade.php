@extends('layouts.recruiter')
@section('title', 'Applications')
@section('content')
    <h5 class="pb-1 mb-4">Application Information</h5>

    <div class="card shadow-sm mb-5 overflow-hidden">
        <div class="row g-0">

            {{-- Enhanced Applicant Section --}}
            <div class="col-md-7">
                <div class="card-body p-4">
                    {{-- Applicant Header --}}
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ $application->user->profile->profile_picture ? asset('storage/' . $application->user->profile->profile_picture) : asset('assets/img/elements/12.jpg') }}"
                            class="rounded-circle shadow-sm me-4"
                            style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #f8f9fa;"
                            alt="{{ $application->user->name }}'s Photo">
                        <div class="flex-grow-1">
                            <h4 class="mb-1 text-dark fw-bold">{{ $application->user->name }}</h4>
                            <p class="text-primary mb-0 fw-medium">Job Applicant</p>
                            <small class="text-muted">
                                <i class="mdi mdi-calendar-check me-1"></i>
                                Applied {{ $application->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>

                    {{-- Contact Information --}}
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted mb-3 fw-bold"
                            style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            Contact Information
                        </h6>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="mdi mdi-email text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Email</small>
                                        <span class="fw-medium">{{ $application->user->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="mdi mdi-phone text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Phone</small>
                                        <span
                                            class="fw-medium">{{ $application->user->profile->phone ?? 'Not provided' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="mdi mdi-map-marker text-info"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Location</small>
                                        <span
                                            class="fw-medium">{{ $application->user->profile->location ?? 'Not specified' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="mdi mdi-calendar text-warning"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Applied Date</small>
                                        <span class="fw-medium">{{ $application->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('public.profile.show', ['id' => $application->user->id]) }}"
                            class="btn btn-primary">
                            <i class="mdi mdi-account-circle me-1"></i> View Full Profile
                        </a>
                        <a href="mailto:{{ $application->user->email }}?subject=Regarding Your Application on {{ $application->job->title }} at {{ $application->job->company->company_name ?? 'N/A' }} &body=Hi {{ $application->user->name }},%0D%0A%0D%0A"
                            class="btn btn-outline-secondary" target="_blank">
                            <i class="mdi mdi-message-text me-1"></i> Contact Applicant
                        </a>


                    </div>
                </div>
            </div>

            {{-- Compact Job Information Panel --}}
            <div class="col-md-5 bg-light border-start">
                <div class="card-body p-4 h-100 d-flex flex-column">
                    <div class="text-center mb-3">
                        <small class="text-muted text-uppercase fw-bold"
                            style="font-size: 0.7rem; letter-spacing: 0.5px;">Applied Position</small>
                    </div>

                    <div class="text-center mb-4">
                        <h5 class="fw-bold text-dark mb-2">{{ $application->job->title }}</h5>
                        <p class="text-muted mb-1">
                            <i class="mdi mdi-domain me-1"></i>{{ $application->job->company->company_name ?? 'N/A' }}
                        </p>
                        <p class="text-muted small">
                            <i class="mdi mdi-map-marker me-1"></i>{{ $application->job->location ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <span class="badge bg-primary bg-opacity-10 text-dark px-3 py-2">
                                <i class="mdi mdi-clock-outline me-1 text-primary"></i>
                                {{ ucwords(str_replace('_', ' ', $application->job->employment_type)) }}
                            </span>
                            <span class="badge bg-success bg-opacity-10 text-dark px-3 py-2">
                                <i class="mdi mdi-star-circle me-1 text-success"></i>
                                {{ $application->job->experience_level ?? 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <div class="text-center mb-3">
                            <small class="text-muted">
                                <i class="mdi mdi-calendar-clock me-1"></i>
                                Job posted: {{ $application->job->created_at->format('M d, Y') }}
                            </small>
                        </div>

                        <a href="{{ route('jobs.show', ['id' => $application->job->id, 'slug' => \Str::slug($application->job->title)]) }}"
                            class="btn btn-outline-primary btn-sm w-100">
                            <i class="mdi mdi-briefcase-search me-1"></i> View Job Posting
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <h5 class="pb-1 mb-4">Application Status</h5>
    <div class="card mb-5 w-100">
        @if ($application->status === 'Under_assessment')
            <div class="card-body">
                <div class="alert alert-warning mb-0">
                    This applicant is currently working on their assessment. Please wait for submission.
                </div>
            </div>
        @else
            <form action="{{ route('applications.updateStatus', $application->id) }}" method="POST" class="card-body">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Current Status: <span class="text-primary">{{ $application->status }}</span>
                    </label>
                </div>

                @if ($application->status === 'Pending')
                    <button type="submit" name="status" value="Processed" class="btn btn-outline-primary">Move to
                        Processed</button>
                @elseif ($application->status === 'Processed' || $application->status === 'Waiting_for_review')
                    @if ($submission && $submission->submission_text)
                        <div class="mb-4">
                            <label class="form-label fw-bold">Applicant's Answer</label>
                            <div class="border p-3 rounded bg-white" style="white-space: pre-wrap;">
                                {!! $submission->submission_text !!}
                            </div>
                        </div>
                    @endif
                    @if ($submission && $submission->submission_file)
                        <div class="mb-4">
                            <label class="form-label fw-bold">Submitted File</label>
                            <p>
                                <a href="{{ asset('storage/' . $submission->submission_file) }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-download me-1"></i> Download File
                                </a>
                            </p>
                        </div>
                    @endif
                    @php
                        $nextStatus = match ($application->status) {
                            'Pending' => 'Processed',
                            'Processed', 'Waiting_for_review' => 'Interview',
                            'Interview' => null,
                            default => null,
                        };
                    @endphp
                    @if ($application->status === 'Waiting_for_review')
                        <div class="mb-3">
                            <label for="feedback" class="form-label fw-bold">Feedback</label>
                            <textarea class="form-control w-75" id="feedback" name="feedback" rows="3" required>{{ old('feedback', $application->feedback) }}</textarea>
                            <small class="text-muted">Please write a review before moving forward.</small>
                        </div>

                        {{-- Interview Date (always shown) --}}
                        <div class="mb-3">
                            <label for="interview-date" class="form-label fw-bold">Interview Date</label>
                            <input type="date" name="interview_date" id="interview-date" class="form-control w-50"
                                value="{{ old('interview_date', $application->interview_date ? $application->interview_date->format('Y-m-d') : '') }}">
                            <small class="text-muted">Only required if moving to Interview.</small>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" name="status" value="Interview" class="btn btn-outline-success">Move
                                to Interview</button>
                            <button type="submit" name="status" value="Rejected"
                                class="btn btn-outline-danger">Reject</button>
                        </div>
                    @endif
                @elseif ($application->status === 'Interview')
                    <div class="mb-3">
                        <label class="form-label fw-bold">Interview Date</label>
                        <input type="date" name="interview_date" class="form-control w-50"
                            value="{{ $application->interview_date }}" required>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Score</label>
                        <input type="number" name="score" class="form-control w-50"
                            value="{{ $application->score }}" min="1" max="100" required>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Feedback</label>
                        <textarea name="feedback" class="form-control w-75" rows="3" required>{{ old('feedback', $application->feedback) }}</textarea>
                    </div>
                    <div class="d-flex gap-2  mt-4">
                        <button type="submit" name="status" value="Accepted" class="btn btn-success">Accept</button>
                        <button type="submit" name="status" value="Rejected" class="btn btn-danger">Reject</button>
                    </div>
                @endif
            </form>
        @endif
    </div>






@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let clickedStatus = null;

            const form = document.querySelector('form');
            const dropdown = document.getElementById('status-dropdown'); // Optional, for dropdown usage
            const interviewDateWrapper = document.getElementById('interview-date-wrapper');
            const interviewDateInput = document.getElementById('interview-date');
            const feedbackInput = document.getElementById('feedback');
            const scoreInputAlt = document.getElementById('score-alt');
            const feedbackInputAlt = document.getElementById('feedback-alt');

            // Handle BUTTON-based status changes
            const statusButtons = form.querySelectorAll('button[name="status"]');
            statusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    clickedStatus = this.value;

                    // Toggle interview date
                    if (interviewDateWrapper) {
                        interviewDateWrapper.style.display = (clickedStatus === 'Interview') ?
                            'block' : 'none';
                    }
                });
            });

            // Handle DROPDOWN status change
            if (dropdown) {
                dropdown.addEventListener('change', function() {
                    clickedStatus = dropdown.value;

                    if (interviewDateWrapper) {
                        interviewDateWrapper.style.display = (clickedStatus === 'Interview') ? 'block' :
                            'none';
                    }

                    const feedbackSection = document.getElementById('feedback-section');
                    if (feedbackSection) {
                        feedbackSection.style.display = (clickedStatus === 'Accepted' || clickedStatus ===
                            'Rejected') ? 'block' : 'none';
                    }

                    // Clear unused
                    if (clickedStatus !== 'Interview') {
                        interviewDateInput && (interviewDateInput.value = '');
                    }
                    if (clickedStatus !== 'Accepted' && clickedStatus !== 'Rejected') {
                        scoreInputAlt && (scoreInputAlt.value = '');
                        feedbackInputAlt && (feedbackInputAlt.value = '');
                    }
                });
            }

            // Final form validation
            form.addEventListener('submit', function(e) {
                const status = clickedStatus || dropdown?.value;

                // General feedback validation if leaving 'Waiting_for_review'
                if ('{{ $application->status }}' === 'Waiting_for_review') {
                    if (!feedbackInput?.value.trim()) {
                        e.preventDefault();
                        alert('Feedback is required to proceed.');
                        return;
                    }
                }

                if (status === 'Interview') {
                    if (!interviewDateInput?.value.trim()) {
                        e.preventDefault();
                        alert('Interview date is required.');
                        return;
                    }
                }

                if (status === 'Accepted' || status === 'Rejected') {
                    if (!scoreInputAlt?.value.trim() || !feedbackInputAlt?.value.trim()) {
                        e.preventDefault();
                        alert('Please fill out both score and feedback.');
                        return;
                    }
                }
            });
        });
    </script>
@endpush
