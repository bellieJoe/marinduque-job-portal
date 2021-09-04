console.log('job page is connected')
import $ from 'jquery'

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

const loading = $('#loading')
loading.css('display', 'none')

new Vue({
    el: '#job',
    data: {
        toggledView: 'job details',
        daysExpForm : null
    },
    methods: {
        toggleView(viewName){
            this.toggledView = viewName
        },

        toggleLoading(){
            if(loading.css('display') == 'none'){
                loading.css('display', 'initial')
            }else{
                loading.css('display', 'none')
            }
        },

        // async setDaysExpire(e){
        //     e.preventDefault();
        //     const formDaysExpire = $('#formDaysExpire')
        //     try {
        //         const res = await $.ajax({
        //             method: 'post',
        //             url: formDaysExpire.attr('action'),
        //             data: formDaysExpire.serializeArray()
        //         })
        //         console.log(res)
        //         // location.reload()
        //     } catch (error) {
        //         console.log(error)
        //     }

        // }

    },

})