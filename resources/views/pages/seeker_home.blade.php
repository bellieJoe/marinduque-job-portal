@extends('app')
@section('title', '- Home')
@section('content')
<link rel="stylesheet" href="{{asset('css/seeker_home.css')}}">

<body class="seeker-home bg-gray-200">
    <section id="seeker-home">

        {{-- home navigation --}}
        <div class="profile-hero pt-3">
            <div class=" p-3 mb-4 lg:w-10/12 mx-auto ">
                @if ($seeker->display_picture)
                    <img class="mt-2 w-52 d-block mx-auto rounded-full shadow-lg {{ $seeker->display_picture ? '' : 'd-none' }}" src="{{ url('image') }}\seeker\profile\{{  $seeker->display_picture }}" alt="profile">
                @endif
                <a href="/seeker/profile/upload-image/seeker-profile" class=" duration-500 rounded-md hover:text-gray-50 pt-16 text-center fw-bold text-gray-400 hover:bg-gray-300 mt-2 border-3 border-dashed  w-40 h-40 d-block mx-auto bg-gray-100 {{ $seeker->display_picture ? 'd-none' : '' }}">Upload photo</a>
                <a href="/seeker/profile/upload-image/seeker-profile" class="mx-auto btn btn-outline-light block  my-2 w-52  {{ $seeker->display_picture ? '' : 'd-none' }}">Upload display photo</a>
                <h6 class="fw-bold text-3xl text-white my-3 text-center ">{{ $seeker->firstname.' '.Str::ucfirst($seeker->middlename[0]).'. '.$seeker->lastname }}</h6>
            </div>
        </div>

        {{-- sesarch box --}}
        <div class="lg:w-10/12 mx-auto shadow-md">
            <div class="mb-5 bg-gray-800 p-3">
                <h4 class="fw-bold text-white mb-2">Search Jobs</h4>
                <form action="/job-search/search" method="get">
                    <div class="row">
                        <div class="mb-2 col-md">
                            <div class="">
                                <input type="search" class="form-control " name="keyword" placeholder="Search Job Title or Company Name">
                            </div>
                        </div>
                        <div class="mb-2 col-md-auto">
                            <button class="search-button btn btn-outline-light h-100 w-100" > <i claass="fas fa-search"></i> Search</button>
                        </div>
                        
                    </div>
                </form>
            </div> 
        </div>

        {{-- seeker features --}}
        <div class="lg:w-10/12 mx-auto shadow-md">
            <nav class="bg-indigo-800 pt-1 ps-1 pe-1" v-cloak>
                <button class="py-2 px-3 duration-300 hover:bg-indigo-600 rounded-t-md rounded-tr-md" :class="toggledJobs == 'suggestions' ? 'bg-white text-indigo-800' : 'bg-indigo-800 text-white'" @click="toggleJobs('suggestions')">
                    <i class="fa fa-archive me-1"></i> Suggested Jobs
                </button>
                <button class="py-2 px-3 hover:bg-indigo-600 duration-300 rounded-t-md rounded-tr-md" :class="toggledJobs == 'invitations' ? 'bg-white text-indigo-800' : 'bg-indigo-800 text-white'"  @click="toggleJobs('invitations')">
                    <i class="fa fa-envelope me-1"></i> Invitations
                </button>
                <button class="py-2 px-3 hover:bg-indigo-600 duration-300 rounded-t-md rounded-tr-md" :class="toggledJobs == 'saved jobs' ? 'bg-white text-indigo-800' : 'bg-indigo-800 text-white'"  @click="toggleJobs('saved jobs')">
                    <i class="fa fa-bookmark me-2"></i> 
                    Saved Jobs 
                </button>
                <button class="py-2 px-3 hover:bg-indigo-600 duration-300 rounded-t-md rounded-tr-md" :class="toggledJobs == 'applications' ? 'bg-white text-indigo-800' : 'bg-indigo-800 text-white'"  @click="toggleJobs('applications')">
                    <i class="fa fa-briefcase me-2"></i> 
                    Applications
                </button>
            </nav>
            {{-- feature contents --}}
            <div class="bg-blue-100 mb-5">
                <input type="hidden" id="toggle" value="{{ isset($_GET["toggle"]) ? $_GET["toggle"] : null }}">
                {{-- suggested jobs --}}
                <div v-if="toggledJobs == 'suggestions'" class="p-3" v-cloak>
                      <h1 class="text-gray-500 mb-3 fw-bold">Jobs that matches your profile</h1>
                      <div v-for="job of jobSuggestions">
                          
                          <div @click="redirectRoute('/job-search-mdq/view/' + job.job.job_id )" class="rounded-md  p-3 mb-2 bg-white hover:shadow-lg cursor-pointer duration-300 ">
                              <h6 class="font-bold text-indigo-500">@{{ job.job.job_title }}</h6>
                              <p class="text-gray-500">@{{ job.job.company_name }}</p>
                              
                              <div class="mt-3 text-sm">
                                {{-- <p>@{{ job.job.job_industry }}</p> --}}
                                <div v-if="job.job_specialization.length > 0">
                                    <p ><span >@{{ devModule.comaSeparateSpec(job.job_specialization) }}</span></p> 
                                </div>
                                <p class="" v-if="job.salary_range.max && job.salary_range.min">Php @{{ job.salary_range.min }} - Php @{{ job.salary_range.max }}</p>
                                <p>@{{ devModule.titleCase(job.job.job_type) }}</p>
                                <p v-if="job.isLocal">@{{ job.company_address.municipality.name }}, @{{ job.company_address.province.name }}</p>
                                <p v-if="!job.isLocal">@{{ job.country }}</p>
                                
                                <p class="mt-2">
                                    <span :class="(job.total > 50 ? 'text-green-600 text-xl font-bold' : 'text-red-500 text-xl font-bold') ">@{{ job.total }}% <span class="font-normal">match</span></span> 
                                    <span class="text-gray-500">  &nbsp;&nbsp;&nbsp; Education: @{{ job.educationRate }}% <i class="fa-solid fa-angles-up" title="Overqualified" v-if="job.overQualified"></i></span>
                                    <span class="text-gray-500">  &nbsp;&nbsp;&nbsp; Skills: @{{ job.skillsRate }}%</span>
                                    <span class="text-gray-500">  &nbsp;&nbsp;&nbsp; Experience: @{{ job.yoeRate }}%</span>
                                </p>
                              </div>
                              
                              <p class="text-gray-400 mt-3">@{{ job.date_posted_diffForHumans  }}</p>
                          </div>
                      </div>
                      <div v-if="jobSuggestions">
                        <a href="/seeker/home/job-suggestions-full" class="btn block mx-auto text-blue-500">See more</a>
                      </div>           
                      <div v-if="!jobSuggestions">
                            <h1 class="text-gray-500 text-center py-4">No Job Suggestions</h1>
                      </div>           
                    
                </div>
                {{-- job invitions --}}
                <div v-if="toggledJobs == 'invitations'" class="p-3" v-cloak>
                    <h1 class="text-gray-500 mb-3 fw-bold">Job Invitations</h1>
                    @if (!empty($invitations))
                        @foreach ($invitations as $job)
                        <div class="bg-white rounded-md p-4 mb-2">
                            <a href="/job-search-mdq/view/{{ $job->job_id }}" class="btn btn-primary float-right">View</a>
                            <h1 class="font-bold text-indigo-500  ">{{ $job->job_title }}</h1>
                            <h1 class="mb-3">{{ $job->company_name }}</h1>
                            <h1 >{{ Str::title($job->job_type) }}</h1>
                            <h1 >
                            @if ($job->company_address)
                                @if (json_decode($job->company_address)->municipality)
                                    {{ json_decode($job->company_address)->municipality->name }},
                                @endif
                                @if (json_decode($job->company_address)->province)
                                    {{ json_decode($job->company_address)->province->name }}
                                @endif
                            @endif
                            </h1>
                            @if ($job->country)
                                <h1 >{{ $job->country }}</h1>
                            @endif
                            <h1 >{{ Str::title($job->status) }}</h1>
                            
                        </div>
                        @endforeach
                    @else
                        <h6 class="text-center text-gray-400 py-4">No Invitations</h6>
                    @endif
                </div>
                {{-- saved jobs --}}
                <div v-if="toggledJobs == 'saved jobs'" class="p-3" v-cloak>
                    <h1 class="text-gray-500 mb-3 fw-bold">Saved jobs</h1>
                    <div v-if="savedJobsLoader">
                        <div class="spinner-border spinner-border-sm  text-primary" role="status" >
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <label for="" class="ms-2">Fetching Data</label>
                    </div>
                    <div v-if="savedJobs">
                        <div v-for="i of savedJobs" class="my-2 mx-0 p-2 rounded-md hover:shadow-md row" :class="i.status == 'open' ? 'bg-white' : 'bg-red-100'">
                            <div class="col-sm">
                                <label class="d-block text-blue-500 fw-bold" >@{{ i.job_title }}</label>
                                <label class="d-block" for="">@{{ i.company_name }}</label>
                                <label class="d-block text-gray-400" for="">@{{ i.status }}</label>
                            </div>
                            <div class="col-sm-auto">
                                <button class="btn btn-sm btn-danger me-2" @click="deleteSavedJob(i.saved_job_id)">Delete</button>
                                <button class="btn btn-sm btn-success" @click="viewJob(i.job_id)">View</button>
                            </div>
                        </div>
                    </div>
                    <div v-if="errors.saveJobs">
                        <h1 class="text-gray-500 text-center m-5 ">Something went wrong</h1>
                    </div>
                    <div v-if="!errors.saveJobs">
                        <h1 v-if="!savedJobs && !savedJobsLoader" class="text-gray-500 text-center m-5 ">No Recent Jobs Saved</h1>
                    </div>
                </div>
                {{-- applications --}}
                <div v-if="toggledJobs == 'applications'" class="p-3  h-auto max-h-screen overflow-y-scroll" v-cloak>
                    <h1 class="text-gray-500 mb-3 fw-bold">Job Applications</h1>
                    {{-- job filters --}}
                    <div class="dropdown ms-auto me-0 w-max">
                        show
                        <button class="bg-white border-1 p-2 dropdown-toggle" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                           @{{ jobApplicationFilter }}
                        </button>
                      
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                          <li class="dropdown-item" @click="filterJobApplications('all')">All</li>
                          <li class="dropdown-item" @click="filterJobApplications('approved')">Approved</li>
                          <li class="dropdown-item" @click="filterJobApplications('pending')">Pending</li>
                          <li class="dropdown-item" @click="filterJobApplications('declined')">Declined</li>
                        </ul>
                    </div>

                    {{-- job application fetch loading --}}
                    <div v-if="JobApplicationLoader">
                        <div class="spinner-border spinner-border-sm  text-primary" role="status" >
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <label for="" class="ms-2">Fetching Data</label>
                    </div>
                    <div v-for="i in jobApplications" v-if="jobApplicationFilter == 'all' || jobApplicationFilter == i.application_status" class="p-4 my-2 bg-gray-100">
                       <h1 class="text-indigo-800 fw-bold">@{{ i.job_title }}</h1>
                       <h1 class="">@{{ i.company_name }}</h1>
                       <h1 class="">@{{ i.date_applied }}</h1>
                       <div class="w-max p-2 " :class="i.application_status == 'pending' ? 'bg-gray-50 text-gray-500' : (i.application_status == 'declined' ? 'bg-red-100 text-red-500': (i.application_status == 'approved' ? 'bg-green-100 text-green-500' : ''))">
                           @{{ i.application_status }}
                        </div>
                    </div>
                    <div class="p-6" v-if="!jobApplications">
                        <h1 class="text-secondary text-center">No Job Applications</h1>
                    </div>
                </div>
            </div>
        </div>



    </section>

    {{-- loading screen --}}
    <div id="loading" class=" w-screen h-screen bg-gray-800 bg-opacity-50 fixed top-0 " style="z-index: 3000">
        <div class="fixed top-1/3 w-screen">
            <div class="spinner-grow text-white mx-auto d-block" role="status">
                <span class="visually-hidden">Loading</span>
            </div>
            <h6 class="fw-bold fs-5 text-center text-white">Loading..</h6>
        </div>
    </div>

</body>

<script src="{{asset('js/pages/seeker_home.js')}}"></script>
    
@endsection