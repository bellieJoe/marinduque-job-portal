<?php

namespace App\Http\Controllers;

use App\Models\Seeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    //
    public function viewImageUpload($type){
        if($type == 'seeker-profile'){
            return view('pages.seeker.upload_profile_picture');
        }
    }

    public function uploadPofileImageSeeker(Request $request){
        $request->validate([
            'image' => 'required'
        ]);

        $image = base64_decode($request->image);

        $image_name= Auth::user()->user_id.'-'.time().'.jpeg';

        $path = public_path('image/seeker/profile/'.$image_name);

        if(Seeker::where('user_id', Auth::user()->user_id)->get('display_picture')->first()->display_picture){
            $image_name = Seeker::where('user_id', Auth::user()->user_id)->get('display_picture')->first()->display_picture;
            $path = public_path('image/seeker/profile/'.$image_name);
            file_put_contents( $path, $image);
        }else{
            Seeker::where('user_id', Auth::user()->user_id)->update([
                'display_picture' => $image_name 
             ]);
     
             file_put_contents($path, $image);
        }
        
    }


}
