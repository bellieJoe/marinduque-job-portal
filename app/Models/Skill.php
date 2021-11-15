<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $primaryKey = "skill_id";
    
    protected $fillable = [
        'user_id', 'skill_description', 'generated_skills'
    ];
}
