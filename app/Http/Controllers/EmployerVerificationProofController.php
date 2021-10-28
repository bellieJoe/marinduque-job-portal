<?php

namespace App\Http\Controllers;

use App\Events\VerificationProofSubmitted;
use App\Models\EmployerVerificationProof;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class EmployerVerificationProofController extends Controller
{

    public function createEmployerVerificationProof(Request $request)
    {
        $request->validate([
            'proof' => 'required'
        ]);


        foreach ($request->file('proof') as $rawFile) {

            $file = UploadedFile::createFromBase($rawFile);
            $fileName = $file->hashName();

            $verificationProof = EmployerVerificationProof::create([
                'user_id' => Auth::user()->user_id,
                'title' => $fileName,
                'location' => 'proofs/'.Auth::user()->user_id
            ]);

            
            $file->storeAs('/public/proofs/'.Auth::user()->user_id, $fileName);

        }

        return back()->with([
            'success' => true,
        ]);

    }
    
}
