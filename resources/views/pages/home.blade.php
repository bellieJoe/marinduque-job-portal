@extends('app')
@section('title', '- Home')
@section('content')

    <link rel="stylesheet" href="{{asset('css/home.css')}}">

    <body class="home ">
        <div class="wrapper" id="home">


            <section class=" bg-home-1  bg-cover">
                <div class="bg-gray-900 bg-opacity-75">
                    <div class="container-lg">
                        <form action="/job-search/search" class='py-40 container  mx-sm-auto ' method='GET'>
                            <h1 class="text-white fs-1 fw-bold my-2">Find Jobs base on your preferences.</h1>
                            <div class="row">
                                <div class="col-lg my-2">
                                    <input type="text" name="job_title" class="form-control " placeholder="Job Title">
                                </div>
                                <div class="col-lg my-2">
                                    <input type="text" name="company_name" class="form-control " placeholder="Company Name">
                                </div>
                                <div class="col-lg-auto my-2">
                                    <button class="btn btn-outline-light ">Search Jobs</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>  

            <section class="bg-cover">
                <div class="bg-gray-100 bg-opacity-75">
                    <div class="container-lg py-40 " >
                        {{-- <img src="{{ asset('images/home-2.jpg') }}" alt="okie" class="w-auto"> --}}
                        <h1 class="text-black fs-1 fw-bold my-2 ">Jobs from Marinduque</h1>
                        @foreach ($jobsFromMarinduque as $job)
                        <div class="card hover:shadow-lg w-max inline-block m-2 cursor-pointer" @click="redirectTo('/job-search-mdq/view/{{ $job->job_id }}')">
                            <div class="card-body">
                                <div class="w-40 h-40">
                                    <img src="data:image/png;base64,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" alt="">
                                </div>
                                <p class="my-0 w-40 truncate">{{ $job->company_name }}</p>
                                <h4 class="card-title font-bold text-lg mt-0 w-40 truncate">{{ $job->job_title }}</h4>
                                @php
                                    $address = json_decode($job->company_address)
                                @endphp
                                <p class="card-text my-0">{{ $address->barangay->name }}, {{ $address->municipality->name }}</p>
                            </div>
                        </div>
                        @endforeach
                        <div class="btn btn-outline-dark btn-lg block w-max mx-auto mt-3" @click="redirectTo('/job-search-mdq')">See more jobs <i class="fa fa-arrow-right ml-2" aria-hidden="true"></i></div>
                    </div>
                </div>
            </section>    

            <section class="bg-cover">
                <div class="bg-blue-100 bg-opacity-75">
                    <div class="container-lg py-40 ">
                        {{-- <img src="{{ asset('images/home-2.jpg') }}" alt="okie" class="w-auto"> --}}
                        <h1 class="text-black fs-1 fw-bold my-2 ">Looking for potential employee for your business or company?</h1>
                        <p>Send us your job details and we'll refer potential candidates for you.</p>
                    </div>
                </div>
            </section>     

            @component('components.footer')
                
            @endcomponent
            
            
        </div>
    </body>
    <script src="{{ asset('js/pages/home.js') }}"></script>

@endsection