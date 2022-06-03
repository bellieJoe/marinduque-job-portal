import $ from 'jquery'

import devModule from '../dev_module.js'


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});
$("#loading").css("display", "none")

new Vue({
    el: "#seeker-home",
    data: {
        savedJobs: null,
        jobSuggestions: null,
        toggledJobs: "suggestions",
        jobApplicationFilter: "all",
        jobApplications: [],
        toggle: null,
        devModule: devModule,
        // loaders
        JobApplicationLoader : false,
        savedJobsLoader : false,
        errors : {
            saveJobs : false,
            invitations : false,
            suggestedJobs : false,
            applications : false
        }
        
    },
    methods: {
        async getSavedJobs(){
            try {
                this.savedJobsLoader = true
                let res = await $.ajax({
                    url: '/seeker/home/get-saved-jobs',
                    method: "post",
                })
                this.savedJobsLoader = false
                this.savedJobs = res
            } catch (error) {
                console.log(error)
                this.savedJobsLoader = false
                this.errors.saveJobs = true
            }
            
        },

        deleteSavedJob(saved_job_id){
            $("#loading").css("display", "initial")
            $.ajax({
                url:` /seeker/home/delete-saved-job/${saved_job_id}`,
                method: 'post',

            }).fail((res)=>{
                // console.log(res)
                location.href = "/error"
            }).done((res)=>{
                $("#loading").css("display", "none")
                // console.log(res)
                this.getSavedJobs()
            })
        },

        viewJob(job_id){
            location.href = `job/${job_id}`
        },

        toggleJobs(a){
            if(a == "suggestions"){
                this.toggledJobs = "suggestions"
            }else if(a == "invitations"){
                this.toggledJobs = "invitations"
            }else if(a == "saved jobs"){
                this.toggledJobs = "saved jobs"
                this.getSavedJobs()
            }else if(a == "applications"){
                this.toggledJobs = "applications"
                this.getJobApplications()
            }
        },

        async getJobApplications(){
            try {
                let jobApplications = await $.ajax({
                    url: "/seeker/get-job-applications",
                    method: "post",
    
                })

                this.jobApplications = jobApplications.length != 0  ? jobApplications : null


            } catch (error) {
                console.log(error)
            }
            
        },

        async getJobSuggestions(){

            try {
                this.jobApplicationLoader = true
                let suggestedJobs = await $.ajax({
                    url: '/seeker/home/get-job-suggestions-preview',
                    method: 'GET',
                })

                if(suggestedJobs.length > 0){
                    this.jobSuggestions = suggestedJobs

                    this.jobSuggestions.map((val, i)=>{
                        let job = val
    
                        job.date_posted_diffForHumans = devModule.diffForHumans(val.job.date_posted)
                        job.salary_range = val.job.salary_range ? JSON.parse(val.job.salary_range) : null
                        job.course_studied = val.job.course_studied ? JSON.parse(val.job.course_studied) : null
                        job.company_address = val.job.company_address ? JSON.parse(val.job.company_address) : null
                        job.job_specialization = JSON.parse(val.job.job_specialization)
                        // this.jobSuggestions.push(job)
                    })
                }

                console.log(this.jobSuggestions)
                
                this.jobApplicationLoader = false

            } catch (error) {
                this.jobApplicationLoader = false
                console.log(error)
            }
        },

        filterSuggestedJobs(a){
            this.toggledSuggestedJobs = a
        },

        filterJobApplications(a){
            console.log(this.jobApplicationFilter)
            this.jobApplicationFilter = a
        },

        redirectRoute(route){
            location.href = route
        },

        

    },
    mounted() {
        this.getJobSuggestions()
        
        if(!$("#toggle").val()){
            this.toggleJobs('suggestions')
        }else{
            this.toggleJobs($("#toggle").val())
        }
        
        
       
    },
})
