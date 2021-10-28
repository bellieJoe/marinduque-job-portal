console.log('employer verification page is connected')

import $ from 'jquery'

new Vue({
    el : '#verify_employer',
    data: {
        loading: false,
    },
    methods: {
        toggleLoading(){
            this.loading = this.loading ? false : true
        }
    },
})