import phil from 'phil-reg-prov-mun-brgy'
import $ from "jquery"
import { indexOf } from 'lodash';
import devModule from '../../dev_module'


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

new Vue({
    el: '#post-job',
    data:{
        loading: false,
        phil: phil,
        errors: [],
        job_specialization_list: null,
        courses: null,
        masters: null,
        doctors: null,
        countries : devModule.countryList,
        skillInput: null,
        skillSearching: false,
        skills: [],
        job: {
            job_title: null,
            job_type: null,
            job_industry: 'remove job industry',
            job_specialization : [],
            job_description: null,

            useCurrentInformation: false,
            company_name: null,
            company_address: {
                region: null,
                province: null,
                municipality: null,
                barangay: null
            },
            company_description: null,

            toggleEducationalAttainment: 0,
            educational_attainment: null,
            toggleCourseStudied: 0,
            course_studied: [],
            inputCourseStudied: null,
            toggleGender: 0,
            gender: null,
            toggleExperience: 0,
            experience: null,
            other_qualification: [],
            inputOtherQualification: null,
            skill: [],
            isLocal: true,
            isGovernment: false,
            country: null,
            inputSkill: null,
            
            salary_range: {
                max: null,
                min: null
            },
            job_benefits:  null,
            status: 1

        }


    },
    methods: {
         async searchSkill(){
            try {
                this.skillSearching = true
                this.skills = []
                // console.log(this.skillInput)
                if(this.skillInput){
                    let res = await $.ajax({
                        url: `/skills?search=${this.skillInput.replace(" ", "%%")}`,
                        method: "get"
                    })
                    JSON.parse(res).data.forEach(el => {
                        // console.log(el.name)
                        this.skills.push(el.name)
                    })
                }
                
                this.skillSearching = false
            } catch (error) {
                this.skillSearching = false
                console.log(error)
            }
        },

        inputOverseas_changed () {
            this.job.isLocal =  !$("#inputOverseas")[0].checked
        },

        inputGovernment_changed(){
            this.job.isGovernment = $("#inputGovernment")[0].checked
        },

        async toggleUserCurrentInformation(){
            console.log(this.job.useCurrentInformation)
            try {

                const res = await $.ajax({
                    url: "/employer/post-job/get-company-information",
                    method: "post",
                })

                this.job.company_name = res.company_name
                this.job.company_description = res.description
                    
                if(res.address){
                    var address = JSON.parse(res.address)
                    this.job.company_address = {
                        region: address.region,
                        province: address.province,
                        municipality: address.municipality,
                        barangay: address.barangay
                    }
                }
            } catch (error) {
                console.log(error)
            }
            

        },

        toggleAddress(sec){
            if(sec == "reg"){
                this.job.company_address.province = null
                this.job.company_address.municipality = null
                this.job.company_address.barangay = null
            }else if(sec == "prov"){
                this.job.company_address.municipality = null
                this.job.company_address.barangay = null
            }else if(sec == "mun"){
                this.job.company_address.barangay = null
            }
        },

        changeEducationalAttainment(){
            if(this.job.educational_attainment != "tertiary education"){
                this.course_studied = []
            }
        },

        addCourse(){
            if(this.job.inputCourseStudied){
                this.job.course_studied.push(this.job.inputCourseStudied)
                this.job.inputCourseStudied = null
            }
            
        },

        addQualification(){
            if(this.job.inputOtherQualification){
                this.job.other_qualification.push(this.job.inputOtherQualification)
            }
            this.job.inputOtherQualification = null
        },

        toggleCourseStudied(){
            if(this.job.toggleCourseStudied == false){
                this.job.course_studied = []
            }
        },

        removeCourse(name){
            // console.log(name)
            this.job.course_studied.splice(this.job.course_studied.indexOf(name), 1)
        },
        
        removeQualification(val){
            this.job.other_qualification.splice(this.job.other_qualification.indexOf(val), 1)
        },

        async postJob(){
            // console.log(loading)
            // loading.show()
            this.loading = true
            try {
                this.errors = []
                $('#errorMessage').css('display', 'initial')
                var job = {
                    job_title : this.job.job_title,
                    job_industry : this.job.job_industry,
                    job_specialization : this.job.job_specialization,
                    job_type : this.job.job_type,
                    job_description : this.job.job_description,
        
                    company_name : this.job.company_name,
                    region : this.job.company_address.region,
                    province : this.job.company_address.province,
                    municipality : this.job.company_address.municipality,
                    barangay :this.job.company_address.barangay,
                    company_description : this.job.company_description,
                    isLocal: this.job.isLocal,
                    isLocal: this.job.isGovernment,
                    country: this.job.country,
        
                    educational_attainment : this.job.educational_attainment,
                    gender: this.job.gender,
                    course_studied : this.job.course_studied,
                    experience : this.job.experience,
                    other_qualification : this.job.other_qualification,
                    skill: this.job.skill,
        
                    salary_max : this.job.salary_range.max,
                    salary_min : this.job.salary_range.min,
                    benefits : this.job.job_benefits,
                    status : this.job.status,
                }
                
                console.log(job);
                await $.ajax({
                    url:  '/employer/post-job/add-job',
                    method: 'post',
                    data: job,

                })
                
                location.href = "/employer/profile"
                this.loading = false

            } catch (error) {
                console.log(error)
                this.loading = false
                // alert(JSON.stringify(error))
                this.errors = error.responseJSON.errors
            }
            this.loading = false

        },

        addSkill(skill){
            if(skill && skill.trim() != ""){

                this.job.skill.push(skill)
                this.skillInput = null 
                this.skills = []

            }
        },

        removeSkill(a){

            this.job.skill.map((val, i)=>{
                if(val == a){
                    this.job.skill.splice(i, 1)
                }
            })
        },

        async getSpecializations(){
            try {
                let spec = await $.ajax({
                    url: '/job_specializations',
                    method: "get"
                })

                this.job_specialization_list = spec.length > 0 ? spec : null
            } catch (error) {
                console.log(error)
            }
        },

        async getCourses(){
            try {
                let masters = []
                let doctors = []
                let bachelors = []
                let courses = await $.ajax({
                    url: "/courses",
                    method: "get"
                })

                courses.map((val, i) => { 
                    switch (val.course_type) {
                        case "bachelor":
                            bachelors.push(val.course)
                            break
                        case "master":
                            masters.push(val.course)
                            break
                        case "doctor":
                            doctors.push(val.course)
                            break
                    }
                }) 

                this.courses = bachelors.length > 0 ? bachelors : null
                this.doctors = doctors.length > 0 ? doctors  : null
                this.masters = masters.length > 0 ? masters : null

            } catch (error) {
                console.log(error)
            }
        },

        setSpecializations(){
            this.job.job_specialization = []
            this.job_specialization_list.forEach(el => {
                let spc = document.getElementById(el.specialization)
                if(spc.checked){
                    this.job.job_specialization.push([el.job_specialization_id, el.specialization])
                }
            })
        }
        
    },

    mounted() {
        this.getSpecializations()
        this.getCourses()
    },
})




