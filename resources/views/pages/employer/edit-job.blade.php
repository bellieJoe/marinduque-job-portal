@extends('app')
@section('title', '- Jobs')
@section('content')
<link rel="stylesheet" href="{{ asset('css/employer/edit-job.css') }}">
<body class="edit-job">
    <div class="wrapper container-lg" id="edit_job">

        <div class="bg-light my-5 shadow-sm px-4 py-5 ">
            
            <form action="" method="post" id="formEditJob">
                {{-- @csrf --}}
                <h5 class="fw-bold mb-3 text-primary">Edit Job details</h5>

                <input class="d-none" type="text" value="{{ $job->job_id }}" id="job_id">

                <div class="row">
                    <div class="col-md mb-3">
                        <label class="fw-bold">Job Title <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" name="job_title" v-model.lazy="job.job_title" :class="errors.job_title ? 'is-invalid' : ''">
                        <div class="text-danger" v-if="errors.job_title" v-cloak>@{{ errors.job_title[0] }}</div>
                    </div>
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
                    <div class="col-md mb-3">
                        <label class="fw-bold">Job Industry<span class="text-danger"> *</span></label>
                        <select name="job_industry" class="form-select" v-model.lazy="job.job_industry" :class="errors.job_industry ? 'is-invalid' : ''">
                            <option value="null">--choose one--</option>
                            <option v-for="spec of specializations" :value="spec">@{{ spec }}</option>                  
                        </select>
                        <div class="text-danger" v-if="errors.job_industry" v-cloak>@{{ errors.job_industry[0] }}</div>
                    </div>
                </div>
                <div class="col-md-7 mb-5">
                    <label class="fw-bold">Job Description</label>
                    <textarea name="job_description" v-model.lazy="job.job_description" class="form-control" :class="errors.job_description ? 'is-invalid' : ''"></textarea>
                    <div class="text-danger" v-if="errors.job_description" v-cloak>@{{ errors.job_description[0] }}</div>
                </div>


                <div class="mb-3">
                    <input type="checkbox" class="form-check-input" v-model.lazy="toggle.useCompanyInformation" id="useCurrentInformation" @change="getCurrentCompany">
                    <label for="useCurrentInformation" class="form-check-label">Use current Company Information</label>
                </div>
                <div class="col-md-7 mb-3">
                    <label class="fw-bold">Company Name<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control" name="company_name" v-model.lazy="job.company_name" :class="errors.company_name ? 'is-invalid' : ''">   
                    <div class="text-danger" v-if="errors.company_name" v-cloak>@{{ errors.company_name[0] }}</div>                 
                </div>
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
                <div class="col-md-7 mb-3">
                    <input class="form-check-input" type="checkbox" v-model.lazy="toggle.educationalAttainment" id="educationalAttainment" @change="toggleEducationalAttainment">
                    <label for="educationalAttainment" class="fw-bold form-check-label">Educational Attainment</label>
                    <select v-if="toggle.educationalAttainment" name="educational_attainment" v-model.lazy="job.educational_attainment" class="form-select">
                        <option value="null">--select one--</option>
                        <option value="primary education">Elementary Graduate</option>
                        <option value="secondary education">High School Graduate</option>
                        <option value="tertiary education">College Graduate</option>
                    </select>
                </div>
                <div class="col-md-7 mb-2" v-if="job.educational_attainment == 'tertiary education'">
                    <input class="form-check-input" type="checkbox" v-model.lazy="toggle.courseStudied" id="courseStudied" @change="toggleCourseStudied">
                    <label for="courseStudied" class="fw-bold form-check-label">Course Studied</label>
                    <div class="row" v-if="toggle.courseStudied">
                        <div class="col">
                            <select v-model.lazy="input.courseStudied" class="form-select">
                                <option value="null">--select one--</option>
                                <option v-for="course of courses" :value="course">@{{ course }}</option>      
                            </select>
                        </div>
                        <div class="col-auto" >
                            <button type="button" class="btn btn-primary" @click="addCourse">add</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 mb-3" v-if="toggle.courseStudied">
                    <div class="card p-2">
                        <label for="">Must have studied atleast one of the following courses:</label>
                        <button type="button" v-for="i of job.course_studied" class="btn btn-outline-secondary text-start border-0" @click="removeCourse(i)">@{{ i }} <span class="text-white fw-light ms-5"><i>click to remove</i></span></button>
                    </div>
                </div>
                <div class="col-md-7 mb-3">
                    <input class="form-check-input" type="checkbox" v-model.lazy="toggle.gender" id="gender" @change="toggleGender">
                    <label for="gender" class="fw-bold form-check-label">Gender</label>
                    <select name="gender" v-model.lazy="job.gender" class="form-select" v-if="toggle.gender">
                        <option value="null">--select one--</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="col-md-7 mb-3">
                    <input class="form-check-input" type="checkbox" v-model="toggle.experience" id="experience" @change="toggleExperience" >
                    <label for="experience" class="fw-bold form-check-label">Years of job related experience</label>
                    <div class="input-group" v-if="toggle.experience" >
                        <input type="number" name="experience" class="form-control" v-model.lazy="job.experience" :class="errors.experience ? 'is-invalid' : ''">
                        <label class="input-group-text">year/s</label>
                    </div>
                    <div class="text-danger" v-if="errors.experience" v-cloak>@{{ errors.experience[0] }}</div>
                </div>
                <div class="col-md-7 mb-2">
                    <label class="fw-bold ">Other Qualifications</label>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" v-model.lazy="input.otherQualification">
                        </div>
                        <div class="col-auto" >
                            <button type="button" class="btn btn-primary" @click="addQualification">add</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 mb-5" v-if="job.other_qualification">
                    <div class="card p-2" >
                        <button type="button" v-for="i of job.other_qualification" class="btn btn-outline-secondary mb-2 border-0 text-start" @click="removeQualification(i)">• @{{ i }} <span class="text-white fw-light ms-5"><i>click to remove</i></span></button>
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
        

    </div>



    {{-- modal loading --}}
    <div class="modal fade" id="mdlLoading"  tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="spinner-border text-white mx-auto" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/pages/employer/edit-job.js') }}"></script>
@endsection