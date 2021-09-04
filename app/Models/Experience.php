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
        'date_ended'
    ];

    protected $dates = [
        'date_started',
        'date_ended'
    ];
}
