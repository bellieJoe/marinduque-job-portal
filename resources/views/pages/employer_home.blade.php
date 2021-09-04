@extends('app')
@section('title', '- Home')
@section('content')
    <body class="employer-home">
        <link rel="stylesheet" href="{{asset('css/employer_home.css')}}">

        <div class="employer-home-wrapper">
            <section class="profile mt-md-5">
                <h1>COMPANY PROFILE</h1>
                <hr>
                <img src="https://image.freepik.com/free-vector/colleagues-working-together-project_74855-6308.jpg" alt="">
                <h5>Any recent changes on your company? Update your company's profile now.</h5>
                <button class="btnEditProfile">
                    Edit Profile
                    <i class="fas fa-chevron-right"></i>
                </button>
            </section>

            <section class="post-job  mt-md-5">
                <h1>JOB POSTS</h1>
                <hr>
                <img src="https://image.freepik.com/free-vector/team-leader-teamwork-concept_74855-6671.jpg" alt="">
                <h5>Post new vacancies and job openings your company needs.</h5>
                <button class="btnPostJob">
                    Post a Job
                    <i class="fas fa-chevron-right"></i>
                </button>
            </section>

            <section class="applicants  mt-md-5">
                <h1>MY APPLICANTS</h1>
                <hr>
                <img src="https://image.freepik.com/free-vector/tiny-hr-manager-looking-candidate-job-interview-magnifier-computer-screen-flat-vector-illustration-career-employment_74855-8619.jpg" alt="">
                <h5>Review recent applications oyur company received</h5>
                <button class="btnEditProfile">
                    View Applicants
                    <i class="fas fa-chevron-right"></i>
                </button>
            </section>

        </div>
    </body>
@endsection