console.log("admin nav list page connected")

import $ from 'jquery'



new Vue({
    el: '#admin_nav',
    data: {
        loading: false,
        navToggle: false,
        reportToggle: false,
    },
    methods: {

        toggleLoading(){
            this.loading = this.loading ? false : true
        },

        showReports(){
            this.reportToggle =  true
        },

        hideReports(){
            this.reportToggle =  false
        },

        toggleNav(){
            if(this.navToggle){
                this.navToggle = false
            }else{
                this.navToggle = true
            }
        },

        redirectRoute(route){
            location.href = route
        },
    }
})