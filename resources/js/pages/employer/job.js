console.log('job page is connected')
import $ from 'jquery'

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});


new Vue({
    el: '#job',
    data: {
        daysExpForm : null,
        loading : false
    },
    methods: {
        // toggleView(viewName){
        //     this.toggledView = viewName
        // },

        toggleLoading(){
            if(this.loading){
                this.loading = false
            }else{
                this.loading = true
            }
        },

        modifyUrl(params){
            let url = new URL(window.location)


            url.searchParams.set('view', params.view)
            if (params.applicants) {
                url.searchParams.set('applicants', params.applicants)
            }
            
            window.history.pushState(null, '', url)

            console.log(url.searchParams.get('view'))
        },

        redirectRoute(route){
            this.toggleLoading()
            location.href = route

        }

    },

})