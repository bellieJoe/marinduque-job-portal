import VueRx from "vue-rx";
import VuejsClipper from "vuejs-clipper/dist/vuejs-clipper.umd";
import "vuejs-clipper/dist/vuejs-clipper.css";
import $ from 'jquery'

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

// console.log(typeof([1,2,3]))

Vue.use(VueRx)
Vue.use(VuejsClipper);


const vApp = new Vue({
    el: "#seeker_image_uploader",
    data:{
        image: null,
        imageData: null
    },
    methods: {
        getResult: function () {
            const canvas = this.$refs.clipper.clip({wPixel: 500})
            
            const imageBase64 = canvas.toDataURL("image/jpeg", 1).split(",")[1]

            $.ajax({
                url: "/seeker/profile/upload-image/seeker-post",
                method: "post",
                data: {image: imageBase64},
            }).fail((res)=>{
                console.log(res)
                console.log(res.getAllResponseHeaders())
            }).done((res)=>{
                console.log(res)
                location.href = "/seeker/home"
            })
        },


    }
})