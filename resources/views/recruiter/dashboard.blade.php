@extends('layouts.recruiter')
@section('title', 'Dashboard')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <!-- Total Revenue Big Card (Left Side) -->
    <div class="col-12 col-lg-8 order-1 mb-4">
      <div class="card">
        <div class="row row-bordered g-0">
          <div class="col-md-8">
            <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>
            <div id="totalRevenueChart" class="px-2"></div>
          </div>
          <div class="col-md-4">
            <div class="card-body">
              <div class="text-center">
                <div class="dropdown">
                  <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="growthReportId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Select Job
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                    <!-- Options dynamically inserted later with Blade or JS -->
                  </div>
                </div>
              </div>
            </div>
            <div id="growthChart"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- 4 Small Cards (Right Side) -->
    <!-- 4 Small Cards (Right Side) -->
    <div class="col-12 col-lg-4 order-2 mb-4">
      <div class="row">

        <!-- Total Applicants -->
        <div class="col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" alt="Applicants" class="rounded" />
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Total Applicants</span>
              <h3 class="card-title mb-2">{{ $totalApplicants }}</h3>
            </div>
          </div>
        </div>

        <!-- Total Jobs Posted -->
        <div class="col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" alt="Applicants" class="rounded" />
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Total Job Posts</span>
              <h3 class="card-title mb-2">{{ $totalJobs }}</h3>
            </div>
          </div>
        </div>

        <!-- Accepted Applicants -->
        <div class="col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" alt="Applicants" class="rounded" />
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Accepted</span>
              <h3 class="card-title mb-2">{{ $acceptedApplicants }}</h3>
            </div>
          </div>
        </div>

        <!-- Rejected Applicants -->
        <div class="col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" alt="Applicants" class="rounded" />
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Rejected</span>
              <h3 class="card-title mb-2">{{ $rejectedApplicants }}</h3>
            </div>
          </div>
        </div>

      </div> <!-- End row inside col-4 -->
    </div> <!-- End right-side column -->

  </div> <!-- End main row -->
</div> <!-- End container -->

@endsection