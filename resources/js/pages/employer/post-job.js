import phil from 'phil-reg-prov-mun-brgy'
import $ from "jquery"
import { indexOf } from 'lodash';


// console.log($("#formPostJob").serializeArray())

// const loading = new bootstrap.Modal(document.getElementById('mdlLoading'), {
//     keyboard: false,
//     backdrop: 'static'
//   })


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

new Vue({
    el: '#post-job',
    data:{
        phil: phil,
        errors: [],
        // courses: [],
        // industries: [],
        sample: {
            sam: "okie"
        },
        job: {
            job_title: null,
            job_type: null,
            job_industry: null,
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
            
            salary_range: {
                max: null,
                min: null
            },
            job_benefits:  null,
            status: 1

        }
    },
    methods: {

        async toggleUserCurrentInformation(){
            console.log(this.job.useCurrentInformation)
            try {
                if(this.job.useCurrentInformation){
                    // this.job.useCurrentInformation = true
                    // $("#toggleUseCurrent").val(true)
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
                    
                }else{
                    this.job.company_address = {
                        region: null,
                        province: null,
                        municipality: null,
                        barangay: null
                    }
                    this.job.company_description = null,
                    this.job.company_name = null                
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

        postJob(){
            // console.log(loading)
            // loading.show()
            this.errors = []
            $('#errorMessage').css('display', 'initial')
            var job = {
                job_title : this.job.job_title,
                job_industry : this.job.job_industry,
                job_type : this.job.job_type,
                job_description : this.job.job_description,
    
                company_name : this.job.company_name,
                region : this.job.company_address.region,
                province : this.job.company_address.province,
                municipality : this.job.company_address.municipality,
                barangay :this.job.company_address.barangay,
                company_description : this.job.company_description,
    
                educational_attainment : this.job.educational_attainment,
                gender: this.job.gender,
                course_studied : this.job.course_studied,
                experience : this.job.experience,
                other_qualification : this.job.other_qualification,
    
                salary_max : this.job.salary_range.max,
                salary_min : this.job.salary_range.min,
                benefits : this.job.benefits,
                status : this.job.status,
            }
            
            $.ajax({
                url:  '/employer/post-job/add-job',
                method: 'post',
                data: job,
                statusCode: {
                    500: ()=>{
                        // location.href ="/error"
                    }
                },
                
            }).fail((res)=>{
                console.log(res)
                setTimeout(() => {
                    // loading.hide()
                    $(window).scrollTop(0)
                    this.errors = res.responseJSON.errors
                    for(var i = 0 ; i < this.job.course_studied.length; i++){
                        if(this.errors[`course_studied.${i}`]){
                            this.errors['course_studied'] = ["Duplicate Entry"]
                            i = this.job.course_studied.length
                        }
                    }
                }, 500);
            
            }).done((res)=>{
                // console.log(res)
                location.href = "/employer/profile"
            })


        }
        
    },
    beforeCreate() {

    },
})




