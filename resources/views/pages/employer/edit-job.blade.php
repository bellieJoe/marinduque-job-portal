@extends('app')
@section('title', '- Jobs')
@section('content')
<link rel="stylesheet" href="{{ asset('css/employer/edit-job.css') }}">
<body class="edit-job">
    <div class=" " id="edit_job">

        <div class="container-lg bg-light my-5 shadow-sm px-4 py-5 ">
            <form action="" method="post" id="formEditJob">
              
                <h5 class="fw-bold mb-3 text-primary">Edit Job details</h5>

                <input class="d-none" type="text" value="{{ $job->job_id }}" id="job_id">

                <div class="row">
                    {{-- job title --}}
                    <div class="col-md mb-3">
                        <label class="fw-bold">Job Title <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" name="job_title" v-model.lazy="job.job_title" :class="errors.job_title ? 'is-invalid' : ''">
                        <div class="text-danger" v-if="errors.job_title" v-cloak>@{{ errors.job_title[0] }}</div>
                    </div>
                    {{-- job type --}}
                    <div class="col-md mb-3">
                        <label class="fw-bold">Job Type<span class="text-danger"> *</span></label>
                        <select name="job_type" class="form-select" v-model.lazy="job.job_type" :class="errors.job_type ? 'is-invalid' : ''">
                            <option value="null">--select one--</option>
                            <option value="full time">Full Time</option>
                            <option value="part time">Part Time</option>
                            <option value="contractual">Contractual</option>
                            <option value="temporary">Temporary</option>
                            <option value="internship">Internship</option>                            
                        </select>
                        <div class="text-danger" v-if="errors.job_type" v-cloak>@{{ errors.job_type[0] }}</div>
                    </div>
                </div>

                {{-- job industry --}}
                <div class="mb-3 ">
                    <label class='fw-bold mb-1'>Job Specialization<span class="text-danger">*</span></label>
                    {{-- <select v-cloak class='form-select' v-model.lazy="job.job_industry" :class="errors.job_industry ? 'is-invalid' : ''" multiple>
                        <option v-cloak v-for="specialization of job_specialization_list" :value="specialization.specialization">@{{ specialization.specialization }}</option>
                    </select> --}}
                    <ul class="list-group  hover:bg-gray-200 cursor-pointer" data-bs-toggle="modal" data-bs-target="#mdlSpecialization">
                        <li class="list-group-item list-group-item-action" v-if="!job.job_specialization[0]">Select Job Specialization</li>
                        <li class="list-group-item list-group-item-action" v-for="specialization of job.job_specialization" v-cloak>@{{ specialization[1] }}</li>
                    </ul>
                    <div class="modal fade" data-bs-backdrop="static" id="mdlSpecialization">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="font-bold">Select Specializations</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="form-check" v-for="specialization of job_specialization_list">
                                        <input class="form-check-input" type="checkbox" :id="specialization.specialization" >
                                        <label class="form-check-label" :for="specialization.specialization" >@{{ specialization.specialization }}</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="setSpecializations">Done</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-danger"  v-for="i of errors.job_specialization" v-cloak>@{{ i }}</div>
                </div>

                {{-- job description --}}
                <div class="col-md-7 mb-5">
                    <label class="fw-bold">Job Description</label>
                    <textarea name="job_description" v-model.lazy="job.job_description" class="form-control" :class="errors.job_description ? 'is-invalid' : ''"></textarea>
                    <div class="text-danger" v-if="errors.job_description" v-cloak>@{{ errors.job_description[0] }}</div>
                </div>

        
                <div class="mb-3">
                    <input type="checkbox" class="form-check-input" v-model.lazy="toggle.useCompanyInformation" id="useCurrentInformation" @change="getCurrentCompany">
                    <label for="useCurrentInformation" class="form-check-label">Use current Company Information</label>
                </div>
                {{-- company name --}}
                <div class="col-md-7 mb-3">
                    <label class="fw-bold">Company Name<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control" name="company_name" v-model.lazy="job.company_name" :class="errors.company_name ? 'is-invalid' : ''">   
                    <div class="text-danger" v-if="errors.company_name" v-cloak>@{{ errors.company_name[0] }}</div>                 
                </div>
                {{-- company address --}}
                <div class="col-md-7 mb-3">
                    <label class="fw-bold">Company Address<span class="text-danger"> *</span></label>
                    <div class="form-control" :class="errors.region || errors.province || errors.municipality ||errors.barangay ? 'is-invalid' : ''">
                        <select name="region" v-model="job.region" class="form-select border-0 mb-2" @change="changeAddress('reg')">
                            <option value="null" class="text-secondary">region</option>
                            <option v-for="i of phil.regions" :value="i" >@{{ i.name }}</option>
                        </select>
                        <select name="province" v-model="job.province" class="form-select border-0 mb-2" @change="changeAddress('prov')">
                            <option value="null" class="text-secondary">province</option>
                            <option v-for="i of phil.provinces" v-if="job.region && job.region.reg_code == i.reg_code" :value="i" >@{{ i.name }}</option>
                        </select>
                        <select name="municipality" v-model="job.municipality" class="form-select border-0 mb-2 " @change="changeAddress('mun')">
                            <option value="null" class="text-secondary">municipality</option>
                            <option v-for="i of phil.city_mun" v-if="job.province && job.province.prov_code == i.prov_code" :value="i" >@{{ i.name }}</option>
                        </select>
                        <select name="barangay" v-model="job.barangay" class="form-select border-0 mb-2">
                            <option value="null" class="text-secondary">barangay</option>
                            <option v-for="i of phil.barangays" v-if="job.municipality && job.municipality.mun_code == i.mun_code" :value="i" >@{{ i.name }}</option>
                        </select>
                    </div>  
                    <div class="text-danger" v-if="errors.region || errors.province || errors.municipality ||errors.barangay" v-cloak>The company address is incomplete</div>                 
                </div>
                <div class="col-md-7 mb-5">
                    <label class="fw-bold">Company Description</label>
                    <textarea name="company_description" v-model.lazy="job.company_description" class="form-control" :class="errors.company_description ? 'is-invalid' : ''"></textarea>
                    <div class="text-danger" v-if="errors.company_description" v-cloak>@{{ errors.company_description[0] }}</div>
                </div>


                <label class="fw-bold mb-3">Qualifications</label>
                {{-- educational attainment --}}
                <div class="col-md-7 mb-3">
                    <input class="form-check-input" type="checkbox" v-model.lazy="toggle.educationalAttainment" id="educationalAttainment" @change="toggleEducationalAttainment">
                    <label for="educationalAttainment" class="fw-bold form-check-label">Educational Attainment</label>
                    <select v-if="toggle.educationalAttainment" name="educational_attainment" v-model.lazy="job.educational_attainment" class="form-select">
                        <option value="null">--select one--</option>
                        <option value="primary education">Elementary Graduate</option>
                        <option value="secondary education">High School Graduate</option>
                        <option value="tertiary education">College Graduate</option>
                        <option value="master's degree">Master's Degree</option>
                        <option value="doctorate degree">Doctorate Degree</option>
                    </select>
                </div>
                {{-- course studied --}}
                <div :class="toggle.courseStudied ?  'col-md-7 mb-2 rounded-md bg-indigo-100 p-2' : ''" v-if="job.educational_attainment == 'tertiary education' || job.educational_attainment == 'master\'s degree' || job.educational_attainment == 'doctorate degree' ">
                    <input class="form-check-input" type="checkbox" v-model.lazy="toggle.courseStudied" id="courseStudied" @change="toggleCourseStudied">
                    <label for="courseStudied" class="fw-bold form-check-label">Course Studied</label>
                    <div class="row" v-if="toggle.courseStudied">
                        <div class="col">
                            <select v-model.lazy="input.courseStudied" class="form-select">
                                <option v-cloak v-if="job.educational_attainment == 'tertiary education'" v-for="course of courses" :value="course">@{{ course }}</option>
                                <option v-cloak v-if="job.educational_attainment == 'master\'s degree'" v-for="course of masters" :value="course">@{{ course }}</option>
                                <option v-cloak v-if="job.educational_attainment == 'doctorate degree'" v-for="course of doctors" :value="course">@{{ course }}</option>     
                            </select>
                        </div>
                        <div class="col-auto" >
                            <button type="button" class="btn btn-primary" @click="addCourse">Add</button>
                        </div>
                    </div>

                    <div class="col-md-7 mb-3" v-if="toggle.courseStudied">
                        <div class="p-2 btn btn-outline-dark m-1" v-for="i of job.course_studied" v-cloak>
                            @{{ i }}
                            <button type="button"  class="" @click="removeCourse(i)">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                {{-- gender --}}
                <div class="col-md-7 mb-3">
                    <input class="form-check-input" type="checkbox" v-model.lazy="toggle.gender" id="gender" @change="toggleGender">
                    <label for="gender" class="fw-bold form-check-label">Gender</label>
                    <select name="gender" v-model.lazy="job.gender" class="form-select" v-if="toggle.gender">
                        <option value="null">--select one--</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                {{-- experience --}}
                <div class="col-md-7 mb-3">
                    <input class="form-check-input" type="checkbox" v-model="toggle.experience" id="experience" @change="toggleExperience" >
                    <label for="experience" class="fw-bold form-check-label">Years of job related experience</label>
                    <div class="input-group" v-if="toggle.experience" >
                        <input type="number" name="experience" class="form-control" v-model.lazy="job.experience" :class="errors.experience ? 'is-invalid' : ''">
                        <label class="input-group-text">year/s</label>
                    </div>
                    <div class="text-danger" v-if="errors.experience" v-cloak>@{{ errors.experience[0] }}</div>
                </div>
                {{-- skills --}}
                <div :class="job.skill[0] ? 'bg-indigo-100 p-1 rounded-md' : ''">
                    <div class="mb-3">
                        <h1 class="font-bold mb-1">Skills</h1>
                        <div class="mb-2 " v-if="job.skill[0] != null" v-cloak>
                            <div class="w-max btn btn-outline-dark p-2 m-1" v-cloak v-for="i of job.skill">
                                <label ><i class="fa fa-check text-green-500"></i> @{{ i }}</label>
                                <button   type="button" class=" hover:text-red-500  text-secondary" @click="removeSkill(i)">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search Skill" v-model.lazy="skillInput" >
                            <span class="input-group-text cursor-pointer" @click="searchSkill"><i class="fa fa-search"></i></span>
                        </div>
                        <ul class="list-group h-min max-h-80 overflow-y-scroll">
                            <li class="list-group-item list-group-item-action" v-for="skill of skills" @click="addSkill(skill)">
                                @{{ skill }}
                            </li>
                            <li class="list-group-item list-group-item-action" v-if="skillSearching">
                                {{-- <img class="block mx-auto w-14" src="{{ asset("image/website/ellipsis-loader.svg") }}" alt="loading"> --}}
                                <?xml version="1.0" encoding="utf-8"?>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="100px" height="100px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                                    <circle cx="84" cy="50" r="10" fill="#93dbe9">
                                        <animate attributeName="r" repeatCount="indefinite" dur="0.6097560975609756s" calcMode="spline" keyTimes="0;1" values="10;0" keySplines="0 0.5 0.5 1" begin="0s"></animate>
                                        <animate attributeName="fill" repeatCount="indefinite" dur="2.4390243902439024s" calcMode="discrete" keyTimes="0;0.25;0.5;0.75;1" values="#93dbe9;#3b4368;#5e6fa3;#689cc5;#93dbe9" begin="0s"></animate>
                                    </circle><circle cx="16" cy="50" r="10" fill="#93dbe9">
                                    <animate attributeName="r" repeatCount="indefinite" dur="2.4390243902439024s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;10;10;10" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="0s"></animate>
                                    <animate attributeName="cx" repeatCount="indefinite" dur="2.4390243902439024s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="0s"></animate>
                                    </circle><circle cx="50" cy="50" r="10" fill="#689cc5">
                                    <animate attributeName="r" repeatCount="indefinite" dur="2.4390243902439024s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;10;10;10" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.6097560975609756s"></animate>
                                    <animate attributeName="cx" repeatCount="indefinite" dur="2.4390243902439024s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.6097560975609756s"></animate>
                                    </circle><circle cx="84" cy="50" r="10" fill="#5e6fa3">
                                    <animate attributeName="r" repeatCount="indefinite" dur="2.4390243902439024s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;10;10;10" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-1.2195121951219512s"></animate>
                                    <animate attributeName="cx" repeatCount="indefinite" dur="2.4390243902439024s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-1.2195121951219512s"></animate>
                                    </circle><circle cx="16" cy="50" r="10" fill="#3b4368">
                                    <animate attributeName="r" repeatCount="indefinite" dur="2.4390243902439024s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;10;10;10" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-1.8292682926829267s"></animate>
                                    <animate attributeName="cx" repeatCount="indefinite" dur="2.4390243902439024s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-1.8292682926829267s"></animate>
                                    </circle>
                                <!-- [ldio] generated by https://loading.io/ -->
                                </svg>
                            </li>
                            <li class="list-group-item list-group-item-action" v-if="skills.length == 0 && skillInput && !skillSearching">
                                <h1 class="text-center">No Result</h1>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- other quilification --}}
                <div :class="job.other_qualification ? 'col-md-7 mb-2 bg-indigo-100 rounded-md p-2' : 'col-md-7'">
                    <label class="fw-bold ">Other Qualifications</label>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" v-model.lazy="input.otherQualification">
                        </div>
                        <div class="col-auto" >
                            <button type="button" class="btn btn-primary" @click="addQualification">Add</button>
                        </div>
                    </div>

                    <div class="col-md-7 mt-2  mb-2" v-if="job.other_qualification">
                        <div class="btn btn-outline-dark m-1"  v-for="i of job.other_qualification" v-cloak>
                            <i class="fa fa-check text-green-500 m-1 inline-block"></i> @{{ i }} 
                            <button type="button"class="text-secondary" @click="removeQualification(i)">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                

                <br>
                <div class="col-md-7 mb-3">
                    <label class="fw-bold">Monthly Salary</label>
                    <div class="row">
                        <div class="col">
                            <div class="input-group ">
                                <label class="input-group-text">Min</label>
                                <input type="number" class="form-control" v-model.lazy="job.salary_min" :class="errors.salary_min ? 'is-invalid' : ''">
                            </div>
                            <div class="text-danger" v-if="errors.salary_min" v-cloak>@{{ errors.salary_min[0] }}</div>
                        </div>
                        <div class="col">
                            <div class="input-group">
                                <label class="input-group-text">Max</label>
                                <input type="number" class="form-control" v-model.lazy="job.salary_max" :class="errors.salary_max ? 'is-invalid' : ''">
                            </div> 
                            <div class="text-danger" v-if="errors.salary_max" v-cloak>@{{ errors.salary_max[0] }}</div>
                        </div>                       
                    </div>
                </div>
                <div class="col-md-7 mb-3">
                    <label class="fw-bold">Benefits</label>
                    <textarea class="form-control" name="job_benefits" v-model.lazy="job.benefits" :class="errors.benefits ? 'is-invalid' : ''"></textarea>
                    <div class="text-danger" v-if="errors.benefits" v-cloak>@{{ errors.benefits[0] }}</div>
                </div>

                <div class="row">
                    <div class="col-auto ms-auto me-0">
                        <a href="/employer/job" class="btn btn-secondary">Cancel</a>
                        <button type="button" class="btn btn-success" @click="updateJob">Save changes</button>
                    </div>
                </div>

           



            </form>
        </div>

        {{-- loading --}}
        <div v-if="loading">
            @component('components.loading')
                
            @endcomponent
        </div>
        

    </div>
</body>
<script src="{{ asset('js/pages/employer/edit-job.js') }}"></script>
@endsection