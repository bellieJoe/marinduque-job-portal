<?php
namespace App\Rules;

use App\Models\Education;
use App\Models\Seeker;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;



class EducationYear implements Rule
{

    protected $data = [];
    
    public function __construct()
    {
        //
    }

    
    public function passes($attribute, $value)
    {
        /* function getValidYear(){
  
            $educations = Education::where([
                'user_id' => Auth::user()->user_id
            ])->pluck('education_level')->toArray();

            if (in_array('doctorate degree', $educations)) {

            } else if (in_array("master's degree", $educations)){

            } else if (in_array("tertiary education", $educations)) {

            } else if (in_array("secondary education", $educations)) {
                                

            } else if (in_array('primary education', $educations)) {
                $validYear = Education::where([
                    'user_id' => Auth::user()->user_id, 
                    'education_level' => 'primary education'
                ])->first();

                return $validYear->year_graduated + 3;
            }else{
                $birthdate = Seeker::where([
                    'user_id' => Auth::user()->user_id
                ])->first()->birthdate->format("Y");

                return $birthdate + 6;
            }
        }

        $validYear = getValidYear();

        return $value >= $validYear && $value <=  (int)Carbon::now()->format("Y"); */
    }

    public function setData($data)
    {
        $this->data = $data;
 
        return $this;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The year is invalid';
    }
}
