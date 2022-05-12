console.log("admin nav list page connected")

import $ from 'jquery'


new Vue({
    el: '#admin_nav',
    data: {
        loading: false,
        navToggle: false,
        reportToggle: false,
        employerNavToggle: false,
        jobNavToggle: false
    },
    methods: {

        toggleLoading(){
            this.loading = this.loading ? false : true
        },

        showJobNav(){
            this.jobNavToggle = true
        },

        hideJobNav(){
            this.jobNavToggle = false
        },

        showEmployerNav(){
            this.employerNavToggle = true
        },

        hideEmployerNav(){
            this.employerNavToggle = false
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
            if(route == '/admin/reports/placement-report'){
                location.href = `${route}/${new Date().getMonth() + 1}/${new Date().getFullYear()}`
            }else{
                location.href = route
            }
            
        },
    }
});

(()=>{
    const btnMenuShow = document.getElementById("btnAdminMenuShow")
    const btnMenuHide = document.getElementById("btnAdminMenuHide")
    const adminNav = document.getElementById("admin_nav")
    
    btnMenuShow.addEventListener("click", ev => {
        adminNav.style.left = "0px"
    })
    adminNav.addEventListener("mouseleave", ev => {
        adminNav.style.left = "-20rem"
    })
    btnMenuHide.addEventListener("click", ev => {
        adminNav.style.left = "-20rem"
    })
})();