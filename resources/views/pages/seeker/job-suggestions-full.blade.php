@extends('app')
@section('title', '- Job Suggestions')
@section('content')

<body class="bg-gray-200" >
<div id="job_suggestions_full">
    

    <section class="lg:w-10/12 mx-auto my-3">
        <h6 class="font-bold my-3">Job that matches your profile</h6>
        @foreach ($jobs as $jobTemp)
        @php
            $job = $jobTemp["job"];
        @endphp
        <div @click="redirectRoute('/job-search-mdq/view/{{ $job->job_id }}')" class="rounded-md bg-white my-3 p-3 hover:shadow-lg duration-500 cursor-pointer">
            @php
                $salary = $job->salary_range ? json_decode($job->salary_range) : null;
                $company_address = json_decode($job->company_address);
            @endphp
            <h6 class="font-bold text-indigo-500">{{ $job->job_title }}</h6>
            <p class="text-gray-500">{{ $job->company_name }}</p>
                                      
            <div class="mt-3">
                <p>{{ $job->job_industry }}</p>
                @if ($salary->min && $salary->max)
                <p >Php {{ $salary->min }} - Php {{ $salary->max }}</p>
                @endif
                
                <p>{{ $job->job_type }}</p>
                <p>{{ $company_address->municipality->name }}, {{ $company_address->province->name }}</p>
                <p class="mt-2">
                    <span class="text-xl text-green-600 font-bold">{{ $jobTemp["total"] }}% <span class="font-normal">match</span></span> 
                    <span class="text-gray-500">  &nbsp;&nbsp;&nbsp; Education: {{ $jobTemp["educationRate"] }}%</span>
                    <span class="text-gray-500">  &nbsp;&nbsp;&nbsp; Skills: {{ $jobTemp["skillsRate"] }}%</span>
                    <span class="text-gray-500">  &nbsp;&nbsp;&nbsp; Experience: {{ $jobTemp["yoeRate"] }}%</span>
                </p>
            </div>
                                      
            <p class="text-gray-400 mt-3">{{ $job->date_posted->diffForHumans() }}</p>
        </div>
        @endforeach

        {{-- <div>
            {{ $jobs }}
        </div> --}}
    </section>

    
</div>
</body>

<script src="{{ asset('js/pages/seeker/job-suggestions-full.js') }}"></script>
    
@endsection