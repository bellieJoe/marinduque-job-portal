@extends('app')
@section('title' , '- Jobs from Marinduque')
@section('content')
<body class="bg-gray-200">
    <div id="jobViewMarinduque">

        <section class="container-lg py-5 px-4 my-5 bg-white rounded-md ">

            {{-- variabless --}}
            @php
                $address = json_decode($job->company_address);
                $salary = $job->salary_range ? json_decode($job->salary_range) : null
            @endphp

            {{-- main content --}}
            <p class="font-bold text-xl text-blue-800 leading-tight">{{ $job->job_title }}</p>
            <p class="text-gray-400 leading-tight mb-2">{{ $job->company_name }}</p>
            @if ($salary->min && $salary->max)
            <p class="">₱{{ number_format($salary->min, '0', '.', ',') }} - ₱{{ number_format($salary->max, '0', '.', ',') }}</p>
            @endif
            <p>{{ $address->barangay->name }}, {{ $address->municipality->name }}, {{ $address->province->name }}</p>

            {{-- specfificatopns --}}
            <p class="font-bold mt-3">Job Specifications</p>
            <h6 class=" text-indigo-800">{{ Str::title($job->job_type) }}</h6>
            @if (!empty(json_decode($job->job_specialization)))
            <h6 class=" text-indigo-800">
                @foreach (json_decode($job->job_specialization) as $key => $specialization)
                    @if ($key < count(json_decode($job->job_specialization))-1)
                    {{ $specialization[1].", " }}
                    @else
                    {{ $specialization[1] }}
                    @endif
                
                @endforeach
            </h6>
            @endif
            @if($job->country)
                <h6 class="mb-4 text-indigo-800">Overseas, {{ $job->country }}</h6>
            @endif

            {{-- job description --}}
            @if($job->job_description)
            <p class="font-bold mt-3">Job Description</p>
            <p class="whitespace-pre-wrap">{{ $job->job_description }}</p>
            @endif


            {{-- qualifications --}}
            <p class="font-bold mt-3">Qualifications</p>
            
            @if ($job->educational_attainment)
                <h1 class="font-bold text-gray-500 mt-2">Educational Attainment</h1>
                <p>
                    <i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>
                    {{ 
                        Str::title($job->educational_attainment) 
                    }}
                </p>
            @endif
            @if ($job->course_studied)
                <p>
                    <i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>
                    @foreach (json_decode($job->course_studied) as $course)
                        {{ $course }},
                    @endforeach
                </p>       
            @endif
    
            <h1 class="font-bold text-gray-500 mt-2">Years of Experience</h1>
            <p><i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>{{ $job->experience ? $job->experience : "Less than 1" }} year/s of experience.</p>
     
            @if ($job->skill)
                <h1 class="font-bold text-gray-500 mt-2">Skills</h1>
                @foreach (json_decode($job->skill) as $skill)
                <p><i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>{{ $skill }}</p>
                @endforeach
            @endif

            @if ($job->gender || $job->other_qualification)
            <h1 class="font-bold text-gray-500 mt-2">Others</h1>
            @endif
            @if ($job->gender)
                <p><i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>{{ Str::ucfirst($job->gender) }}</p>
            @endif
            @if ($job->other_qualification)

                @foreach (json_decode($job->other_qualification) as $qualification)
                <p><i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>{{ $qualification }}</p>
                @endforeach
            @endif

            

            {{-- about the company --}}
            @if($job->company_description)
            <p class="font-bold mt-3">About the company</p>
            <p class="whitespace-pre-wrap">{{ $job->company_description }}</p>
            @endif
            


            <p class="mt-3 text-gray-400">Posted {{ $job->date_posted->diffForHumans() }}</p>

            <div>
                @auth
                    @if (Auth::user()->role == 'seeker')
                        @if (!$seekerInterference['saved'])
                            <button v-if="!tempSaved" type="button" @click="saveJob({{ $job->job_id }})" class="btn  btn-primary text-white  mx-auto mt-5">Save Job</button>
                            <label v-if="tempSaved" class="text-green-500 mr-3 btn mt-5 p-2 hover:text-green-500"><i class="fa fa-check mr-2"></i>Saved</label>
                        @else
                            <label class="text-green-500 mr-3 mt-5 btn p-2 hover:text-green-500"><i class="fa fa-check mr-2"></i>Saved</label>
                        @endif

                        @if (!$seekerInterference['applied'])
                            <a class="btn  bg-green-500 text-white  mx-auto mt-5" href="/seeker/apply-job/{{ $job->job_id }}">Apply</a>  
                        @else
                            <label class="text-green-500 mt-5 btn p-2 hover:text-green-500"><i class="fa fa-check mr-2"></i>Applied</label>
                        @endif
                    @endif                         
                @endauth
                @guest
                    <a href="/signin" class="btn  bg-green-500 text-white  mx-auto mt-5">Sign In to Apply</a>  
                @endguest
            </div>

        </section>


        <div v-if="loading">
            @component('components.loading')
            @endcomponent
        </div>

    </div>
</body>
<script src="{{ asset('js/pages/guest/job-view-marinduque.js') }}"></script>
@endsection