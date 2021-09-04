import $ from "jquery"
import philippines from "phil-reg-prov-mun-brgy"

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});


const loading = new bootstrap.Modal(document.getElementById("mdlLoading"),{
    backdrop: "static",
    keyboard: false
})


new Vue({
    el: "#edit_job",
    data: {
        phil : philippines,
        job_data: null,
        errors : [],
        job:{
            job_title: null,
            job_type: null,
            job_industry: null,
            job_description: null,

            company_name:  null,
            region: null,
            province: null,
            municipality: null,
            barangay: null,

            educational_attainment: null,
            course_studied: [],
            gender: null,
            experience: null,
            other_qualification: null,

            salary_max: null,
            salary_min: null,
            benefits: null,
            status: null
        },
        toggle:{
            useCompanyInformation: false,
            educationalAttainment: false,
            courseStudied: false,
            gender: false,
            experience: false,
            status: 0
        },
        input:{
            courseStudied: null,
            otherQualification: null,
        }
    },
    methods: {

        removeCourse(name){
            this.job.course_studied.splice(this.job.course_studied.indexOf(name), 1)
        },

        addCourse(){
            var isDuplicate = false
            this.job.course_studied.map((val, i)=>{
                if(this.input.courseStudied == val){
                    isDuplicate = true
                }
            })

            if(!isDuplicate){
                this.job.course_studied.push(this.input.courseStudied)
            }

            this.input.courseStudied = null
        },

        addQualification(){
            if(!this.job.other_qualification){
                this.job.other_qualification = []
            }
            if(this.input.otherQualification){
                this.job.other_qualification.push(this.input.otherQualification)
                this.input.otherQualification = null
            }    
        },

        removeQualification(name){
            this.job.other_qualification.splice(this.job.other_qualification.indexOf(name), 1)
        },

        getCurrentCompany(){
            if(this.toggle.useCompanyInformation){
                $.ajax({
                    url: "/employer/post-job/get-company-information",
                    method: "post",
                }).fail((res)=>{
                    location.href ="/error"
                }).done((res)=>{
                    console.log(res)
                    this.job.company_name = res.company_name
                    this.job.company_description = res.description
                    
                    if(res.address){
                        var address = JSON.parse(res.address)
                        this.job.region = address.region
                        this.job.province = address.province
                        this.job.municipality = address.municipality
                        this.job.barangay = address.barangay
                    }
                })
            }else{
                var address = JSON.parse(this.job_data.company_address)
                this.job.company_name = this.job_data.company_name
                this.job.description = this.job_data.job_description
                this.job.region = address.region
                this.job.province = address.province
                this.job.municipality = address.municipality
                this.job.barangay = address.barangay
            }
        },

        toggleEducationalAttainment(){
            if(!this.toggle.educationalAttainment){
                this.job.educational_attainment = null
                this.job.course_studied = []
                this.toggle.courseStudied = false
            }else{
                this.job.educational_attainment = this.job_data.educational_attainment
                this.job.course_studied = this.job_data.course_studied ? JSON.parse(this.job_data.course_studied) : null
                this.toggle.courseStudied = this.job_data.course_studied ? true : false
            }
        },

        toggleGender(){
            console.log("Gender toggled", this.toggle.gender)
            if(this.toggle.gender){
                this.job.gender = this.job_data.gender
            }else{
                this.job.gender = null
            }
        },

        toggleExperience(){
            console.log(this.toggle.experience)
            if(this.toggle.experience){
                this.job.experience = this.job_data.experience
            }else{
                this.job.experience = null
                
            }
        },

        toggleCourseStudied(){
            if(this.toggle.courseStudied){
                this.job.course_studied = []
            }else{
                this.job.course_studied = this.job_data.course_studied
            }
        },

        changeAddress(level){
            if(level == "reg"){
                this.job.province = null
                this.job.municipality = null
                this.job.barangay = null
            }else if(level == "prov"){
                this.job.municipality = null
                this.job.barangay = null
            }else{
                this.job.barangay = null
            }
        },

        updateJob(){
            console.log(this.job)
            loading.show()
            $.ajax({
                url: `/employer/job/update-job/${this.job_data.job_id}`,
                method: "post",
                data: this.job,
                statusCode: {
                    500: ()=>{
                        location.href = "/error"
                    }
                }
            }).fail((res)=>{
                // console.log(res)
                setTimeout(() => {
                    loading.hide()
                }, 1000);
                this.errors = res.responseJSON.errors
            }).done((res)=>{
                // console.log(res)
                location.href = "/employer/job"
            })
        }
        
    },

    beforeCreate() {
        loading.show()
        $.ajax({
            url: `/employer/job/get-job/${$("#job_id").val()}`,
            method: "post"
        }).fail((res)=>{
            setTimeout(() => {
                loading.hide()
            }, 2000);
            console.log(res)
        }).done((res)=>{
            setTimeout(() => {
                loading.hide()
            }, 2000);
            console.log(res)
            this.job_data = res
            var address = JSON.parse(res.company_address)
            this.toggle = {
                useCompanyInformation: false,
                educationalAttainment: res.educational_attainment ? true : false,
                courseStudied: res.course_studied ? true : false,
                gender: res.gender ? true : false,
                experience: res.experience ? true : false,
                status: res.status == 'open' ? true : false
            }
            this.job = {
                job_title: res.job_title,
                job_type: res.job_type,
                job_industry: res.job_industry,
                job_description: res.job_description,

                company_name:  res.company_name,
                region: address.region,
                province: address.province,
                municipality: address.municipality,
                barangay: address.barangay,

                educational_attainment: res.educational_attainment,
                course_studied: res.course_studied ? JSON.parse(res.course_studied) : [],
                gender: res.gender,
                experience: res.experience,
                other_qualification: res.other_qualification ? JSON.parse(res.other_qualification) : null,

                salary_max: res.salary_range ? JSON.parse(res.salary_range).max : null,
                salary_min: res.salary_range ? JSON.parse(res.salary_range).min : null,
                benefits: res.job_benefits,
                status: res.status == 'open' ? 1 : 0
            }
        })
    },
})