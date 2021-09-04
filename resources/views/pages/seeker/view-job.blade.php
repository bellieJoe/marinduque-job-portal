@extends('app')
@section('title', '- Home')
@section('content')
<link rel="stylesheet" href="{{asset('css/seeker/view-job.css')}}">

<body class="bg-gray-100">
    <section id="view-job">


        <div class="col-sm-7 mx-auto pt-4 bg-white p-4 my-10" >

            <h6 class="fw-bold text-blue-800">{{ $job->job_title }}</h6>
            <h6>{{ $job->company_name }}</h6>
            <h6 >{{ Str::title(json_decode($job->company_address)->barangay->name) }}, {{ Str::title(json_decode($job->company_address)->municipality->name) }}, {{ Str::title(json_decode($job->company_address)->province->name) }}</h6>
            <h6>Php {{ number_format(json_decode($job->salary_range)->min,0) }} - Php {{ number_format(json_decode($job->salary_range)->max,0) }}</h6>

            <h6 class="mt-5 fw-bold">Qualifications</h6>
            <h6 class="mb-1">{{ $job->educational_attainment  ? ($job->educational_attainment == "tertiary education" ? "• Must be a College graduate." : ($job->educational_attainment == "secondary education" ? "• Must be atleast Highschool graduate." : ($job->educational_attainment == "primary education" ? "• Must be atleast Elementary graduate." : ''))) : '' }}</h6>
            @if ($job->course_studied)
                <h6 class="mb-1">• Studied 
                @foreach (json_decode($job->course_studied) as $course)
                    @php $i = json_decode($job->course_studied); @endphp
                    {{ $course ==  end($i) ? $course : $course.', ' }}
                @endforeach
                </h6>
            @endif
            <h6 class="{{ $job->gender ? '' : 'd-none' }}">• {{ Str::title($job->gender) }}</h6>
            <h6 class="{{ $job->experience ? '' : 'd-none' }}">• {{ $job->experience }} year/s of experience.</h6>
            @if ($job->other_qualification)
                @foreach (json_decode($job->other_qualification) as $qualification )
                <h6 >• {{ $qualification }}</h6>                          
                @endforeach
            @endif

            <h6 class="mt-5 fw-bold {{ $job->job_description ? '' : 'd-none'}}">Description</h6>
            <p class="whitespace-pre-wrap">{{ $job->job_description }}</p>

            <h6 class="mt-5 fw-bold {{ $job->company_description ? '' : 'd-none'}}">About us</h6>
            <p class="whitespace-pre-wrap">{{ $job->company_description }}</p>

            <h6 class="mt-5 fw-bold {{ $job->job_benefits ? '' : 'd-none'}}">Benefits</h6>
            <p class="whitespace-pre-wrap">{{ $job->job_benefits }}</p>

            
            <div>
                @auth
                    @if (Auth::user()->role == 'seeker' && !$job_application)
                        <a class="btn  bg-pink-800 text-white  mx-auto mt-5" href="/seeker/apply-job/{{ $job->job_id }}">Apply</a>  
                    @elseif(Auth::user()->role == 'seeker' && $job_application)
                        @if ($job_application->application_status == 'pending') 
                            <label for="" class="d-block text-lg px-3 py-2 w-max mt-4 bg-gray-100 text-gray-500" >{{ Str::ucfirst($job_application->application_status ) }} Application</label>
                        @elseif ($job_application->application_status == 'approved')
                            <label for="" class="d-block text-lg px-3 py-2 w-max mt-4 bg-green-100 text-green-500 " >{{ Str::ucfirst($job_application->application_status ) }} Application</label>
                        @elseif ($job_application->application_status == "declined")
                            <div class="row px-3">
                                <label for="" class=" text-lg px-3 py-2 w-max mt-4 bg-red-100 text-red-500 col-auto" >{{ Str::ucfirst($job_application->application_status ) }} Application</label>
                                <a class="btn  bg-pink-800 text-white  px-3 py-2 w-max mt-4 ms-2 col-auto" href="/seeker/apply-job/{{ $job->job_id }}">Re-Apply</a>   
                            </div>
                        @endif
                    @endif                         
                @endauth
            </div>
        </div>

    </section>
</body>
<script src="{{ asset('js/pages/seeker/view-job.js') }}"></script>
@endsection