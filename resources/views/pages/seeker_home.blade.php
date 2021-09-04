@extends('app')
@section('title', '- Home')
@section('content')
<link rel="stylesheet" href="{{asset('css/seeker_home.css')}}">

<body class="seeker-home">
    <section id="seeker-home">

    
        <div class="wrapper mt-5 row">
            {{-- home navigation --}}
            <div class="col-sm-4">
                <div class="p-3 mb-4 bg-white shadow-sm">
                    <h4 class="fw-bold text-center p-2">Welcome back Job Hunter!</h4>
                    <hr>
                    <img class="mt-2 col-5 d-block mx-auto border {{ $seeker->display_picture ? '' : 'd-none' }}" src="{{ url('image') }}\seeker\profile\{{  $seeker->display_picture }}" alt="profile">
                    <a href="/seeker/profile/upload-image/seeker-profile" class="duration-500 hover:text-gray-50 pt-16 text-center fw-bold text-gray-400 hover:bg-gray-300 mt-2 border-3 border-dashed  w-40 h-40 d-block mx-auto bg-gray-100 {{ $seeker->display_picture ? 'd-none' : '' }}">Upload photo</a>
                    <h6 class="fw-bold text-center my-3">{{ $seeker->firstname.' '.Str::ucfirst($seeker->middlename[0]).'. '.$seeker->lastname }}</h6>

                    <a href="/seeker/profile/upload-image/seeker-profile" class="btn btn-primary btn-sm mx-auto d-block my-2 w-auto {{ $seeker->display_picture ? '' : 'd-none' }}">Upload display photo</a>
                    <a href="/seeker/profile/personal" class="btn btn-outline-primary w-100 my-1" id="view_prof"><i class="fa fa-user me-2"></i> View Profile</a>
                    <a href="" class="btn btn-outline-primary w-100 my-1" id="view_prof"><i class="fa fa-cog me-2"></i> Account Settings</a>
                    {{-- <button class="ctrls">My Portfolio</button> --}}
                </div>
                <button class="btn btn-dark d-block mx-auto w-100 mb-5 btn-lg"><i class="fas fa-briefcase"></i> Find match today!</button>
            </div>

            {{-- sesarch box --}}
            <div class="col-sm">
                <div class="mb-5 bg-gray-800 p-3">
                    <h4 class="fw-bold text-white mb-2">Search Jobs</h4>
                    <form action="/job-search/search" method="get">
                        <div class="row">
                            <div class="mb-2 col-md">
                                <div class="form-floating">
                                    <input type="search" class="form-control form-control-lg" name="job_title" placeholder="job title">
                                    <label class="fw-bold text-secondary mb-1">Job Title</label>
                                </div>
                            </div>
                            <div class="mb-2 col-md">
                                <div class="form-floating">
                                    <input type="search" class="form-control form-control-lg" name="company_name" placeholder="company name">
                                    <label class="fw-bold text-secondary mb-1">Company Name</label>
                                </div>
                            </div>
                            <div class="mb-2 col-md-auto">
                                <button class="search-button btn btn-outline-light h-100 w-100" > <i claass="fas fa-search"></i> Search</button>
                            </div>
                            
                        </div>
                    </form>
                </div>


                <div>
                    <nav class="bg-indigo-800 pt-1 ps-1 pe-1" v-cloak>
                        <button class="py-2 px-3 duration-300 hover:bg-indigo-600" :class="toggledJobs == 'suggestions' ? 'bg-white text-indigo-800' : 'bg-indigo-800 text-white'" @click="toggleJobs('suggestions')">
                            <i class="fa fa-archive me-1"></i> Suggested Jobs
                        </button>
                        <button class="py-2 px-3 hover:bg-indigo-600 duration-300" :class="toggledJobs == 'invitations' ? 'bg-white text-indigo-800' : 'bg-indigo-800 text-white'"  @click="toggleJobs('invitations')">
                            <i class="fa fa-envelope me-1"></i> Invitations
                        </button>
                        <button class="py-2 px-3 hover:bg-indigo-600 duration-300" :class="toggledJobs == 'saved jobs' ? 'bg-white text-indigo-800' : 'bg-indigo-800 text-white'"  @click="toggleJobs('saved jobs')">
                            <i class="fa fa-bookmark me-2"></i> 
                            Saved Jobs 
                        </button>
                        <button class="py-2 px-3 hover:bg-indigo-600 duration-300" :class="toggledJobs == 'applications' ? 'bg-white text-indigo-800' : 'bg-indigo-800 text-white'"  @click="toggleJobs('applications')">
                            <i class="fa fa-briefcase me-2"></i> 
                            Applications
                        </button>
                    </nav>
                    <div class="bg-white mb-5">
                        {{-- suggested jobs --}}
                        <div v-if="toggledJobs == 'suggestions'" class="p-3" v-cloak>
                              <h1 class="text-gray-500 mb-3 fw-bold">Jobs for You</h1>
                            suggestions
                        </div>
                        {{-- job invitions --}}
                        <div v-if="toggledJobs == 'invitations'" class="p-3" v-cloak>
                            <h1 class="text-gray-500 mb-3 fw-bold">Job Invitations</h1>
                            invitations
                        </div>
                        {{-- saved jobs --}}
                        <div v-if="toggledJobs == 'saved jobs'" class="p-3" v-cloak>
                            <h1 class="text-gray-500 mb-3 fw-bold">Saved jobs</h1>
                            <div v-if="!savedJobs">
                                <div class="spinner-border spinner-border-sm  text-primary" role="status" >
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <label for="" class="ms-2">Fetching Data</label>
                            </div>
                            <div v-if="savedJobs">
                                <div v-for="i of savedJobs" class="my-2 mx-0 p-2 border-1 row" :class="i.status == 'open' ? 'bg-white' : 'bg-red-100'">
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
                                <h1 v-if="!savedJobs[0]" class="text-gray-300 text-center m-5 fs-3">No Recent Jobs Saved</h1>
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
                            <div v-if="!jobApplications[0]">
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