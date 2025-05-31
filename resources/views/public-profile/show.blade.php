@push('body_classes', 'profile-page-bs5-active')
@extends('layouts.landing') {{-- This should be your main layout that includes styles for the hero section --}}
@section('title', $user->name . ' — Profile')

@push('styles')
    {{-- CSS for the new design (Applied to content below hero) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css"
        integrity="sha512-LX0YV/MWBEn2dwXCYgQHrpa9HJkwB+S+bnBpifSOTO1No27TqNMKYoAn6ff2FBh03THAzAiiCwQ+aPX+/Qt/Ow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style type="text/css">
        /* Styles from the new HTML (show.blade.php) - Scope to new content if necessary */
        body {
            /* background:#f7f8fa; Assuming layouts.landing handles the overall body background */
            /* margin-top:20px; Might conflict with hero, adjust if needed */
        }

        .avatar-xxl {
            height: 7rem;
            width: 7rem;
        }

        .card {
            margin-bottom: 20px;
            -webkit-box-shadow: 0 2px 3px #eaedf2;
            box-shadow: 0 2px 3px #eaedf2;
        }

        .pb-0 {
            padding-bottom: 0 !important;
        }

        .font-size-16 {
            font-size: 16px !important;
        }

        .avatar-title {
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            background-color: #038edc;
            color: #fff;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            font-weight: 500;
            height: 100%;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 100%;
        }

        .bg-soft-primary {
            background-color: rgba(3, 142, 220, .15) !important;
        }

        /* .rounded-circle { border-radius: 50%!important; } -- Might be too general, old hero uses it too. */
        .nav-tabs-custom .nav-item .nav-link.active {
            color: #038edc;
        }

        .nav-tabs-custom .nav-item .nav-link {
            border: none;
        }

        .avatar-group {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding-left: 12px;
        }

        .border-end {
            border-right: 1px solid #eff0f2 !important;
        }

        .d-inline-block {
            display: inline-block !important;
        }

        .badge-soft-danger {
            color: #f34e4e;
            background-color: rgba(243, 78, 78, .1);
        }

        .badge-soft-warning {
            color: #f7cc53;
            background-color: rgba(247, 204, 83, .1);
        }

        .badge-soft-success {
            color: #51d28c;
            background-color: rgba(81, 210, 140, .1);
        }

        .avatar-group .avatar-group-item {
            margin-left: -14px;
            border: 2px solid #fff;
            border-radius: 50%;
            -webkit-transition: all .2s;
            transition: all .2s;
        }

        .avatar-sm {
            height: 2rem;
            width: 2rem;
        }

        .nav-tabs-custom .nav-item {
            position: relative;
            color: #343a40;
        }

        .nav-tabs-custom .nav-item .nav-link.active:after {
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        .nav-tabs-custom .nav-item .nav-link::after {
            content: "";
            background: #038edc;
            height: 2px;
            position: absolute;
            width: 100%;
            left: 0;
            bottom: -2px;
            -webkit-transition: all 250ms ease 0s;
            transition: all 250ms ease 0s;
            -webkit-transform: scale(0);
            transform: scale(0);
        }

        .badge-soft-secondary {
            color: #74788d;
            background-color: rgba(116, 120, 141, .1);
        }

        .work-activity {
            position: relative;
            color: #74788d;
            padding-left: 5.5rem
        }

        .work-activity::before {
            content: "";
            position: absolute;
            height: 100%;
            top: 0;
            left: 66px;
            border-left: 1px solid rgba(3, 142, 220, .25)
        }

        .work-activity .work-item {
            position: relative;
            border-bottom: 2px dashed #eff0f2;
            margin-bottom: 14px;
            padding-bottom: 14px;
        }

        .work-activity .work-item:last-of-type {
            padding-bottom: 0;
            margin-bottom: 0;
            border: none
        }

        .work-activity .work-item::after,
        .work-activity .work-item::before {
            position: absolute;
            display: block
        }

        .work-activity .work-item::before {
            content: attr(data-date);
            left: -157px;
            top: -3px;
            text-align: right;
            font-weight: 500;
            color: #74788d;
            font-size: 12px;
            min-width: 120px
        }

        .work-activity .work-item::after {
            content: "";
            width: 10px;
            height: 10px;
            border-radius: 50%;
            left: -26px;
            top: 3px;
            background-color: #fff;
            border: 2px solid #038edc
        }

        .edit-icon {
            font-size: 1.2rem;
            color: #6c757d;
            margin-left: 8px;
        }

        .edit-icon:hover {
            color: #038edc;
        }

        .biography-text {
            max-height: 100px;
            /* Adjust this value for ~4-5 lines of text */
            overflow: hidden;
            position: relative;
            /* Needed for the fade-out effect */
            transition: max-height 0.35s ease-in-out;
            /* Smooth animation for expansion */
            line-height: 1.6;
            /* Adjust line-height for better calculation */
        }

        .biography-text.expanded {
            max-height: 2000px;
            /* A large value to ensure all content can be shown. Adjust if bios can be extremely long. */
        }

        /* Optional: Adds a fade-out effect at the bottom of the collapsed text */
        .biography-text:not(.expanded)::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            /* Height of the fade effect */
            background: linear-gradient(to bottom, transparent, #fff);
            /* Assuming card background is white. Change #fff if different. */
        }

        .toggle-bio-link {
            display: none;
            /* Hidden by default, JavaScript will show it if needed */
            margin-top: 10px;
            font-weight: bold;
            color: #038edc;
            /* Your theme's primary color */
            cursor: pointer;
            text-decoration: none;
        }

        .toggle-bio-link:hover {
            text-decoration: underline;
        }
        <style type="text/css">
    /* ... (all your existing pushed styles) ... */

    .biography-text {
        max-height: 100px; /* Adjust this value for ~4-5 lines of text */
        overflow: hidden;
        position: relative; /* Needed for the fade-out effect */
        transition: max-height 0.35s ease-in-out; /* Smooth animation for expansion */
        line-height: 1.6; /* Adjust line-height for better calculation */
    }

    .biography-text.expanded {
        max-height: 2000px; /* A large value to ensure all content can be shown. Adjust if bios can be extremely long. */
    }

    /* Optional: Adds a fade-out effect at the bottom of the collapsed text */
    .biography-text:not(.expanded)::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 30px; /* Height of the fade effect */
        background: linear-gradient(to bottom, transparent, #fff); /* Assuming card background is white. Change #fff if different. */
    }

    .toggle-bio-link {
        display: none; /* Hidden by default, JavaScript will show it if needed */
        margin-top: 10px;
        font-weight: bold;
        color: #038edc; /* Your theme's primary color */
        cursor: pointer;
        text-decoration: none;
    }
    .toggle-bio-link:hover {
        text-decoration: underline;
    }
</style>
    </style>
@endpush

@section('content')
    {{-- Retained Hero Section --}}
    <section class="section-hero overlay inner-page bg-image"
        style="background-image: url('{{ asset('assets/images/hero_1.jpg') }}');" id="home-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h1 class="text-white font-weight-bold">Profile Page</h1>
                    <div class="custom-breadcrumbs">
                        <a href="{{ url('/') }}">Home</a> <span class="mx-2 slash">/</span>
                        <span class="text-white"><strong>Profile Page</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End Retained Hero Section --}}

    {{-- New Profile Design Content --}}
    <div class="container mt-4 mb-5"> {{-- Added mt-4 mb-5 for spacing --}}
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="text-center border-end">
                                    <img src="{{ $profile->profile_picture ? asset('storage/' . $profile->profile_picture) : asset('assets/img/default-avatar.png') }}"
                                        alt="{{ $user->name }}" class="img-fluid avatar-xxl rounded-circle">
                                    <h4 class="text-primary font-size-20 mt-3 mb-2">{{ $user->name }}</h4>
                                    <h5 class="text-muted font-size-13 mb-0">{{ $profile->location ?? 'Location not set' }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="ms-3">
                                    {{-- ... inside <div class="col-md-9"> <div class="ms-3"> ... --}}
<div class="d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-2">Biography</h4>
    
</div>
<div class="biography-text-container"> {{-- Wrapper for the text and link --}}
    <div class="biography-text"> {{-- This div will be collapsed/expanded --}}
        <p class="mb-0 text-muted">
            {{-- Using nl2br(e($text)) to convert newlines to <br> and escape HTML --}}
            {!! nl2br(e($profile->bio ?? 'No bio provided.')) !!}
        </p>
    </div>
    <a href="javascript:void(0);" class="toggle-bio-link">Read More</a>
</div>
{{-- ... --}}

                                    <div class="row my-4">
                                        <div class="col-md-12">
                                            <div>
                                                @if ($user->email)
                                                    <p class="text-muted mb-2 fw-medium">
                                                        <i class="mdi mdi-email-outline me-2"></i>{{ $user->email }}
                                                    </p>
                                                @endif
                                                {{-- Add phone if available in $profile or $user --}}
                                                <p class="text-muted fw-medium mb-0"><i
                                                        class="mdi mdi-phone-in-talk-outline me-2"></i>{{ $profile->phone }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs nav-tabs-custom border-bottom-0 mt-3 nav-justfied"
                                        role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link px-4 active" data-bs-toggle="tab" href="#projects-tab"
                                                role="tab" aria-selected="true">
                                                <span class="d-block d-sm-none"><i
                                                        class="mdi mdi-briefcase-outline"></i></span>
                                                <span class="d-none d-sm-block">Projects</span>
                                            </a>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link px-4" data-bs-toggle="tab" href="#experience-tab"
                                                role="tab" aria-selected="false"> {{-- Changed href --}}
                                                <span class="d-block d-sm-none"><i
                                                        class="mdi mdi-briefcase-variant-outline"></i></span>
                                                {{-- Changed icon --}}
                                                <span class="d-none d-sm-block">Experience</span> {{-- Changed text --}}
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link px-4" data-bs-toggle="tab" href="#achievements-tab"
                                                role="tab" aria-selected="false">
                                                <span class="d-block d-sm-none"><i
                                                        class="mdi mdi-trophy-outline"></i></span>
                                                <span class="d-none d-sm-block">Achievements</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="tab-content p-4">
                        {{-- Projects Tab --}}
                        <div class="tab-pane active show" id="projects-tab" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title">Projects</h4>
                                
                            </div>
                            <div class="row">
                                @forelse($projects as $proj)
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <h5 class="mb-1 font-size-17 team-title">
                                                        @if ($proj->link)
                                                            <a href="{{ $proj->link }}"
                                                                target="_blank">{{ $proj->title }}</a>
                                                        @else
                                                            {{ $proj->title }}
                                                        @endif
                                                    </h5>
                                                    <p class="text-muted mb-2 team-description">
                                                        {{ Str::limit($proj->description, 120) }}</p>
                                                    @if ($proj->technologies_used)
                                                        <p class="mb-0"><small class="text-muted"><strong>Tech:</strong>
                                                                {{ $proj->technologies_used }}</small></p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-muted">No projects added.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>{{-- Education Tab --}}
                        <div class="tab-pane" id="experience-tab" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title">Experience</h4>
                                
                            </div>
                            <div class="row">
                                @forelse($experiences as $exp)
                                    <div class="col-md-12 mb-3"> {{-- Each experience takes full width in the tab --}}
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-body">
                                                <h5 class="mb-1">
                                                    {{ $exp->title }}
                                                    @if ($exp->type)
                                                        <small class="text-muted">({{ ucfirst($exp->type) }})</small>
                                                    @endif
                                                </h5>
                                                <p class="mb-1 text-primary">
                                                    <strong>{{ $exp->company_or_org }}</strong>
                                                    @if ($exp->location)
                                                        — {{ $exp->location }}
                                                    @endif
                                                </p>
                                                <p class="text-muted mb-2">
                                                    {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} –
                                                    {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'Present' }}
                                                </p>
                                                @if ($exp->description)
                                                    <p class="mb-0 text-muted">{{ Str::limit($exp->description, 200) }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-muted">No experiences added.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>{{-- Achievements Tab --}}
                        <div class="tab-pane" id="achievements-tab" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title">Achievements</h4>
                                
                            </div>
                            @forelse ($achievements as $achievement)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5>{{ $achievement->title }}</h5>
                                        <p class="mb-1"><strong>Issuer:</strong> {{ $achievement->issuer }}</p>
                                        <p class="mb-1"><strong>Date Awarded:</strong>
                                            {{ \Carbon\Carbon::parse($achievement->date_awarded)->format('M Y') }}</p>
                                        @if ($achievement->description)
                                            <p>{{ Str::limit($achievement->description, 150) }}</p>
                                        @endif
                                        @if ($achievement->certificate)
                                            <a href="{{ asset('storage/' . $achievement->certificate) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary mt-2">
                                                View Certificate
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No achievements added yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                {{-- About Card in Sidebar - simplified as main bio is above --}}
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center pb-2">
                            <h4 class="card-title mb-0">About Me</h4>
                            
                        </div>
                        <hr class="mt-2">
                        <p class="text-muted">
                            {{ Str::limit($profile->bio ?? 'No detailed bio provided here. See main biography section.', 150) }}
                        </p>
                        @if ($profile->cv_url)
                            <a href="{{ asset('storage/' . $profile->cv_url) }}" target="_blank">Download CV</a>
                        @else
                            <p class="text-muted">CV not uploaded.</p>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-4">My Skills</h4>
                            
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            @forelse ($skills as $skill)
                                <span class="badge badge-soft-secondary p-2">{{ $skill->name }}</span>
                            @empty
                                <p class="text-muted">No skills added.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-4">Personal Details</h4>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Location</th>
                                        <td>{{ $profile->location ?? 'Not specified' }}</td>
                                    </tr>
                                    {{-- You can add more dynamic fields here if available --}}
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td>{{ $user->email ?? 'Not specified' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-4">Education</h4>
                            
                        </div>
                        @if($educations->count() > 0)
    <ul class="list-unstyled work-activity mb-0">
        {{-- Sort by end_date (nulls/ongoing first, then newest) --}}
        @foreach ($educations->sortByDesc(function ($edu) { 
            return $edu->end_date ?? now(); 
        }) as $edu)
            <li class="work-item"
                data-date="{{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} – {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('Y') : 'Ongoing' }}">
                <h6 class="lh-base mb-0">{{ $edu->degree }}
                    @if ($edu->field_of_study)
                        <small class="text-muted">in {{ $edu->field_of_study }}</small>
                    @endif
                </h6>
                <p class="font-size-13 mb-1 text-primary">{{ $edu->institution_name }}</p>
                @if ($edu->description)
                    <p class="font-size-13 text-muted mb-0">
                        {{ Str::limit($edu->description, 100) }}</p>
                @endif
            </li>
        @endforeach
    </ul>
@else
    <p class="text-muted">No education entries added.</p>
@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End New Profile Design Content --}}
@endsection

@push('scripts')
    {{-- Scripts for the new design --}}
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        // Any custom JS for the new template can go here
        // For example, to ensure Bootstrap tooltips are initialized if you use them:
        // var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        // var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        //   return new bootstrap.Tooltip(tooltipTriggerEl)
        // })
    </script>
    <script type="text/javascript">
    // ... (any existing pushed scripts like jQuery and Bootstrap bundle) ...

    document.addEventListener('DOMContentLoaded', function () {
        const bioTextElement = document.querySelector('.biography-text');
        const toggleLinkElement = document.querySelector('.toggle-bio-link');

        if (bioTextElement && toggleLinkElement) {
            // Check if the content's full scroll height is greater than its initial visible height
            // This determines if the content is actually overflowing the collapsed view
            const isOverflowing = bioTextElement.scrollHeight > bioTextElement.offsetHeight;

            if (isOverflowing) {
                toggleLinkElement.style.display = 'inline-block'; // Show the "Read More" link
                toggleLinkElement.textContent = 'Read More';     // Set initial text
            } else {
                // If not overflowing, no need for the link or collapsed state styling
                // You can remove the max-height to ensure all content is shown if it's just under the limit
                bioTextElement.style.maxHeight = 'none'; 
                toggleLinkElement.style.display = 'none'; // Keep link hidden
            }

            toggleLinkElement.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent page jump
                if (bioTextElement.classList.contains('expanded')) {
                    bioTextElement.classList.remove('expanded');
                    this.textContent = 'Read More';
                } else {
                    bioTextElement.classList.add('expanded');
                    this.textContent = 'Read Less';
                }
            });
        }
    });
</script>
@endpush
