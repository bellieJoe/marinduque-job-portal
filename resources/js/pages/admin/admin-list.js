console.log("Admin list page connected")

import $ from "jquery"



new Vue({
    el: "#admin-list",
    data: {
        loading: false
    },
    methods: {
        addModalIdParam(modalId){
            window.history.pushState(
                null,
                "Add modal param",
                `admin-list?modal=${modalId}`
            )
            console.log(window.history)
        },

        showLoader(){
            this.loading = true
        }
    },
    mounted() {
        (()=>{        
            var modalId = $("#updateModalId").val()
            var modal = modalId && new bootstrap.Modal(document.getElementById(modalId)).show()
        })()
    },
})