@extends('app')
@section('title', '- jobs from Marinduque')
@section('content')

<body class="bg-gray-200">
    <div id="jobsFromMarinduque">


        {{-- employers from marinduque --}}
        <div class="bg-gray-800 ">
            <div class="mx-auto lg:w-10/12 py-4 ">
                <h6 class="font-bold mb-2 text-gray-300">Employers from Marinduque 
                    @if (sizeof($employers) > 10)
                    <button class="btn btn-outline-light ml-3 " @click="redirectTo('/employers?from=MARINDUQUE')">
                        See More Employers
                    </button>
                    @endif
                </h6>
    
                @foreach ($employers as $employer)
                <div @click="redirectTo('/employers/{{ $employer->user_id }}/jobs')" class="rounded-md bg-white inline-block w-max p-3 m-2 hover:shadow-md duration-500 cursor-pointer">
                    @if ($employer->company_logo)
                    <img class="w-20 block mx-auto" src="{{ url('image') }}/employer/logo/{{ $employer->company_logo }}" alt="">
                    @else
                    <h6 class="text-blue-600 text-4xl font-bold">{{ Str::ucfirst($employer->company_name)[0] }}</h6>
                    @endif
                    
                    <h6 class="font-bold text-center mt-2">{{ $employer->company_name }}</h6>
                </div>
                @endforeach
            </div>
        </div>
        

        {{-- search form --}}
        <div class="bg-gray-800 ">
            <form action="/job-search-mdq" method="GET" class="mx-auto lg:w-10/12 py-4 px-2">
                <h6 class="text-white text-xl mb-1 font-bold">Search Jobs from Marinduque</h6>
                <div class="row">
                    <div class=" col-lg my-1">
                        <input type="text" class="form-control" placeholder="Enter Job Title or Company name" name="keyword" value="{{ isset($_GET['keyword']) ? $_GET['keyword'] : null }}">
                    </div>
                    <div class="col-lg-auto my-1">
                        <button class=" btn btn-outline-light">Search</button>
                    </div>
                </div>
                
            </form>
        </div>


        <div class="mx-auto lg:w-10/12 py-4">

            

            

            {{-- filter --}}
            <div class=" mb-3 p-3">
                @php
                    $from = isset($_GET['from']) ? $_GET['from'] : null;
                @endphp
                <div class="dropdown w-max ">
                    Show Jobs from 
                    <a class="hover:bg-gray-300 duration-500 no-underline p-2 dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                      {{ $from ? ($from == 'BOAC (Capital)' ? 'Boac' : Str::title($from) ) : 'Marinduque' }}
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <li><a class="dropdown-item" href="/job-search-mdq?from=BOAC (Capital)">Boac</a></li>
                      <li><a class="dropdown-item active" href="/job-search-mdq?from=GASAN">Gasan</a></li>
                      <li><a class="dropdown-item" href="/job-search-mdq?from=BUENAVISTA">Buenavista</a></li>
                      <li><a class="dropdown-item" href="/job-search-mdq?from=TORRIJOS">Torrijos</a></li>
                      <li><a class="dropdown-item" href="/job-search-mdq?from=STA. CRUZ">Sta. Cruz</a></li>
                      <li><a class="dropdown-item" href="/job-search-mdq?from=MOGPOG">Mogpog</a></li>
                      <li><a class="dropdown-item" href="/job-search-mdq">Marinduque</a></li>
                    </ul>
                </div>
            </div>


            @foreach ($jobs as $job )
                <div @click="redirectTo('/job-search-mdq/view/{{ $job->job_id }}')" class="rounded-md bg-white my-3 hover:shadow-lg duration-500 cursor-pointer hover:bg-gray-100 lg:w-8/12">
                    <div class="card-body">
                        @php
                            $address = json_decode($job->company_address);
                            $salary = $job->salary_range ? json_decode($job->salary_range) : null
                        @endphp
                        <p class="font-bold text-lg text-gray-800 leading-tight">{{ $job->job_title }}</p>
                        <p class=" leading-tight ">{{ $job->company_name }}</p>
                        <p class="mb-2">{{ $address->barangay->name }}, {{ $address->municipality->name }}</p>

                        <h6 class=" text-indigo-800">{{ Str::title($job->job_type) }}</h6>
                        <h6 class="mb-4 text-indigo-800">{{ Str::title($job->job_industry) }}</h6>

                        @if ($salary->max && $salary->min)
                        <p class="font-bold">₱{{ number_format($salary->min, '0', '.', ',') }} - ₱{{ number_format($salary->max, '0', '.', ',') }}</p>
                        @endif
                        
                        <p class="font-bold mt-3">Qualifications</p>
                        
                        @if ($job->educational_attainment)
                            <h1 class="font-bold text-gray-500 mt-2">Educational Attainment</h1>
                            <p>
                                <i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>
                                {{ Str::title($job->educational_attainment) }}
                            </p>
                        @endif
                        @if ($job->course_studied)
                        @foreach (json_decode($job->course_studied) as $course)
                        <p> <i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i> {{ $course }} </p>           
                        @endforeach
                                
                        @endif
                        @if ($job->experience)
                            <h1 class="font-bold text-gray-500 mt-2">Years of Experience</h1>
                            <p><i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>{{ $job->experience }} years of experience.</p>
                        @endif
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
<script src="{{ asset('js/pages/guest/job-search-marinduque.js') }}"></script>
    
@endsection