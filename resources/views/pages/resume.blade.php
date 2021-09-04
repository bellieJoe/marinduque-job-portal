<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/resume.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app_sample.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://kit.fontawesome.com/2a90b2a25f.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <title>Resume</title>
</head>
<body>
    <div id="resume w-max">

        <header class="bg-blue-900 py-10  z-10 shadow-sm">
            <div class="container mx-auto row">
                <div class="col-auto m-2">
                    <img class="w-40 h-40 shadow" src="{{ asset('image/seeker/profile/'.$resumeData['userData']->display_picture) }}" alt="">
                </div>
                <div class="col m-2">
                    <h1 class="text-white">{{ $resumeData['userData']->firstname.' '.$resumeData['userData']->middlename[0].'. '.$resumeData['userData']->lastname }}</h1>
                    <p class="text-blue-200 text-lg"><i class="fa fa-map-marker-alt me-2"></i>{{ $resumeData['userData']->address }}</p>
                    <p class="text-blue-200 text-lg"><i class="fa fa-mobile-alt me-2"></i>{{ $resumeData['userData']->contact_number }}</p>
                </div>
            </div>
        </header>

        {{-- personal information --}}
        <section class=" bg-gray-100 z-0">
            <div class="container py-10 px-5 mx-auto bg-white">
                <h2 class="text-blue-900 mt-2"><i class="fa fa-user-alt me-2"></i> Personal Information</h2>

                <div class="mt-6 text-lg">
                    <div class="row">
                        <div class="col-auto px-3">
                            <h6 class="text-lg text-gray-400 my-0">Firstname</h6>
                            <h6 class="text-lg">{{ $resumeData['userData']->firstname }}</h6>
                        </div>
                        <div class="col-auto px-3">
                            <h6 class="text-lg text-gray-400 my-0">Middlename</h6>
                            <h6 class="text-lg">{{ $resumeData['userData']->middlename }}</h6>
                        </div>
                        <div class="col-auto px-3">
                            <h6 class="text-lg text-gray-400 my-0">Lastname</h6>
                            <h6 class="text-lg">{{ $resumeData['userData']->lastname }}</h6>
                        </div>
                    </div>
                    @if ($resumeData['userData']->birthdate)
                        <div class="col-auto mt-4">
                            <h6 class="text-lg text-gray-400 my-0">Birthdate</h6>
                            <h6 class="text-lg">{{ $resumeData['userData']->birthdate->toFormattedDateString() }}</h6>
                        </div>
                        <div class="col-auto mt-4">
                            <h6 class="text-lg text-gray-400 my-0">Age</h6>
                            <h6 class="text-lg">{{ $resumeData['userData']->birthdate->diffInYears() }} years old</h6>
                        </div> 
                    @endif
                    <div class="col-auto mt-4">
                        <h6 class="text-lg text-gray-400 my-0">Gender</h6>
                        <h6 class="text-lg">{{ $resumeData['userData']->gender }}</h6>
                    </div>
                    @if ($resumeData['userData']->nationality)
                        <div class="col-auto mt-4">
                            <h6 class="text-lg text-gray-400 my-0">Nationality</h6>
                            <h6 class="text-lg">{{ $resumeData['userData']->nationality }}</h6>
                        </div>
                    @endif
                    @if ($resumeData['userData']->civil_status)
                        <div class="col-auto mt-4">
                            <h6 class="text-lg text-gray-400 my-0">Civil Status</h6>
                            <h6 class="text-lg">{{ Str::ucfirst($resumeData['userData']->civil_status)  }}</h6>
                        </div>
                    @endif
                    @if (!empty(json_decode($resumeData['userData']->language)))
                        <div class="col-auto mt-4">
                            <h6 class="text-lg text-gray-400 my-0">Language</h6>
                            @foreach (json_decode($resumeData['userData']->language) as $i)
                                <h6 class="text-lg">{{ $i }}</h6>
                            @endforeach
                        </div>
                    @endif
                    @if ($resumeData['userData']->address)
                        <div class="col-auto mt-4">
                            <h6 class="text-lg text-gray-400 my-0">Address</h6>
                            <h6 class="text-lg">{{ Str::ucfirst($resumeData['userData']->address)  }}</h6>
                        </div>
                    @endif
                    @if ($resumeData['userData']->contact_number)
                        <div class="col-auto mt-4">
                            <h6 class="text-lg text-gray-400 my-0">Contact Number</h6>
                            <h6 class="text-lg">{{ Str::ucfirst($resumeData['userData']->contact_number)  }}</h6>
                        </div>
                    @endif
                    @if ($resumeData['userData']->email)
                        <div class="col-auto mt-4">
                            <h6 class="text-lg text-gray-400 my-0">Email Address</h6>
                            <h6 class="text-lg">{{ Str::ucfirst($resumeData['userData']->email)  }}</h6>
                        </div>
                    @endif
                    
                </div>
            </div>
        </section>

        {{-- educational background --}}
        <section class=" bg-gray-100 z-0">
            <div class="container py-10 px-5 mx-auto bg-gray-200">
                <h2 class="text-blue-900 mt-2"><i class="fa fa-graduation-cap me-2"></i> Educational Background</h2>
                @foreach ($resumeData['educationData'] as $education )
                    {{-- primary education --}}
                    @if ($education->education_level === 'primary education')
                        <div class="mt-4 py-2">
                            <h6 class="text-blue-500 mb-0"><i class="fa fa-graduation-cap"></i> {{ Str::title($education->education_level) }}</h6>
                            <h6 class="mb-0">{{ $education->school_name }}</h6>
                            <h6 class="mb-0 font-light">{{ $education->school_address }}</h6>
                            <h6 class="mb-0 font-light">Graduated on {{ $education->year_graduated }}</h6>
                        </div>
                    @endif
                @endforeach
                @foreach ($resumeData['educationData'] as $education )
                    {{-- secondary education --}}
                    @if ($education->education_level === 'secondary education')
                        <div class="mt-4 py-2">
                            <h6 class="text-blue-500 mb-0"><i class="fa fa-graduation-cap"></i> {{ Str::title($education->education_level) }}</h6>
                            <h6 class="mb-0">{{ $education->school_name }}</h6>
                            <h6 class="mb-0 font-light">{{ $education->school_address }}</h6>
                            <h6 class="mb-0 font-light">Graduated on {{ $education->year_graduated }}</h6>
                        </div>
                    @endif
                @endforeach
                @foreach ($resumeData['educationData'] as $education )
                    {{-- tertiary education --}}
                    @if ($education->education_level === 'tertiary education')
                        <div class="mt-4 py-2">
                            <h6 class="text-blue-500 mb-0"><i class="fa fa-graduation-cap"></i> {{ Str::title($education->education_level) }}</h6>
                            <h6 class="mb-0">{{ $education->school_name }}</h6>
                            <h6 class="mb-0 font-light">{{ $education->school_address }}</h6>
                            @if ($education->year_graduated == '0000')
                                <h6 class="mb-0 font-light">Undergraduate</h6>
                            @else
                                <h6 class="mb-0 font-light">Graduated on {{ $education->year_graduated }}</h6>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </section>

        {{-- Work Experience --}}
        @if (!empty($resumeData['experienceData'][0]))
        <section class=" bg-gray-100 z-0">
            <div class="container py-10 px-5 mx-auto bg-white">
                <h2 class="text-blue-900 mt-2"><i class="fa fa-business-time me-2"></i> Work Experience</h2>

                @foreach ($resumeData['experienceData'] as $experience )
                <div class="mt-4 py-2">
                    <h6 class="mb-0 text-gray-400">Industry: {{ $experience->job_industry }}</h6>
                    <h6 class="mb-0">{{ $experience->job_title }}</h6>
                    <h6 class="mb-0">{{ $experience->company_name }}</h6>
                    <h6 class="mb-0 font-light">From {{ $experience->date_started->format('F Y') }} to {{ $experience->date_ended->format('F Y') }}</h6>
                    <h6 class="mb-0 font-light">{{ round($experience->date_started->floatDiffInYears($experience->date_ended), 1) }} years</h6>
                    <h6 class="mt-2 font-normal">{{ $experience->job_description }}</h6>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        @if (!empty($resumeData['credentialData'][0]))
        <section class=" bg-gray-100 z-0">
            <div class="container py-10 px-5 mx-auto bg-gray-200">
                <h2 class="text-blue-900 mt-2"><i class="fa fa-award me-2"></i> Liscences & Certificates</h2>

                <div class="row">
                    @foreach ($resumeData['credentialData'] as $credential)
                    @if ($credential->credential_type == 'award')
                    <div class="mt-4 bg-white p-2 rounded-2 w-max col-auto m-2">
                        <h6 class="text-yellow-400 font-normal mb-0"><i class="fa fa-award me-2"></i>Award</h6>
                        @if ($credential->credential_number)
                        <h6 class="mb-0 text-gray-400">{{ $credential->credential }}</h6>
                        @endif
                        <h6 class="mb-0">{{ $credential->credential_name }}</h6>
                        @if ($credential->issuing_organization)
                        <h6 class="mb-0">{{ $credential->issuing_organization }}</h6>
                        @endif   
                        <h6 class="mb-0 font-normal">Issued on {{ $credential->date_issued->format("F d Y") }}</h6>
                        @if ($credential->non_expiry == 1)
                        <h6 class="mb-0 font-normal">No Validity</h6>
                        @else
                        <h6 class="mb-0 font-normal">Valid until {{ $credential->expiry_date->format("F d Y") }}</h6>
                        @endif
                    </div>
                    @endif
                    @if ($credential->credential_type == 'license')
                    <div class="mt-4 bg-white p-2 rounded-2 w-max col-auto m-2">
                        <h6 class="text-yellow-400 font-normal mb-0"><i class="fa fa-id-badge me-2"></i>License</h6>
                        @if ($credential->credential_number)
                        <h6 class="mb-0 text-gray-400">{{ $credential->credential }}</h6>
                        @endif
                        <h6 class="mb-0">{{ $credential->credential_name }}</h6>
                        @if ($credential->issuing_organization)
                        <h6 class="mb-0">{{ $credential->issuing_organization }}</h6>
                        @endif   
                        <h6 class="mb-0 font-normal">Issued on {{ $credential->date_issued->format("F d Y") }}</h6>
                        @if ($credential->non_expiry == 1)
                        <h6 class="mb-0 font-normal">No Validity</h6>
                        @else
                        <h6 class="mb-0 font-normal">Valid until {{ $credential->expiry_date->format("F d Y") }}</h6>
                        @endif
                    </div>
                    @endif
                    @if ($credential->credential_type == 'certification')
                    <div class="mt-4 bg-white p-2 rounded-2 w-max col-auto m-2">
                        <h6 class="text-yellow-400 font-normal mb-0"><i class="fa fa-id-certificate me-2"></i>Certificate</h6>
                        @if ($credential->credential_number)
                        <h6 class="mb-0 text-gray-400">{{ $credential->credential }}</h6>
                        @endif
                        <h6 class="mb-0">{{ $credential->credential_name }}</h6>
                        @if ($credential->issuing_organization)
                        <h6 class="mb-0">{{ $credential->issuing_organization }}</h6>
                        @endif   
                        <h6 class="mb-0 font-normal">Issued on {{ $credential->date_issued->format("F d Y") }}</h6>
                        @if ($credential->non_expiry == 1)
                        <h6 class="mb-0 font-normal">No Validity</h6>
                        @else
                        <h6 class="mb-0 font-normal">Valid until {{ $credential->expiry_date->format("F d Y") }}</h6>
                        @endif
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        @if (!empty($resumeData['skillData'][0]))
        <section class=" bg-gray-100 z-0">
            <div class="container py-10 px-5 mx-auto bg-white">
                <h2 class="text-blue-900 mt-2"><i class="fa fa-tools me-2"></i> Skills</h2>

                @foreach ($resumeData['skillData'] as $skill)
                <div class="mt-4">
                    <h6><i class="fa fa-list me-2"></i>{{ $skill->skill_description }}</h6>
                </div>
                @endforeach

            </div>
        </section>
        @endif
    </div>
</body>
<script src="{{ asset('js/pages/resume.js') }}"></script>
</html>


