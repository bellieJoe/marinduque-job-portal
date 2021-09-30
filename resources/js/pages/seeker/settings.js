console.log("settings page connected")

import $ from 'jquery'

require('../../ajax-setup.js')

new Vue({
    el: "#seeker_settings",
    data:{
        // states
        passwordResetToast: false,
        loading: false,
        email: $("#email").val(),

        // responses
        resetPasswordResponse: null,
    },
    methods: {
        togglePasswordResetToast(){
            if(this.passwordResetToast){
                this.passwordResetToast = false
            }else{
                this.passwordResetToast = true
            }
        },

        toggleLoading(){
            if (this.loading){
                this.loading = false
            } else {
                this.loading = true
            }
        },

        async resetPassword(){
            try {

                this.toggleLoading()
                if(this.togglePasswordResetToast){
                    this.passwordResetToast = false
                }

                let status = await $.ajax({
                    url: "/forgot-password-send",
                    method: "POST",
                    data: {
                        email: this.email
                    }
                }) 

                this.toggleLoading()
                this.togglePasswordResetToast()
                this.resetPasswordResponse = status

                setTimeout(() => {
                    this.togglePasswordResetToast()
                }, 10000);
                

            } catch (error) {
                this.toggleLoading()
                console.log(error)
            }
        }
    },
})