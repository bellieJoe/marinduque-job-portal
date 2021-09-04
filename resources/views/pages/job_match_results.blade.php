@extends('app')
@section('title', '- Job Matching')
@section('content')
    <body class="job_match_results">
        @component('../components.jobseeker_nav')
        @endcomponent
        <link rel="stylesheet" href="{{asset('css/job_match_results.css')}}">
        <div class="job_match_results-wrapper">
            <section class="score">
                <h1>MY SCORE</h1>
                <div class="item">
                    <i class="fas fa-graduation-cap"></i>
                    <label class="title">Education</label>
                    <label class="value">30%</label>
                </div>
                <div class="item">
                    <i class="fas fa-business-time"></i>
                    <label class="title">Experience</label>
                    <label class="value">12.5%</label>
                </div>
                <div class="item">
                    <i class="fas fa-id-card"></i>
                    <label class="title">License</label>
                    <label class="value">10%</label>
                </div>
                <div class="item">
                    <i class="fas fa-language"></i>
                    <label class="title">Language</label>
                    <label class="value">3.33%</label>
                </div>
                <div class="item">
                    <i class="fas fa-cogs"></i>
                    <label class="title">Soft Skills</label>
                    <label class="value">10%</label>
                </div>
                <hr>
                <div class="total">
                    <label  class="lbl">Total Percentage</label>
                    <label class="total-value">65.83%</label>
                </div>
            </section>

            <section class="results">
                <h1>JOB MATCH RESULTS</h1>
                <hr>
                @for ($i = 0; $i < 3; $i++)
                <div class="item-result">
                    <img src="https://cdn2.iconfinder.com/data/icons/big-business/512/Global_Corpotation-512.png" alt="">
                    <div class="job-details">
                        <h3 class="job-title">University Instructor/Professor</h3>
                        <span><i class="fas fa-check-circle"></i> Reuires a master's degree or higher.</span>
                        <span><i class="fas fa-check-circle"></i> Prefers 2 years of work experience or more.</span>
                        <span><i class="fas fa-check-circle"></i> Must be a PRC board passer.</span>
                        <span><i class="fas fa-check-circle"></i> Speaks fluent english and Filipino</span>
                        <span><i class="fas fa-check-circle"></i> Has good quality life skills.</span>
                    </div>
                    <hr>
                </div>
                @endfor
                <h5>4 matches found</h5>
            </section>
        </div>
    </body>
@endsection