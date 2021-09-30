<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index(){
        //
        return view("pages.signup");
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);
        
        
        if(User::where('email', $request->input('email'))->pluck('verified')->first() === 1){
            $credentials = $request->only('email', 'password');
            if(Auth::attempt($credentials)){
                $request->session()->regenerate();
                return redirect('/'.Auth::user()->role);
            }else{
                return back()->withErrors([
                    'signin_failed' => 'The information you entered is incorrect.'
                ]);
            }
        }else{
            return redirect('email_verification/'.$request->input('email'));
        }

        
    }
    
    public function verify_email(Request $request){
        $validation = $request->validate([
            'verification_code' => 'required|min:6'
        ]);

        $verification_code = User::where('email', $request->input('email'))->pluck('verification_code')->first();

        if($verification_code === $request->input('verification_code')){
            $User = User::where('email', $request->input('email'))->first();
            $user = $User->user_id;
            $request->session()->put('user_id', $User->user_id);
            $request->session()->put('role', $User->role);
            User::where('email', $request->input('email'))->update(['verified'=>true]);
            
            Auth::loginUsingId($user);
            
            return redirect('/');

        }else{
            return back()->withErrors([
                'verification_failed' => 'The verification code is incorrect.',
            ]);
        }
    }

    public function resetPassword(Request $request){
        $request->validate([
            'email' => 'required|exists:users,email|email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );
        

        if (Auth::check()){
            return __($status);
        } else {
            return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
        }
        
        

    }

    public function updatePassword(Request $request){

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
                ? back()->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);

        return "GUmanasai";

    }

    // setters

    public function setStatus($status, $user_id){
        User::where('user_id', $user_id)->update([
            'status' => $status == 'deactivate' ? 'deactivated' : 'activated' 
        ]);

        return back();
    }



}
