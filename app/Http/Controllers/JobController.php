<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Seeker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Algolia\AlgoliaSearch\SearchIndex;
use App\Models\SavedJob;
use App\Notifications\InvitationNotification;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{

    private static function array_to_CSV($array){
        $ret  = "";
        foreach($array as $el){
            $ret = $ret.$el.", ";
        }

        return $ret;
    }

    public function addJob(Request $request){
        
        $validator = Validator::make($request->all(), [
            'job_title' => 'required',
            'job_type' => 'required',
            'job_industry' => 'required',
            'job_specialization' => 'required',
            'job_description' => 'nullable|min:50|max:5000',

            'company_name' => 'required',
            'region' => 'required_if:isLocal,true',
            'province' => 'required_if:isLocal,true',
            'municipality' => 'required_if:isLocal,true',
            'barangay' => 'required_if:isLocal,true',
            'company_description' => 'nullable|min:50|max:5000',
            'country' => 'required_if:isLocal,false',
            
            'educational_attainment' => 'nullable',
            'course_studied.*' => 'nullable',
            'gender' => 'nullable',
            'experience' => 'nullable|integer',
            'other_qualification' => 'nullable',

            'salary_min' => 'nullable|required_with:salary.max|integer',
            'salary_max' => 'nullable|required_with:salary.min|integer|gt:salary_min',
            'benefits' => 'nullable|max:5000',
            'status' => 'nullable'
        ], [
            'salary_max.gt' => 'The Maximum salary must be greater than minimum',
            'salary_max.required_with' => 'Maximum salary is required if minimum salary has a value',
            'salary_min.integer' => 'The Minimum Salary must be integer',
            'salary_max.integer' => 'The Maximum Salary must be integer',
            'course_studied.*.distinct' => 'Duplicate entry found'
        ])->validate();
        

        $job = Job::create([
            'user_id' => Auth::user()->user_id,
            'job_title' => $request->input('job_title'),
            'job_industry' => $request->input('job_industry'),
            'job_specialization' => json_encode($request->input('job_specialization')),
            'job_type' => $request->input('job_type'),
            'job_description' => $request->input('job_description'),

            'company_name' => $request->input('company_name'),
            'company_description' => $request->input('company_description'),
            'company_address' => json_encode([
                'region' => $request->input('region'),
                'province' => $request->input('province'),
                'municipality' => $request->input('municipality'),
                'barangay' => $request->input('barangay'),
            ]), 
            'country' => $request->input("country"),
            'isLocal' => $request->input("isLocal") == true ? 1 : 0,
            'isGovernment' => $request->input("isGovernment") == true ? 1 : 0,
            // 'match_preferences' => 	'{"educational_attainment":30,"skills":40,"yoe":30}',	

            'educational_attainment' => $request->input('educational_attainment'),
            'course_studied' => $request->input('course_studied') ? json_encode($request->input('course_studied')) : null,
            'gender' => $request->input('gender'),
            'experience' => $request->input('experience'),
            'other_qualification' => $request->input('other_qualification') ? json_encode($request->input('other_qualification')) : null,
            'skill' => $request->input('skill') ? json_encode($request->input('skill')) :  null,
            'generated_skills' => null,
            // 'generated_skills' => $request->input('skill') ? json_encode(EmsiAPIController::extractSkills(self::array_to_CSV($request->input('skill')))) : null,
            'salary_range' => json_encode([
                'min' => $request->input('salary_min'),
                'max' => $request->input('salary_max'),
            ]) ,
            'job_benefits' => $request->input('benefits'),
            'status' => $request->input('status') == 0 ? 'closed' : 'open',
            'date_posted' =>  date('Y-m-d H:i:s'),
        ]);

        return $job;

    }

    public function updateStatus($id){
        
        $job = Job::where([
            'user_id' => Auth::user()->user_id,
            'job_id' => $id
        ]);

        if($job->first()->status == "open"){
            $job->update([
                'status' => 'closed'
            ]);
        }else{
            $job->update([
                'status' => 'open',
                'date_posted' => Carbon::now()
            ]);
        }
    }

    public function updateJob($id, Request $request){
        
        $validator = Validator::make($request->all(), [
                'job_title' => 'required',
                'job_type' => 'required',
                'job_industry' => 'required',
                'job_specialization' => 'required',
                'job_description' => 'nullable|min:100|max:5000',

                'company_name' => 'required',
                'region' => 'required',
                'province' => 'required',
                'municipality' => 'required',
                'barangay' => 'required',
                'company_description' => 'nullable|min:100|max:5000',
                
                'educational_attainment' => 'nullable',
                'course_studied.*' => 'nullable|distinct',
                'gender' => 'nullable',
                'experience' => 'nullable|integer',
                'other_qualification' => 'nullable',

                'salary_min' => 'nullable|required_with:salary.max|integer',
                'salary_max' => 'nullable|required_with:salary.min|integer|gt:salary_min',
                'benefits' => 'nullable|max:5000',
                'status' => 'nullable'
            ], [
                'salary_max.gt' => 'The Maximum salary must be greater than minimum',
                'salary_max.required_with' => 'Maximum salary is required if minimum salary has a value',
                'salary_min.integer' => 'The Minimum Salary must be integer',
                'salary_max.integer' => 'The Maximum Salary must be integer',
                'course_studied.*.distinct' => 'Duplicate entry found'
            ])
        ->validate();

        Job::where([
            'user_id' => Auth::user()->user_id,
            'job_id' => $id
        ])->update([
            'job_title' => $request->input('job_title'),
            'job_industry' => $request->input('job_industry'),
            'job_specialization' => json_encode($request->input('job_specialization')),
            'job_type' => $request->input('job_type'),
            'job_description' => $request->input('job_description'),

            'company_name' => $request->input('company_name'),
            'company_description' => $request->input('company_description'),
            'company_address' => json_encode([
                'region' => $request->input('region'),
                'province' => $request->input('province'),
                'municipality' => $request->input('municipality'),
                'barangay' => $request->input('barangay'),
            ]), 
            // 'country' => $request->input("country"),
            // 'isLocal' => $request->input("isLocal") == true ? 1 : 0,
            'isGovernment' => $request->input("isGovernment") == true ? 1 : 0,

            'educational_attainment' => $request->input('educational_attainment'),
            'course_studied' => $request->input('course_studied') ? json_encode($request->input('course_studied')) : null,
            'gender' => $request->input('gender'),
            'experience' => $request->input('experience'),
            'other_qualification' => $request->input('other_qualification') ? json_encode($request->input('other_qualification')) : null,
            'skill' => $request->input('skill') ? json_encode($request->input('skill')) :  null,
            // 'generated_skills' => $request->input('skill') ? json_encode(EmsiAPIController::extractSkills(self::array_to_CSV($request->input('skill')))) : null,
            'salary_range' => json_encode([
                'min' => $request->input('salary_min'),
                'max' => $request->input('salary_max'),
            ]) ,
            'job_benefits' => $request->input('benefits')       
        ]);

        // return $request;
    }


    // getters
    public function getJobByEmployerId($EmployerId){
        return Job::where([
            'user_id' => Auth::user()->user_id,
            'job_id' => $EmployerId
        ])->first();
    }



    public function searchJobMain(Request $request){

        // get results from algolia
        $jobIds = Job::search($request->input('keyword'))
            ->get()
            ->map(function($item, $key){
                return $item->job_id;
            });

        // filter results
        $salary_min = $request->has('salary_min') ? $request->input('salary_min') : null;
        $salary_max = $request->has('salary_max') ? $request->input('salary_max') : null;

        $salary_query = null;
        if($salary_min && $salary_max){
            $salary_query = [
                ['salary_range->min' , '>=', $salary_min],
                ['salary_range->min' , '<', $salary_max],
                ['salary_range->max' , '<=', $salary_max],
                ['salary_range->max' , '>', $salary_min]
            ];
        }elseif ($salary_min && !$salary_max) {
            $salary_query = [
                ['salary_range->min' , '>=', $salary_min],
            ];
        }elseif (!$salary_min && $salary_max) {
            $salary_query = [
                ['salary_range->max' , '<=', $salary_max],
            ];
        }else{
            $salary_query = [
                ['salary_range->min' , 'like', '%'],
                ['salary_range->max' , 'like', '%']
            ];
        }

        $jobs = Job::whereIn('job_id', $jobIds)
                ->where([
                    ['status', 'open'],
                    ['company_address->province->name', 'like', $request->input('province') ? $request->input('province') : '%'],
                    ['company_address->municipality->name', 'like', $request->input('municipality') ? $request->input('municipality') : '%'],
                    ...$salary_query
                ])
                ->paginate(10);


        return view('pages.guest.job-search')->with([
            'job_inputs' => [
                'keyword' => $request->input('keyword'),
                'province' => $request->input('province'),
                'municipality' => $request->input('municipality'),
                'salary_min' => $request->input('salary_min'),
                'salary_max' => $request->input('salary_max'),
            ],
            'jobs' => $jobs
        ]);
    }

    public function getCompanyNames(Request $request){
        $job = Job::where([
            ['company_name', 'like', $request->input('company_name').'%'],
        ])
        ->orWhere('company_name', 'like', '% '.$request->input('company_name').'%')
        ->limit(5)
        ->distinct('company_name')
        ->orderBy('company_name', 'asc')
        ->get('company_name');

        return $job;
    }

    public function getJobs(Request $request){

        $jobs = null;
        $jobCount = Job::count();

        if($request->has('search')){

            if(trim($request->input('search')) != ""){
                $jobs = Job::where('job_id', $request->input('search'))->paginate(50);
            }else{
                $jobs = Job::paginate(50);
            }
            

        }else if($request->has('sort') && $request->has('column')){
            $jobs = Job::orderBy($request->input('column'), $request->input('sort'))->paginate(50);
        }else{
            $jobs = Job::paginate(50);
        }

        return view('pages.admin.job-list')->with([
            'jobsData' => $jobs,
            'jobCount' => $jobCount
        ]);
    }

    public function getJobFromMarinduque($job_id){
        $job = Job::where('job_id', $job_id)->first();
        $seekerInterference = [
            'applied' => null,
            'saved' => null,
        ];


        // check if already applied and already saved
        $jobApplications = Auth::check() ? JobApplication::where([
            ['applicant_id', Auth::user()->user_id],
            ['job_id', $job_id],
            ['application_status', 'pending']
        ])->first() : [];

        $saveJobs = Auth::check() ? SavedJob::where([
            ['user_id', Auth::user()->user_id],
            ['job_id', $job_id],

        ])->first() : [];

        if (!empty($jobApplications)) {
            $seekerInterference['applied'] = true;
        } 

        if (!empty($saveJobs)) {
            $seekerInterference['saved'] = true;
        } 


        return view('pages.guest.job-view-marinduque')->with([
            'job' => $job,
            'seekerInterference' => $seekerInterference
        ]);
        // return $job->skill;
    }



    // setters
    public function setDaysExpire($job_id, Request $request){

        Job::where('job_id', $job_id)
        ->update([
            'days_expire' => $request->input('days_expire') ? $request->input('days_expire') : 0
        ]);

        JobApplication::where([
            ['job_id', $job_id],
            ['application_status', 'pending']
        ])
        ->update([
            'expiry_date' => $request->input('days_expire') ?  Carbon::now('UTC')->addDays($request->input('days_expire')) : null
        ]);

        return redirect()->back();
    }

    public function toggleStatus($job_id){
        
        $job = Job::where('job_id', $job_id);

        if(Auth::user()->user_id == $job->first()->user_id){
            if($job->first()->status == 'open'){
                $job->update([
                    'status' => 'closed'
                ]);
            }else{
                $job->update([
                    'status' => 'open',
                    'date_posted' => Carbon::now()
                ]);
            }

            return redirect()->back();
        }
    } 

    public function setStatus($status, $job_id){
        Job::where('job_id', $job_id)->update([
            'status' => $status == 'terminate' ? 'terminated' : 'closed' 
        ]);

        return back();
    }

    // deletes
    public function deleteJobById($job_id){

        $job = Job::where('job_id', $job_id);

        $job->delete();

        // decline all applications
        JobApplication::where([
            ['job_id', $job_id],
            ['application_status', 'pending']
            ])->update([
            'application_status' => 'declined'
        ]);

        return back();
    }


    // returns suggested jobs ids might delete later
    public function generateJobSuggestionsIds(){

        $userId = Auth::user()->user_id;

        $generatedJobIds = [];

        /* first retrieve the data from the user */
        // data from seekers table
        $seeker = Seeker::where('user_id', $userId)->first(); 

        // data from experiences table
        $userExperiences = Experience::where('user_id', $userId)->get(); 

        // data from educations table
        $userEducations = Education::where('user_id', $userId)->get();




        // setup the data as array
        $userData = [
            'user_id' => Auth::user()->user_id,
            'address' => $seeker->address, // used
            'gender' => $seeker->gender,  // used
            'birthdate' => $seeker->birthdate,
            'nationality' => $seeker->nationality,
            'civil_status' => $seeker->civil_status,
            'language' => $seeker->language ? [...json_decode($seeker->language)] : null,
            'experiences' => !empty($userExperiences->toArray()) ? [...$userExperiences->toArray()] : null,
            'educations' => !empty($userEducations->toArray()) ? [...$userEducations->toArray()] : null,
        ];

        /* fetching possible candidate jobs, apparently there are only 4 basis for generating job suggestions */
        // get job base on users address
        $addressBasedJobs = $userData['address'] 
                            ? Job::where([
                                    ['company_address->province->name', strtoupper(trim(explode(',' ,$userData['address'])[2]))],
                                    ['status', 'open']
                                ])
                                ->orWhere([
                                    ['company_address->province->name', 'like', '%'.strtoupper(trim(explode(',' ,$userData['address'])[2])).'%'],
                                    ['status', 'open']
                                ])
                                ->orWhere([
                                    ['company_address->province->name', 'like', strtoupper(trim(explode(',' ,$userData['address'])[2])).'%'],
                                    ['status', 'open']
                                ])
                                ->orWhere([
                                    ['company_address->province->name', 'like', '%'.strtoupper(trim(explode(',' ,$userData['address'])[2]))],
                                    ['status', 'open']
                                ])
                                ->pluck('job_id')->toArray() 
                            : [];

        
        // get job base on gender
        $genderBasedJobs = $userData['gender']
                           ? Job::where([
                                ['gender', $userData['gender']],
                                ['status', 'open']
                           ])
                           ->orWhere([
                                ['gender', null],
                                ['status', 'open']
                           ])->pluck('job_id')->toArray() 
                           : [];


        // get job base on experience
        $experienceBasedJobs = [];
        if($userData['experiences']){
            foreach ($userData['experiences'] as $experience) {

                $started = new Carbon($experience['date_started']);
                $ended = new Carbon($experience['date_ended']);

                $jobs = Job::where([
                            ['job_industry' , $experience['job_industry']],
                            ['experience', '>=', $started->diffInYears($ended)],
                            ['status', 'open']
                        ])
                        ->orWhere([
                            ['job_industry' , $experience['job_industry']],
                            ['experience', null],
                            ['status', 'open']
                        ])->pluck('job_id')->toArray();

                if(!empty($jobs)){
                    array_push($experienceBasedJobs, ...$jobs);
                }

            }
        }
        // get job base on educations
        $educationbasedJobs = [];
        if($userData['educations']){


            // check the highest education level
            $educInNumArray = [];
            $courses = [];
            foreach($userData['educations'] as $education){
                
                if($education['course']){
                    array_push($courses, $education['course'] );
                }
                

                switch ($education['education_level']) {
                    case 'primary education':
                        array_push($educInNumArray, 1);
                        break;
                    case 'secondary education':
                        array_push($educInNumArray, 2);
                        break;
                    case 'tertiary education':
                        array_push($educInNumArray, 3);
                        break;
                    
                    default:
                        array_push($educInNumArray, 0);
                        break;
                }
            }

            // generate the jobs base on higshet education
            switch (max($educInNumArray)) {
                case 3:
                    // include the course

                    $tempEducJobs = Job::where([
                        ['status', 'open'],
                        ['educational_attainment', 'tertiary education'],
                        // ['course_studied->', $courses]
                    ])
                    // ->whereJsonLength('course_studied', '>', 1)
                    ->get()
                    ->toArray();

                    // clean the generated jobs to select only that mathces the course
                    foreach ($tempEducJobs as $job) {
                        if($job['course_studied']){
                            foreach(json_decode($job['course_studied']) as $course){
                                foreach($courses as $baseCourse){
                                    if($course == $baseCourse){
                                        array_push($educationbasedJobs, $job['job_id']);
                                    }
                                }
                            }
                        }else{
                            array_push($educationbasedJobs, $job['job_id']);
                        }
                        
    
                    }

                    break;
                case 2:
                    $educationbasedJobs = Job::where([
                        ['status', 'open'],
                    ])
                    ->whereIn('educational_attainment', ['secondary education', 'primary education'])
                    ->pluck('job_id')
                    ->toArray();

                    break;
                case 1:
                    $educationbasedJobs = Job::where([
                        ['status', 'open'],
                        ['educational_attainment', 'primary education'],
                    ])
                    ->pluck('job_id')
                    ->toArray();
                    break;
                
                default:
                    $educationbasedJobs = [];
                    break;
            }

        }



        // combine most important and less important jobs
        // $mostImportant = [...$educationbasedJobs,...$experienceBasedJobs];
        // $lessImportant = [...$genderBasedJobs, ...$addressBasedJobs ];

    
        foreach(array_unique(array_intersect([...$educationbasedJobs,...$experienceBasedJobs],[...$genderBasedJobs,...$addressBasedJobs])) as $key => $value){
            if ($value) {
                array_push($generatedJobIds, $value);
            }
            
            // echo $value.' ' ;
        }

        return [...$generatedJobIds];



    }

    public function generateJobSuggestionsPreview(){

        $res = collect(JobMatchingController::genSuggestedJobs());
        return $res->count() < 11 ? $res : $res->take(10);
    }

    public function generateJobSuggestionsFull(){


        return view('pages.seeker.job-suggestions-full')
                ->with([
                    'jobs' => JobMatchingController::genSuggestedJobs()
                ]);

    }

    public static function generateCandidates($job_id){
        // $job = Job::find($job_id);

        // // do not generate candidatte if the job is closef=d
        // if($job->status == "closed"){
        //     return null;
        // }

        // // data preparation
        // $config = [
        //     '1' => [],
        //     '2' => [],
        //     '3' => []
        // ];

        // foreach([$job->match_preference[0], $job->match_preference[1], $job->match_preference[2]] as $key => $val){
        //     $name = $key == 0 ? 'educational_attainment' : ( $key == 1 ? 'skills' : 'yoe' );
        //     array_push($config[$val], $name);
        // }
        // $education = [
        //         'educational_attainment' => $job->educational_attainment,
        //         'courses' => $job->course_studied ? json_decode($job->course_studied) : null
        //     ];
        // // skill should only be separated by comma
        // $skills = "";
        // foreach(json_decode($job->skill) as $skill){
        //     $skills = $skills.$skill.", ";
        // }

        // if(!empty($config['1'])){

        // } else if (!empty($config['2'])){

        // } else {
            
        // }

        // return $config;
    }

    public function sendInvitation(Request $request){

        $seeker = Seeker::where("user_id", $request->input("seeker_id"))->first();
        $seekerAcc = User::find($request->input("seeker_id"));
        $job = Job::find($request->input("job_id"));
        $seekerAcc->notify(new InvitationNotification($seeker, $job, $request->input("message")));

        $invitations = $job->invitation ? json_decode($job->invitation) : [];

        array_push($invitations, $request->input("seeker_id"));

        Job::where("job_id", $request->input("job_id"))->update([
            "invitation" => json_encode($invitations)
        ]);

        return back()->with([
            "InvitationSuccessMessage" => "The Invitation was sent successfully."
        ]);
    }

}

