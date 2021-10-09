console.log("Job seeker list page is connected")

import $ from 'jquery'

// console.log($('#printable')[0].innerHTML)


new Vue({
    el: '#jobSeekerList',
    data: {
        loading: false,
        printable: $('#printable')[0].innerHTML
    },
    methods: {



        toggleLoading(){
            this.loading = this.loading ? false : true
        }
    }
})