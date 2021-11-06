<?php

namespace App\Models;

use App\Notifications\NewVerificationProofNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerVerificationProof extends Model
{
    use HasFactory;

    protected $primaryKey = 'proof_id';
    protected $fillable = [
        'user_id',
        'title',
        'location'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($employerVerificationProof) {
            //
            $employer = Employer::where([
                ['user_id', $employerVerificationProof->user_id]
            ])->first();

            $Users = User::where([
                ['role', 'admin']
            ])->get();

            foreach ($Users as $user) {
                
                $user->notify( new NewVerificationProofNotification($employerVerificationProof, $employer));

            }



        });
    }
}
