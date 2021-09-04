import $ from 'jquery'
import philippines from 'phil-reg-prov-mun-brgy'

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});


const loading = new bootstrap.Modal(document.getElementById('mdlLoading'), {
    keyboard: false,
    backdrop: 'static'
  })


new Vue({
    el: "#job-list",
    data: {
    },
    methods: {
        changeJobStatus(id){
            loading.show()
            $.ajax({
                url: `/employer/job/update-status/${id}`,
                method: "post",
            }).fail((res)=>{
                console.log(res)
                setTimeout(() => {
                    loading.hide()
                }, 1000);
                // location.href = "/error"
            }).done((res)=>{
                location.href = location.href
            })
        }
    },
})
