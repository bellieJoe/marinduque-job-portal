<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CredentialController extends Controller
{
    public function addCredential(Request $request){
        $request->validate([
            'credential_name' => 'required',
            'credential_type' => 'required',
            'credential_number' => 'nullable',
            'issuing_organisation' => 'nullable',
            'date_issued' => 'required|date',
            'expiry_date' => 'required_if:non_expiry,false',
        ]);

        $image_name = null;

        $credential = Credential::create([
            'user_id' => Auth::user()->user_id,
            'credential_name' => $request->input('credential_name'),
            'credential_type' => $request->input('credential_type'),
            'credential_number' => $request->input('credential_number'),
            'issuing_organization' => $request->input('issuing_organisation'),
            'date_issued' => $request->input('date_issued'),
            'expiry_date' => $request->input('expiry_date'),
            'non_expiry' => $request->input('non_expiry') == 'false' ? 0 : 1,
        ]);

        if($request->input('credential_image')){
            
            $image_name = $credential->id.'-'.time().'.jpeg';

            Credential::where('credential_id', $credential->id)
            ->update([
                'credential_image' => $image_name
            ]);

            file_put_contents(public_path('image').'/seeker/credential/'.$image_name, base64_decode($request->input('credential_image')));


        }

        return $credential;
    }

    public function getCredential($id){
        return Credential::where([
            'user_id'=> Auth::user()->user_id,
            'credential_id' => $id
            ])->first();
    }

    public function updateCredential($id, Request $request){
        $request->validate([
            'credential_name' => 'required',
            'credential_type' => 'required',
            'credential_number' => 'nullable',
            'issuing_organisation' => 'nullable',
            'date_issued' => 'required|date',
            'expiry_date' => 'required_if:non_expiry,false',
            'non_expiry' => '',
            'credential_image' => ''
        ]);

        $credential = Credential::where([
            'user_id'=> Auth::user()->user_id,
            'credential_id' => $id
        ])->first();

        Credential::where([
            'user_id'=> Auth::user()->user_id,
            'credential_id' => $id
        ])->update([
            'credential_name' => $request->input('credential_name'),
            'credential_number' => $request->input('credential_number'),
            'issuing_organization' => $request->input('issuing_organisation'),
            'date_issued' => $request->input('date_issued'),
            'expiry_date' => $request->input('expiry_date'),
            // 'non_expiry' => $request->input('non_expiry') == false ? 0 : 1,
        ]);


        if($request->input('credential_image') != $credential->credential_image){
            if($credential->credential_image){
                $path = public_path('image').'/seeker/credential/'.$credential->credential_image;
                $data = base64_decode($request->input('credential_image'));
                file_put_contents($path, $data);
            }else{
                $image_name = $credential->credential_id.'-'.time().'.jpeg';
                $path = public_path('image').'/seeker/credential/'.$image_name;
                $data = base64_decode($request->input('credential_image'));
                Credential::where('credential_id', $id)
                ->update([
                    'credential_image' => $image_name
                ]);
                file_put_contents($path, $data);
            }
            
        }

        if($request->input('non_expiry') == 1 || $request->input('non_expiry') == 0){
            Credential::where([
                'user_id'=> Auth::user()->user_id,
                'credential_id' => $id
            ])->update([
                'non_expiry' => $request->input('non_expiry') == 'false' ? 0 : 1,
            ]);
        }else{
            
        }
        
    }

    public function deleteCredential($id){
        $credential_image = Credential::where([
            'user_id'=> Auth::user()->user_id,
            'credential_id' => $id
        ])->first()->credential_image;

        Credential::where([
            'user_id'=> Auth::user()->user_id,
            'credential_id' => $id
        ])->delete();

        if($credential_image){
            unlink(public_path('image').'/seeker/credential/'.$credential_image);
        }
    }


}
