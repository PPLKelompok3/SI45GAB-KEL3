@extends('layouts.recruiter') 
@section('title', 'Applications')
@section('content')
<h5 class="pb-1 mb-4">Application Information</h5>

<div class="row mb-5 d-flex align-items-stretch">
  <!-- Applicant Info Card -->
  <div class="col-md-6 d-flex">
    <div class="card mb-3 w-100 h-100">
      <div class="row g-0">
        <div class="col-md-4">
          <img class="card-img card-img-left" src="{{ asset('assets/img/elements/12.jpg') }}" alt="Applicant Photo" />
        </div>
        <div class="col-md-8">
          <div class="card-body d-flex flex-column justify-content-between h-100">
            <div>
                <h5 class="card-title mb-2">{{ $application->user->name }}</h5>
                <p class="card-text mb-2">
                    <strong>Email:</strong> {{ $application->user->email }}<br>
                    <strong>Phone:</strong> {{ $application->user->phone ?? '-' }}<br>
                    <strong>Location:</strong> {{ $application->user->profile->location ?? '-' }}
                </p>                
            </div>
            <div class="mt-auto">
              <a href="#" class="btn btn-outline-primary btn-sm">View Full Profile</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Job Info Card -->
  <div class="col-md-6 d-flex">
    <div class="card mb-3 w-100 h-100">
      <div class="row g-0">
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title mb-2">{{ $application->job->title }}</h5>
<p class="card-text mb-2">
    <strong>Company:</strong> {{ $application->job->company->company_name ?? '-' }}<br>
    <strong>Location:</strong> {{ $application->job->location ?? '-' }}<br>
    <strong>Employment Type:</strong> {{ ucwords(str_replace('_', ' ', $application->job->employment_type)) }}<br>
    <strong>Experience Level:</strong> {{ $application->job->experience_level ?? '-' }}
</p>
<p class="card-text">
    <small class="text-muted">Posted on: {{ $application->job->created_at->format('M d, Y') }}</small>
</p>

<a href="{{ route('jobs.show', ['id' => $application->job->id, 'slug' => \Str::slug($application->job->title)]) }}" 
    class="btn btn-outline-primary btn-sm mt-2">
   View Job Posting
 </a>
 
          </div>
        </div>
        <div class="col-md-4">
          <img class="card-img card-img-right" src="{{ asset('assets/img/elements/17.jpg') }}" alt="Company Logo" />
        </div>
      </div>
    </div>
  </div>
</div>

<h5 class="pb-1 mb-4">Update Application Status</h5>
<div class="card mb-5 w-100">
  <form action="{{ route('applications.updateStatus', $application->id) }}" method="POST" class="card-body">
    @csrf
    @method('PATCH')

    <!-- Status -->
    <div class="mb-4">
      <label for="status-dropdown" class="form-label fw-bold">Current Status: <span class="text-primary fw-bold">{{ $application->status }}</span></label>
      <select name="status" class="form-select w-50" id="status-dropdown">
        <option value="Pending" {{ $application->status == 'Pending' ? 'selected' : '' }}>Pending</option>
        <option value="Processed" {{ $application->status == 'Processed' ? 'selected' : '' }}>Processed</option>
        <option value="Interview" {{ $application->status == 'Interview' ? 'selected' : '' }}>Interview</option>
        <option value="Accepted" {{ $application->status == 'Accepted' ? 'selected' : '' }}>Accepted</option>
        <option value="Rejected" {{ $application->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
      </select>
    </div>

    <!-- Interview Date Picker -->
    <div id="interview-date-section" class="mb-4" style="display: none;">
      <label for="interview-date" class="form-label fw-bold">Interview Date</label>
      <input type="date" name="interview_date" class="form-control w-50" id="interview-date"
        value="{{ $application->interview_date }}">
    </div>

    <!-- Feedback and Score -->
    <div id="feedback-section" class="mb-4" style="display: none;">
      <label for="score" class="form-label fw-bold">Score (1–100)</label>
      <input type="number" class="form-control w-50 mb-3" id="score" name="score" min="1" max="100">

      <label for="feedback" class="form-label fw-bold">Feedback</label>
      <textarea class="form-control w-75" id="feedback" name="feedback" rows="3"></textarea>
    </div>

    <div class="text-end">
      <button type="submit" class="btn btn-primary">Apply Status</button>
    </div>
  </form>
</div>



  
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const dropdown = document.getElementById('status-dropdown');
    const interviewSection = document.getElementById('interview-date-section');
    const feedbackSection = document.getElementById('feedback-section');
    const form = dropdown.closest('form');
    const scoreInput = document.getElementById('score');
    const feedbackInput = document.getElementById('feedback');

    function toggleSections() {
      const value = dropdown.value;

      // Show/hide conditional sections
      interviewSection.style.display = (value === 'Interview') ? 'block' : 'none';
      feedbackSection.style.display = (value === 'Accepted' || value === 'Rejected') ? 'block' : 'none';
    }
    function clearUnusedFields() {
      const status = dropdown.value;

      if (status !== 'Interview') {
        document.getElementById('interview-date').value = '';
      }
      if (status !== 'Accepted' && status !== 'Rejected') {
        scoreInput.value = '';
        feedbackInput.value = '';
      }
    }

    dropdown.addEventListener('change', toggleSections);
    toggleSections();
    clearUnusedFields();

    // Final validation
    form.addEventListener('submit', function (e) {
  const status = dropdown.value;

  // Validate feedback and score for Accepted/Rejected
  if (status === 'Accepted' || status === 'Rejected') {
    const score = scoreInput.value.trim();
    const feedback = feedbackInput.value.trim();

    if (!score || !feedback) {
      e.preventDefault();
      alert('Please fill out both score and feedback before applying status.');
      return;
    }
  }

  // Validate interview date for Interview status
  if (status === 'Interview') {
    const interviewDate = document.getElementById('interview-date').value.trim();
    if (!interviewDate) {
      e.preventDefault();
      alert('Please select an interview date before applying Interview status.');
      return;
    }
  }
});

    toggleSections();
  });
</script>
@endpush


