@extends('app')
@section('title', '- jobs from Marinduque')
@section('content')

<body>
    <div id="jobsFromMarinduque">


        <div class="container-lg py-4">
            <div class=" mb-3 sticky top-20 z-10 bg-white p-3">
                <div class="dropdown w-max mr-0 ml-auto">
                    Show Jobs from 
                    <a class="hover:bg-gray-300 duration-500 no-underline p-2 dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                      Marinduque
                    </a>
                  
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <li><a class="dropdown-item" href="#">Boac</a></li>
                      <li><a class="dropdown-item" href="#">Gasan</a></li>
                      <li><a class="dropdown-item" href="#">Buenavista</a></li>
                      <li><a class="dropdown-item" href="#">Torrijos</a></li>
                      <li><a class="dropdown-item" href="#">Sta. Cruz</a></li>
                      <li><a class="dropdown-item" href="#">Mogpog</a></li>
                    </ul>
                </div>
            </div>
            @foreach ($jobs as $job )
                <div @click="redirectTo('/job-search-mdq/view/{{ $job->job_id }}')" class="card w-72 inline-flex m-2 hover:shadow-lg duration-500 cursor-pointer hover:bg-gray-100">
                    <div class="card-body">
                        @php
                            $address = json_decode($job->company_address);
                            $salary = $job->salary_range ? json_decode($job->salary_range) : null
                        @endphp
                        <p class="font-bold text-lg text-blue-800 leading-tight">{{ $job->job_title }}</p>
                        <p class="text-gray-400 leading-tight mb-2">{{ $job->company_name }}</p>
                        @if ($salary)
                        <p class="">₱{{ number_format($salary->min, '0', '.', ',') }} - ₱{{ number_format($salary->max, '0', '.', ',') }}</p>
                        @endif
                        <p>{{ $address->barangay->name }}, {{ $address->municipality->name }}, {{ $address->province->name }}</p>
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

            {{ $jobs }}
        </div>


    </div>
</body>
<script src="{{ asset('js/pages/guest/job-search-marinduque.js') }}"></script>
    
@endsection