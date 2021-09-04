import $ from 'jquery'

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
        toggledJobs: "suggestions",
        jobApplicationFilter: "all",
        jobApplications: [],
    },
    methods: {
        getSavedJobs(){
            $.ajax({
                url: '/seeker/home/get-saved-jobs',
                method: "post",

            }).fail((res)=>{
                console.log(res)
                // location.href = "/error"
            }).done((res)=>{
                this.savedJobs = res
 
            })
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
                console.log(res)
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

        getJobApplications(){
            $.ajax({
                url: "/seeker/get-job-applications",
                method: "post",

            }).fail((res)=>{
                console.log(res)
            }).done((res)=>{
                console.log(res)
                if(res.length != 0){
                    // console.log("me laman")
                    this.jobApplications = res
                }else{
                    // console.log("wala laman")
                    this.jobApplications = null
                }
            })
        },

        getJobSuggestions(){

        },

        filterSuggestedJobs(a){
            this.toggledSuggestedJobs = a
        },

        filterJobApplications(a){
            console.log(this.jobApplicationFilter)
            this.jobApplicationFilter = a
        }

    },
    mounted() {
        this.toggleJobs('suggestions')
    },
})
