@extends('layouts.recruiter')
@section('title', 'Company Reviews')

@section('content')
<div class="container">
  <h4 class="mb-4">Company Reviews</h4>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @forelse ($reviews as $review)
    <div class="card mb-3">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            <strong>{{ $review->user->name }}</strong>
            @php
              $job = $review->user->applications()
                ->whereHas('job', fn($q) => $q->where('company_id', $review->company_id))
                ->latest()
                ->first();
            @endphp
            @if ($job)
              <small class="d-block text-muted">Applied as: {{ $job->job->title }}</small>
            @endif
            <p class="mt-2">{{ $review->comment }}</p>
          </div>
          <div class="text-end">
            <form method="POST" action="{{ route('reviews.toggleUseful', $review->id) }}" class="d-inline">
              @csrf @method('PATCH')
              <button class="btn btn-sm {{ $review->is_useful ? 'btn-warning' : 'btn-outline-secondary' }}">
                {{ $review->is_useful ? '⭐ Useful' : 'Mark as Useful' }}
              </button>
            </form>
            <form method="POST" action="{{ route('reviews.destroy', $review->id) }}" class="d-inline" onsubmit="return confirm('Delete this review?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @empty
    <p class="text-muted">No reviews yet.</p>
  @endforelse

  <div class="mt-4">
    {{ $reviews->links('pagination::bootstrap-4') }}
  </div>
</div>
@endsection
