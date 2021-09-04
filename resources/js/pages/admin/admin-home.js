console.log("Admin home is connected")

import $ from 'jquery'

new Vue({
    el: '#admin_home',
    data: {

    },
    methods: {

        redirectRoute(route){
            location.href = route
        },

    }
})