console.log("Employer list page connected")

import $ from 'jquery'



new Vue({
    el: '#employerList',
    data: {
        loading: false,
        navToggle: false,
    },
    methods: {

        toggleLoading(){
            this.loading = this.loading ? false : true
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
    },
    mounted() {
        // window.print()
    },
})