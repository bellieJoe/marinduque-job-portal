<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Employer extends Model
{
    use HasFactory, Searchable;

    protected $primaryKey = 'user_id';

    // protected $fillable = [
    //     'user_id',
    //     'company_name',
    //     'address',
    //     'contact_number',
    //     'contact_person_name',
    //     'description',
    //     'mission',
    //     'vision',
    //     'company_logo',
    //     'status',
    //     'verified',
    //     'verified_by',
    //     'date_verified'
    // ];
    
    protected $guarded = [];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize the data array...
        // $array
        

        $notIncluded = [
            'address',
            'contact_number',
            'contact_person_name',
            'description',
            'mission',
            'vision',
            'company_logo',
            'status',
            'verified_by',
            'date_verified'
        ];

        foreach($notIncluded as $item){
            unset($array[$item]);
        }
        
        

        return $array;

    }


}
