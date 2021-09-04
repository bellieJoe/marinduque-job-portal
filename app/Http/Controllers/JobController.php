<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Job;
use App\Models\Seeker;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{

    public function addJob(Request $request){
        
        $validator = Validator::make($request->all(), [
            'job_title' => 'required',
            'job_type' => 'required',
            'job_industry' => 'required',
            'job_description' => 'nullable|min:100|max:5000',

            'company_name' => 'required',
            'region' => 'required',
            'province' => 'required',
            'municipality' => 'required',
            'barangay' => 'required',
            'company_description' => 'nullable|min:100|max:5000',
            
            'educational_attainment' => 'nullable',
            'course_studied.*' => 'nullable',
            'gender' => 'nullable',
            'experience' => 'nullable|integer',
            'other_qualification' => 'nullable',

            'salary_min' => 'nullable|required_with:salary.max|integer',
            'salary_max' => 'nullable|required_with:salary.min|integer|gt:salary_min',
            'benefits' => 'nullable|min:50|max:5000',
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
            'job_type' => $request->input('job_type'),
            'job_description' => $request->input('job_description'),

            'company_name' => $request->input('company_name'),
            'company_descrption' => $request->input('company_description'),
            'company_address' => json_encode([
                'region' => $request->input('region'),
                'province' => $request->input('province'),
                'municipality' => $request->input('municipality'),
                'barangay' => $request->input('barangay'),
            ]), 

            'educational_attainment' => $request->input('educational_attainment'),
            'course_studied' => $request->input('course_studied') ? json_encode($request->input('course_studied')) : null,
            'gender' => $request->input('gender'),
            'experience' => $request->input('experience'),
            'other_qualification' => $request->input('other_qualification') ? json_encode($request->input('other_qualification')) : null,

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
            'benefits' => 'nullable|min:50|max:5000',
            'status' => 'nullable'
        ], [
            'salary_max.gt' => 'The Maximum salary must be greater than minimum',
            'salary_max.required_with' => 'Maximum salary is required if minimum salary has a value',
            'salary_min.integer' => 'The Minimum Salary must be integer',
            'salary_max.integer' => 'The Maximum Salary must be integer',
            'course_studied.*.distinct' => 'Duplicate entry found'
        ])->validate();

        Job::where([
            'user_id' => Auth::user()->user_id,
            'job_id' => $id
        ])->update([
            'job_title' => $request->input('job_title'),
            'job_industry' => $request->input('job_industry'),
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

            'educational_attainment' => $request->input('educational_attainment'),
            'course_studied' => $request->input('course_studied') ? json_encode($request->input('course_studied')) : null,
            'gender' => $request->input('gender'),
            'experience' => $request->input('experience'),
            'other_qualification' => $request->input('other_qualification') ? json_encode($request->input('other_qualification')) : null,

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

    public function searchJobs(Request $request){
        // $request->validate([
        //     'salary_min' => 'numeric',
        //     'salary_max' => 'numeric',
        // ]);
        $job_title = $request->input('job_title');
        $company_name = $request->input('company_name');
        $province = $request->input('province');
        $municipality = $request->input('municipality');
        $salary_min = (int)$request->input('salary_min');
        $salary_max = (int)$request->input('salary_max');

        $job = NULL;

        if($job_title && !$company_name){
            // for job title only
            if($province && $municipality){
                if($salary_min != 0 && $salary_max != 0){ //check
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max],
                    ])
                    ->orWhere([
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max],
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min == 0 && $salary_max != 0){
                    // dalary max lang
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->max', '<=' , $salary_max],
                        
                    ])
                    ->orWhere([
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->max', '<=' , $salary_max],
                    ])
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min != 0 && $salary_max == 0){
                    // dalary min lang
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                        
                    ])
                    ->orWhere([
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                else{ //check
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        
                    ])
                    ->orWhere([
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                    ])
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
            }
            elseif($province && !$municipality){
                if($salary_min != 0 && $salary_max != 0){ //clear
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min == 0 && $salary_max != 0){
                    // salary macx ang
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->max', '<=' , $salary_max]
                        
                    ])
                    ->orWhere([
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min != 0 && $salary_max == 0){
                    // salary min lang
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                        
                    ])
                    ->orWhere([
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                else{ //clear
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        
                    ])
                    ->orWhere([
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                    ])
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
            }
            elseif(!$province && !$municipality){
                if($salary_min != 0 && $salary_max != 0){ //check
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max],
                    ])
                    ->orWhere([
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max],
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min == 0 && $salary_max != 0){
                    // salary max
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['salary_range->max', '<=' , $salary_max],
                    ])
                    ->orWhere([
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['salary_range->max', '<=' , $salary_max],
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min != 0 && $salary_max == 0){
                    //salary min
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->orWhere([
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                else{ //check
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['status','open'],   
                    ])
                    ->orWhere([
                        ['job_title', 'like', '%'.$job_title],
                        ['status','open'],   
                    ])
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                    
                }                
            }
        }
        elseif(!$job_title && $company_name){
            // for company name only
            if($province && $municipality){ 
                if($salary_min != 0 && $salary_max != 0){ //clear
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min == 0 && $salary_max != 0){
                    // salary max
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min != 0 && $salary_max == 0){
                    // salary min
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                else{ //clear
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                    ])
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
            }
            elseif($province && !$municipality){
                if($salary_min != 0 || $salary_max != 0){ //check
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min == 0 || $salary_max != 0){
                    // max
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min != 0 || $salary_max == 0){
                    // min
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                else{ //check
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                    ])
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }

            }
            elseif(!$province && !$municipality){
                if($salary_min != 0 && $salary_max != 0){ //tinamad
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['status', 'open'],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min == 0 && $salary_max != 0){
                    // max
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['status', 'open'],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min != 0 && $salary_max == 0){
                    // min
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['status', 'open'],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                else{ //check
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
     
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['status', 'open'],
                    ])
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }                
            }
        }
        elseif($job_title && $company_name){
            // for both
            if($province && $municipality){
                if($salary_min != 0 && $salary_max != 0){ //tinamad
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min == 0 && $salary_max != 0){
                    //max
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min != 0 && $salary_max == 0){
                    //min
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->orWhere([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                else{ //tinamad
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                        
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                    ])
                    ->orWhere([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['company_address->municipality->name', $municipality],
                    ])
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
            }
            elseif($province && !$municipality){ 
                if($salary_min != 0 && $salary_max != 0){ //tinamad
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]

                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]

                    ])
                    ->orWhere([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min == 0 && $salary_max != 0){ //tinamad
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->max', '<=' , $salary_max]

                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->max', '<=' , $salary_max]

                    ])
                    ->orWhere([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->max', '<=' , $salary_max]
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min != 0 && $salary_max == 0){ //tinamad
                    $job = Job::where([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],

                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],

                    ])
                    ->orWhere([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        ['salary_range->min', '>=' , $salary_min],
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                else{ //tinamad
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                        
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                    ])
                    ->orWhere([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like' , $job_title.'%'],
                        ['status', 'open'],
                        ['company_address->province->name', $province],
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }

            }
            elseif(!$province && !$municipality){
                if($salary_min != 0 && $salary_max != 0){ //tinamad
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['company_name', 'like' , $company_name.'%'],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max],
                        ['status', 'open'],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max],
                        ['status', 'open'],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like' , $job_title.'%'],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max],
                        ['status', 'open'],
                    ])
                    ->orWhere([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like', '%'.$job_title],
                        ['salary_range->min', '>=' , $salary_min],
                        ['salary_range->max', '<=' , $salary_max],
                        ['status', 'open'],
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min == 0 && $salary_max != 0){ //tinamad
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['company_name', 'like' , $company_name.'%'],
                        ['salary_range->max', '<=' , $salary_max],
                        ['status', 'open'],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['salary_range->max', '<=' , $salary_max],
                        ['status', 'open'],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like' , $job_title.'%'],
                        ['salary_range->max', '<=' , $salary_max],
                        ['status', 'open'],
                    ])
                    ->orWhere([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like', '%'.$job_title],
                        ['salary_range->max', '<=' , $salary_max],
                        ['status', 'open'],
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                elseif($salary_min != 0 && $salary_max == 0){ //tinamad
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['company_name', 'like' , $company_name.'%'],
                        ['salary_range->min', '>=' , $salary_min],
                        ['status', 'open'],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['salary_range->min', '>=' , $salary_min],
                        ['status', 'open'],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like' , $job_title.'%'],
                        ['salary_range->min', '>=' , $salary_min],
                        ['status', 'open'],
                    ])
                    ->orWhere([
                        ['company_name', 'like' , $company_name.'%'],
                        ['job_title', 'like', '%'.$job_title],
                        ['salary_range->min', '>=' , $salary_min],
                        ['status', 'open'],
                    ])
                    ->whereNotNull('salary_range')
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }
                else{ //check
                    $job = Job::where([
                        ['job_title', 'like' , $job_title.'%'],
                        ['company_name', 'like' , $company_name.'%'],
                        ['status', 'open'],
                        
                    ])
                    ->orWhere([
                        ['status', 'open'],
                        ['job_title', 'like' , $job_title.'%'],
                        ['company_name', 'like', '%'.$company_name],
                    ])
                    ->orWhere([
                        ['status', 'open'],
                        ['job_title', 'like', '%'.$job_title],
                        ['company_name', 'like' , $company_name.'%'],
                    ])
                    ->orWhere([
                        ['company_name', 'like', '%'.$company_name],
                        ['job_title', 'like', '%'.$job_title],
                        ['status', 'open'],
                    ])
                    ->orderBy('date_posted', 'desc')
                    ->paginate(7)
                    ->withPath('?job_title='.$job_title.'&company_name='.$company_name.'&province='.$province.'&municipality='.$municipality.'&salary_min='.$salary_min.'&salary_max='.$salary_max);
                }                
            }
        }
        else{
            $jobs = null;
        }

        return view('pages.guest.job-search')->with([
            'job_inputs' => [
                'job_title' => $job_title,
                'company_name' => $company_name,
                'province' => $province,
                'municipality' => $municipality,
                'salary_min' => $salary_min,
                'salary_max' => $salary_max,
            ],
            'jobs' => $job
        ]);

        // return var_dump($request->salary_max);

        
    }

    public function getJobTitles(Request $request){

        $job = Job::where([
            ['job_title', 'like', $request->input('job_title').'%'],
        ])
        ->orWhere('job_title', 'like', '% '.$request->input('job_title').'%')
        ->limit(5)
        ->distinct('job_title')
        ->orderBy('job_title', 'asc')
        ->get('job_title');

        return $job;
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

    public function generateJobSuggestions(){

        // oendung muna tow
        $seeker = Seeker::where('user_id', Auth::user()->user_id)->first();
        $education = Education::where('user_id', Auth::user()->user_id)->get();
        $experience = Experience::where('user_id', Auth::user()->user_id)->get();

        $highest_education = "";

        foreach($education as $i){
            $education_level_1 = 0;
            $education_level_2 = 0;
            $education_level_3 = 0;
            if($i->education_level == "tertiary education"){
                $education_level_3++;
            }elseif($i->education_level == "secondary education"){
                $education_level_2++;
            }else{
                $education_level_1 = 0;
            }

            if($education_level_3 != 0){
                $highest_education = "tertiary education";
            }elseif($education_level_3 == 0 && $education_level_2 != 0){
                $highest_education = "secondary education";
            }elseif($education_level_3 == 0 && $education_level_2 == 0){
                $highest_education = "primary education";
            }
        }


        //check if profile is complete first

        $suggestedJobs = Job::where([
            ['status' , 'open'],
            ['educational_attainment', null],
            ['gender', null],
            ['experience', null],
        ])

        ->count();
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

        return view('pages.guest.job-view-marinduque')->with([
            'job' => $job
        ]);
    }





    // setters
    public function setDaysExpire($job_id, Request $request){

        Job::where('job_id', $job_id)
        ->update([
            'days_expire' => $request->input('days_expire') ? $request->input('days_expire') : 0
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
}
