console.log('Add admin account page connected')


new Vue({
    el: '#addAdminAccount',
    data: {
        loading: false
    }, 
    methods: {
        toggleLoading(){
            if(this.loading){
                this.loading == false
            }else{
                this.loading = true
            }
        }
    },
})