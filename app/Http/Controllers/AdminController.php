<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
 
    public function registerAdmin(Request $request){
        $request->validate([
            'fullname' => 'required|max:50',
            'contact_number' => 'required|max:15',
            'address' => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'admin',
            'verification_code' => '000000'
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

}
