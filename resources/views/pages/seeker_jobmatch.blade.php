@extends('app')
@section('title', ' - Job Match')
@section('content')

<body class="seeker-jobmatch">
    <link rel="stylesheet" href="{{asset('css/seeker_jobmatch.css')}}">
    
    @component('../components.jobseeker_nav')
    @endcomponent

    <div class="wrapper">
        <div class="sec-1">
            <h1 class="title">FIND JOBS THAT SUIT YOUR SKILLS.</h1>
            <hr>
            <p>This job matching feature will serve as your guide during you job hunting.
                Different qualifications about yourself will serve as the key to whatever job will be matched
                to you. The answers that you will provide will be matched among the system's records of job
                descriptions neeeded by different employers that uses a pointing system evaluation.
            </p>
            <p>So answer with honesty as it will be subjected for review by the employer whenever
                you sent an application.
            </p>
            <p>Good luck Hunters</p>
            <button id="btnStart"><i class="fas fa-search" ></i> Start Job Matching</button>
        </div>

        <div class="sec-2">
            <div class="pager"></div>
            <div class="p1">
                <h6 class="desc">1. Please select the level of your <strong>educational attainment</strong></h6>
                <div class="item"><input type="radio" name="educational"><label> Associate's Degree</label></div>
                <div class="item"><input type="radio" name="educational"><label> Bachelor's Degree</label></div>
                <div class="item"><input type="radio" name="educational"><label> Master's Degree</label></div>
                <div class="item"><input type="radio" name="educational"><label> Doctor's Degree</label></div>
                <button id="btnNext1">Next <i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="p2">
                <h6  class="desc">2. Please select the level of your <strong>job experience</strong></h6>
                <div class="item"><input type="radio" name="experience"><label> Entry level (less than 5 years)</label></div>
                <div class="item"><input type="radio" name="experience"><label> Intermediate Level (2 to 10 years)</label></div>
                <div class="item"><input type="radio" name="experience"><label> Advance Level (5 to 20 years)</label></div>
                <div class="item"><input type="radio" name="experience"><label> Senior Lvel (15 years and above)</label></div>
                <button id="btnNext2">Next <i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="p3">
                <h6  class="desc">3. Please select the level of your <strong>professional license</strong></h6>
                <div class="item"><input type="radio" name="license"><label> None</label></div>
                <div class="item"><input type="radio" name="license"><label> With Civil Service Eligibility</label></div>
                <div class="item"><input type="radio" name="license"><label> With PRC License</label></div>
                <div class="item"><input type="radio" name="license"><label> With both CSC and PRC License</label></div>
                <p><i class="fas fa-info-circle"></i> Note: The license/s will be verified and validated by the employer upon submission of your application.</p>
                <button id="btnNext3">Next <i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="p4">
                <h6  class="desc">4. Please select the language speak</h6>
                <div class="item"><input type="radio" name="language"><label> Tagalog</label></div>
                <div class="item"><input type="radio" name="language"><label> Tagalog and English</label></div>
                <div class="item"><input type="radio" name="language"><label> Tagalog, English and others (Multilingual)</label></div>
                <button id="btnNext4">Next <i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="p5">
                <h6  class="desc">5. Please select five (5) <strong>soft skills</strong> you posses.</h6>
                <div class="item"><input type="checkbox"><label> Teamwork</label></div>
                <div class="item"><input type="checkbox"><label> Leadership Skills</label></div>
                <div class="item"><input type="checkbox"><label> Communication Skills</label></div>
                <div class="item"><input type="checkbox"><label> Management Skills</label></div>
                <div class="item"><input type="checkbox"><label> Interpersonal Skills</label></div>
                <div class="item"><input type="checkbox"><label> Presentation Skills</label></div>
                <div class="item"><input type="checkbox"><label> Skills in dealing with difficult personalities</label></div>
                <div class="item"><input type="checkbox"><label> Facilitating Skills</label></div>
                <button id="btnFindMatch">Find Match <i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>

</body>
<script src="{{asset('js/pages/seeker_jobmatch.js')}}"></script>
@endsection