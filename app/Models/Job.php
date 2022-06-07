<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, Searchable, SoftDeletes;


    protected $primaryKey = 'job_id';

    protected $guarded = [];


    protected $dates = [
        'date_posted'
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize the data array...
        // $array
        

        $notIncluded = [
            'job_description',
            'company_address',
            'company_description',	
            'educational_attainment',	
            'course_studied',	
            'gender',
            'experience',
            'other_qualification',
            'salary_range',
            'job_benefits',
            'status',
            'date_posted',
            'days_expire',
            'created_at',
            'updated_at',
            'deleted_at',
            'view_engagements',
            'search_engagements',
            'user_id',
            'isGovernment'
        ];

        foreach($notIncluded as $item){
            unset($array[$item]);
        }
        
        

        return $array;
    }



}
