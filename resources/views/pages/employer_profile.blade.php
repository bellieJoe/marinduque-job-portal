@extends('app')
@section('title', '- Employer Profile')
@section('content')

    <body class="employer-profile bg-gray-200" >

        <link rel="stylesheet" href="{{asset('css/employer_profile.css')}}">
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

        <div class="employer-profile-wrapper" id="EmployerProfile">
            {{-- initialization --}}
            <div class="d-none">
                <input type="text" id="init_company_name" value='{{ $employer->company_name }}'>
                <input type="text" id="init_contact_number" value='{{ $employer->contact_number }}'>
                <input type="text" id="init_contact_person_name" value='{{ $employer->contact_person_name }}'>
                {{-- <input type="text" id="init_address" value='{{ $employer->address }}'> --}}
                <input type="text" id="init_description" value='{{ $employer->description }}'>
                <input type="text" id="init_mission" value='{{ $employer->mission }}'>
                <input type="text" id="init_vision" value='{{ $employer->vision }}'>
                <input type="text" id="init_address" value='{{ $employer->address }}'>
            </div>

            <section class="com-details m-2 p-4 my-5 shadow-sm bg-white">
                <div class="row">
                    <div class="col-sm-auto mx-auto">
                        @if ($employer->company_logo)
                            <img class="mx-auto d-block com-logo" src="{{ url('image').'/employer/logo/'.$employer->company_logo }}" alt="">
                        @else
                            <a href="/employer/profile/upload-logo" class="btn btn-lg btn-outline-light mx-auto text-white com-logo">Upload logo</a>
                        @endif
                        
                    </div>
                    <div class="col-sm">
                        <h1 class="com-name fw-bold my-3 text-xl">{{ $employer->company_name }}</h1>
                        <label class="fs-5 d-block text-secondary">
                            @if ($employer->address)
                            {{ json_decode($employer->address)->{'barangay'}->{'name'}.', '
                            .ucwords(strtolower(json_decode($employer->address)->{'municipality'}->{'name'})).', '
                            .ucwords(strtolower(json_decode($employer->address)->{'province'}->{'name'})).', '   
                            .json_decode($employer->address)->{'region'}->{'name'}   }}
                            @endif
                        </label>
                        {{-- <label class="type">Retails/Merchandise --pansamantala muna to--</label> --}}
                        <button class="btnEditProfile btn my-3 me-2" id='btnEditProfile' @click='openEditProfile()'>
                            Edit Profile
                        </button>
                        @if ($employer->company_logo)
                        <a class="btn btn-primary my-3" id='btnEditProfile' href="/employer/profile/upload-logo">
                            Change Logo
                        </a>                            
                        @endif
                        
                    </div>
                </div>
                
            </section>


            <section class="sec-1 mx-2 mb-0 p-5 shadow-sm ">
                <div class="">
                    <label class="border-info fw-bold fs-4 head-1 ">Company Overview</label>
                </div>
                <div class="divContent mt-4">
                    <div class="divOverview">
                        @if ($employer->description)
                        <div class="mb-5">
                            <button type="button" class="btn btn-outline-secondary btn-sm d-block mb-4 me-0 ms-auto" id='btnEditDescription' @click='openEditProfile()'>
                                <i class='far fa-edit me-1'></i> Edit Description
                            </button>
                            <h6 class='fw-bold fs-5'>Company Description</h6>
                            <p class='text-secondary fs-5 desc mb-5'>{{ $employer->description }}</p>
                        </div>
                        @else
                        <div class="my-5 mx-auto">
                            <h5 class='d-block text-center text-secondary mx-auto mb-3'>Describe your company.</h5>
                            <button type="button" class="btn btn-outline-primary mb-3 d-block mx-auto" id='btnEditDescription' @click='openEditProfile()'>
                                <i class='far fa-edit  me-1' ></i> Set Description
                            </button>
                        </div>
                        @endif
                        @if ($employer->mission)
                        <div class="mb-5">
                            <button type="button" class="btn btn-outline-secondary btn-sm d-block mb-4 me-0 ms-auto" id='btnEditDescription' @click='clear()' data-bs-toggle="modal" data-bs-target="#mdlSetMission">
                                <i class='far fa-edit me-1'></i> Edit Mission
                            </button>
                            <h5 class='fw-bold fs-5'>Mission</h5>
                            <p class='text-secondary fs-5 desc  mb-5' style="white-space: pre-wrap">{{ $employer->mission }}</p>
                        </div>   
                        @else
                        <div class="mb-5">
                            <h5 class='text-secondary text-center mb-3'>Write your company mission.</h5>
                            <button type="button" class="btn btn-outline-primary my-2 mx-auto d-block" id='btnEditDescription' @click='clear()' data-bs-toggle="modal" data-bs-target="#mdlSetMission">
                                <i class='far fa-edit  me-1' ></i> Set Mission
                            </button>
                        </div>
                        @endif
                        @if ($employer->vision)
                        <div class="mb-5">
                            <button type="button" class="btn btn-outline-secondary btn-sm d-block mb-4 me-0 ms-auto" id='btnEditDescription' @click='clear()' data-bs-toggle="modal" data-bs-target="#mdlSetVision">
                                <i class='far fa-edit me-1'></i> Edit Vision
                            </button>
                            <h5 class='fw-bold fs-5'>Vision</h5>
                            <p class='text-secondary fs-5 desc  mb-5' style="white-space: pre-wrap">{{ $employer->vision }}</p>
                        </div>   
                        @else
                        <div class="mb-5">
                            <h5 class='text-secondary text-center mb-3'>Write your company vision.</h5>
                            <button type="button" class="btn btn-outline-primary my-2 mx-auto d-block" id='btnEditDescription' @click='clear()' data-bs-toggle="modal" data-bs-target="#mdlSetVision">
                                <i class='far fa-edit  me-1' ></i> Set Vision
                            </button>
                        </div>
                        @endif
                       
                    </div>
                    
                </div>
            </section>

            <section class="sec-2 mx-2 p-5 shadow-sm mb-5">
                <div class="">
                    <label class="border-info fw-bold fs-4 head-2">Contact Information</label>
                </div>
                <div class="row mt-5">
                    <div class="col-auto mx-auto">
                        <div class="mb-5 ">
                            <label class="fs-5 head-2 d-block"><i class="fa fa-envelope me-1"></i> Email address</label>
                            <label class="fs-4 text-white text-break">{{ Auth::user()->email }}</label>
                        </div>                       
                        <div class="mb-5 ">
                            <label class="fs-5 head-2 d-block"><i class="fa fa-user me-1"></i>Contact person</label>
                            <label class="fs-4 text-white">{{ $employer->contact_person_name }}</label>
                        </div> 
                        <div class="mb-5 ">
                            <label class="fs-5 head-2 d-block"><i class="fa fa-phone me-1"></i>Contact number</label>
                            <label class="fs-4 text-white">{{ $employer->contact_number }}</label>
                        </div> 
                    </div>
                </div>
            </section>




            {{-- other components --}}
            {{-- edit profile form --}}
            <div class="modal fade " id='mdlEditProfile'>
                <div class="modal-dialog modal-fullscreen-sm-down modal-lg">
                    <div class="modal-content p-3">
                        <div class="modal-header">
                            <h5 class='fw-bold'><i class='far fa-edit text-secondary me-2'></i> Edit Profile</h5>
                        </div>

                        <div class="modal-body">

                            {{-- test vue --}}
                            <div class=" mb-3 lg-w-25">
                                <label for="" class='mb-1 fw-bold'>Company Name</label>
                                <input type="text" class="form-control" :class="errors.company_name ? 'is-invalid' : '' " v-model.lazy='employer.company_name'>
                                <div class="alert-danger p-1" v-for='i of errors.company_name'>@{{ i }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="" class='mb-1 fw-bold'>Contact Number</label>
                                <input type="number"  class="form-control" :class="errors.contact_number ? 'is-invalid' : '' "  v-model.lazy='employer.contact_number'>
                                <div class="alert-danger p-1" v-for='i of errors.contact_number'>@{{ i }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="" class='mb-1 fw-bold'>Contact Person Name</label>
                                <input type="text" class="form-control" :class="errors.contact_person_name ? 'is-invalid' : '' " v-model.lazy='employer.contact_person_name'>
                                <div class="alert-danger p-1" v-for='i of errors.contact_person_name'>@{{ i }}</div>
                            </div>


                            {{-- address --}}
                            <label for="" class='mb-1 mt-1 fw-bold'>Company Address</label><br>
                            <div class="row">
                                <div class="mb-2 col-lg">
                                    <label for="" class='mb-1 text-secondary' >Region</label>
                                    <select class="form-select" placeholder="Region" v-model='employer.region' @change='resetAddress("reg")'>
                                        <option v-for='i in ph.regions' :value='i'>@{{ i.name }}</option>
                                    </select>
                                    <div class="alert-danger p-1" v-for='i of errors.region'>@{{ i }}</div>
                                </div>
                                
                                <div class="mb-2 col-lg">
                                    <label for="" class='mb-1 text-secondary' >Province</label>
                                    <select class="form-select  " v-model='employer.province' :disabled="employer.region ? false : true" @change='resetAddress("prov")'>
                                        <option v-for='i in ph.provinces' :value="i" v-if='employer.region && i.reg_code == employer.region.reg_code'>@{{ i.name }}</option>
                                    </select>
                                    <div class="alert-danger p-1" v-for='i of errors.province'>@{{ i }}</div>
                                </div>
                                
                                <div class="mb-2 col-lg">
                                    <label for="" class='mb-1 text-secondary' >Municipality</label>
                                    <select class="form-select " v-model='employer.municipality' :disabled="employer.province ? false : true" @change='resetAddress("mun")'>
                                        <option v-for='i in ph.city_mun' :value="i" v-if='employer.province && i.prov_code == employer.province.prov_code'>@{{ i.name }}</option>
                                    </select>
                                    <div class="alert-danger p-1" v-for='i of errors.municipality'>@{{ i }}</div>
                                </div>
    
                                <div class="mb-2 col-lg">
                                    <label for="" class='mb-1 text-secondary' >Barangay</label>
                                    <select class="form-select" v-model='employer.barangay' :disabled="employer.municipality ? false : true" @change='resetAddress("brgy")'>
                                        <option v-for='i in ph.barangays' :value="i" v-if='employer.municipality && i.mun_code == employer.municipality.mun_code'>@{{ i.name }}</option>
                                    </select>
                                    <div class="alert-danger p-1" v-for='i of errors.barangay'>@{{ i }}</div>
                                </div>
                            </div>
                            

                       </div>
                       <div class="modal-footer" >
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                            <button type='button' class='btn btn-primary' id='btnUpdateProfile' @click='updateProfile'>
                                <div class='d-inline' v-if='updating'>
                                    <div class="spinner-border spinner-border-sm text-light me-1" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    Updating
                                </div>
                                <span v-if='!updating'><i class='fas fa-check me-1'></i> Update</span> 
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            {{-- edit description form --}}
            <div class="modal fade" id='mdlEditDescription'>
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class='fw-bold'><i class='far fa-edit text-secondary me-2'></i> Edit Description</h5>
                        </div>

                        <div class="modal-body">
                            <div class="mb-2">
                                <label for="" class='fw-bold mb-1'>Company Description</label>
                                <textarea class='form-control' rows="10"  placeholder="write description here" v-model.lazy='employer.description'></textarea>
                                <div class="text-danger p-1" v-for='i of errors.description'>@{{ i }}</div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                            <button type='button' class='btn btn-primary' @click='updateDescription()'>
                                <div class='d-inline' v-if='updating'>
                                    <div class="spinner-border spinner-border-sm text-light me-1" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    Updating
                                </div>
                                <span v-if='!updating'><i class='fas fa-check me-1'></i> Update</span> 
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- set mission form --}}
            <div class="modal fade" id="mdlSetMission">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3">
                        <div class="modal-header">
                            <h5 class="fw-bold">Set Mission</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="fw-bold mb-1">Mission</label>
                                <textarea v-model.lazy="employer.mission" rows="10" class="form-control" :class="errors.mission ? 'is-invalid' : ''"></textarea>
                                <div class="text-danger" v-for="i of errors.mission">@{{ i }}</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-success" @click="setMission">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- set vision form --}}
            <div class="modal fade" id="mdlSetVision">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3">
                        <div class="modal-header">
                            <h5 class="fw-bold">Set Vision</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="fw-bold mb-1">Vision</label>
                                <textarea v-model.lazy="employer.vision" rows="10" class="form-control" :class="errors.vision ? 'is-invalid' : ''"></textarea>
                                <div class="text-danger" v-for="i of errors.vision">@{{ i }}</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-success" @click="setVision">Save</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </body>

    <script src="{{asset('js/pages/employer_profile.js')}}"></script>

@endsection