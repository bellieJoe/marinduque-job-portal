<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_title',
        'position',
        'job_industry',
        'company_name',
        'job_description',
        'date_started',
        'date_ended',
        'status_of_appointment',
        'salary',
        'salary_grade',
        'govnt_service'
    ];

    protected $dates = [
        'date_started',
        'date_ended'
    ];
}
