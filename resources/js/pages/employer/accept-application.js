console.log("Accept application connected")

import $ from 'jquery'

$('#loading').css('display', 'none')

new Vue({
    el: '#acceptApplication',
    data:{

    },
    methods:{
        toggleLoading(){
            if($('#loading').css('display') == 'none'){
                $('#loading').css('display', 'initial')
            }else{
                $('#loading').css('display', 'none')
            }
        }
    }
})