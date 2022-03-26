@extends('app')
@section('title', '- Jobs')
@section('content')
<link rel="stylesheet" href="{{ asset('css/employer/job-list.css') }}">
    <body class="job-list bg-indigo-100" >
        <div  id="job-list">

            <section class=" bg-gradient-to-t from-indigo-700 to-indigo-900 shadow-sm  p-4">
                <form class="container-lg" method="GET" action="/employer/job">
                    <h5 class=" mb-2 text-white">Seach job from your list</h5>
                    <div class="row">
                        <div class="mb-3 col-md-5 col-sm-9">
                            <input type="search" name="keyword" value="{{ isset($_GET['keyword']) ? $_GET['keyword'] : null }}" placeholder="type the job title" class="form-control border-0 bg-gray-200">
                        </div>
                        <div class="mb-3 col-sm-auto ">
                            <button class="btn btn-primary w-100">Search</button>
                        </div>
                        <div class="mb-3 col-sm-auto ">
                            <a  href="/employer/post-job" class="btn bg-green-500 hover:bg-green-700 text-white w-100">Create new Job</a>
                        </div>
                    </div>  
                </form>
            </section>


            <section class="container-lg mx-auto mt-2 mb-5">
                <div>
                    @if ($jobs)
                        <h4 class="fw-bold fs-4 col-sm-9 p-6">Jobs</h4>
                        @foreach ($jobs as $job)
                        <div class="bg-white shadow-sm p-6 md:mx-2 mb-4 rounded-lg hover:bg-blue-50 row">
                            <div class="col-lg">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" {{ $job->status  == 'open' ? 'checked' : '' }} @change="changeJobStatus({{ $job->job_id }})">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">{{ $job->status == 'open' ? 'Open for hiring' : 'Closed' }}</label>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold  text-indigo-800 mb-0">
                                        {{ $job->job_title }} 
                                    </h6> 
                                    <h6 class="text-secondary">{{ $job->company_name }}</h6>  
                                    @if ($job->isLocal)
                                    <h6 class="text-secondary">{{ rtrim(Str::title(json_decode($job->company_address)->municipality->name), "(Capital)").', '.Str::title(json_decode($job->company_address)->province->name)  }}</h6>
                                    @else
                                    <h6 class="text-secondary">Overseas, {{ $job->country }}</h6>
                                    @endif
                                    
    
                                    
                                    @if ($job->salary_range)
                                    <h6 class="fw-bold my-3">{{ 'Php '.number_format(json_decode($job->salary_range)->min, 0).' - Php '.number_format(json_decode($job->salary_range)->max, 0) }}</h6>    
                                    @endif                               
                                       
                                    
                                    <div class="mt-4">
                                        <h6 class="text-secondary mb-0">{{ $job->status == 'open' ? 'Opened '. $job->date_posted->diffForHumans() : 'Last opened on '.date_format($job->date_posted, 'F d, Y') }}</h6>
                                        <h6 class="text-secondary mb-0">Created on on {{ date_format($job->created_at, 'F d, Y') }}</h6>   
                                    </div>                                          
                                </div>
                            </div>
                            <div class="col-lg">
                                @if ($job->status == 'open')
                                <p class="font-bold">{{ $applicantCounts[strval($job->job_id)]['total'] }} Applications</p>
                                <p class="text-gray-500"><i class="fa fa-clipboard mr-2"></i>{{ $applicantCounts[strval($job->job_id)]['pending'] }} pending</p>
                                <p class="text-green-500"><i class="fa fa-clipboard-check mr-2"></i>{{ $applicantCounts[strval($job->job_id)]['approved'] }} approved</p>
                                <p class="text-red-500"><i class="fa fa-window-close mr-2"></i>{{ $applicantCounts[strval($job->job_id)]['declined'] }} declined</p>
                                <p class="text-yellow-500"><i class="fa fa-calendar-times mr-2"></i>{{ $applicantCounts[strval($job->job_id)]['expired'] }} expired</p>
                                @endif
                                <div>
                                    <form action="/employer/job/{{ $job->job_id }}/delete" method="post" class="inline">
                                        @csrf
                                        @method('delete')
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal{{ $job->job_id }}" class="btn btn-danger mt-4 w-max">Delete Job</button>
                                        <div class="modal fade" id="deleteConfirmationModal{{ $job->job_id }}">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="text-red-500 font-bold text-lg"><i class="fa fa-exclamation-triangle me-2"></i>Delete Warning</h6>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            You are about to delete  a job posting you created titled <strong>{{ $job->job_title }}</strong>. Pending applicants from this job posting will be automatically declined after deleting.
                                                        </p>
                                                        <br>
                                                        <p>Ire baga ay aburahin talaga?</p>
                                                        {{-- <p>Are you sure you want to delete this Job?</p> --}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">No</button>
                                                        <button class="btn btn-danger">Yes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <a class="btn btn-primary mt-4 w-max" href="/employer/job/{{ $job->job_id }}">Manage Job</a>
                                </div>
                                
                            </div>
                        </div>  
                        @endforeach  
                        {{ $jobs->links() }}                      
                    @else
                        <div class="text-center">
                            <h5 class="text-secondary">No Jobs to show.</h5>
                        </div>
                    @endif
                    
                    
                </div> 
            </section>
            
        </div>

        

        <div class="modal fade" id="mdlLoading"   tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-transparent border-0">
                    <div class="spinner-border text-white mx-auto" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="{{ asset('js/pages/employer/job-list.js') }}"></script>
@endsection