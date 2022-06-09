<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'job_application_id';

    // protected $fillable = [
    //     'job_id',
    //     'applicant_id',
    //     'application_status',
    //     'others',
    //     'expiry_date'
    // ];

    protected $guarded = [];

    // 
    protected $dates = [
        'created_at',
        'updated_at',
        'expiry_date',
        'date_hired'
    ];
}
