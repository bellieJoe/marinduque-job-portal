<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSpecialization extends Model
{
    use HasFactory;

    protected $primaryKey = "job_specialization_id";

    protected $guarded = [];
    
}
