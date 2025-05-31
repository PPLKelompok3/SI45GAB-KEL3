@extends('layouts.landing')

@section('title', 'Job Assessments - File Submission')

@section('content')
<!-- HERO SECTION -->
<section class="section-hero overlay inner-page bg-image" style="background-image: url('{{ asset('assets/images/hero_1.jpg') }}');" id="home-section">
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <h1 class="text-white font-weight-bold">Assessments</h1>
        <div class="custom-breadcrumbs">
          <a href="{{ url('/') }}">Home</a> <span class="mx-2 slash">/</span>
          <a href="#">Laravel Developer</a> <span class="mx-2 slash">/</span>
          <span class="text-white"><strong>File Submission</strong></span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MAIN CONTENT -->
<section class="site-section">
  <div class="container">

    <!-- Heading + Submit Button -->
    <div class="row align-items-center mb-4">
      <div class="col-lg-8 mb-3 mb-lg-0">
        <h2>Upload Your Assessment File</h2>
      </div>
      <div class="col-lg-4">
        <div class="row">
        </div>
      </div>
    </div>

    <!-- Due Date -->
    <div class="alert alert-warning d-flex align-items-center justify-content-between mb-4" role="alert">
      <div>
        <strong>Due Date:</strong> Sunday, June 2, 2025 at 23:59 WIB
      </div>
      <span class="badge bg-warning text-dark">4 days remaining</span>
    </div>

    <!-- Instruction + Upload Form -->
    <form class="p-4 p-md-5 border rounded bg-light" method="POST" action="{{ route('assessment.submit', $job->id) }}" enctype="multipart/form-data">
    @csrf
      {{-- Assessment Instructions --}}
      <div class="mb-4">
        <h4 class="mb-3">Instructions</h4>
        <div class="small" style="font-size: 0.95rem;">
          <p>{!! $assessment->instruction !!}</p>
          <ul>
            <li>Pastikan file tidak lebih dari 5MB.</li>
            <li>Penamaan file: <code>NamaLengkap_Posisi.pdf</code></li>
          </ul>
        </div>

        {{-- Optional download guide file --}}
         @if($assessment->attachment)
    <div class="mt-3">
      <a href="{{ asset('storage/' . $assessment->attachment) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
        <i class="bx bx-download me-1"></i> Download Guide File
      </a>
    </div>
  @endif
</div>

      {{-- File Upload --}}
      <div class="mb-4">
        <label for="assessment_file" class="form-label">Upload Your File</label>
        <input type="file" class="form-control" id="assessment_file" name="assessment_file" accept=".pdf,.doc,.docx" required>
        <small class="text-muted d-block mt-1">Accepted formats: PDF, DOC, DOCX. Max size: 5MB.</small>
      </div>

      {{-- Submit --}}
      <button type="submit" class="btn btn-primary">Submit Assessment</button>
    </form>

  </div>
</section>
@endsection
