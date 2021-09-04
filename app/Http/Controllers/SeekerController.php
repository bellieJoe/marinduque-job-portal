<?php

namespace App\Http\Controllers;

use App\Models\Seeker;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
use App\Mail\verify_email;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;


class SeekerController extends Controller
{
    //
    public function index(){
        return view("pages.signup");
    }

    public function register(Request $request){
        $validation = $request->validate([
            'firstname' => 'required|min:2',
            'middlename' => 'required|min:2',
            'lastname' => 'required|min:2',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8',
        ]);

        User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'seeker',
            'verification_code' => rand(100000, 999999)
        ]);

        $user = User::where('email', $request->input('email'))->first();

        Seeker::create([
            'user_id' => $user->user_id,
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'middlename' => $request->input('middlename'),
        ]);
        
        $ret_user = User::where('email', $request->input('email'))->first();

        //verify email
        Mail::to($ret_user->email)->send(new verify_email($ret_user->verification_code));
        
        return redirect('email_verification/'.$ret_user->email);

    }

    public function updateProfile(Request $request){
        $request->validate([
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'address' => 'nullable',
            'birthdate' => 'nullable|date',
            'contact_number' => 'nullable|max:13',
            'gender' => 'nullable',
            'nationality' => 'nullable',
            'civil_status' => 'nullable'
        ]);

        Seeker::where("user_id", Auth::user()->user_id)
        ->update([
            'firstname' => $request->input('firstname'),
            'middlename' => $request->input('middlename'),
            'lastname' => $request->input('lastname'),
            'address' => $request->input('address'),
            'birthdate' => $request->input('birthdate'),
            'contact_number' => $request->input('contact_number'),
            'gender' => $request->input('gender'),
            'nationality' => $request->input('nationality'),
            'civil_status' => $request->input('civil_status')
        ]);

    }

    public function getProfile(){
        return Seeker::where('user_id', Auth::user()->user_id)->first();
    }

    public function addLanguage(Request $request){
        $request->validate([
            'language' => 'required'
        ]);

        $languages = json_decode(Seeker::where('user_id', Auth::user()->user_id)->get('language')->first()->language);

        if($languages != null){
            array_push($languages, $request->input('language'));
            Seeker::where('user_id', Auth::user()->user_id)->update([
                'language' => $languages
            ]);
        }else{
            Seeker::where('user_id', Auth::user()->user_id)->update([
                'language' => [$request->input('language')]
            ]);
        }

    }

    public function getLanguage(){
        return Seeker::where('user_id', Auth::user()->user_id)->get('language')->first();
        // return "sibad";
    }

    public function deleteLanguage($lang){
        $newlanguage = json_decode(Seeker::where('user_id', Auth::user()->user_id)->get('language')->first()->language);
        for($i = 0; $i < sizeof($newlanguage); $i++){
            if($newlanguage[$i] == $lang){
                array_splice($newlanguage, $i, 1);
            }
        }
        Seeker::where('user_id', Auth::user()->user_id)->update([
            'language' => $newlanguage
        ]);
    }

    
    // getters
    public function getSeekers(){

        $seekers = Seeker::join('users', 'seekers.user_id', '=', 'users.user_id');

        return view('pages.admin.job-seeker-list')
        ->with([
            'seekersData' => $seekers
        ]);

    }
}
