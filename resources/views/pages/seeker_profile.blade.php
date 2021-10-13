@extends('app')
@section('title', '- Profile')
@section('content')
    <body class="seeker-prof bg-purple-100" >
        <link rel="stylesheet" href="{{asset('css/seeker_profile.css')}}">

        <div class="" id='SeekerProfile'>

            {{-- home navigation --}}
            <div class="bg-gradient-to-t from-indigo-500 to-indigo-900 pt-3">
                <div class=" p-3 mb-4 lg:w-10/12 mx-auto ">
                    <img class="mt-2 w-52 d-block mx-auto rounded-full shadow-lg {{ $profile->display_picture ? '' : 'd-none' }}" src="{{ url('image') }}\seeker\profile\{{  $profile->display_picture }}" alt="profile">
                    <a href="/seeker/profile/upload-image/seeker-profile" class=" duration-500 rounded-md hover:text-gray-50 pt-16 text-center fw-bold text-gray-400 hover:bg-gray-300 mt-2 border-3 border-dashed  w-40 h-40 d-block mx-auto bg-gray-100 {{ $profile->display_picture ? 'd-none' : '' }}">Upload photo</a>
                    <a href="/seeker/profile/upload-image/seeker-profile" class="mx-auto btn btn-outline-light block  my-2 w-52  {{ $profile->display_picture ? '' : 'd-none' }}">Upload display photo</a>
                    <h6 class="fw-bold text-3xl text-white my-3 text-center ">{{ $profile->firstname.' '.Str::ucfirst($profile->middlename[0]).'. '.$profile->lastname }}</h6>
                </div>
            </div>
        

            <section class="lg:w-10/12 mx-auto py-3 lg:grid lg:grid-cols-4 lg:items-start lg:gap-4">

                {{-- profile navigation --}}
                <div class="profile-nav shadow-md rounded-md my-3 lg:col-span-1">
                    <h4 class="title bg-gray-800 text-gray-50 fw-bold p-3 rounded-t-md">JOB HUNTER PROFILE</h4>

                    <div class=" bg-white rounded-b-md">
                        <div class="item px-3 py-2  {{ $view == 'personal' ? 'fw-bold text-indigo-900' : '' }}text-indigo-700 hover:bg-indigo-200 hover:text-indigo-500 duration-500 cursor-pointer" @click="toggleView('personal')">
                            <i class="fas fa-user cursor-pointer mr-2"></i>
                            <label class="cursor-pointer" >Personal Information</label>
                        </div>
                        <div class="item px-3 py-2  {{ $view == 'education' ? 'fw-bold text-indigo-900' : '' }}text-indigo-700 hover:bg-indigo-200  hover:text-indigo-500 duration-500 cursor-pointer" @click="toggleView('education')">
                            <i class="fas fa-graduation-cap cursor-pointer mr-2"></i>
                            <label class="cursor-pointer" >Education</label>
                        </div>
                        <div class="item px-3 py-2  {{ $view == 'experience' ? 'fw-bold text-indigo-900' : '' }}text-indigo-700 hover:bg-indigo-200  hover:text-indigo-500 duration-500 cursor-pointer" @click="toggleView('experience')">
                            <i class="fas fa-business-time cursor-pointer mr-2"></i>
                            <label class="cursor-pointer" >Work Experience</label>
                        </div>
                        <div class="item px-3 py-2  {{ $view == 'certificate' ? 'fw-bold text-indigo-900' : '' }}text-indigo-700 hover:bg-indigo-200  hover:text-indigo-500 duration-500 cursor-pointer" @click="toggleView('certificate')">
                            <i class="far fa-address-card cursor-pointer mr-2"></i>
                            <label class="cursor-pointer" >License & Certificates</label>
                        </div>
                        <div class="item px-3 py-2  {{ $view == 'language' ? 'fw-bold text-indigo-900' : '' }}text-indigo-700 hover:bg-indigo-200  hover:text-indigo-500 duration-500 cursor-pointer" @click="toggleView('language')">
                            <i class="fas fa-language cursor-pointer mr-2"></i>
                            <label class="cursor-pointer" >Languages</label>
                        </div>
                        <div class="item px-3 py-2  {{ $view == 'skill' ? 'fw-bold text-indigo-900' : '' }}text-indigo-700 hover:bg-indigo-200  hover:text-indigo-500 duration-500 cursor-pointer" @click="toggleView('skill')">
                            <i class="fas fa-cogs cursor-pointer mr-2"></i>
                            <label class="cursor-pointer">Skills</label>
                        </div>
                        <div class="item px-3 py-2 text-indigo-700 hover:text-indigo-800 duration-500 cursor-pointer hover:bg-indigo-200 " @click="redirectRoute('/resume/{{ Auth::user()->user_id }}')">
                            <i class="far fa-file-alt cursor-pointer mr-2"></i>
                            <label  class="cursor-pointer">View Resume</label>
                        </div>
                    </div>
                </div>
                



                {{-- views --}}
                <div class="view-sec p-4 bg-white shadow-md rounded-md my-3 lg:col-span-3">

                    @if ($view == "personal")
                    <div >
                        <h5 class="fw-bolder"><i class="fas fa-user me-2"></i> Personal Information</h5>
                        <button type='button' class='btn btn-primary ms-auto me-0 d-block' data-bs-toggle="modal" data-bs-target="#mdlEditPersonalInformation" @click="showUpdateProfile({{ Auth::user()->user_id }})"><i class='fa fa-edit'></i> Edit Personal Information</button>
                        {{-- edit personal information form --}}
                        <div class="modal fade " id="mdlEditPersonalInformation">
                            <div class="modal-dialog modal-lg  modal-fullscreen-md-down">
                                <div class="modal-content p-4">
                                    <div class="modal-header">
                                        <h5 class="fw-bold"><i class="fa fa-user me-2"></i> Edit Personal Information</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <label class="fw-bold mb-1">Name <span class="text-red-500">*</span></label>
                                            <div class="mb-3 col-md">
                                                <label class="fw-bold mb-1">Firstname <span class="text-red-500">*</span></label>
                                                <input type="text" class="form-control" v-model="profile.firstname" :class="errors.firstname ? 'is-invalid' : ''">
                                                <div class="text-danger" v-for="i in errors.firstname">@{{ i }}</div>
                                            </div>
                                            <div class="mb-3 col-md">
                                                <label class="fw-bold mb-1">Middlename <span class="text-red-500">*</span></label>
                                                <input type="text" class="form-control" v-model="profile.middlename" :class="errors.middlename ? 'is-invalid' : ''">
                                                <div class="text-danger" v-for="i in errors.middlename">@{{ i }}</div>
                                            </div>
                                            <div class="mb-3 col-md">
                                                <label class="fw-bold mb-1">Lastname <span class="text-red-500">*</span></label>
                                                <input type="text" class="form-control" v-model="profile.lastname" :class="errors.lastname ? 'is-invalid' : ''">
                                                <div class="text-danger" v-for="i in errors.lastname">@{{ i }}</div>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-lg-7">
                                            <label class="fw-bold mb-1">Gender</label>
                                            <select class="form-select"  v-model="profile.gender" :class="errors.gender ? 'is-invalid' : ''">
                                                <option value="">--select gender--</option>
                                                <option value="female">Female</option>
                                                <option value="male">Male</option>
                                            </select>
                                            <div class="text-danger" v-for="i in errors.gender">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3 col-lg-7">
                                            <label class="fw-bold mb-1">Nationality</label>
                                            <select class="form-select" v-model="profile.nationality" :class="errors.nationality ? 'is-invalid' : ''">
                                                <option value="" selected>--select nationality--</option>
                                                <option v-for="i in nationality" :value="i.nationality">@{{ i.nationality }}</option>
                                            </select>
                                            <div class="text-danger" v-for="i in errors.nationality">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3 col-lg-7">
                                            <label class="fw-bold mb-1">Civil Status</label>
                                            <select class="form-select" v-model="profile.civil_status" :class="errors.civil_status ? 'is-invalid' : ''">
                                                <option value="" selected>--select civil status--</option>
                                                <option value="single" >Single</option>
                                                <option value="married" >Married</option>
                                                <option value="widowed" >Widowed</option>
                                            </select>
                                            <div class="text-danger" v-for="i in errors.civil_status">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3 col-lg-7">
                                            <label class="fw-bold mb-1">Birthdate</label>
                                            <input type="date" class="form-control" v-model="profile.birthdate" :class="errors.birthdate ? 'is-invalid' : ''">
                                            <div class="text-danger" v-for="i in errors.birthdate">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3 col-lg-7">
                                            <label class="fw-bold mb-1">Contact Number</label>
                                            <input type="number" class="form-control" v-model="profile.contact_number" :class="errors.contact_number ? 'is-invalid' : ''">
                                            <div class="text-danger" v-for="i in errors.contact_number">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3 col-lg-7">
                                            <label class="fw-bold mb-1">Address</label>
                                            <input type="text" class="form-control" v-model="profile.address" :class="errors.address ? 'is-invalid' : ''">
                                            <div class="text-danger" v-for="i in errors.addresss">@{{ i }}</div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                        <button class="btn btn-success" @click="updateProfile"><i class="fa fa-check"></i> Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- contents --}}
                        <div>
                            <div class="m-4">
                                <h6 class="fw-bold mb-1"><i class="fa fa-tag me-2"></i> Full Name</h6>
                                <label > {{ $profile->firstname }} {{ $profile->middlename[0] }}. {{ $profile->lastname }} </label>
                            </div>
                            <div class="m-4">
                                <h6 class="fw-bold mb-1"><i class="fa fa-venus-mars me-2"></i> Gender</h6>
                                <label >@if ($profile->gender) {{ Str::ucfirst($profile->gender) }} @else <span class="text-secondary">unset</span> @endif</label>
                            </div>
                            <div class="m-4">
                                <h6 class="fw-bold mb-1"><i class="fa fa-flag me-2"></i> Nationality</h6>
                                <label >@if ($profile->nationality) {{ $profile->nationality }} @else <span class="text-secondary">unset</span> @endif</label>
                            </div>
                            <div class="m-4">
                                <h6 class="fw-bold mb-1"><i class="fa fa-ring me-2"></i> Civil Status</h6>
                                <label >@if ($profile->civil_status) {{ Str::ucfirst($profile->civil_status) }} @else <span class="text-secondary">unset</span> @endif</label>
                            </div>
                            <div class="m-4">
                                <h6 class="fw-bold mb-1"><i class="fas fa-birthday-cake me-2"></i> Birthdate</h6>
                                <label >@if ($profile->birthdate) {{ date_format($profile->birthdate, 'F d, Y') }} @else <span class="text-secondary">unset</span> @endif</label>
                            </div>
                            <div class="m-4">
                                <h6 class="fw-bold mb-1"><i class="fas fa-address-book me-2"></i> Contact Number</h6>
                                <label >@if ($profile->contact_number) {{ $profile->contact_number }} @else <span class="text-secondary">unset</span> @endif</label>
                            </div>
                            <div class="m-4">
                                <h6 class="fw-bold mb-1"><i class="fas fa-at me-2"></i> Email Address</h6>
                                <label >{{ Auth::user()->email }}</label>
                            </div>
                            <div class="m-4">
                                <h6 class="fw-bold mb-1"><i class="fas fa-address-card me-2"></i> Address</h6>
                                <label >@if ($profile->address) {{ $profile->address }} @else <span class="text-secondary">unset</span> @endif</label>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if ($view == "education")
                    <div >
                        <h5 class="fw-bolder"><i class="fas fa-graduation-cap"></i> Educational Attainments</h5>
                        <button type='button' class='btn btn-primary ms-auto me-0 d-block' @click='showAddEducationForm()' data-bs-toggle="modal" data-bs-target="#mdlAddEducationForm"><i class='fa fa-plus'></i> Add Education</button>
                        {{-- add education form --}}
                        <div class="modal fade " id='mdlAddEducationForm' aria-hidden="true" tabindex='-1'>
                            <div class="modal-dialog modal-fullscreen-md-down">
                                <div class="modal-content p-3">
                                    <div class="modal-header">
                                        <h5 class='fw-bold'><i class="fas fa-graduation-cap me-2"></i>Add Education</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3 ">
                                            <label class='mb-1 fw-bold'>Educational Level <span class="text-red-500">*</span></label>
                                            <select class='form-select form-select' v-model='education.education_level' :class="errors.education_level ? 'is-invalid' : ''">
                                                <option value="" selected>--select level of education--</option>
                                                <option value="primary education">Primary Education</option>
                                                <option value="secondary education">Secondary Education</option>
                                                <option value="tertiary education">Tertiary Education</option>
                                                <option value="master's degree">Master's Degree</option>
                                                <option value="doctorate degree">Doctorate Degree</option>
                                            </select>
                                            <div class="text-danger" v-for="i of errors.education_level">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3 " v-if="education.education_level == 'tertiary education' || education.education_level == `master's degree` || education.education_level == 'doctorate degree'">
                                            <label class='mb-1 fw-bold'>Course Name <span class="text-red-500">*</span></label>
                                            {{-- <input type="text" class='form-control' v-model='education.course' :class="errors.course ? 'is-invalid' : '' "> --}}
                                            <select class='form-select form-select' v-model='education.course' :class="errors.course ? 'is-invalid' : ''">
                                                <option value="" selected>--select course--</option>
                                                <option v-if="education.education_level == 'tertiary education'" v-for="course of courses" :value="course">@{{ course }}</option>
                                                <option v-if="education.education_level == `master's degree`" v-for="course of masters" :value="course">@{{ course }}</option>
                                                <option v-if="education.education_level == 'doctorate degree'" v-for="course of doctors" :value="course">@{{ course }}</option>
                                            </select>
                                            <div class="text-danger" v-for="i of errors.course">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3 ">
                                            <label class='mb-1 fw-bold'>School Name <span class="text-red-500">*</span></label>
                                            <input type="text" class='form-control' v-model="education.school_name" :class="errors.school_name ? 'is-invalid' : '' ">
                                            <div class="text-danger" v-for="i of errors.school_name">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3 ">
                                            <label class='mb-1 fw-bold'>School Address <span class="text-red-500">*</span></label>
                                            <input type="text" class='form-control' v-model="education.school_address" placeholder='barangay, municipality, province' :class="errors.school_address ? 'is-invalid' : '' ">
                                            <div class="text-danger" v-for="i of errors.school_address">@{{ i }}</div>
                                        </div>

                                        <div class="form-check" v-if="education.education_level == 'tertiary education' || education.education_level == `master's degree` || education.education_level == 'doctorate degree'">
                                            <input class="form-check-input" type="checkbox" v-model="undergraduate" @change="toggleUndergraduate">
                                            <label class="form-check-label" for="flexCheckDefault">
                                              I am undergraduate
                                            </label>
                                        </div>
                                        <div class="mb-3" v-if="!undergraduate">
                                            <label class='mb-1 fw-bold'>Year Graduated <span class="text-red-500">*</span></label>
                                            <input type="text" maxlength="4" class='form-control' v-model="education.year_graduated" :class="errors.year_graduated ? 'is-invalid' : '' ">
                                            <div class="text-danger" v-for="i of errors.year_graduated">@{{ i }}</div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div >
                                            <button type='button' class='btn btn-secondary me-2' data-bs-dismiss='modal'><i class='fa fa-times'></i> Close</button>
                                            <button type='button' class='btn btn-success' @click="addNewEducation()"><i class='fa fa-check'></i> Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- delete confirmation --}}
                        <div class="modal fade" id="mdlConfirmDelete">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="fw-bold">Confirm Delete</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p >Are you sure you want to delete this education attainment record?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal" @click="deleteEducation(null, false)"><i class='fas fa-times me-1'></i> Cancel</button>
                                        <button class="btn btn-primary" @click="deleteEducation(null, true)"><i class="fas fa-check me-1"></i> Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- edit education --}}
                        <div class="modal fade " id='mdlEditEducationForm' aria-hidden="true" tabindex='-1'>
                            <div class="modal-dialog modal-fullscreen-md-down">
                                <div class="modal-content p-3">
                                    <div class="modal-header">
                                        <h5 class='fw-bold'><i class="fas fa-graduation-cap me-2"></i>Edit Education</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3 ">
                                            <label class='mb-1 fw-bold'>Educational Level <span class="text-red-500">*</span></label>
                                            <select class='form-select form-select' v-model='education.education_level' :class="errors.education_level ? 'is-invalid' : ''">
                                                <option value="" selected>--select level of education--</option>
                                                <option value="primary education">Primary Education</option>
                                                <option value="secondary education">Secondary Education</option>
                                                <option value="tertiary education">Tertiary Education</option>
                                                <option value="master's degree">Master's Degree</option>
                                                <option value="doctorate degree">Doctorate Degree</option>
                                            </select>
                                            <div class="text-danger" v-for="i of errors.education_level">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3 " v-if="education.education_level == 'tertiary education'  || education.education_level == `master's degree` || education.education_level == 'doctorate degree'">
                                            <label class='mb-1 fw-bold'>Course Name <span class="text-red-500">*</span></label>
                                            <select class='form-select form-select' v-model='education.course' :class="errors.course ? 'is-invalid' : ''">
                                                <option value="" selected>--select course--</option>
                                                <option v-if="education.education_level == 'tertiary education'" v-for="course of courses" :value="course">@{{ course }}</option>
                                                <option v-if="education.education_level == `master's degree`" v-for="course of masters" :value="course">@{{ course }}</option>
                                                <option v-if="education.education_level == 'doctorate degree'" v-for="course of doctors" :value="course">@{{ course }}</option>
                                            </select>
                                            <div class="text-danger" v-for="i of errors.course">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3 ">
                                            <label class='mb-1 fw-bold'>School Name <span class="text-red-500">*</span></label>
                                            <input type="text" class='form-control' v-model="education.school_name" :class="errors.school_name ? 'is-invalid' : '' ">
                                            <div class="text-danger" v-for="i of errors.school_name">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3 ">
                                            <label class='mb-1 fw-bold'>School Address <span class="text-red-500">*</span></label>
                                            <input type="text" class='form-control' v-model="education.school_address" placeholder='barangay, municipality, province' :class="errors.school_address ? 'is-invalid' : '' ">
                                            <div class="text-danger" v-for="i of errors.school_address">@{{ i }}</div>
                                        </div>

                                        <div class="form-check" v-if="education.education_level == 'tertiary education' || education.education_level == `master's degree` || education.education_level == 'doctorate degree'">
                                            <input class="form-check-input" type="checkbox" v-model="undergraduate" @change="toggleUndergraduate" >
                                            {{-- :checked="education.year_graduated == '0000' ? '1' : '0'  --}}
                                            <label class="form-check-label" for="flexCheckDefault">
                                              I am undergraduate
                                            </label>
                                        </div>
                                        <div class="mb-3" v-if="!undergraduate">
                                            <label class='mb-1 fw-bold'>Year Graduated <span class="text-red-500">*</span></label>
                                            <input type="text" maxlength="4" class='form-control' v-model="education.year_graduated" :class="errors.year_graduated ? 'is-invalid' : '' ">
                                            <div class="text-danger" v-for="i of errors.year_graduated">@{{ i }}</div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div >
                                            <button type='button' class='btn btn-secondary me-2' data-bs-dismiss='modal'><i class='fa fa-times'></i> Close</button>
                                            <button type='button' class='btn btn-success' @click="updateEducation()"><i class='fa fa-check'></i> Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- contents --}}
                        @if ($education->first())
                            @if ($education_count['primary_education'] != 0)
                            <div class="mb-5">
                                <h6 class="fw-bold mb-2"><i class="fa fa-list me-2"></i> Primary Education</h6>
                                @foreach ($education as $i)
                                    @if ($i->education_level == "primary education")
                                    <div class="my-4 ms-4">
                                        <div class="float-end">
                                            <button class="btn btn-outline-secondary btn-sm py-0 ms-3" data-bs-toggle="modal" data-bs-target="#mdlEditEducationForm" @click="showEditEducationForm({{ $i->education_id }})">edit</button>
                                            <button class="btn btn-outline-danger btn-sm py-0 ms-1 " data-bs-toggle="modal" data-bs-target="#mdlConfirmDelete" @click="deleteEducation({{ $i->education_id }}, false)">delete</button>
                                        </div>
                                        <h6 class="my-0 fw-bold">{{ $i->school_name }} </h6>
                                        <h6 class="my-0">{{ $i->school_address }}</h6>
                                        <h6 class="my-0 text-secondary">Graduated on year {{ $i->year_graduated }}</h6>
                                    </div> 
                                    @endif
                                @endforeach
                            </div>
                            @endif
                            @if ($education_count['secondary_education'] != 0)
                            <div class="mb-5">
                                <h6 class="fw-bold"><i class="fa fa-list me-2"></i> Secondary Education</h6>
                                @foreach ($education as $i)
                                    @if ($i->education_level == "secondary education")
                                    <div class="my-4 ms-4">
                                        <div class="float-end">
                                            <button class="btn btn-outline-secondary btn-sm py-0 ms-3" data-bs-toggle="modal" data-bs-target="#mdlEditEducationForm" @click="showEditEducationForm({{ $i->education_id }})">edit</button>
                                            <button class="btn btn-outline-danger btn-sm py-0 ms-1" data-bs-toggle="modal" data-bs-target="#mdlConfirmDelete" @click="deleteEducation({{ $i->education_id }}, false)">delete</button>
                                        </div>
                                        <h6 class="my-0 fw-bold">{{ $i->school_name }}  </h6>
                                        <h6 class="my-0">{{ $i->school_address }}</h6>
                                        <h6 class="my-0 text-secondary">Graduated on year {{ $i->year_graduated }}</h6>
                                    </div> 
                                    @endif
                                @endforeach
                            </div>
                            @endif
                            @if ($education_count['tertiary_education'] != 0)
                            <div>
                                <h6 class="fw-bold"><i class="fa fa-list me-2"></i> Tertiary Education</h6>
                                @foreach ($education as $i)
                                    @if ($i->education_level == "tertiary education" || $i->education_level == 'master\'s degree' || $i->education_level == 'doctorate degree')
                                    <div class="my-4 ms-4">
                                        <div class="float-end">
                                            <button class="btn btn-outline-secondary btn-sm py-0 ms-3" data-bs-toggle="modal" data-bs-target="#mdlEditEducationForm" @click="showEditEducationForm({{ $i->education_id }})">edit</button>
                                            <button class="btn btn-outline-danger btn-sm py-0 ms-1" data-bs-toggle="modal" data-bs-target="#mdlConfirmDelete" @click="deleteEducation({{ $i->education_id }}, false)">delete</button>
                                        </div>
                                        <h6 class="my-0 fw-bold">{{ $i->school_name }} </h6>
                                        {{-- <h6 class="my-0 fw-bold">{{ $i->education_level == 'tertiary education' ? 'Bachelors Degree' : Str::title($i->education_level) }} </h6> --}}
                                        <h6 class="my-0 fw-bold">{{ $i->course }}</h6>
                                        <h6 class="my-0">{{ $i->school_address }}</h6>
                                        @if ($i->year_graduated == "0000")
                                            <h6 class="my-0 text-secondary">Undergraduate</h6>
                                        @else
                                            <h6 class="my-0 text-secondary ">Graduated on year {{ $i->year_graduated }}</h6>
                                        @endif
                                    </div> 
                                    @endif
                                @endforeach
                            </div>
                            @endif
                        @else
                            <h4 class='fs-4 text-center my-4 text-black-50 '>Don't forget to add your educational attainments.</h4>
                        @endif
                    </div>
                    @endif
                    

                    @if ($view == "experience")
                    <div>
                        <h5 class="fw-bolder"><i class="fas fa-business-time me-2"></i>Work Experiences</h5>
                        <button type='button' class='btn btn-primary ms-auto me-0 d-block' data-bs-toggle="modal" data-bs-target="#mdlAddExperienceForm" @click="showAddExperienceForm"><i class='fa fa-plus'></i> Add Experience</button>
                        {{-- add experience form --}}
                        <div class="modal fade" id="mdlAddExperienceForm">
                            <div class="modal-dialog modal-fullscreen-md-down">
                                <div class="modal-content p-3">
                                    <div class="modal-header">
                                        <h5 class="fw-bold"><i class="fas fa-business-time me-2"></i> Add Experience</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3 " >
                                            <label class='mb-1 fw-bold'>Position Title <span class="text-red-500">*</span></label>
                                            <input type="text" class='form-control' v-model="experience.job_title" :class="errors.job_title ? 'is-invalid' : '' " >
                                            <div class="text-danger" v-for="i of errors.job_title">@{{ i }}</div>
                                        </div>
                                        {{-- <div class="mb-3 " >
                                            <label class='mb-1 fw-bold'>Position</label>
                                            <input type="text" class='form-control' v-model="experience.position" :class="errors.position ? 'is-invalid' : '' " >
                                            <div class="text-danger" v-for="i of errors.position">@{{ i }}</div>
                                        </div> --}}
                                        <div class="mb-3 " >
                                            <label class='mb-1 fw-bold'>Job Industry <span class="text-red-500">*</span></label>
                                            <select  class='form-select' v-model="experience.job_industry" :class="errors.job_industry ? 'is-invalid' : '' " >
                                                <option value="null">--select one--</option>
                                                <option v-for="industry of job_industries" :value="industry">@{{ industry }}</option>
                                            </select>
                                            <div class="text-danger" v-for="i of errors.job_industry">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3 " >
                                            <label class='mb-1 fw-bold'>Company Name <span class="text-red-500">*</span></label>
                                            <input type="text" class='form-control'  :class="errors.company_name ? 'is-invalid' : '' " v-model="experience.company_name">
                                            <div class="text-danger" v-for="i of errors.company_name">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class='mb-1 fw-bold'>How long have you work here?</label>
                                            <div class="row">
                                                <div class="col">
                                                    <label class="mb-1 fw-bold">From <span class="text-red-500">*</span></label>
                                                    <input type="date" class="form-control" :class="errors.date_started ? 'is-invalid' : '' " v-model="experience.date_started">
                                                    <div class="text-danger" v-for="i of errors.date_started">@{{ i }}</div>
                                                </div>
                                                <div class="col">
                                                    <label class="mb-1 fw-bold">To <span class="text-red-500">*</span></label>
                                                    <input type="date" class="form-control" :class="errors.date_ended ? 'is-invalid' : '' " v-model="experience.date_ended">
                                                    <div class="text-danger" v-for="i of errors.date_ended">@{{ i }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 " >
                                            <label class='mb-1 '><span class="fw-bold">What do you do on this job?</span></label>
                                            <textarea type="text" class='form-control'  :class="errors.job_description ? 'is-invalid' : '' " v-model="experience.job_description"></textarea>
                                            <div class="text-danger" v-for="i of errors.job_description">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class='mb-1 '><span class="fw-bold">Monthly Salary</span> <span class="text-red-500">*</span></label>
                                            <div class="input-group">
                                                <label class="input-group-text">Php</label>
                                                <input type="number" class="form-control" :class="errors.salary ? 'is-invalid' : '' " v-model="experience.salary">
                                            </div>
                                            
                                            <div class="text-danger" v-for="i of errors.salary">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class='mb-1 '><span class="fw-bold">Status of Appointment</span> <span class="text-red-500">*</span></label>
                                            <input type="text" class="form-control" :class="errors.status_of_appointment ? 'is-invalid' : '' " v-model="experience.salastatus_of_appointmentry">
                                            <div class="text-danger" v-for="i of errors.status_of_appointment">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="checkbox" > <label >Government Service</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times" ></i> Close</button>
                                        <button class="btn btn-success" @click="addExperience"><i class="fa fa-check" ></i> Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- edit experience form --}}
                        <div class="modal fade" id="mdlEditExperienceForm">
                            <div class="modal-dialog modal-fullscreen-md-down">
                                <div class="modal-content p-3">
                                    <div class="modal-header">
                                        <h5 class="fw-bold"><i class="fas fa-business-time me-2"></i> Edit Experience</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3 " >
                                            <label class='mb-1 fw-bold'>Job Title/Position <span class="text-red-500">*</span></label>
                                            <input type="text" class='form-control' v-model="experience.job_title" :class="errors.job_title ? 'is-invalid' : '' " >
                                            <div class="text-danger" v-for="i of errors.job_title">@{{ i }}</div>
                                        </div>
                                        {{-- <div class="mb-3 " >
                                            <label class='mb-1 fw-bold'>Position</label>
                                            <input type="text" class='form-control' v-model="experience.position" :class="errors.position ? 'is-invalid' : '' " >
                                            <div class="text-danger" v-for="i of errors.position">@{{ i }}</div>
                                        </div> --}}
                                        <div class="mb-3 " >
                                            <label class='mb-1 fw-bold'>Job Industry <span class="text-red-500">*</span></label>
                                            <select  class='form-select' v-model="experience.job_industry" :class="errors.job_industry ? 'is-invalid' : '' " >
                                                <option value="null">--select one--</option>
                                                <option v-for="industry of job_industries" :value="industry">@{{ industry }}</option>
                                            </select>
                                            <div class="text-danger" v-for="i of errors.job_industry">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3 " >
                                            <label class='mb-1 fw-bold'>Company Name <span class="text-red-500">*</span></label>
                                            <input type="text" class='form-control'  :class="errors.company_name ? 'is-invalid' : '' " v-model="experience.company_name">
                                            <div class="text-danger" v-for="i of errors.company_name">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class='mb-1 fw-bold'>How long have you work here?</label>
                                            <div class="row">
                                                <div class="col">
                                                    <label class="mb-1 fw-bold">Date Started <span class="text-red-500">*</span></label>
                                                    <input type="date" class="form-control" :class="errors.date_started ? 'is-invalid' : '' " v-model="experience.date_started">
                                                    <div class="text-danger" v-for="i of errors.date_started">@{{ i }}</div>
                                                </div>
                                                <div class="col">
                                                    <label class="mb-1 fw-bold">Date Ended <span class="text-red-500">*</span></label>
                                                    <input type="date" class="form-control" :class="errors.date_ended ? 'is-invalid' : '' " v-model="experience.date_ended">
                                                    <div class="text-danger" v-for="i of errors.date_ended">@{{ i }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 " >
                                            <label class='mb-1 '><span class="fw-bold">What do you do on this job?</span> <span class="text-secondary">(optional)</span></label>
                                            <textarea type="text" class='form-control'  :class="errors.job_description ? 'is-invalid' : '' " v-model="experience.job_description"></textarea>
                                            <div class="text-danger" v-for="i of errors.job_description">@{{ i }}</div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times" ></i> Close</button>
                                        <button class="btn btn-success" @click="updateExperience"><i class="fa fa-check" ></i> Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- confirm experience delete --}}
                        <div class="modal fade" id="mdlConfirmDeleteExperience">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="fw-bold">Confirm Delete</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p >Are you sure you want to delete this experience?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal" @click="deleteExperience(null, false)"><i class='fas fa-times me-1'></i> Cancel</button>
                                        <button class="btn btn-primary" @click="deleteExperience(null, true)"><i class="fas fa-check me-1"></i> Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- contents --}}
                        @if ($experience->first())
                            @foreach ($experience as $i)
                            <div class="my-4 ms-4">
                                <div class="float-end">
                                    <button class="btn btn-outline-secondary btn-sm py-0 ms-3" data-bs-toggle="modal" data-bs-target="#mdlEditExperienceForm" @click="showEditExperience({{ $i->experience_id }})">edit</button>
                                    <button class="btn btn-outline-danger btn-sm py-0 ms-1 " data-bs-toggle="modal" data-bs-target="#mdlConfirmDeleteExperience" @click="deleteExperience({{ $i->experience_id }}, false)">delete</button>
                                </div>
                                <h6 class="my-0 fw-bold">{{ $i->job_title }} </h6>
                                {{-- <h6 class="my-0 ">{{ $i->position }} </h6> --}}
                                <h6 class="my-0">{{ $i->company_name }}</h6>
                                <h6 class="my-0 text-secondary">Worked from {{ date_format($i->date_started, "F d, Y") }} to {{ date_format($i->date_ended, "F d, Y") }}</h6>
                            </div> 
                            @endforeach
                        @else
                            <h4 class='fs-4 text-center my-4 text-black-50 '>Don't forget to add your job experiences.</h4>
                        @endif
                    </div>
                    @endif
                    

                    @if ($view == "certificate")
                    <div >
                        <h5 class="fw-bolder"><i class="fa fa-trophy me-2"></i> Awards, Licenses & Certificates</h5>
                        <button type='button' class='btn btn-primary ms-auto me-0 d-block' data-bs-toggle="modal" data-bs-target="#mdlChooseCredential" @click="clearCredential()"><i class='fa fa-plus'></i> Add credential</button>
                        {{-- modal choose type --}}
                        <div class="modal fade" id="mdlChooseCredential">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content p-3">
                                    <div class="modal-header">
                                        <h5 class="fw-bold">Choose credential type</h5>
                                    </div>
                                    <div class="modal-body">
                                        <button class="btn btn-lg d-block w-100 text-start" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#mdlAddCredential" @click="changeCredentialType('certification')"><i class='fa fa-certificate me-3 text-secondary'></i>Certification</button>
                                        <button class="btn btn-lg d-block w-100 text-start" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#mdlAddCredential" @click="changeCredentialType('award')"><i class='fa fa-award me-3 text-secondary'></i>Award</button>
                                        <button class="btn btn-lg d-block w-100 text-start" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#mdlAddCredential" @click="changeCredentialType('license')"><i class='fa fa-id-badge me-3 text-secondary'></i>License</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- add credential form --}}
                        <div class="modal fade" id="mdlAddCredential">
                            <div class="modal-dialog modal-fullscreen-md-down">
                                <div class="modal-content p-3">
                                    <div class="modal-header">
                                        <h5 class="fw-bold"><i class="fa fa-file-certificate"></i> Add Credential</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">Credential Name*</label>
                                            <input type="text" class="form-control" v-model="credential.credential_name" :class="errors.credential_name ? 'is-invalid' : ''">
                                            <div class="text-danger" v-for=" i of errors.credential_name">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">Issuing Organization</label>
                                            <input type="text" class="form-control" v-model="credential.issuing_organisation">
                                        </div>
                                        <div class="mb-4">
                                            <label class="fw-bold mb-1">Credential Number</label>
                                            <input type="text" class="form-control" v-model="credential.credential_number">
                                        </div>

                                        {{-- date --}}
                                        <div class="mb-3" v-if="credential.credential_type == 'award'">
                                            <label class="fw-bold mb-1">Date Issued*</label>
                                            <input type="date" class="form-control" v-model="credential.date_issued" :class="errors.date_issued ? 'is-invalid' : ''">
                                            <div class="text-danger" v-for=" i of errors.date_issued">@{{ i }}</div>
                                        </div>

                                        <div class="form-check" v-if="credential.credential_type != 'award'">
                                            <input class="form-check-input" type="checkbox"  v-model="credential.non_expiry">
                                            <label class="form-check-label">
                                              This doesn't expire
                                            </label>
                                        </div>
                                        <div class="row" v-if="credential.credential_type != 'award'">
                                            <div class="mb-3 col">
                                                <label class="fw-bold mb-1">Date Issued*</label>
                                                <input type="date" class="form-control" v-model="credential.date_issued" :class="errors.date_issued ? 'is-invalid' : ''">
                                                <div class="text-danger" v-for="i of errors.date_issued">@{{ i }}</div>
                                            </div>
                                            <div class="mb-3 col" >
                                                <div v-if="!credential.non_expiry">
                                                    <label class="fw-bold mb-1">Expiration Date*</label>
                                                    <input type="date" class="form-control" v-model="credential.expiry_date" :class="errors.expiry_date ? 'is-invalid' : ''">
                                                    <div class="text-danger" v-for=" i of errors.expiry_date">@{{ i }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">Upload Credential Image</label>
                                            <input type="file" accept="image/*" class="form-control" id="inCredentialImage" @change="setCredentialImage()">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                        <button class="btn btn-success" @click="addCredential()"><i class="fa fa-save"></i> Save Credential</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- edit credential form --}}
                        <div class="modal fade" id="mdlEditCredential">
                            <div class="modal-dialog modal-fullscreen-md-down">
                                <div class="modal-content p-3">
                                    <div class="modal-header">
                                        <h5 class="fw-bold"><i class="fa fa-file-certificate"></i> Edit Credential</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">Credential Name*</label>
                                            <input type="text" class="form-control" v-model="credential.credential_name" :class="errors.credential_name ? 'is-invalid' : ''">
                                            <div class="text-danger" v-for=" i of errors.credential_name">@{{ i }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">Issuing Organization</label>
                                            <input type="text" class="form-control" v-model="credential.issuing_organisation">
                                        </div>
                                        <div class="mb-4">
                                            <label class="fw-bold mb-1">Credential Number</label>
                                            <input type="text" class="form-control" v-model="credential.credential_number">
                                        </div>

                                        {{-- date --}}
                                        <div class="mb-3" v-if="credential.credential_type == 'award'">
                                            <label class="fw-bold mb-1">Date Issued*</label>
                                            <input type="date" class="form-control" v-model="credential.date_issued" :class="errors.date_issued ? 'is-invalid' : ''">
                                            <div class="text-danger" v-for=" i of errors.date_issued">@{{ i }}</div>
                                        </div>

                                        <div class="form-check" v-if="credential.credential_type != 'award'">
                                            <input class="form-check-input" type="checkbox"  v-model="credential.non_expiry">
                                            <label class="form-check-label">
                                              This doesn't expire
                                            </label>
                                        </div>
                                        <div class="row" v-if="credential.credential_type != 'award'">
                                            <div class="mb-3 col">
                                                <label class="fw-bold mb-1">Date Issued*</label>
                                                <input type="date" class="form-control" v-model="credential.date_issued" :class="errors.date_issued ? 'is-invalid' : ''">
                                                <div class="text-danger" v-for="i of errors.date_issued">@{{ i }}</div>
                                            </div>
                                            <div class="mb-3 col" >
                                                <div v-if="!credential.non_expiry">
                                                    <label class="fw-bold mb-1">Expiration Date*</label>
                                                    <input type="date" class="form-control" v-model="credential.expiry_date" :class="errors.expiry_date ? 'is-invalid' : ''">
                                                    <div class="text-danger" v-for=" i of errors.expiry_date">@{{ i }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">@{{ credential.credential_image ? 'Change' : 'Upload' }} credential image</label>
                                            <input type="file" accept="image/*"  class="form-control" id="inEditCredentialImage" v-on:change="setCredentialImage()">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                        <button class="btn btn-success" @click="updateCredential"><i class="fa fa-save"></i> Save Credential</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- credential delete confirmation --}}
                        <div class="modal fade" id="mdlDeleteCredential">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="fw-bold">Confirm Delete</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p class="fs-5">Are you sure you want to delete this credential?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times" ></i> Cancel</button>
                                        <button class="btn btn-primary" @click="deleteCredential(null, true)"><i class="fa fa-check" ></i> Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- contents --}}
                        @if ($credential->first())
                            @foreach ($credential as $i)
                            <div class="my-5 ms-5">
                                <div class="float-end ">
                                    <button class="btn btn-outline-secondary btn-sm py-0 ms-3" data-bs-toggle="modal" data-bs-target="#mdlEditCredential" @click="showEditCredential({{ $i->credential_id }})">edit</button>
                                    <button class="btn btn-outline-danger btn-sm py-0 ms-1 " data-bs-toggle="modal" data-bs-target="#mdlDeleteCredential" @click="deleteCredential({{ $i->credential_id }}, false)">delete</button>
                                </div>
                                <h6 class="fw-bold">
                                    <span >
                                        @if ($i->credential_type == "certification")
                                            <i class='fa fa-certificate me-2 text-secondary'></i>
                                        @elseif($i->credential_type == "award")
                                            <i class='fa fa-award me-2 text-secondary'></i>
                                        @else
                                            <i class='fa fa-id-badge me-2 text-secondary'></i>
                                        @endif
                                    </span> 
                                    {{ $i->credential_name }}
                                </h6>
                                @if ($i->issuing_organization)
                                <h6 class="my-0">Issued by: {{ $i->issuing_ordanization }}</h6>
                                @endif
                                @if ($i->credential_number)
                                <h6 class="my-0">Credential# {{ $i->credential_number }}</h6>
                                @endif
                                <h6 class="my-0">Issued on {{  date_format($i->date_issued, "F d, Y") }} </h6>
                                @if ($i->expiry_date)
                                <h6 class="my-0">Valid until {{  date_format($i->expiry_date, "F d, Y") }}</h6>
                                @endif
                                @if ($i->credential_image)
                                <a href="{{ url('image').'/seeker/credential/'.$i->credential_image }}" class="link-primary" target="_blank">View Credential Image</a>
                                @endif

                            </div>
                            @endforeach
                        @else
                            <h4 class='fs-4 text-center my-4 text-black-50 '>Dont forget to share your achievements.</h4>
                        @endif
                    </div>
                    @endif
                    

                    @if ($view == "skill")
                    <div >
                        <h5 class="fw-bolder"><i class="fas fa-cogs me-2"></i> Skills</h5>
                        {{-- add skill --}}
                        <div class="mb-4">
                            <label class="fw-bold mb-1">Add Skill</label>
                            <div class=" row">
                                <div class="col col-xl-6">
                                    <textarea class="form-control" :class="errors.skill ? 'is-invalid' : ''" placeholder="write your skills here" v-model="skills.skill"></textarea>
                                </div>
                                <div class="col-auto">
                                    <button type='button' class='btn btn-primary ' @click="addSkill"><i class='fa fa-plus'></i> Add</button>
                                </div>    
                            </div>
                        </div>
                        {{-- edit skill modal --}}
                        <div class="modal fade" id="mdlEditSkill">
                            <div class="modal-dialog modal-fullscreen-md-down">
                                <div class="modal-content p-4">
                                    <div class="modal-header">
                                        <h5 class="fw-bold"><i class="fa fa-edit"></i> Edit Skill</h5>
                                    </div>
                                    <div class="modal-body">
                                        <label class="mb-1 fw-bold">Describe your Skill</label>
                                        <div class="mb-3">
                                            <textarea class="form-control" rows="10" :class="errors.skill ? 'is-invalid' : ''" placeholder="write your skills here" v-model="skills.skill"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button class="btn btn-success" @click="updateSkill">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- delete skill confirmation --}}
                        <div class="modal fade" id="mdlDeleteSkill">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="fw-bold"><i class="fa fa-edit"></i>Delete Skill</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are tou sure you want to delete this Skill?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button class="btn btn-primary" @click="deleteSkill(null, true)">Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- content --}}
                        <div class="container">
                            @if ($skill->first())
                                @foreach ($skill as $item)
                                <div class="row my-3 rounded-md hover:shadow-md hover:bg-indigo-100 p-2">
                                    <div class="col-auto pe-0">
                                        <i class="fas fa-check text-green-400"></i>
                                    </div>
                                    <div class="col ">
                                        <p class="d-inline" style="white-space: pre-wrap">{{ $item->skill_description }}</p>
                                    </div>
                                    <div class="col-lg-auto m-sm-2">
                                        <button class="btn btn-outline-secondary btn-sm py-0 ms-3" data-bs-toggle="modal" data-bs-target="#mdlEditSkill" @click="showEditSkill({{ $item->skill_id }})">edit</button>
                                        <button class="btn btn-outline-danger btn-sm py-0 ms-1 " data-bs-toggle="modal" data-bs-target="#mdlDeleteSkill" @click="deleteSkill({{ $item->skill_id }}, false)">delete</button>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <h4 class='fs-4 text-center my-5 text-black-50 '>Job Seekers with overwelming skills easily attract employers.</h4>
                            @endif
                            
                        </div>
                    </div>
                    @endif
                    

                    @if ($view == "language")
                    <div>
                        <h5 class="fw-bolder"><i class="fas fa-language me-2"></i> Languages</h5>
                        {{-- add language form --}}
                        <div class="mb-3 ">
                            <label class="fw-bold mb-1">Select Language</label>
                            <div class=" row">
                                <div class="col col-xl-6">
                                    <select class="form-select" v-model="language" :class="errors.language ? 'is-invalid' : ''">
                                        <option value="null" selected>--select language--</option>
                                        <option value="Tagalog" >Tagalog</option>
                                        <option value="English" >English</option>
                                        <option v-for="i in languages" :value="i.language">@{{ i.language }}</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type='button' class='btn btn-primary ' @click="addLanguage"><i class='fa fa-plus'></i> Add</button>
                                </div>
                            </div>
                        </div>
                        {{-- duplicate language alert --}}
                        <button class="d-none" id="btnShowDuplicateLanguageAlert" data-bs-toggle="modal" data-bs-target="#mdlDuplicateLanguageAlert"></button>
                        <div class="modal fade" id="mdlDuplicateLanguageAlert">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="fw-bold text-danger"><i class="fa fa-exclamation-circle me-1"></i> Duplicate Entry</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p>You already added this language before.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- content --}}
                        <div id="bdgLanguage"  style="display: none">
                            <div  class="btn rounded-pill btn-outline-dark fs-6 fw-normal m-1" v-for="i in languageList">
                                @{{ i }} 
                                <i class="fa fa-times ms-2 text-secondary" @click="deleteLanguage(i)"></i>
                            </div>
                        </div>

                    </div>
                    @endif
                    

                    @if ($view == "resume")
                    <div >
                        <h1 class="title"><i class="far fa-file-alt"></i> Resume</h1>
                        <div class="content">
                            <h1>dito yung mga resume pagupload at pag view</h1>
                        </div>
                    </div>
                    @endif
                </div>


            </section>
        </div> 
        {{-- end of wrapper --}}


        {{-- loading --}}
        <div id="loading" class=" w-screen h-screen bg-gray-800 bg-opacity-50 fixed top-0 " style="z-index: 3000">
            <div class="fixed top-1/3 w-screen">
                <div class="spinner-grow text-white mx-auto d-block" role="status">
                    <span class="visually-hidden">Loading</span>
                </div>
                <h6 class="fw-bold fs-5 text-center text-white">Loading..</h6>
            </div>
        </div>

    </body>
    <script src="{{asset('js/pages/seeker_profile.js')}}"></script>
@endsection