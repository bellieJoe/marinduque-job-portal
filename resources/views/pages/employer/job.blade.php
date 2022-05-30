@extends('app')
@section('title', '- Manage Job')
@section('content')
<link rel="stylesheet" href="{{ asset('css/employer/job.css') }}">
<body class="bg-gray-200">
    <div id="job">

        <section class="container-lg mx-auto my-4 md:grid grid-cols-4 rounded-2 shadow-sm p-0">

          {{-- states --}}
          @php
            $job_id = $job['jobDetails']->job_id;
            $view = isset($_GET['view']) ? $_GET['view'] : 'job_details';
            $applicants = isset($_GET['applicants']) ? $_GET['applicants'] : null;
            $hasApplications = false;
          @endphp

            {{-- job navigation --}}
            <aside class="md:col-span-1 md:inline-block bg-blue-100 p-0 rounded-start">
                <h5 class="p-3"><strong>{{ $job['jobDetails']->job_title }}</strong></h5>
                <ul>
                  <li>
                    <button @click="redirectRoute('/employer/job/{{ $job_id }}?view=job_details')" class="{{ $view == 'job_details' ? 'text-indigo-900 font-bold' : '' }} py-2 px-3 w-100 text-start hover:font-bold text-blue-500" @click="toggleView('job details')">
                      <i class="fa fa-stream me-2"></i> 
                      Job Details
                    </button>
                  </li>
                  <li>
                    <button class="{{ $view == 'applicants' && $applicants ? 'text-indigo-900 font-bold' : '' }} py-2 px-3 w-100 text-start hover:font-bold text-blue-500" data-bs-toggle="collapse" data-bs-target="#aplicantLinks"><i class="fa fa-folder-open me-2"></i>Applications</button>
                  </li>
                  <li class="collapse {{ $view == 'applicants' ? 'show' : '' }}" id="aplicantLinks">
                    <ul class="bg-blue-50">
                      <li>
                        <button @click="redirectRoute('/employer/job/{{ $job_id }}?view=applicants&applicants=all')"  class="{{ $view == 'applicants' && $applicants == 'all' ? 'font-bold' : '' }} ms-4 py-2 px-3 w-100 text-start hover:font-bold text-gray-500" ><i class="fa fa-list me-2 " ></i>All</button>
                      </li>
                      <li>
                        <button @click="redirectRoute('/employer/job/{{ $job_id }}?view=applicants&applicants=pending')"  class="{{ $view == 'applicants' && $applicants == 'pending' ? 'font-bold' : '' }} ms-4 py-2 px-3 w-100 text-start hover:font-bold text-blue-500" ><i class="fa fa-clipboard mr-2"></i>Pending</button>
                      </li>
                      <li>
                        <button @click="redirectRoute('/employer/job/{{ $job_id }}?view=applicants&applicants=approved')"  class="{{ $view == 'applicants' && $applicants == 'approved' ? 'font-bold' : '' }} ms-4 py-2 px-3 w-100 text-start hover:font-bold text-green-500" ><i class="fa fa-clipboard-check mr-2"></i>Approved</button>
                      </li>
                      <li>
                        <button @click="redirectRoute('/employer/job/{{ $job_id }}?view=applicants&applicants=declined')" class="{{ $view == 'applicants' && $applicants == 'declined' ? 'font-bold' : '' }} ms-4 py-2 px-3 w-100 text-start hover:font-bold text-red-500"><i class="fa fa-window-close mr-2"></i>Declined</button>
                      </li>
                      <li>
                        <button @click="redirectRoute('/employer/job/{{ $job_id }}?view=applicants&applicants=expired')" class="{{ $view == 'applicants' && $applicants == 'expired' ? 'font-bold' : '' }} ms-4 py-2 px-3 w-100 text-start hover:font-bold text-yellow-500"><i class="fa fa-calendar-times mr-2"></i>Expired</button>
                      </li>
                      <li>
                        <button @click="redirectRoute('/employer/job/{{ $job_id }}?view=applicants&applicants=hired')" class="{{ $view == 'applicants' && $applicants == 'hired' ? 'font-bold' : '' }} ms-4 py-2 px-3 w-100 text-start hover:font-bold "><i class="fa fa-check mr-2"></i>Hired</button>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <button @click="redirectRoute('/employer/job/{{ $job_id }}?view=suggested_seekers')" class="{{ $view == 'suggested_seekers' ? 'text-indigo-900 font-bold' : '' }} py-2 px-3 w-100 text-start hover:font-bold text-blue-500" @click="toggleView('suggested seekers')"><i class="fa fa-user-check me-2"></i>Suggested  Seekers</button>
                  </li>
                  <li>
                    <button @click="redirectRoute('/employer/job/{{ $job_id }}?view=job_preferences')" class="{{  $view == 'job_preferences' ? 'text-indigo-900 font-bold' : ''  }} py-2 px-3 w-100 text-start hover:font-bold text-blue-500" @click="toggleView('job preferences')"><i class="fa fa-sliders-h me-2"></i>Job Preferences</button>
                  </li>
                </ul>
            </aside>


            {{-- contents --}}
            <section class="md:col-span-3 md:inline-block py-4 px-3 bg-white rounded-end">
                {{-- job details --}}
                @if ($view == 'job_details')
                <div>
                  <ul class="list-group" class="bg-indigo-100">
                    <li class="list-group-item border-0">
                      <h6><strong>Job Title</strong></h6>
                      {{ $job['jobDetails']->job_title }}
                    </li>
                    <li class="list-group-item border-0">
                      <h6><strong>Job Type</strong></h6>
                      {{ $job['jobDetails']->job_type }}
                    </li>
                    @if ($job['jobDetails']->job_descriptio)
                    <li class="list-group-item border-0">
                      <h6><strong>Job Desciption</strong></h6>
                      {{ $job['jobDetails']->job_description }}
                    </li>
                    @endif
                    <li class="list-group-item border-0">
                      <h6><strong>Company Name</strong></h6>
                      {{ $job['jobDetails']->company_name}}
                    </li>
                    <li class="list-group-item border-0">
                      <h6><strong>Company Address</strong></h6>
                      {{-- {{ json_decode($job['jobDetails']->company_address)-> }} --}}
                      @php
                          $companyAddress  = $job["jobDetails"]->isLocal ? json_decode($job['jobDetails']->company_address) : null;
                      @endphp
                      @if ($job["jobDetails"]->isLocal)
                      <p>
                        {{ $companyAddress->barangay->name.', ' }} 
                        {{ $companyAddress->municipality->name.', ' }}
                        {{ $companyAddress->province->name.', ' }}
                        {{ $companyAddress->region->name }}
                      </p>
                      @else
                      <p>Overseas, {{ $job["jobDetails"]->country }}</p>
                      @endif
                      
                    </li>
                    <li class="list-group-item border-0">
                      <h6><strong>Qualifications</strong></h6>
                      <ul>
                        @if ($job['jobDetails']->educational_attainment)
                        <h1 class="font-bold text-gray-500 mt-2">Educational Attainment</h1>
                          <li ><i class="fa fa-check text-success me-2"></i>{{ Str::title($job['jobDetails']->educational_attainment) }} </li>
                        @endif
                        @if ($job['jobDetails']->course_studied )
                            @foreach (json_decode($job['jobDetails']->course_studied) as $course)
                              <li >
                              <i class="fa fa-check text-success me-2"></i>
                                {{ $course }} 
                              </li>
                            @endforeach
                        @endif
                        @if ($job['jobDetails']->experience)
                        <h1 class="font-bold text-gray-500 mt-2">Years of Experience</h1>
                          <li ><i class="fa fa-check text-success me-2"></i>{{ $job['jobDetails']->experience.' years of experience' }} </li>
                        @endif
                        
                        @if ($job['jobDetails']->skill)
                          <h1 class="font-bold text-gray-500 mt-2">Skills</h1>
                          @foreach (json_decode($job['jobDetails']->skill) as $skill )
                            <li ><i class="fa fa-check text-success me-2"></i>{{ $skill }} </li>
                          @endforeach
          
                          @if ($job["jobDetails"]->generated_skills && $job["jobDetails"]->generated_skills != 200 && json_decode($job["jobDetails"]->generated_skills) != null)
                              <label for="" class="text-sm text-gray-500" title="This extracted skills is auto generated using the EMSI Open skills API and will be use later on for job matching"><i class="fa fa-info-circle"></i> Extracted Skills: </label>
                            @foreach (json_decode($job["jobDetails"]->generated_skills)->generated as $skill)
                              <div class="inline-block bg-green-200 rounded-sm m-1 p-1 text-sm">
                                {{ $skill->name }}
                              </div> 
                            @endforeach
                          @endif
                          @if ($job["jobDetails"]->generated_skills && $job["jobDetails"]->generated_skills != 200 && json_decode($job["jobDetails"]->generated_skills) != null)
                              <br><label for="" class="text-sm text-gray-500" title="This related skills is auto generated using the EMSI Open skills API and will be use later on for job matching"><i class="fa fa-info-circle"></i> Related Skills: </label>
                            @foreach (json_decode($job["jobDetails"]->generated_skills)->related as $skill)
                              <div class="inline-block bg-purple-200 rounded-sm m-1 p-1 text-sm">
                                {{ $skill->name }}
                              </div> 
                            @endforeach
                          @endif
                        @endif

                        @if($job['jobDetails']->gender || $job['jobDetails']->other_qualification)
                        <h1 class="font-bold text-gray-500 mt-2">Other Qualifications</h1>
                        @endif
                        @if ($job['jobDetails']->gender)
                          <li ><i class="fa fa-check text-success me-2"></i>{{ Str::title($job['jobDetails']->gender) }} </li>
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
                @endif


                {{-- applicants --}}
                @if ($view == 'applicants')
                <div >
                  <div >
                    @if ($job['jobApplications'])
                      <div class="w-full" >
                      @isset($_GET['applicants'])
                        <div>
                          <h1 class="font-bold">{{ Str::ucfirst($_GET['applicants'])  }} Applicants</h1>
                        </div>
                      @endisset
                      @foreach ($job['jobApplications'] as $jobApplication)
                        
                        @if ( $applicants && ( $applicants == 'all' || $applicants ==  $jobApplication['applicationInformation']->application_status ) )
                        @php
                          $hasApplications = true;
                        @endphp
                        <div class='{{ $jobApplication['applicationInformation']->application_status == 'pending' ? 'border-gray-500' : ($jobApplication['applicationInformation']->application_status == 'approved' ? 'border-green-500' : ($jobApplication['applicationInformation']->application_status == 'declined' ? 'border-red-500' : ($jobApplication['applicationInformation']->application_status == 'expired' ? 'border-yellow-500' : 'border-black'))) }} border-l-4  rounded-2 shadow-md duration-500 my-4' >
                          <div class="p-3 ">
                            <div>
                              <h6 class="text-blue-500 font-bold my-0">Application# {{ $jobApplication['applicationInformation']->job_application_id }}</h6>
                              <h6 class="py-0 my-0">From <span class="font-bold">{{ $jobApplication['applicantInformation']->firstname.' '.Str::ucfirst($jobApplication['applicantInformation']->middlename[0]).'. '.$jobApplication['applicantInformation']->lastname }}</span></h6>
                              <h6 class="text-gray-500 my-0">{{ date_format($jobApplication['applicationInformation']->created_at ,"F d Y").', '  }}{{ $jobApplication['applicationInformation']->created_at->diffForHumans() }}</h6>
                              {{-- matchRate --}}
                              <h6  class="text-gray-500">
                                 {{ $jobApplication['applicationInformation']->match_rate['total'] }}% Match. 
                                 Education {{ $jobApplication['applicationInformation']->match_rate['educRate'] }}%, 
                                 Skills {{ $jobApplication['applicationInformation']->match_rate['skillRate'] }}%, 
                                 Experience {{ $jobApplication['applicationInformation']->match_rate['yoeRate'] }}%, 
                              </h6>
                              {{-- application status --}}
                              <h6  class="text-gray-500">
                                Status: {{ $jobApplication['applicationInformation']->application_status }}
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
                                  <button data-bs-toggle="modal" data-bs-target="#mdlConfirmDecline"  class="btn btn-danger">Decline Application</button>
                                  <div class="modal fade" id="mdlConfirmDecline">
                                    <div class="modal-dialog modal-dialog-centered" >
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h6 class="text-red-500 font-bold text-lg"><i class="fa fa-exclamation-triangle mr-2"></i>Confirm Decline Action</h6>
                                        </div>
                                        <div class="modal-body">
                                          Are you sure you want to decline this Job Application from <span class="font-bold">{{ $jobApplication['applicantInformation']->firstname.' '.Str::ucfirst($jobApplication['applicantInformation']->middlename[0]).'. '.$jobApplication['applicantInformation']->lastname }}</span>?
                                        </div>
                                        <div class="modal-footer">
                                          <form action="/employer/job/decline-application/{{ $jobApplication['applicationInformation']->job_application_id }}" method="POST">
                                            @csrf
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button class="btn btn-primary">Continue</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                                  @if ($jobApplication['applicationInformation']->application_status == 'approved')
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#hireModal">Add to Hired List</button>
                                    <form class="modal fade" id="hireModal" method="post" action="/employer/hire/{{ $jobApplication['applicationInformation']->job_application_id }}">
                                      @csrf
                                      <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                          <div class="modal-header border-none">
                                            <h1 class="font-bold">Confirm Hiring</h1>
                                          </div>
                                          <div class="modal-body  border-none">
                                            Adding hired applicants to your hired list will reflect your placement report which will be acquired by the LMD PESO Admin. Therefore this action is permanent and cannot be reverted.
                                          </div>
                                          <div class="modal-footer border-none">
                                            <button t ype="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <input type="submit" class="btn btn-success" value="Continue">
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                  @endif
                                  <a class="btn btn-primary" href="/resume/{{ $jobApplication['applicantInformation']->user_id }}" target="_blank_">View Resume</a>
                                </div>

                              
                            </div>
                          </div>
                        </div>
                        @endif
                      @endforeach

                      <div class="mt-10">
                        <h6 class="text-center text-gray-500 mt-6">{{ $hasApplications ? '' : 'No Applications to show' }}</h6>
                      </div>
                      </div>
                    @else
                    <div class="mt-6">
                      <h1 class="text-gray-500 text-center ">
                        No applicants
                      </h1>
                    </div>
                    @endif
                    
                  </div>
                </div>
                @endif

                {{-- suggested seekers --}}
                @if ($view == 'suggested_seekers')
                <div >
                  <input type="hidden" value="{{ $job['jobDetails']->job_id }}" id="jobId">
                  <h1 class="font-bold">Suggested Seekers</h1>
                  <button class="btn btn-outline-primary btn-sm block ml-auto mr-0 mb-2" @click="generateSuggestions()"><i class="fa fa-sync-alt"></i> Refresh</button>
                  @if (Session::has('InvitationSuccessMessage'))
                    <div class="m-2">
                      <p  class="text-green-500">{{ Session::get('InvitationSuccessMessage') }}</p>
                    </div>
                  @endif
                  <div v-if="suggestedSeekers.length > 0">
                    <div v-for="seeker in suggestedSeekers" class="mb-3 p-3 rounded-sm border-1" v-cloak>
                      <h1 class="font-bold text-blue-800 mb-2 text-xl" v-cloak>
                        @{{ seeker.seeker.firstname + " " + seeker.seeker.lastname  }} 
                        <i class="fa-solid fa-certificate text-yellow-400" title="With Eligibility" v-if="seeker.eligibility"></i>
                      </h1>
                      <h1 class="text-gray-500" v-cloak>
                        Educational Attainment: @{{ seeker.educationRate }}%
                      </h1>
                      <h1 class="text-gray-500" v-cloak>
                        Skills: @{{ seeker.skillsRate }}%
                      </h1>
                      <h1 class="text-gray-500" v-cloak>
                        Experience: @{{ seeker.yoeRate }}%
                      </h1>
                      <h1 v-cloak :class="seeker.total > 50 ? 'text-xl font-semibold text-green-700' : 'text-xl font-semibold text-red-500'">
                        @{{ seeker.total }}% match
                      </h1>
                      <a target="_blank" :href="'/resume/' + seeker.seeker_id" class="btn btn-primary btn-sm mt-2">View Resume</a>
                      <button data-bs-toggle="modal" data-bs-target="#inviteModal" class="btn btn-success btn-sm mt-2"><i class="fa fa-envelope"></i> Invite</button>
                      <form action="/employer/job/sendInvitation" method="POST" >
                        @csrf
                        <input type="hidden" name="seeker_id" :value="seeker.seeker.user_id">
                        <input type="hidden" name="job_id" value="{{ $job["jobDetails"]->job_id }}">
                        <div class="modal fade" id="inviteModal">
                          <div class="modal-dialog modal-dialog-centered ">
                            <div class="modal-content">
                              <div class="modal-header border-none">
                                <div>
                                  <h1 class="text-xl font-bold">Invitation</h1>
                                  <p class="block ">Send an email invitation to apply to your job posting</p>
                                </div>
                                
                              </div>
                              <div class="modal-body border-none">
                                <div>
                                  <label for="" class="font-bold mb-1">Write a message for your invitation <span class="text-danger">*</span></label>
                                  <textarea name="message" id="" cols="30" rows="10" class="form-control" required></textarea>
                                </div>
                              </div>
                              <div class="modal-footer border-none">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-envelope"></i> Send</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div  v-if="suggestedSeekers.length < 1">
                    <h1 class="text-center text-gray-600 my-48">No Suggestions. Try adding more data to your job postings.</h1>
                  </div>
                </div>
                @endif

                {{-- job prefeerences --}}
                @if ($view == 'job_preferences')
                <div >

                  {{-- setting expiration date --}}
                  <div>
                    <div class="mb-3 p-2 rounded-2 duration-500 cursor-pointer hover:bg-indigo-100 border " data-bs-toggle="modal" data-bs-target="#mdlDaysExpire">
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
                    <div class="mb-3 p-2 cursor-pointer duration-500 rounded-2 hover:bg-indigo-100 border " data-bs-toggle="modal" data-bs-target="#mdlToggleHiring">
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
                  
                  <a  class="w-full btn text-left font-bold mb-3 p-2 cursor-pointer hover:bg-indigo-100 border" href="/employer/job/edit-job/{{ $job['jobDetails']->job_id }}">
                    Edit job information?
                  </a>

                  {{-- Applicant Matching --}}
                  <div class="accordion" >
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#applicant_match_toggles">
                          Applicant Matching Preference
                        </button>
                      </h2>
                      <div class="accordion-collapse collapse show" id="applicant_match_toggles">
                        <div class="accordion-body">

                          <p class="mb-3">Matching suggested candidates for your job will be based here.</p>
                          <form action="/employer/job/{{ $job['jobDetails']->job_id }}/match_preferences/update" method="post">
                            @csrf
                            {{-- educational attainment --}}
                            <div class="form-check form-switch lg:grid lg:grid-cols-2 mb-2">
                              <label class="form-check-label " for="flexSwitchCheckDefault">Education Attainment</label>
                              <div class="input-group w-32">
                                <input 
                                type="number" 
                                name="match_preferences[educational_attainment]" 
                                value="{{   json_decode($job['jobDetails']->match_preferences)->educational_attainment }}" 
                                class="form-control" max="100" min="0">
                                <label for="" class="input-group-text">%</label>
                              </div>
                            </div>
                            {{-- skills --}}
                            <div class="form-check form-switch lg:grid lg:grid-cols-2 mb-2">
                              <label class="form-check-label " for="flexSwitchCheckDefault">Skills</label>
                              <div class="input-group w-32">
                                <input 
                                type="number" 
                                name="match_preferences[skills]" 
                                value="{{ json_decode($job['jobDetails']->match_preferences)->skills }}" 
                                class="form-control" max="100" min="0">
                                <label for="" class="input-group-text">%</label>
                              </div>
                            </div>
                            {{-- Experience --}}
                            <div class="form-check form-switch lg:grid lg:grid-cols-2 mb-4">
                              <label class="form-check-label " for="flexSwitchCheckDefault">Years of Experience</label>
                              <div class="input-group w-32">
                                <input 
                                type="number" 
                                name="match_preferences[yoe]" 
                                value="{{ json_decode($job['jobDetails']->match_preferences)->yoe }}" 
                                class="form-control" max="100" min="0">
                                <label for="" class="input-group-text">%</label>
                              </div>
                            </div>
                            @error('not_100')
                              <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <button class="btn btn-success block ml-auto mr-0">Update</button>
                          </form>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
            </section>


            
        </section>



        <div v-if="loading">
          @component('components.loading')
          @endcomponent
        </div>


    </div>
</body>
<script src="{{ asset('js/pages/employer/job.js') }}"></script>
@endsection