console.log("Admin home is connected")

import $ from 'jquery'

new Vue({
    el: '#admin_home',
    data: {
        navToggle: false,
    },
    methods: {

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