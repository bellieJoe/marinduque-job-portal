<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'credential_name', 
        'credential_number', 
        'credential_type', 
        'issuing_organization', 
        'date_issued',
        'expiry_date',
        'non_expiry',
        'credential_image'
    ];

    protected $dates = [
        'date_issued', 'expiry_date'
    ];
}
