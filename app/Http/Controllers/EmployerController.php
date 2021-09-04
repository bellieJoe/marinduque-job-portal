<?php

namespace App\Http\Controllers;

use App\Mail\verify_email;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Psy\Util\Json;
use PDF;


class EmployerController extends Controller
{
    //
    public function register(Request $request){

        $request->validate([
            'contact_person_name' => 'required',
            'company_name' => 'required',
            'contact_number' => 'required|max:12',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);
        
        // create new user instance
        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'employer',
            'verification_code' => rand(100000, 999999)
        ]);

        // create new employer instance
        Employer::create([
            'user_id' => $user->user_id,
            'company_name' => $request->input('company_name'),
            'contact_number' => $request->input('contact_number'),
            'contact_person_name' => $request->input('contact_person_name'),
        ]);

        //verify email
        Mail::to($user->email)->send(new verify_email($user->verification_code));

        return redirect('email_verification/'.$user->email);
    }


    // setters
    public function updateProfile(Request $request){
        $request->validate([
            'company_name' => 'required',
            'contact_number' => 'required|max:11',
            'contact_person_name' => 'required',
            'region' => 'nullable|required_with:province,municipality,barangay',
            'province' => 'nullable|required_with:region,municipality,barangay',
            'municipality' => 'nullable|required_with:region,province,barangay',
            'barangay' => 'nullable|required_with:region,province,municipality',
        ]);
        
        if($request->input('region')){
            $address = [
                'region' => $request->input('region'),
                'province' => $request->input('province'), 
                'municipality' => $request->input('municipality'), 
                'barangay' => $request->input('barangay')
            ];

            // return $address;
    
            Employer::where('user_id', Auth::user()->user_id)
                    ->update([
                        'company_name' => $request->input('company_name'),
                        'contact_number' => $request->input('contact_number'),
                        'contact_person_name' => $request->input('contact_person_name'),
                        'address' => json_encode($address)
                    ]);
        }else{
            Employer::where('user_id', Auth::user()->user_id)
                    ->update([
                        'company_name' => $request->input('company_name'),
                        'contact_number' => $request->input('contact_number'),
                        'contact_person_name' => $request->input('contact_person_name'),
                        'address' => NULL
                    ]);
        }
    }

    public function updateDescription(Request $request){
        $request->validate([
            'description' => 'required|min:50|max:5000'
        ]);

        Employer::where('user_id', Auth::user()->user_id)
        ->update([ 'description' => $request->input('description') ]);
    }

    public function setMission(Request $request){
        $request->validate([
            'mission' => 'required|min:50|max:5000'
        ]);

        Employer::where('user_id' , Auth::user()->user_id)
        ->update([
            'mission' => $request->input('mission')
        ]);
    }

    public function setVision(Request $request){
        $request->validate([
            'vision' => 'required|min:50|max:5000'
        ]);

        Employer::where('user_id' , Auth::user()->user_id)
        ->update([
            'vision' => $request->input('vision')
        ]);
    }

    public function uploadLogo(Request $request){
        $request->validate([
            'imageData' => 'required'
        ]);

        $employer = Employer::where('user_id' , Auth::user()->user_id)->first();

        if($employer->company_logo){
            $data = base64_decode($request->imageData);
            $imagePath = public_path('image').'/employer/logo/'.$employer->company_logo;
            file_put_contents($imagePath, $data);
        }else{
            $data = base64_decode($request->imageData);
            $imageName = $employer->user_id.'-'.time().'.jpeg';
            $imagePath = public_path('image').'/employer/logo/'.$imageName;
            Employer::where('user_id' , Auth::user()->user_id)
            ->update([
                'company_logo' => $imageName
            ]);
            file_put_contents($imagePath, $data);
        }
        
    }




    // getters
    public function getEmployer(){
        return Employer::where('user_id', Auth::user()->user_id)->first();
    }

    public function getAddress(){
        return Employer::where('user_id', Auth::user()->user_id)->get('address')->first();
    }

    public function getEmployers(){

        $employers = Employer::join('users', 'employers.user_id', '=', 'users.user_id');

        return view('pages.admin.employer-list')
        ->with([
            'employersData' => $employers
        ]);
    }




}
