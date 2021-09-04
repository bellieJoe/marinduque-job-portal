@extends('app')
@section('title' , '- Jobs from Marinduque')
@section('content')
<body class="bg-gray-100">
    <div id="jobViewMarinduque">

        <section class="container-lg py-5 px-4 mt-5 bg-white">

            @php
                $address = json_decode($job->company_address);
                $salary = $job->salary_range ? json_decode($job->salary_range) : null
            @endphp
            <p class="font-bold text-xl text-blue-800 leading-tight">{{ $job->job_title }}</p>
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
                @foreach (json_decode($job->other_qualification) as $qualification)
                <p><i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>{{ $qualification }}</p>
                @endforeach
            @endif
            <p class="mt-3 text-gray-400">Posted {{ $job->date_posted->diffForHumans() }}</p>

            <div>
                @auth
                    @if (Auth::user()->role == 'seeker')
                        <button type="button" @click="saveJob({{ $job->job_id }})" class="btn  btn-primary text-white  mx-auto mt-5">Save Job</button>
                        {{-- <button class="btn  bg-pink-800 text-white  mx-auto mt-5">Apply</button>   --}}
                        <a class="btn  bg-pink-800 text-white  mx-auto mt-5" href="/seeker/apply-job/{{ $job->job_id }}">Apply</a>  
                        {{-- <div class="fixed bottom-5 col-sm-7 duration-300" :class="toastSaveJob">
                            <div  class="p-3 rounded-2 bg-gray-700 text-white w-max mx-auto">
                                <i class="fa fa-check text-green-500"></i>
                                Job successfully saved
                            </div>
                        </div> --}}

                    @endif                         
                @endauth
                @guest
                    <a href="/signin" class="btn  bg-pink-800 text-white  mx-auto mt-5">Sign In to Apply</a>  
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