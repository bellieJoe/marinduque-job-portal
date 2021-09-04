console.log("Job list page is connected")

import $ from 'jquery'



new Vue({
    el: '#jobList',
    data: {
        loading: false
    },
    methods: {

        toggleLoading(){
            this.loading = this.loading ? false : true
        }
    }
})