@extends('app')
@section('title', '- Jobs')
@section('content')
<link rel="stylesheet" href="{{ asset('css/employer/job-list.css') }}">
    <body class="job-list bg-indigo-100" >
        <div  id="job-list">

            <section class=" bg-light shadow-sm  p-4">
                <div class="container-lg">
                    <h5 class="fw-bold mb-2">Seach job from your list</h5>
                    <div class="row">
                        <div class="mb-3 col-md-5 col-sm-9">
                            <input type="search" name="" id="" placeholder="type the job title" class="form-control border-0 bg-gray-200">
                        </div>
                        <div class="mb-3 col-sm-auto ">
                            <button class="btn btn-primary w-100">Search</button>
                        </div>
                        <div class="mb-3 col-sm-auto ">
                            <a  href="/employer/post-job" class="btn btn-success w-100">Create new Job</a>
                        </div>
                    </div>  
                </div>
                
            </section>


            <section class="container-lg mx-auto mt-2 mb-5">
                <div>
                    @if ($jobs)
                        <h4 class="fw-bold fs-4 col-sm-9 p-6">Jobs</h4>
                        @foreach ($jobs as $job)
                        <div class="bg-white shadow-sm p-6 mx-2 mb-4 rounded-lg hover:bg-blue-50 row">
                            <div class="col-lg">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" {{ $job->status  == 'open' ? 'checked' : '' }} @change="changeJobStatus({{ $job->job_id }})">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">{{ $job->status == 'open' ? 'Open for hiring' : 'Closed' }}</label>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold fs-5 text-primary mb-0">
                                        {{ $job->job_title }} 
                                    </h6> 
                                    <h6 class="text-secondary">{{ $job->company_name }}</h6>  
    
                                    
                                    @if ($job->salary_range)
                                    <h6 class="fw-bold mb-0">{{ 'Php '.number_format(json_decode($job->salary_range)->min, 0).' - Php '.number_format(json_decode($job->salary_range)->max, 0) }}</h6>    
                                    @endif                               
                                    <h6 class="fw-bold">{{ rtrim(Str::title(json_decode($job->company_address)->municipality->name), "(Capital)").', '.Str::title(json_decode($job->company_address)->province->name)  }}</h6>   
                                    
                                    <div class="mt-4">
                                        <h6 class="text-secondary mb-0">{{ $job->status == 'open' ? 'Opened on' : 'Last opened on' }} {{ date_format($job->date_posted, 'F d, Y') }}</h6>
                                        <h6 class="text-secondary mb-0">Created on on {{ date_format($job->created_at, 'F d, Y') }}</h6>   
                                    </div>                                          
                                </div>
                            </div>
                            <div class="col-lg">
                                <p>34 Applicants</p>
                                <p>0 pending</p>
                                <p>1 approved</p>
                                <p>33 declined</p>
                                <a class="btn btn-primary mt-2 w-max d-block" href="/employer/job/{{ $job->job_id }}">Manage</a>
                            </div>
                        </div>  
                        @endforeach  
                        {{ $jobs->links() }}                      
                    @else
                        <div class="text-center">
                            <h5 class="text-secondary">You haven't created a job yet.</h5>
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