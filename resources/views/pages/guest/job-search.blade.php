<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="_token" content="{!! csrf_token() !!}" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
        <script src="https://kit.fontawesome.com/2a90b2a25f.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <title>Job Hunter - Search Jobs</title>
        <link rel="stylesheet" href="{{ asset('css/app_sample.css') }}">
        <link rel="stylesheet" href="{{ asset('css/guest/job-search.css') }}">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
            * :not(i) {
                font-family: 'Montserrat' !important; 
    
            }
        </style>
    </head>

    <body class="bg-gray-200">
        <div id="job_search">



            {{-- search form --}}
            <section class="bg-gray-800 pb-5 pt-3 text-white">
                <form action="/job-search/search" method="get" id='search_form'>
                <div class="container-lg">
                    <a href="/" class="text-decoration-none btn text-white"><i class="fa fa-arrow-left"></i> Back</a>
                    <h3 class="fw-bold fs-4  mb-3">Search Jobs</h3>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <input type="text" class="form-control" id="keyword" placeholder="Enter Job Title or Company Name"   name="keyword" value="{{ $job_inputs['keyword'] ? $job_inputs['keyword'] : ''}}" >
                        </div>
                        <div class="col-md-auto mb-3">
                            <button type="submit" class="btn btn-outline-light w-100 " @click="search">Search</button>
                        </div>
                    </div>

                    {{-- filters --}}
                    <div class="row">
                        <div class="btn btn-outline-secondary border-0 text-white col-auto" data-bs-toggle="modal" data-bs-target="#mdlFilter">
                            <i class="fa fa-filter me-2"></i> Filter Jobs
                        </div>
                        @if ($job_inputs['province'] && !$job_inputs['municipality'])
                        <div class="btn hover:text-blue-300 text-blue-300 col-auto"><i class="fa fa-search-location ms-2 "></i> {{ Str::title($job_inputs['province']) }}</div>
                        @endif
                        @if ($job_inputs['province'] && $job_inputs['municipality'])
                        <div class="btn hover:text-blue-300 text-blue-300 col-auto"><i class="fa fa-search-location ms-2"></i> {{ Str::title($job_inputs['municipality']) }}, {{ Str::title($job_inputs['province']) }}</div>
                        @endif
                        @if ($job_inputs['salary_min'] && $job_inputs['salary_max'])
                        <div class="btn hover:text-blue-300 text-blue-300 col-auto"><i class="fa fa-money-bill-wave ms-2"></i> Php {{ number_format($job_inputs['salary_min'],0) }} - Php {{ number_format($job_inputs['salary_max'],0) }}</div>
                        @endif
                        @if ($job_inputs['salary_min'] && !$job_inputs['salary_max'])
                        <div class="btn hover:text-blue-300 text-blue-300 col-auto"><i class="fa fa-money-bill-wave ms-2"></i> Greater than Php {{ number_format($job_inputs['salary_min'],0) }}</div>
                        @endif
                        @if (!$job_inputs['salary_min'] && $job_inputs['salary_max'])
                        <div class="btn hover:text-blue-300 text-blue-300 col-auto"><i class="fa fa-money-bill-wave ms-2"></i> Less than Php {{ number_format($job_inputs['salary_max'],0) }}</div>
                        @endif
                        
                        {{-- modal filter --}}
                        <div class="modal fade" id="mdlFilter">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content text-black">
                                    <div class="modal-header">
                                        <h5 class="fw-bold">Filter</h5>
                                        <button class="btn btn-outline-secondary border-0" data-bs-dismiss="modal">close</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">Location</label>
                                            <div class="input-group">
                                                <select id="province" class="form-select" id="province" name="province" @change="setCityMun" >
                                                    <option value="">province</option>
                                                    @if ($job_inputs['province'])
                                                        <option value="{{ $job_inputs['province'] }}" selected>{{ $job_inputs['province'] }}</option>
                                                    @endif
                                                    <option v-for="i of provinces" :value="i.name">@{{ i.name }}</option>
                                                </select>
                                                <select id="municipality" class="form-select" name="municipality" value="{{ $job_inputs['municipality'] ? $job_inputs['municipality'] : ''  }}">
                                                    @if ($job_inputs['municipality'])
                                                        <option value="{{ $job_inputs['municipality'] }}" selected>{{ $job_inputs['municipality'] }}</option>
                                                    @endif
                                                    <option value="">municipality</option>
                                                    <option v-for="i of city_mun" :value="i.name">@{{ i.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">Salary</label>
                                            <div class="row">
                                                <div class="input-group col">
                                                    <label for="" class="input-group-text">Min</label>
                                                    <input type="number" id="salary_min" class="form-control" name="salary_min" value="{{ $job_inputs['salary_min'] ? $job_inputs['salary_min'] : '0' }}">
                                                </div>
                                                <div class="input-group col">
                                                    <label for="" class="input-group-text">Max</label>
                                                    <input type="number" id="salary_max" class="form-control" name="salary_max" value="{{ $job_inputs['salary_max'] ? $job_inputs['salary_max'] : '0' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" @click="clearFilter">
                                            Clear
                                        </button>
                                        <button type="submit" class="btn btn-dark" @click="search" >
                                            Apply Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </section>



            {{-- results --}}
            <section class="py-5 ">
                <div class="container-lg">
                @if ($jobs)
                    @if (count($jobs) != 0)
                        @foreach ($jobs as $job)
                        <div class="bg-gray-50 rounded-md hover:scale-150 hover:bg-blue-100 hover:border-0  shadow-sm  p-4 my-3  col-md-7 border" title="click to view full details" >
                            <h6 class="fw-bold fs-5">{{ $job->job_title }}</h6>
                            <h6 class="mb-4">{{ $job->company_name }}</h6>

                            <h6 class=" text-indigo-800">{{ Str::title($job->job_type) }}</h6>
                            <h6 class=" text-indigo-800">{{ Str::title($job->job_industry) }}</h6>
                            @if(!$job->isLocal)
                            <h6 class="mb-4 text-indigo-800">Overseas</h6>
                            @endif
                            

                            @if ($job->salary_range)
                                <h6>Php {{  number_format(json_decode($job->salary_range)->min, 0)  }} - Php {{  number_format(json_decode($job->salary_range)->max, 0)  }} </h6>
                            @endif
                            <h6 >{{ Str::title(json_decode($job->company_address)->municipality->name) }}, {{ Str::title(json_decode($job->company_address)->province->name) }}</h6>
                            <div class="mt-4">
                                <h6 class="fw-bold text-secondary mb-1">Qualifications</h6>
                                <h6 class="mb-1"><i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i>{{ $job->educational_attainment  ? ($job->educational_attainment == "tertiary education" ? "Must be a College graduate." : ($job->educational_attainment == "secondary education" ? "Must be atleast Highschool graduate." : ($job->educational_attainment == "primary education" ? "Must be atleast Elementary graduate." : ''))) : '' }}</h6>
                                @if ($job->course_studied)
                                <h6 class="mb-1"><i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i> Required course studied:</h6>
                                    @foreach (json_decode($job->course_studied) as $course)
                                        <h6 class="ms-3 my-0">{{ $course }}</h6>
                                    @endforeach
                                @endif
                                @if ($job->gender)
                                <h6 class="mb-1"><i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i> {{ Str::title($job->gender) }}</h6>
                                @endif
                                @if ($job->experience)
                                <h6 class="mb-1"><i class="fa fa-check-circle mr-2 text-green-400" aria-hidden="true"></i> Must have {{ $job->experience }} year/s of experience to job related field.</h6>
                                @endif
                            </div>

                            <a href="/job-search-mdq/view/{{ $job->job_id }}" target="_blank" class="btn btn-primary block mr-0 ml-auto mt-5 w-max">View Full Details</a>
                            <h6 class="mt-3 text-secondary">{{ $job->date_posted->diffForHumans() }}</h6>
                        </div>
                        @endforeach
                        {{ $jobs->links() }}
                    @else
                        <h5 class="text-secondary fs-4 text-center my-5">No results found? Try a different keyword.</h5>
                    @endif
                    
                @else
                    <h5 class="text-secondary fs-4 text-center my-5">Enjoy your job browsing.</h5>
                @endif 
                </div>
            </section>

            
        </div>




        <div id="loading" class=" w-screen h-screen bg-gray-800 bg-opacity-50 fixed top-0 " style="z-index: 3000">
            <div class="fixed top-1/3 w-screen">
                <div class="spinner-grow text-white mx-auto d-block" role="status">
                    <span class="visually-hidden">Loading</span>
                </div>
                <h6 class="fw-bold fs-5 text-center text-white">Loading..</h6>
            </div>
        </div>


    </body>
    <script src="{{ asset('js/pages/guest/job-search.js') }}"></script>
</html>
