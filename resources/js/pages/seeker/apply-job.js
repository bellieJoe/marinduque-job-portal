import $ from 'jquery'


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

$("#loading").css("display", "none")

new Vue({
    el: "#apply_job",
    data:{
        other_information: null,
        errors : []
    },
    methods: {
        toggleLoading(){
            if($("#loading").css("display") == "none"){
                $("#loading").css("display", "initial")
            }else{
                $("#loading").css("display", "none")
            }
        },

        // async submitApplication(job_id, applicant_id){
        //     this.toggleLoading()
        //     try {

        //         let jobApplication = await $.ajax({
        //             url: "/seeker/add-job-application",
        //             method: "post",
        //             data: {
        //                 job_id: job_id,
        //                 applicant_id : applicant_id,
        //                 other_information: this.other_information
        //             },
    
        //         })

        //         location.href = `/seeker/job/${job_id}`

        //     } catch (error) {
        //         this.errors = error.responseJSON.errors
        //         console.log(error)
        //     }
        // }
    },
})