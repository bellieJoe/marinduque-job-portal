<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Job;
use App\Models\Seeker;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobMatchingController extends Controller
{

    public static function genSuggestedJobs()
    {

        $user_id = Auth::user()->user_id;
        $seeker = Seeker::where('user_id', $user_id)->first();
        $jobs = Job::where('status', "open")->get(); 
        $education = Education::where("user_id", $user_id)->get();
        $suggestedJobs = collect([]);

        foreach ($jobs as $job) {
            // if($job->generated_skills == null || $job->experience == null){
            //     return null;
            // } 
            $educRate = number_format(self::rateEducationSeeker($job, $education) * (json_decode($job->match_preferences)->educational_attainment / 100), 2, "." , ",");
            $skillsRate = $job->generated_skills && !empty(json_decode($job->generated_skills)->generated) ?  number_format(self::rateSkills($job, $seeker) * (json_decode($job->match_preferences)->skills / 100), 2, "." , ",") : 0;
            $yoeRate = $job->experience ? number_format(self::rateYOE($job, $seeker) * (json_decode($job->match_preferences)->yoe / 100), 2, "." , ",") : json_decode($job->match_preferences)->yoe;
            // echo "Job Title : $job->job_title, Education: $educRate, Skills Rate:  $skillsRate , Experience Rate: $yoeRate<br>";
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
                    // echo "<br>sorting<br>";
                    $_seeker = $suggestedJobs[$i];
                    // echo "Before: ".$seekers[$i]["total"]." After: ".$seekers[($i+1)]["total"]."<br>";
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

    public static function rateEducationSeeker(Job $job, $educations)
    {

        $rate = 0;

        foreach($educations as $education){
            if($job->educational_attainment == $education->education_level){
                $courses = $job->course_studied ? json_decode($job->course_studied) : null; 
                
                if(in_array($job->educational_attainment, ["primary education", "secondary education"] )){
                    return 100;
                }
                else{

                    if($courses){
                        if($courses && in_array($education->course, $courses)){
                            return 100;
                        }
                        else{
                            $rate = 0;
                        }
                    }
                    else{
                        return 100;
                    }
                    
                }

                
            }
        }

        return $rate;

    }



    public static function genSuggestedCandidate($job_id)
    {

        $job = Job::find($job_id);
        // echo $job;
        // $job = Job::find(22);
        $seekers = Seeker::all();
        $candidates = [];
        $invitedSeekers = json_decode($job->invitation) ? json_decode($job->invitation) : [];

        if($job->generated_skills == null ){
            return null;
        }   

        /* educational attainment */
        foreach($seekers as $seeker){
            // echo "<br>User ID: " .$seeker->user_id."<br>";
            if(in_array($seeker->user_id , $invitedSeekers)){
                continue;
            }
            $educRate  = $job->educational_attainment ?  number_format(self::rateEducation($job, $seeker) * (json_decode($job->match_preferences)->educational_attainment / 100), 2, "." , ",") : json_decode($job->match_preferences)->educational_attainment;
            $skillRate = $job->generated_skills ? number_format(self::rateSkills($job, $seeker) * (json_decode($job->match_preferences)->skills / 100), 2, "." , ",") : json_decode($job->match_preferences)->skills;
            $yoeRate = $job->experience ? number_format(self::rateYOE($job, $seeker) * (json_decode($job->match_preferences)->yoe / 100), 2, "." , ",") : json_decode($job->match_preferences)->yoe;
            array_push($candidates, [
                "seeker_id" => $seeker->user_id,
                "seeker" => $seeker,
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

        // return $candidates;
    }


    public static function rateYOE(Job $job, Seeker $seeker){

        $seekerExps = [];
        $checkedIndustry = [];
        $rate = 0;

        if($job->experience){
            foreach (Experience::where('user_id', $seeker->user_id)->get() as  $exp) {
                if( !in_array($exp->job_industry, $checkedIndustry)){
                    array_push($checkedIndustry, $exp->job_industry);
                    array_push($seekerExps, [
                        "job_industry" => $exp->job_industry,
                        "years" => $exp->date_started->floatDiffInYears($exp->date_ended)
                    ]);
                    
                }
                else{
                    foreach($seekerExps as $key => $val){
                        if($val["job_industry"] == $exp->job_industry){
                            $seekerExps[$key]["years"] += $exp->date_started->floatDiffInYears($exp->date_ended);
                        }
                    }   
                }
            }
        }
        
        if($job->experience){
            foreach($seekerExps as $exp){
                // echo var_dump($exp)."<br>";
                if($job->job_industry == $exp["job_industry"]){
                    $rate = ($exp["years"] / $job->experience) * 100;
                    // echo $rate."<br>";
                }

                
            } 
        }
        else{
            $rate = 100;
        }
        
        return $rate > 100  ? 100 : $rate;
    }

    public static function rateSkills(Job $job, Seeker $seeker){

        $jobGenerated = []; // generated skill from job
        $jobRelated = [];
        $scorePerSkill = 0;
        $checkedSkills = [];
        $score = 0;

        if($job->generated_skills){
            if(!empty(json_decode($job->generated_skills)->generated)){
                foreach(json_decode($job->generated_skills)->generated as $key => $skill){
                    // echo $skill->name."<br>";
                    array_push($jobGenerated, $skill->name);
    
                }
            }
            if(!empty(json_decode($job->generated_skills)->related)){
                foreach(json_decode($job->generated_skills)->related as $key => $skill){
                    // echo $skill->name."<br>";
                    array_push($jobRelated, $skill->name);
                }
            }
            
        }

        // if(count($jobGenerated) > 0){
        //     $scorePerSkill =  100 / count($jobGenerated)  ;
        // }
        // else{
        //     return 100;
        // }

        $scorePerSkill =  100 / count($jobGenerated)  ;

        


        foreach (Skill::where('user_id', $seeker->user_id)->get() as $user) {
            $gen = json_decode($user->generated_skills)->generated;
            if(!empty($user->generated_skills) && !empty($gen)){
                foreach ($gen as $skill) {
                    if($score <= 100 && !in_array($skill, $checkedSkills)){
                        array_push($checkedSkills, $skill);
                        if(in_array($skill->name, $jobGenerated)){
                            $score += $scorePerSkill;
                        }
                        else if(in_array($skill->name, $jobRelated)){
                            $score += ($scorePerSkill / 2);
                        }
                        else{
                            //do nothing
                        }
                    }
                }
            }
        }

        if($score > 100){
            return 100;
        }else{
            return $score;
        }

    }

    public static function rateEducation(Job $job, Seeker $seeker){
        // done pansamantala
        $rate = 0;
        $seekerEducation = Education::where('user_id', $seeker->user_id)->get(['education_level', 'course']);
        foreach($seekerEducation as $education){
            if($education->education_level == $job->educational_attainment){
                if(in_array($job->educational_attainment, ["primary education", "secondary education"])){
                    return 100;
                }
                $courses = $job->course_studied ? json_decode($job->course_studied) : null; 
                if($courses){
                    foreach($courses as $course){
                        foreach($seekerEducation as $education){
                            if($course == $education->course){
                                return 100;
                            }
                        }
                    }
                }
                else{
                    return 100;
                }
            }
        }

        return $rate;
    }


}
