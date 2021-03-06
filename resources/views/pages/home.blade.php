@extends('app')
@section('title', '- Home')
@section('content')

    <link rel="stylesheet" href="{{asset('css/home.css')}}">
    

    <body class="home bg-gray-200">
        <div class="wrapper" id="home">

 
            <section class=" bg-home-1  bg-cover">
                <div class="bg-gray-900 bg-opacity-75">
                    <div class="container-lg">
                        <form action="/job-search/search" class='py-40 container  mx-sm-auto ' method='GET'>
                            <h1 class="text-white fs-1 fw-bold my-2" data-aos="fade-right">Find Jobs base on your preferences.</h1>
                            <div class="row">
                                <div class="col-lg my-2"  data-aos="fade-right">
                                    <input type="text" name="keyword" class="form-control " placeholder="Enter Job Title or Company Name">
                                </div>
                                <div class="col-lg-auto my-2" data-aos="fade-right">
                                    <button class="btn btn-outline-light ">Search Jobs</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>  

            <section class="bg-cover ">
                <div class="bg-gray-100 bg-opacity-75">
                    <div class="container-lg py-40 " >
                        <h1 class="text-black fs-1 fw-bold my-2 "  data-aos="fade-up">Jobs from Marinduque</h1>
                        <div class="sm:grid sm:grid-cols-2 sm:gap-2 md:grid-cols-3 lg:grid-cols-4">
                            @foreach ($jobsFromMarinduque as $job)
                            <div class="card hover:shadow-md duration-500 w-full inline-block my-2 cursor-pointer " @click="redirectTo('/job-search-mdq/view/{{ $job->job_id }}')" data-aos="fade-up">
                                <div class="card-body">
                                    <h4 class="card-title font-bold text-indigo-900 text-xl my-0 w-full truncate">{{ $job->job_title }}</h4>
                                    <p class="my-0 w-40 truncate text-gray-500">{{ $job->company_name }}</p>
                                    @php
                                        $address = json_decode($job->company_address)
                                    @endphp
                                    <p class="card-text my-0 text-gray-500 truncate">{{ $address->barangay->name }}, {{ $address->municipality->name }}</p>
    
                                    @if ($job->job_type)
                                        <p class="card-text my-0 text-indigo-500 truncate mt-3">{{ Str::title($job->job_type) }}</p>
                                    @endif
                                    <p class="card-text my-0 font-light truncate ">{{ $job->date_posted->diffForHumans() }}</p>
                                </div>
                            </div>
                            @endforeach
                            <div class="btn btn-outline-dark btn-lg block w-max mx-auto mt-3 justify-self-center place-self-center" @click="redirectTo('/job-search-mdq')"  data-aos="fade-up">See more jobs <i class="fa fa-arrow-right ml-2" aria-hidden="true"></i></div>
                        </div>
                        
                        
                    </div>
                </div>
            </section>    

            {{-- <section class="bg-cover "  >
                <div class="bg-blue-100 bg-opacity-75" data-aos="fade-right">
                    <div class="container-lg py-40 ">
                        <h1 data-aos="fade-right" class="text-black fs-1 fw-bold my-2 ">Looking for potential employee for your business or company?</h1>
                        <p data-aos="fade-right">Send us your job details and we'll refer potential candidates for you.</p>
                    </div>
                </div>
            </section>      --}}

            <div  data-aos="fade-right">
                @component('components.footer')
                
                @endcomponent
            </div>
            
            
            
        </div>
    </body>
    <script src="{{ asset('js/pages/home.js') }}"></script>
    

@endsection