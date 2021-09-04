@extends('app')
@section('title', '- Manage Job')
@section('content')
<link rel="stylesheet" href="{{ asset('css/employer/job.css') }}">
<body class="bg-gray-50">
    <div id="job">

        

        <section class="container-lg mx-auto my-4 row rounded-2 shadow-sm p-0">
            <aside class="col-auto bg-blue-100 p-0 rounded-start">
                <h5 class="p-3"><strong>{{ $job['jobDetails']->job_title }}</strong></h5>
                <ul>
                  <li>
                    <button :class="toggledView == 'job details' ? 'font-bold text-blue-800 ' : ''" class="py-2 px-3 w-100 text-start hover:font-bold text-blue-500" @click="toggleView('job details')"><i class="fa fa-stream me-2"></i> Job Details</button>
                  </li>
                  <li>
                    <button :class="toggledView == 'applicants-all' || toggledView == 'applicants-new' || toggledView == 'applicants-declined' ||toggledView == 'applicants-accepted' ? 'font-bold text-blue-800 ' : ''" class="py-2 px-3 w-100 text-start hover:font-bold text-blue-500" data-bs-toggle="collapse" data-bs-target="#aplicantLinks"><i class="fa fa-folder-open me-2"></i>Applicants</button>
                  </li>
                  <li class="collapse" id="aplicantLinks">
                    <ul class="bg-blue-50">
                      <li>
                        <button :class="toggledView == 'applicants-all' ? 'font-bold' : ''" class="ms-4 py-2 px-3 w-100 text-start hover:font-bold text-gray-500" @click="toggleView('applicants-all')"><i class="fa fa-chevron-right me-2 " :class="toggledView == 'applicants-all' ? 'inline' : 'hidden'"></i>All</button>
                      </li>
                      <li>
                        <button :class="toggledView == 'applicants-pending' ? 'font-bold ' : ''" class="ms-4 py-2 px-3 w-100 text-start hover:font-bold text-blue-500" @click="toggleView('applicants-pending')"><i class="fa fa-chevron-right me-2 " :class="toggledView == 'applicants-pending' ? 'inline' : 'hidden'"></i>New</button>
                      </li>
                      <li>
                        <button :class="toggledView == 'applicants-approved' ? 'font-bold ' : ''" class="ms-4 py-2 px-3 w-100 text-start hover:font-bold text-green-500" @click="toggleView('applicants-approved')"><i class="fa fa-chevron-right me-2 " :class="toggledView == 'applicants-approved' ? 'inline' : 'hidden'"></i>Accepted</button>
                      </li>
                      <li>
                        <button :class="toggledView == 'applicants-declined' ? 'font-bold ' : ''" class="ms-4 py-2 px-3 w-100 text-start hover:font-bold text-red-500" @click="toggleView('applicants-declined')"><i class="fa fa-chevron-right me-2 " :class="toggledView == 'applicants-declined' ? 'inline' : 'hidden'"></i>Declined</button>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <button :class="toggledView == 'job statistics' ? 'font-bold text-blue-800 ' : ''" class="py-2 px-3 w-100 text-start hover:font-bold text-blue-500" @click="toggleView('job statistics')"><i class="fa fa-chart-pie me-2"></i>Job Statistics</button>
                  </li>
                  <li>
                    <button :class="toggledView == 'job preferences' ? 'font-bold text-blue-800 ' : ''" class="py-2 px-3 w-100 text-start hover:font-bold text-blue-500" @click="toggleView('job preferences')"><i class="fa fa-sliders-h me-2"></i>Job Preferences</button>
                  </li>
                </ul>
            </aside>
            <section class="col py-4 px-3 bg-white-100 rounded-end">
                {{-- job details --}}
                <div v-if="toggledView == 'job details'">
                  <ul class="list-group" class="bg-indigo-100">
                    <li class="list-group-item border-0">
                      <h6><strong>Job Title</strong></h6>
                      {{ $job['jobDetails']->job_title }}
                    </li>
                    <li class="list-group-item border-0">
                      <h6><strong>Job Type</strong></h6>
                      {{ $job['jobDetails']->job_type }}
                    </li>
                    <li class="list-group-item border-0">
                      <h6><strong>Job Desciption</strong></h6>
                      {{ $job['jobDetails']->job_description }}
                    </li>
                    <li class="list-group-item border-0">
                      <h6><strong>Company Name</strong></h6>
                      {{ $job['jobDetails']->company_name}}
                    </li>
                    <li class="list-group-item border-0">
                      <h6><strong>Company Address</strong></h6>
                      {{-- {{ json_decode($job['jobDetails']->company_address)-> }} --}}
                      @php
                          $companyAddress  = json_decode($job['jobDetails']->company_address);
                      @endphp
                      <p>
                        {{ $companyAddress->barangay->name.', ' }} 
                        {{ $companyAddress->municipality->name.', ' }}
                        {{ $companyAddress->province->name.', ' }}
                        {{ $companyAddress->region->name }}
                      </p>
                    </li>
                    <li class="list-group-item border-0">
                      <h6><strong>Qualifications</strong></h6>
                      <ul>
                        @if ($job['jobDetails']->gender)
                          <li ><i class="fa fa-check text-success me-2"></i>{{ $job['jobDetails']->gender }} </li>
                        @endif
                        @if ($job['jobDetails']->educational_attainment)
                          <li ><i class="fa fa-check text-success me-2"></i>{{ $job['jobDetails']->educational_attainment }} </li>
                        @endif
                        @if ($job['jobDetails']->course_studied )
                            <li >
                              <i class="fa fa-check text-success me-2"></i>
                              @foreach (json_decode($job['jobDetails']->course_studied) as $course)
                                {{ $course.', ' }} 
                              @endforeach
                            </li>
                        @endif
                        @if ($job['jobDetails']->experience)
                          <li ><i class="fa fa-check text-success me-2"></i>{{ $job['jobDetails']->experience.' years of experience' }} </li>
                        @endif
                        @if ($job['jobDetails']->other_qualification )
                              @foreach (json_decode($job['jobDetails']->other_qualification) as $qualification)
                                <li >
                                  <i class="fa fa-check text-success me-2"></i>
                                  {{ $qualification }} 
                                </li>
                              @endforeach
                        @endif
                      </ul>
                    </li>
                  </ul>
                </div>

                {{-- applicants --}}
                <div  v-if="toggledView == 'applicants-all' || toggledView == 'applicants-pending' || toggledView == 'applicants-declined' ||toggledView == 'applicants-approved'">
                  <div class="m-2">
                    @if ($job['jobApplications'])
                      <div class="w-full" >
                      @foreach ($job['jobApplications'] as $jobApplication)
                      
                        <div class='my-3 rounded-2 shadow-sm' v-if="toggledView == 'applicants-all' || toggledView == '{{ 'applicants-'.$jobApplication['applicationInformation']->application_status }}'">
                          <div class="p-3 ">
                            <div>
                              <h6 class="text-blue-500 font-bold my-0">Application# {{ $jobApplication['applicationInformation']->job_application_id }}</h6>
                              <h6 class="py-0 my-0">From <span class="font-bold">{{ $jobApplication['applicantInformation']->firstname.' '.Str::ucfirst($jobApplication['applicantInformation']->middlename[0]).'. '.$jobApplication['applicantInformation']->lastname }}</span></h6>
                              <h6 class="text-gray-500 my-0">{{ date_format($jobApplication['applicationInformation']->created_at ,"F d Y").', '  }}{{ $jobApplication['applicationInformation']->created_at->diffForHumans() }}</h6>
                              @php
                                $appStat = $jobApplication['applicationInformation']->application_status;
                              @endphp

                              {{-- checks if a job application has expiration date --}}
                              @if ($jobApplication['applicationInformation']->expiry_date != null)
                                @if ($jobApplication['applicationInformation']->created_at->diffInDays($jobApplication['applicationInformation']->expiry_date, false) > 0)
                                  <h6 class="text-gray-500 my-0">Expiration Date: {{ $jobApplication['applicationInformation']->expiry_date->format("F d Y H:m A")  }}</h6>
                                  
                                  {{-- application status --}}
                                  <h6  class="text-gray-500">
                                    Status: {{ $jobApplication['applicationInformation']->application_status == 'approved' ? 'accepted' : $jobApplication['applicationInformation']->application_status }}
                                  </h6>

                                  {{-- notes from the applicant --}}
                                  @if ($jobApplication['applicationInformation']->others)
                                  <div class="accordion mt-3" id="applicantNote{{ $jobApplication['applicationInformation']->job_application_id }}">
                                    <div class="accordion-item">
                                      <h2 class="accordion-header" id="heading{{  $jobApplication['applicationInformation']->job_application_id  }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{  $jobApplication['applicationInformation']->job_application_id  }}" aria-expanded="true" >
                                          A note from the applicant
                                        </button>
                                      </h2>
                                      <div id="collapse{{  $jobApplication['applicationInformation']->job_application_id  }}" class="accordion-collapse collapse" aria-labelledby="heading{{  $jobApplication['applicationInformation']->job_application_id  }}" data-bs-parent="#applicantNote{{ $jobApplication['applicationInformation']->job_application_id }}">
                                        <div class="accordion-body">
                                          <p class="whitespace-pre-wrap">{{ $jobApplication['applicationInformation']->others }}</p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  @endif

                                  {{-- action buttons --}}
                                  <div class="ms-auto me-0 mb-2 mt-4 w-max">
                                    @if ($jobApplication['applicationInformation']->application_status == 'pending')
                                    <a href="/employer/job/accept-application/{{ $jobApplication['applicationInformation']->job_application_id }}" class="btn btn-success">Accept Application</a>
                                    @endif
                                    <a class="btn btn-primary" href="/resume/{{ $jobApplication['applicantInformation']->user_id }}" target="_blank_">View Resume</a>
                                  </div>

                                @else
                                <h6 class="text-red-500 mt-3">This application has expired.</h6>
                                @endif
                              @else
                                <h6 class="text-gray-500">
                                  Status: {{ $jobApplication['applicationInformation']->application_status == 'approved' ? 'accepted' : $jobApplication['applicationInformation']->application_status }}
                                </h6>

                                
                                {{-- notes from the applicant --}}
                                @if ($jobApplication['applicationInformation']->others)
                                <div class="accordion mt-3" id="applicantNote{{ $jobApplication['applicationInformation']->job_application_id }}">
                                  <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{  $jobApplication['applicationInformation']->job_application_id  }}">
                                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{  $jobApplication['applicationInformation']->job_application_id  }}" aria-expanded="true" >
                                        A note from the applicant
                                      </button>
                                    </h2>
                                    <div id="collapse{{  $jobApplication['applicationInformation']->job_application_id  }}" class="accordion-collapse collapse" aria-labelledby="heading{{  $jobApplication['applicationInformation']->job_application_id  }}" data-bs-parent="#applicantNote{{ $jobApplication['applicationInformation']->job_application_id }}">
                                      <div class="accordion-body">
                                        <p class="whitespace-pre-wrap">{{ $jobApplication['applicationInformation']->others }}</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                @endif
                                

                                {{-- action buttons --}}
                                <div class="ms-auto me-0 mb-2 mt-4 w-max">
                                  @if ($jobApplication['applicationInformation']->application_status == 'pending')
                                  <a href="/employer/job/accept-application/{{ $jobApplication['applicationInformation']->job_application_id }}" class="btn btn-success">Accept Application</a>
                                  @endif
                                  <a class="btn btn-primary" href="/resume/{{ $jobApplication['applicantInformation']->user_id }}" target="_blank_">View Resume</a>
                                </div>
                              @endif
                              
                            </div>
                          </div>
                        </div>
                      @endforeach
                      </div>
                    @else
                      No applicants
                    @endif
                    
                  </div>
                </div>

                {{-- job statistics --}}
                <div v-if="toggledView == 'job statistics'">
                  job statistics
                </div>

                {{-- job prefeerences --}}
                <div v-if="toggledView == 'job preferences'">

                  {{-- setting expiration date --}}
                  <div>
                    <div class="mb-3 p-2 rounded-2 duration-500 cursor-pointer hover:bg-indigo-100" data-bs-toggle="modal" data-bs-target="#mdlDaysExpire">
                      <p class="font-bold">Set how many days does an application expire if unattended</p>
                      <p class="text-secondary">{{ $job['jobDetails']->days_expire ?  $job['jobDetails']->days_expire : '0'}} days</p>
                    </div>
                    <div id="mdlDaysExpire" class="modal fade">
                      <div class="modal-dialog modal-dialog-centered">
                        <form class="modal-content" id="formDaysExp" method="POST" action="/employer/job/{{ $job['jobDetails']->job_id }}/days-expire" >
                          @method('PUT')
                          @csrf
                          <div class="modal-body">
                            <p>After the job application expires, the job application will be automatically mark as declined.</p>

                            <div class="mt-4">
                              <input type="text">
                              <h6 class="mb-1 font-bold">No. of Days</h6>
                              <div class="input-group">
                                <input type="number" class="form-control" name="days_expire" min="0">
                                <label class="input-group-text">day/s</label>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer border-none">
                            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                            <button class="btn btn-success" type="submit">Apply</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  {{-- open or close job hiring --}}
                  <div>
                    <div class="mb-3 p-2 cursor-pointer duration-500 rounded-2 hover:bg-indigo-100" data-bs-toggle="modal" data-bs-target="#mdlToggleHiring">
                      <p class="font-bold">{{ $job['jobDetails']->status == 'open' ? 'Close' : 'Open for' }} job hiring?</p>
                      <p class="text-secondary">{{ $job['jobDetails']->status }}</p>
                    </div>
                    <div id="mdlToggleHiring" class="modal fade">
                      <div class="modal-dialog modal-dialog-centered" >
                        <form class="modal-content" method="post" action="/employer/job/{{ $job['jobDetails']->job_id }}/status">
                          @csrf
                          <div class="modal-header border-0">
                            <p class="font-bold">{{ $job['jobDetails']->status == 'open' ? 'Close' : 'Open' }} job hiring</p>
                          </div>
                          <div class="modal-body border-0">
                            <h6>Are you sure sure you want to {{ $job['jobDetails']->status == 'open' ? 'close' : 'open' }} your job hiring for this job?</h6>
                          </div>
                          <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-success">Confirm</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  
                  <a  class="w-full btn text-left font-bold mb-3 p-2 cursor-pointer hover:bg-indigo-100" href="/employer/job/edit-job/{{ $job['jobDetails']->job_id }}">
                    Edit job information?
                  </a>
                </div>
            </section>
        </section>

        <div id="loading">
          @component('components.loading')
          @endcomponent
        </div>
        
    </div>
</body>
<script src="{{ asset('js/pages/employer/job.js') }}"></script>
@endsection