@extends('app')
@section('title', '- Post Jobs')
@section('content') 
    <link rel="stylesheet" href="{{ asset('css/employer/post-job.css') }}">    
    <body class='post-job bg-gray-200'>


        <div class="" id="post-job">

            <div v-if="loading">
                @component('components.loading')
                @endcomponent
            </div>

            <div class="pj-form bg-gray-50  my-5 shadow-md rounded-md lg:w-8/12 mx-auto p-2 " >
                <h5 class='font-bold mb-3 p-4 text-lg text-indigo-800'><i class="fas fa-briefcase me-1"></i>Create a Job</h5>
                <form action="/employer/post-job/add-job" method="post" id="formPostJob">
                    @csrf

                    <h5 id="step-1" class="fw-bold text-secondary "><span class="bg-secondary fs-6 text-white ps-4 p-2 shadow-sm me-2">Step 1 </span>  Basic Information</h5>
                    <div class="p-4" >
                        {{-- job title --}}
                        <div class="mb-3 lg:inline-block lg:w-64 lg:mr-3">
                            <label for="" class='fw-bold mb-1'>Job Title<span class="text-danger">*</span></label>
                            <input type="text" class='form-control' v-model.lazy="job.job_title" :class="errors.job_title ? 'is-invalid' : ''">
                            <div  class="text-danger" v-for="i of errors.job_title" v-cloak>@{{ i }}</div>
                        </div>
                        {{-- job indnustry --}}
                        <div class="mb-3 lg:inline-block lg:w-64 lg:mr-3">
                            <label class='fw-bold mb-1'>Job Industry<span class="text-danger">*</span></label>
                            <select v-cloak class='form-select' v-model.lazy="job.job_industry" :class="errors.job_industry ? 'is-invalid' : ''" >
                                <option v-cloak v-for="specialization of job_specialization_list" :value="specialization.specialization">@{{ specialization.specialization }}</option>
                            </select>
                            <div class="text-danger"  v-for="i of errors.job_industry" v-cloak>@{{ i }}</div>
                        </div>
                        {{-- job type --}}
                        <div class="mb-3 lg:inline-block lg:w-64">
                            <label class='fw-bold mb-1'>Job Type<span class="text-danger">*</span></label>
                            <select class='form-select' v-model.lazy="job.job_type" :class="errors.job_type ? 'is-invalid' : ''"> 
                                {{-- <option value="null" class='p-3'>--select job type--</option> --}}
                                <option value="full time">Full Time</option>
                                <option value="part time">Part Time</option>
                                <option value="contractual">Contractual</option>
                                <option value="temporary">Temporary</option>
                                <option value="internship">Internship</option>
                            </select>
                            <div class="text-danger" v-for="i of errors.job_type" v-cloak>@{{ i }}</div>
                        </div>
                        {{-- job description --}}
                        <div class="mb-3">
                            <label class='fw-bold mb-1'>Job Description</label>
                            <textarea rows="5" class='form-control' v-model.lazy="job.job_description" :class="errors.job_description ? 'is-invalid' : ''"></textarea>
                            <div class="text-danger" v-for="i of errors.job_description" v-cloak>@{{ i }}</div>
                        </div>
                    </div>
                    

                    <h5 id="step-2" class="fw-bold text-secondary"><span class="bg-secondary fs-6 text-white p-2 shadow-sm me-2 ps-4 ">Step 2 </span>  Company Information</h5>
                    <div class="p-4" >
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="toggleUseCurrent"  @change="toggleUserCurrentInformation" v-model.lazy="job.useCurrentInformation">
                            <label class="form-check-label" for="toggleUseCurrent">
                              Use my current company Information
                            </label>
                        </div>
                        {{-- company name --}}
                        <div class="mb-3">
                            <label for="" class='fw-bold mb-1'>Company Name<span class="text-danger">*</span></label>
                            <input type="text" class='form-control' v-model.lazy="job.company_name" :class="errors.company_name ? 'is-invalid' : ''">
                            <div class="text-danger" v-for="i of errors.company_name" v-cloak>@{{ i }}</div>
                        </div>
                        {{-- company address --}}
                        <div class="mb-3">
                            <label for="" class='fw-bold mb-1'>Company Address<span class="text-danger">*</span></label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox"  id="inputOverseas" @input="inputOverseas_changed">
                                <label for="inputOverseas" class="form-check-label">Is this job overseas?</label>
                            </div>
                            
                            {{-- local address --}}
                            <div  v-if="job.isLocal">
                                <div class="form-control mb-2" :class="errors.region || errors.province || errors.municipality || errors.barangay ? 'is-invalid' : ''">
                                    <div >
                                        {{-- region --}}
                                        <select class='form-select  border-0 d-block my-1' id="region"  @change="toggleAddress('reg')" v-model.lazy="job.company_address.region" >
                                            <option value="null" class="text-secondary" >Region</option>
                                            <option 
                                            v-for="i of phil.regions" 
                                            :value="i" >
                                                @{{ i.name }}
                                            </option>
                                        </select>
                                        {{-- province --}}
                                        <select class='form-select border-0 d-block my-1' placeholder="/ province" v-model.lazy="job.company_address.province" :disabled="job.company_address.region  ? false : true"  @change="toggleAddress('prov')" >
                                            <option value="null" class="text-secondary" selected>Province</option>
                                            <option 
                                            v-for="i of phil.provinces" 
                                            :value="i" 
                                            v-if="job.company_address.region && job.company_address.region.reg_code == i.reg_code"
                                            >
                                                @{{ i.name }}
                                            </option>
                                        </select>
                                        {{-- municipality --}}
                                        <select class='form-select border-0 col my-1' placeholder="/ municipality" v-model.lazy="job.company_address.municipality"  :disabled="job.company_address.province  ? false : true"  @change="toggleAddress('mun')" >
                                            <option value="null" class="text-secondary" selected>Municipality</option>
                                            <option 
                                            v-for="i of phil.city_mun" 
                                            :value="i" 
                                            v-if="job.company_address.province && job.company_address.province.prov_code == i.prov_code"
                                            >
                                                @{{ i.name }}
                                            </option>
                                        </select>
                                        {{-- barangay --}}
                                        <select class='form-select border-0 col my-1' placeholder="/ brgy" v-model.lazy="job.company_address.barangay"  :disabled="job.company_address.municipality  ? false : true">
                                            <option value="null" class="text-secondary" selected>Baranggay</option>
                                            <option 
                                            v-for="i of phil.barangays" 
                                            :value="i" 
                                            v-if="job.company_address.municipality && job.company_address.municipality.mun_code == i.mun_code"
                                            >
                                            @{{ i.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-danger" v-if="errors.region || errors.province || errors.municipality || errors.barangay" v-cloak>The company address is incomplete</div>
                            </div>
                            {{-- overseas --}}
                            <div v-cloak v-if="!job.isLocal" class="mb-2">
                                <label >Select Country</label>
                                <select class="form-select" v-model="job.country">
                                    <option v-for="country of countries" v-if="country != 'Philippines'" :value="country">@{{ country }}</option>
                                </select>
                                <div class="text-danger" v-for="i of errors.isLocal" v-cloak>@{{ i }}</div>
                            </div>
                        </div>
                        {{-- company description --}}
                        <div class="mb-3">
                            <label for="" class='fw-bold mb-1' >About the Company</label>
                            <textarea rows="5" class='form-control' v-model.lazy="job.company_description" name="company_description" :class="errors.company_description ? 'is-invalid' : '' "></textarea>
                            <div class="text-danger" v-for="i of errors.company_description" v-cloak>@{{ i }}</div>
                        </div>
                    </div>

                    {{-- qualifications --}}
                    <h5 id="step-3" class="fw-bold text-secondary"><span class="bg-secondary fs-6 text-white p-2 shadow-sm me-2 ps-4 ">Step 3 </span>  Qualifications</h5>
                    <div class="p-4" >
                        {{-- educational attainment --}}
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"  id="flexCheckDefault2" v-model.lazy="job.toggleEducationalAttainment">
                                <label for="flexCheckDefault2" class='form-check-label fw-bold mb-1'>Educational Attainment</label>
                            </div>
                            <select class="form-select " v-model.lazy="job.educational_attainment" v-if="job.toggleEducationalAttainment" @change="changeEducationalAttainment">
                                {{-- <option value="">--select one--</option> --}}
                                <option value="primary education">Primary Education/Elementary</option>
                                <option value="secondary education">Secondary Education/High School</option>
                                <option value="tertiary education">Tertiary Education/College</option>
                                <option value="master's degree">Master's Degree</option>
                                <option value="doctorate degree">Doctorate Degree</option>
                            </select>
                        </div>
                        {{-- course studied --}}
                        <div class="mb-4" v-if="job.educational_attainment == 'tertiary education' || job.educational_attainment == 'master\'s degree' || job.educational_attainment == 'doctorate degree' " :class="job.course_studied[0] ? 'bg-indigo-100 rounded-md p-1' : ''">
                            <div class="form-check ">
                                <input class="form-check-input" type="checkbox"  id="flexCheckDefault4" v-model.lazy="job.toggleCourseStudied" @change="toggleCourseStudied" name="course_studied">
                                <label for="flexCheckDefault4" class='form-check-label fw-bold mb-1'>Course Studied</label>
                            </div>
                            <div class="row" v-if="job.toggleCourseStudied" v-cloak>
                                <div class="col" v-cloak>
                                    <select class="form-select" v-model.lazy="job.inputCourseStudied">
                                        <option v-cloak v-if="job.educational_attainment == 'tertiary education'" v-for="course of courses" :value="course">@{{ course }}</option>
                                        <option v-cloak v-if="job.educational_attainment == 'master\'s degree'" v-for="course of masters" :value="course">@{{ course }}</option>
                                        <option v-cloak v-if="job.educational_attainment == 'doctorate degree'" v-for="course of doctors" :value="course">@{{ course }}</option>
                                    </select>
                                </div>
                                <div class="col-auto" v-cloak>
                                    <button v-cloak type="button" class="btn btn-primary font-bold" @click="addCourse">Add</button>
                                </div>
                                <div class="mt-2">
                                    <div  v-for="i of job.course_studied"  class="btn border-1 btn-outline-dark m-2"  >
                                        @{{ i }}
                                        <button class="" @click="removeCourse(i)"><i class="fa fa-times"></i></button>
                                    </div>
                                    <div v-cloak class="text-danger" v-for="i of errors.course_studied">@{{ i }}</div>
                                </div>
                            </div>
                        </div>
                        {{-- gender --}}
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"  id="flexCheckDefault3" v-model.lazy="job.toggleGender">
                                <label for="flexCheckDefault3" class='form-check-label fw-bold 1'>Gender</label>
                            </div>
                            <select class="form-select" v-model.lazy="job.gender" v-if="job.toggleGender">
                                <option value="">--select one--</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        {{-- experience --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"  id="flexCheckDefault5" v-model.lazy="job.toggleExperience">
                                <label for="flexCheckDefault5" class='form-check-label fw-bold mb-1'>Years of experience</label>
                            </div>
                            <input type="number" class="form-control" v-model.lazy="job.experience"  v-if="job.toggleExperience" :class="errors.experience ? 'is-invalid' : ''">
                            <div class="text-danger" v-for="i of errors.experience" v-cloak>@{{ i }}</div>
                        </div>
                        {{-- skill --}}
                        <div :class="job.skill[0] ? 'bg-indigo-100 p-1 rounded-md' : ''">
                            <div class="mb-3">
                                <h1 class="font-bold mb-1">Skills</h1>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" v-model.lazy="job.inputSkill" >
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-primary fw-bold" @click="addSkill">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2 " v-if="job.skill[0] != null" v-cloak>
                                <div class="w-max btn btn-outline-dark p-2 m-1" v-cloak v-for="i of job.skill">
                                    <label ><i class="fa fa-check text-green-500"></i> @{{ i }}</label>
                                    <button   type="button" class=" hover:text-red-500  text-secondary" @click="removeSkill(i)">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
        
                        {{-- other qualifications --}}
                        <div :class="job.other_qualification[0] ? 'bg-indigo-100 p-1 rounded-md mt-2' : ''">
                            <div class="mb-3">
                                <label class='form-check-label fw-bold mb-1'>Other qualifications</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" v-model.lazy="job.inputOtherQualification" >
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-primary fw-bold" @click="addQualification">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2" v-if="job.other_qualification[0] != null" v-cloak>
                                <div class="w-max inline-block m-1 btn btn-outline-dark" v-for="i of job.other_qualification">
                                    <i class="fa fa-check text-green-500"></i> @{{ i }}
                                    <button data-bs-toggle="tooltip" data-bs-placement="top" title="Click to remove"  type="button" class="text-secondary " @click="removeQualification(i)">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- salary range --}}
                    <h5 id="step-4" class="fw-bold text-secondary"><span class="bg-secondary fs-6 text-white p-2 shadow-sm me-2 ps-4 ">Step 4 </span>  Miscellaneous</h5>
                    <div class="p-4">
                        <div class="mb-3">
                            <label for="" class='fw-bold'>Salary range</label>
                            <div class="row">
                                <div class="col">
                                    <label>Min</label>
                                    <div class="input-group">
                                        <label class='input-group-text'>₱</label> 
                                        <input type="number" class='form-control' v-model.lazy="job.salary_range.min" :class="errors.salary_min ? 'is-invalid' : ''">
                                        <div class="text-danger" v-for="i of errors.salary_min" v-cloak>@{{ i }}</div>
                                    </div>
                                </div>
                                
                                <div class="col">
                                    <label>Max</label>
                                    <div class="input-group">
                                        <label class='input-group-text'>₱</label>
                                        <input type="number" class='form-control' v-model.lazy="job.salary_range.max" :class="errors.salary_max ? 'is-invalid' : ''">
                                        <div class="text-danger" v-for="i of errors.salary_max" v-cloak>@{{ i }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="fw-bold">Benefits</label>
                            <textarea  class="form-control" v-model.lazy="job.job_benefits" name="benefits"></textarea>
                            <div class="text-danger" v-for="i of errors.benefits" v-cloak>@{{ i }}</div>
                        </div>
                    </div>

                    {{-- mark as open --}}
                    <div class="p-4 ">
                        <div class="row">
                            <div class="form-check form-switch col ms-2">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"  v-model.lazy="job.status">
                                <label class="form-check-label fw-bold" for="flexSwitchCheckDefault">Mark as open</label>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-success btn-lg" @click="postJob">Submit</button>
                            </div>
                        </div>
                    </div>                    

                </form>
            </div>
        </div>

        <script src="{{ asset('js/pages/employer/post-job.js') }}" ></script>

       
        
    </body>
    

@endsection