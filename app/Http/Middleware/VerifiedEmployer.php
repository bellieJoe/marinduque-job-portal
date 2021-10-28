<?php

namespace App\Http\Middleware;

use App\Models\Employer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifiedEmployer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $employer = Employer::where('user_id', Auth::user()->user_id)->first();

        if($employer->verified == 0){
            return redirect('/verify-employer');
        }else{
            return $next($request);
        }
    }
}
