<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\JobApplication;
use App\Models\Job;
use App\Models\Credential;
use App\Models\Seeker;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class JobMatchingController extends Controller
{

    public static function genSuggestedJobs(){

        $user_id = Auth::user()->user_id;
        $seeker = Seeker::where('user_id', $user_id)->first();
        $jobsUnfiltered = Job::where('status', "open")
        ->get(); 

        $jobs = [];
        foreach ($jobsUnfiltered as $job) {
            if($job->invitation){
                if(!in_array(Auth::user()->user_id, json_decode($job->invitation))){
                    array_push($jobs, $job); 
                }
            }
            else{
                array_push($jobs, $job); 
            }
        }

        $education = Education::where("user_id", $user_id)->get();
        $suggestedJobs = collect([]);

        foreach ($jobs as $job) {
            $application = JobApplication::where([
                'job_id' => $job->job_id,
                'applicant_id' => $user_id,
                'application_status' => 'hired'
            ])->get();

            if(count($application) > 0){
                continue;
            }

            $educRate = number_format(self::rateEducation($job, $seeker) * (json_decode($job->match_preferences)->educational_attainment / 100), 2, "." , ",");
            $skillsRate = number_format(self::rateSkills($job, $seeker) * (json_decode($job->match_preferences)->skills / 100), 2, "." , ",");
            $yoeRate =  number_format(self::rateYOE($job, $seeker) * (json_decode($job->match_preferences)->yoe / 100), 2, "." , ",");

            $suggestedJobs->push( [
                "job" => $job,
                "educationRate" => $educRate,
                "skillsRate" => $skillsRate,
                'yoeRate' => $yoeRate,
                'total' => number_format( ($educRate + $skillsRate + $yoeRate), 2, '.', ',' )
            ]);
        }

        a:
        $sorted = true;
        foreach($suggestedJobs as $i => $seeker){
            if($i < (count($suggestedJobs)-1)){
                if($suggestedJobs[$i]["total"] < $suggestedJobs[($i+1)]["total"]){
                    $_seeker = $suggestedJobs[$i];
                    $suggestedJobs[$i] = $suggestedJobs[($i+1)];
                    $suggestedJobs[($i+1)] = $_seeker;
                    $sorted = false;
                }
            }
        }


        if(!$sorted){
            goto a;
        }

        return $suggestedJobs->where("total", ">", 0);
        // return $suggestedJobs;
    }

    public static function setHighEducation($education, $highest){
        if(in_array($education->education_level, ["tertiary education", "master's degree", "doctorate degree"])){
            if(!$highest[0]) {
                if($education->education_level == $highest[0]->education_level ){
                    array_push($highest, $education);
                }
            }
            else {
                $highest[0] = $education;
            }
        }
        else {
            $highest[0] = $education;
        }
        return $highest;
    }

    public static function genSuggestedCandidate($job_id){

        $job = Job::find($job_id);
        $seekers = Seeker::all();
        $candidates = [];
        $invitedSeekers = [];
        $applications = JobApplication::where([
            'job_id' => $job_id,
            'application_status' => "hired"
            ])
            ->pluck('applicant_id')->toArray();

        if($job->invitation) {
            $invitedSeekers = json_decode($job->invitation);
        }


        /* educational attainment */
        foreach($seekers as $seeker){
            if(in_array($seeker->user_id , $invitedSeekers) || in_array($seeker->user_id , $applications)){
                continue;
            }
            $educRate  = $job->educational_attainment ?  number_format(self::rateEducation($job, $seeker) * (json_decode($job->match_preferences)->educational_attainment / 100), 2, "." , ",") : json_decode($job->match_preferences)->educational_attainment;
            $skillRate = number_format(self::rateSkills($job, $seeker) * (json_decode($job->match_preferences)->skills / 100), 2, "." , ",");
            $yoeRate = $job->experience ? number_format(self::rateYOE($job, $seeker) * (json_decode($job->match_preferences)->yoe / 100), 2, "." , ",") : json_decode($job->match_preferences)->yoe;
            array_push($candidates, [
                "seeker_id" => $seeker->user_id,
                "seeker" => $seeker,
                "eligibility" => Credential::where([
                    "user_id" => $seeker->user_id,
                    "credential_type" => "eligibility"
                ])->first(),
                "educationRate" => $educRate,
                "skillsRate" => $skillRate,
                'yoeRate' => $yoeRate,
                'total' => number_format( ($educRate + $skillRate + $yoeRate), 2, '.', ',' )
            ]);
            
        }

        a:
        $sorted = true;
        foreach($candidates as $i => $seeker){
            if($i < (count($candidates)-1)){
                if($candidates[$i]["total"] < $candidates[($i+1)]["total"]){
                    // echo "<br>sorting<br>";
                    $_seeker = $candidates[$i];
                    // echo "Before: ".$seekers[$i]["total"]." After: ".$seekers[($i+1)]["total"]."<br>";
                    $candidates[$i] = $candidates[($i+1)];
                    $candidates[($i+1)] = $_seeker;
                    $sorted = false;
                }
            }
        }


        if(!$sorted){
            goto a;
        }

        $candidates = collect($candidates);

        return $candidates->where("total", ">", 0);

    }

    public static function rateYOE(Job $job, Seeker $seeker){

        $rate = 0;
        $seekerExperience = [];
        $jobExperience = [
            'months' => $job->experience ? $job->experience * 12 : 0
        ];

        $seekerExperience = (function($seeker){
            $exp = Experience::where([
                'user_id' => $seeker->user_id
            ])
            ->get()
            ->map(function($item, $key){
                return [
                    'months' => $item->date_ended->diffInMonths($item->date_started),
                    'specialization' => $item->job_industry
                ];
            });
            return $exp;
        })($seeker);


        $jobExperience['specializations'] = (function($job){
            $specs = [];
            foreach(json_decode($job->job_specialization) as $spec){
                array_push($specs, $spec[1]);
            }

            return $specs;
        })($job);


        foreach($seekerExperience as $exp){
            if(in_array($exp['specialization'], $jobExperience['specializations'])){
                $rate += (($exp['months'] / $jobExperience['months']) * 100);
            }
        }

        return $rate > 100 ? 100 : $rate;
    }

    public static function rateSkills(Job $job, Seeker $seeker){
        $rate = 0;
        $scorePerSkill = 0;
        $jobSkills = json_decode($job->skill);
        $seekerSkill = Skill::where([   
            'user_id' => $seeker->user_id
        ])->pluck('skill_description'); 

        $scorePerSkill  = 100 / count($jobSkills);

        foreach($seekerSkill as $skill){
            if(in_array($skill, $jobSkills)){
                $rate += $scorePerSkill;
            }
        }

        return $rate;

    }
    
    public static function rateEducation(Job $job, Seeker $seeker){
        $educationLevels = [
            'primary education',
            'secondary education',
            'tertiary education',
            "masters's degree",
            'doctorate degree'
        ];
        $seekerEducations = Education::where([
            'user_id' => $seeker->user_id
        ])->get();
        $seekerCourses = Education::where([
            'user_id' => $seeker->user_id
        ])->pluck('course');

        // echo count($seekerEducations);
        if(count($seekerEducations) <= 0){
            return 0;
        }

        $seekerHighestEducation = (function($seekerEducations, $educationLevels){
            $educationLevelCount = [
                'doctorate degree' => 0,
                "masters's degree" => 0,
                'tertiary education' => 0,
                'secondary education' => 0,
                'primary education' => 0,
            ];
            
            foreach($seekerEducations as $education){
                foreach($educationLevels as $educLevel){
                    if($education->education_level == $educLevel){
                        $educationLevelCount[$educLevel]++;
                        
                    }
                }
            }
            foreach($educationLevelCount as $educLevel => $educCount){
                if($educCount > 0){
                    return $educLevel;
                }
            }
        })($seekerEducations, $educationLevels);
        
        // echo $seekerHighestEducation;
        if(array_search($job->educational_attainment, $educationLevels) > array_search($seekerHighestEducation, $educationLevels)){
            return 0;
        }

        if(in_array($job->educational_attainment, ['primary education','secondary education'])){
            if($job->educational_attainment == $seekerHighestEducation){
                return 100;
            }
            else {
                return 0;
            }
            
        }

        if(array_search($seekerHighestEducation, $educationLevels) > array_search($job->educational_attainment, $educationLevels)){
            $gap = array_search($seekerHighestEducation, $educationLevels) - array_search($job->educational_attainment, $educationLevels);
            // echo $gap;
            if(!$job->course_studied){
                return 100 - ($gap * 25);
            }
            foreach ($seekerCourses as $course) {
                if(in_array($course, json_decode($job->course_studied))){
                    return 100 - ($gap * 25);
                }
            }
        }
        
        if(!$job->course_studied){
            return 100;
        }

        foreach ($seekerCourses as $course) {
            if(in_array($course, json_decode($job->course_studied))){
                return 100;
            }
        }

        return 0;


    }

    public static function rateEducationForJob(Job $job, Seeker $seeker){
        // done pansamantala
        $rate = 0;

        $highestEducation = (function(Seeker $seeker){
            $seekerEducation = Education::where('user_id', $seeker->user_id)->get(['education_level', 'course']);
            $highest = [];

            foreach ($seekerEducation as $education) {
                switch ($education->education_level) {
                    case "doctorate degree":
                        $highest = self::setHighEducation($education, $highest);
                        break;
                    case "master's degree":
                        $highest = self::setHighEducation($education, $highest);
                        break;
                    case "tertiary education":
                        $highest = self::setHighEducation($education, $highest);
                        break;
                    case "secondary education":
                        $highest = self::setHighEducation($education, $highest);
                        break;
                    case "primary education":
                        $highest = self::setHighEducation($education, $highest);
                        break;
                    default:
                        break;
                }
            }

            return $highest;
        })($seeker);

        /* match the education */
        /* education_level 30% course 70% */
        $rate = (function($highestEducation, Job $job){
            $EDUCATION_LEVELS = [
                "primary education",
                "secondary education",
                "tertiary education",
                "master's degree",
                "doctorate degree"
            ];
            $rate = 0;

            
            $requiredEducationIndex = array_search($job->educational_attainment, $EDUCATION_LEVELS, true);
            $highestEducationIndex = array_search($highestEducation[0]->education_level, $EDUCATION_LEVELS, true);
            $educationGap = $requiredEducationIndex - $highestEducationIndex;
            $seekerCourses = (function($highestEducation){
                $courses = [];
                foreach ($highestEducation as $educ) {
                    array_push($courses, $educ->course);
                }
                return $courses;
            })($highestEducation);

            if($requiredEducationIndex > 1) { // if mataas ang educ required sa job
                if($educationGap == 0) {// qualified
                    $rate = 30;
                    if(is_null(json_decode($job->course_studied))){
                        $rate == 100;
                    }
                    else {
                        $isCourseMatch = (function($seekerCourses, $jobCourses){
                            return !empty(array_intersect($seekerCourses, $jobCourses));
                        })($seekerCourses, json_decode($job->course_studied));

                        if($isCourseMatch){
                            $rate = 100;
                        }
                    }
                }
                else if($educationGap < 0) { // overqualified
                    $rate = (30 / 3) * abs(3 - abs($educationGap));
                    if(is_null(json_decode($job->course_studied))){
                        $rate += 70;
                    }
                    else {
                        $isCourseMatch = (function($seekerCourses, $jobCourses){
                            return !empty(array_intersect($seekerCourses, $jobCourses));
                        })($seekerCourses, json_decode($job->course_studied));
    
                        if($isCourseMatch){
                            $rate += 70;
                        }
                    }
                }
                else { // underqualified
                    $rate = 0;
                }
            }
            else { // if mataas ang educ required sa job
                if($educationGap == 0) {// qualified
                    $rate = 100;
                }
                else if($educationGap > 0) {// underqualified
                    $rate = 0;
                }
                else { // overqualified
                    // $rate = (100 / 2) * abs(2 - abs($educationGap));
                    $rate = 100;
                }
            }
            
            return $rate;
        })($highestEducation, $job);

        return $rate;
    }

}
