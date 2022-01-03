<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seeker extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    // protected $fillable  = [
    //     'user_id', 'firstname', 'middlename', 'lastname', 'address', 'birthdate', 'contact_number',
    //     'gender', 'nationality', 'civil_status', 'language', 'display_picture'
    // ];
    
    protected $guarded = [];
    
    protected $dates = [
        'birthdate'
    ];

}
