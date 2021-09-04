import VueRx from "vue-rx";
import VuejsClipper from "vuejs-clipper/dist/vuejs-clipper.umd"
import "vuejs-clipper/dist/vuejs-clipper.css"
import $ from 'jquery'

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
})
    
Vue.use(VueRx)
Vue.use(VuejsClipper)

new Vue({
    el: "#upload_logo",
    data: {
        imageData: null,
        
    },
    methods: {
        uploadLogo(){
            const canvas = this.$refs.clipper.clip({wPixel: 500})
            
            const imageBase64 = canvas.toDataURL("image/jpeg", 1).split(",")[1]
            // console.log(imageBase64)
            $.ajax({
                url: "/employer/profile/upload-logo/upload",
                method: "post",
                data: { imageData : imageBase64 }
            }).fail((res)=>{
                console.log('res')
            }).done(()=>{
                location.href = "/employer/profile"
            })

        }
    },
})