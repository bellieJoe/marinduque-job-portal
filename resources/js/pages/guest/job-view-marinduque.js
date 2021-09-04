console.log("Job view marinduque page is connected")

import $ from 'jquery'

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

new Vue({
    el: '#jobViewMarinduque',
    data:{
        loading: false,
    },
    methods: {

        async saveJob(job_id){
            try {
                this.toggleLoading()
                await $.ajax({
                    url: `/seeker/job-search/save-job/${job_id}`,
                    method: "post",
                })


                this.toggleLoading()
            } catch (error) {
                alert("Bla bla error")
                console.log(error)
                this.toggleLoading()
            }
            
        },

        toggleLoading(){
            if(this.loading){
                this.loading = false
            }else{
                this.loading = true
            }
        }
    },

    
})