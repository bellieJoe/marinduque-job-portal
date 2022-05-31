@extends('app')
@section('title', '- Home')
@section('content')
<link rel="stylesheet" href="{{asset('css/seeker/apply-job.css')}}">
<body class="bg-gray-100">
    <section  id="apply_job">

        <form method="POST" action="/seeker/add-job-application" class="col-sm-7 bg-white mx-auto my-14 ">
            @csrf
            <h1 class="text-blue-900 fw-bold text-2xl mb-4 text-center p-6 bg-blue-300"><i class="fas fa-file-alt me-3"></i>Application Form</h1>
            <div class="p-6">

                <h1 class="fw-bold text-lg">{{ $job->job_title }}</h1>
                <h1 class="text-lg text-gray-500">{{ $job->company_name }}</h1>
                <h1 class="text-lg text-gray-500">{{ Str::title(json_decode($job->company_address)->barangay->name) }}, {{ Str::title(json_decode($job->company_address)->municipality->name) }}, {{ Str::title(json_decode($job->company_address)->province->name) }}</h1>
                
                <p class="italic font-light bg-yellow-100 p-2 mt-5">
                    Note that the information on your profile will be submitted to the employer so make sure that your profile is complete. 
                      <a href="/seeker/profile/education" target="__blank" class="not-italic text-blue-500 ms-2">Edit Profile</a>
                </p>
                
                <input type="hidden" name="job_id" value="{{ $job->job_id }}">
                <input type="hidden" name="applicant_id" value="{{ Auth::user()->user_id }}">
                <div class="mt-2">
                    <label for="" class="fw-bold mb-1">Other Information</label>
                    <textarea name="other_information" value="{{ old('other_information') }}" class="form-control" placeholder="write something about yourself, career or anything that will help you hired."></textarea>
                    @error('other_information')
                        <div class="text-danger"  >@{{ errors.other_information[0] }}</div>
                    @enderror
                </div>
                <button class="btn btn-lg bg-green-500 text-white mt-4  ms-auto me-0 d-block mb-4" >Submit Application</button>
            </div>
        </form>
       
        

        <div id="loading">
            @component('components.loading')@endcomponent
        </div>


    </section>
</body>
<script src="{{ asset('js/pages/seeker/apply-job.js') }}"></script>
@endsection