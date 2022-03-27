<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Employer;
use App\Models\EmployerVerificationProof;
use App\Models\User;
use App\Notifications\EmployerVerificationNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function registerAdmin(Request $request){
        $request->validate([
            'fullname' => 'required|max:50',
            'contact_number' => 'required|max:11',
            'address' => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'admin',
            'verification_code' => '000000',
            'admin_role' => 'aide'
        ]);

        Admin::create([
            'user_id' => $user->user_id,
            'fullname' => $request->input('fullname'),
            'contact_number' => $request->input('contact_number'),
            'address' => $request->input('address')
        ]);

        return redirect()->back()->with([
            'message' => 'A new admin user '.$request->input('email').' has been created'
        ]);
    }

    public function unverifiedEmployers(Request $request){

        $unverifiedEmployers = [];
        if($request->has('search')){
            $unverifiedEmployers = Employer::search($request->input('search'))->where("verified", 0)->get();
        }else{
            $unverifiedEmployers = Employer::where("verified", 0)->get();
        }
        

        return view('pages.admin.verify-employers')->with(
            [
                'employers' => $unverifiedEmployers
            ]
        );
    }

    public function viewProofs($employer_id){

        $proofs = EmployerVerificationProof::where('user_id', $employer_id)->get();
        $employer = Employer::where("user_id", $employer_id)->first();

        return view("pages.admin.verification-proofs")->with([
            "proofs" => $proofs,
            "employer" => $employer
        ]);
    }

    public function verifyEmployer($employer_id){

        Employer::where("user_id", $employer_id)
        ->update([
            "verified" => 1,
            "date_verified" => Carbon::now(),
            "verified_by" => Auth::user()->user_id
        ]);

        $employer = Employer::where("user_id", $employer_id)->first();

        $user = User::find($employer_id);
        $user->notify(new EmployerVerificationNotification($employer));

        return redirect("/admin/employers/unverified")->with([
            "VerificationSuccess" => "Employer was successfully verified"
        ]);

    }

    public function getAdmins(){
        $users = User::where([
            'role' => 'admin'
        ])
        ->join('admins', 'users.user_id', '=', 'admins.user_id')
        ->get();

        return view('pages.admin.admin-list')->with([
            'admins' => $users
        ]);
    }

    public function updateAdmin(Request $req){
        $req->validate([
            'fullname' => 'required|max:50',
            'contact_number' => 'required|max:11|digits:11',
            'address' => 'required|max:100',
        ]);

        Admin::where([
            'user_id' => $req->user_id
        ])
        ->update([
            'fullname' => $req->fullname,
            'contact_number' => $req->contact_number,
            'address' => $req->address
        ]);

        return redirect(url('/admin/admin-list'));
    }   
}
