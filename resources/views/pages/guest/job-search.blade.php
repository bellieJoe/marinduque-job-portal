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
    </head>

    <body class="bg-blue-50">
        <div id="job_search">



            <section class="bg-gray-800 pb-5 pt-3 text-white">
                <form action="/job-search/search" method="get" id='search_form'>
                @csrf
                <div class="container-lg">
                    <a href="/" class="text-decoration-none btn text-white"><i class="fa fa-arrow-left"></i> Back</a>
                    <h3 class="fw-bold fs-4  mb-3">Search Jobs</h3>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <input type="text" class="form-control" id="job_title" placeholder="job title"   @input="generateJobtitleKeywords" @click="clearKeywords" name="job_title" value="{{ $job_inputs['job_title'] ? $job_inputs['job_title'] : ''}}" list="job_title_keywords" autocomplete="off">
                            <datalist id="job_title_keywords" >
                            </datalist>
                        </div>
                        <div class="col-md-5 mb-3">
                            <input type="text" class="form-control" id="company_name" placeholder="company name" list="company_name_keywords" @input="generateCompanynameKeywords" @click="clearKeywords" name="company_name" value="{{ $job_inputs['company_name'] ? $job_inputs['company_name'] : '' }}" autocomplete="off">
                            <datalist id="company_name_keywords" >
                            </datalist>
                        </div>
                        <div class="col-md-auto mb-3">
                            <button type="submit" class="btn btn-outline-light w-100 " @click="search">Search</button>
                        </div>
                    </div>
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

            
            <section class="py-5 ">
                <div class="container-lg">
                @if ($jobs)
                    @if (count($jobs) != 0)
                        @foreach ($jobs as $job)
                        <div class="bg-gray-50 hover:scale-150 hover:bg-blue-100 hover:border-0 cursor-pointer shadow-sm  p-4 my-3  col-md-7 border" title="click to view full details" data-bs-toggle="modal" data-bs-target="#view_job{{ $job->job_id }}">
                            <h6 class="fw-bold fs-5">{{ $job->job_title }}</h6>
                            <h6 class="mb-4">{{ $job->company_name }}</h6>
                            @if ($job->salary_range)
                                <h6>Php {{  number_format(json_decode($job->salary_range)->min, 0)  }} - Php {{  number_format(json_decode($job->salary_range)->max, 0)  }} </h6>
                            @endif
                            <h6 >{{ Str::title(json_decode($job->company_address)->municipality->name) }}, {{ Str::title(json_decode($job->company_address)->province->name) }}</h6>
                            <div class="mt-4">
                                <h6 class="fw-bold text-secondary mb-1">Qualifications</h6>
                                <h6 class="mb-1">{{ $job->educational_attainment  ? ($job->educational_attainment == "tertiary education" ? "• Must be a College graduate." : ($job->educational_attainment == "secondary education" ? "• Must be atleast Highschool graduate." : ($job->educational_attainment == "primary education" ? "• Must be atleast Elementary graduate." : ''))) : '' }}</h6>
                                @if ($job->course_studied)
                                <h6 class="mb-1">• Required course studied:</h6>
                                    @foreach (json_decode($job->course_studied) as $course)
                                        <h6 class="ms-3 my-0">{{ $course }}</h6>
                                    @endforeach
                                @endif
                                @if ($job->gender)
                                <h6 class="mb-1">• Must be {{ $job->gender }}.</h6>
                                @endif
                                @if ($job->experience)
                                <h6 class="mb-1">• Must have {{ $job->experience }} year/s of experience to job related field.</h6>
                                @endif
                            </div>
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

            @if ($jobs)
            @foreach ($jobs as $job)
            <div class="modal fade" id="view_job{{ $job->job_id }}">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="col-sm-7 mx-auto pt-4">
                                <button type="button" class="btn-close d-block ms-auto me-0" data-bs-dismiss="modal" aria-label="Close"></button>

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
                                        @if (Auth::user()->role == 'seeker')
                                            <button type="button" @click="saveJob({{ $job->job_id }})" class="btn  btn-primary text-white  mx-auto mt-5">Save Job</button>
                                            {{-- <button class="btn  bg-pink-800 text-white  mx-auto mt-5">Apply</button>   --}}
                                            <a class="btn  bg-pink-800 text-white  mx-auto mt-5" href="/seeker/apply-job/{{ $job->job_id }}">Apply</a>  
                                            <div class="fixed bottom-5 col-sm-7 duration-300" :class="toastSaveJob">
                                                <div  class="p-3 rounded-2 bg-gray-700 text-white w-max mx-auto">
                                                    <i class="fa fa-check text-green-500"></i>
                                                    Job successfully saved
                                                </div>
                                            </div>
    
                                        @endif                         
                                    @endauth
                                    @guest
                                        <a href="/signin" class="btn  bg-pink-800 text-white  mx-auto mt-5">Sign In to Apply</a>  
                                    @endguest
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>                
            @endforeach                
            @endif
            



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
