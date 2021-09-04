<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $primaryKey = 'job_id';

    protected $fillable = [
        'user_id',
        'job_industry',
        'job_title',	
        'job_type'	,
        'job_description',	
        'company_name',
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
        'days_expire'
    ];

    protected $dates = [
        'date_posted'
    ];
}
