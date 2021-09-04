import $ from 'jquery'


new Vue({
    el: "#home",
    data:{

    },
    methods: {
        realSearch(){
            location.href = "/job-search"
        },

        redirectTo(route){
            location.href = route
        }
    },
})