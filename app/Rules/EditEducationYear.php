<?php

namespace App\Rules;

use App\Models\Education;
use App\Models\Seeker;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EditEducationYear implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        function getValidYear(){
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

        return $value >= $validYear && $value <=  (int)Carbon::now()->format("Y");
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
