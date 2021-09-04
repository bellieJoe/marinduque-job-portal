console.log("Employer list page connected")

import $ from 'jquery'



new Vue({
    el: '#employerList',
    data: {
        loading: false
    },
    methods: {

        toggleLoading(){
            this.loading = this.loading ? false : true
        }
    }
})