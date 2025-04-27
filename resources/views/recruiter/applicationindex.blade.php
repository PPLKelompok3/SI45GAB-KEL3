@extends('layouts.recruiter') 
@section('title', 'Applications')

@section('content')
<div class="card">
  <h5 class="card-header">Job Applications</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Applicant Name</th>
          <th>Applied For</th>
          <th>Status</th>
          <th>Applied On</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($applications as $application)
        <tr>
          <td>{{ $application->user->name ?? '-' }}</td>
          <td>{{ $application->job->title ?? '-' }}</td>
          <td>
            <span class="badge bg-label-info">{{ $application->status }}</span>
          </td>
          <td>{{ $application->created_at->format('M d, Y') }}</td>
          <td>
            <a href="{{ route('applications.show', $application->id) }}" class="btn btn-sm btn-primary">
              View Details
            </a>            
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">No applications yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
