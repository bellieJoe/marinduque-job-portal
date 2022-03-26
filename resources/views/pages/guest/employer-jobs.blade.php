@extends('app')
@section('title', '- Employer Jobs')
@section('content')

<body class="bg-gray-200">
    <div id="employer_jobs">

        <div class="mx-auto lg:w-10/12 my-4">

            <h6>Jobs from <span class="font-bold text-indigo-800">{{ $employer->company_name }}</span></h6>
            @foreach ($jobs as $job )
                <div @click="redirectTo('/job-search-mdq/view/{{ $job->job_id }}')" class="rounded-md bg-white my-3 hover:shadow-lg duration-500 cursor-pointer hover:bg-gray-100">
                    <div class="card-body">
                        @php
                            $address = $job->isLocal ? json_decode($job->company_address) : $job->country;
                            $salary = $job->salary_range ? json_decode($job->salary_range) : null;
                        @endphp
                        <p class="font-bold text-lg text-blue-800 leading-tight">{{ $job->job_title }}</p>
                        <p class="text-gray-400 leading-tight mb-2">{{ $job->company_name }}</p>
                        @if ($salary->max && $salary->min)
                        <p class="">₱{{ number_format($salary->min, '0', '.', ',') }} - ₱{{ number_format($salary->max, '0', '.', ',') }}</p>
                        @endif
                        @if ($job->isLocal == 1)
                        <p>{{ $address->barangay->name }}, {{ $address->municipality->name }}, {{ $address->province->name }}</p>
                        @else
                        <p>Overseas, {{ $job->country }}</p>
                        @endif
                        
                        <p class="font-bold mt-3">Qualifications</p>
                        @if ($job->gender)
                            <p><i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>{{ Str::ucfirst($job->gender) }}</p>
                        @endif
                        @if ($job->educational_attainment)
                            <p>
                                <i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>
                                {{ 
                                    $job->educational_attainment == 'tertiary education' ? 'College Graduate' : (
                                    $job->educational_attainment == 'secondary education'  ? 'Highschool Graduate' : 'Elementary Graduate'
                                    ) 
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
                        @if ($job->experience)
                            <p><i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>{{ $job->experience }} years of experience.</p>
                        @endif
                        @if ($job->other_qualification)
                            <p><i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>...</p>
                        @endif
                         <p class="mt-3 text-gray-400">Posted {{ $job->date_posted->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
            @if (!$jobs[0])
            <div>
                <h6 class="text-center text-lg"><i class="far fa-frown mr-2"></i>No Results found</h6>
            </div>
            @endif
            

            {{ $jobs }}

        </div>


    </div>
</body>

<script src="{{ asset('js/pages/guest/employer-jobs.js') }}"></script>
    
@endsection