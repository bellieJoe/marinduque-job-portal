console.log("Job seeker list page is connected")

import $ from 'jquery'



new Vue({
    el: '#jobSeekerList',
    data: {
        loading: false
    },
    methods: {

        toggleLoading(){
            this.loading = this.loading ? false : true
        }
    }
})