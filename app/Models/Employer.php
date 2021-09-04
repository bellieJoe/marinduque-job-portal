<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'company_name',
        'address',
        'contact_number',
        'contact_person_name',
        'description',
        'mission',
        'vision',
        'company_logo'
    ];


}
