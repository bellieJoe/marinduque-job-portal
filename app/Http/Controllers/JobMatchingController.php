<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Job;
use App\Models\Seeker;
use App\Models\Skill;
use Illuminate\Http\Request;

class JobMatchingController extends Controller
{

    public static function genSuggestedJobs($user_id = 4)
    {

        $seeker = Seeker::where('user_id', $user_id)->first();
        $jobs = Job::where('status', "open")->get(); 
    }

    public static function genSuggestedCandidate($job_id)
    {

        $job = Job::find($job_id);
        $seekers = Seeker::all();
        $candidates = [];


        if($job->generated_skills == null || $job->experience == null){
            return null;
        }   

        /* educational attainment */
        foreach($seekers as $seeker){
            // echo "<br>User ID: " .$seeker->user_id."<br>";
            $educRate  = number_format(self::rateEducation($job, $seeker) * (json_decode($job->match_preferences)->educational_attainment / 100), 2, "." , ",");
            $skillRate = number_format(self::rateSkills($job, $seeker) * (json_decode($job->match_preferences)->skills / 100), 2, "." , ",");
            $yoeRate = number_format(self::rateYOE($job, $seeker) * (json_decode($job->match_preferences)->yoe / 100), 2, "." , ",");
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

        return $candidates->where("total", ">", 50);
    }


    public static function rateYOE(Job $job, Seeker $seeker){

        $seekerExps = [];
        $checkedIndustry = [];
        $rate = 0;

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
                $rate = 50;
                $courses = json_decode($job->course_studied); 
                if(!empty($courses)){
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
