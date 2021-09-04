import $ from 'jquery'

const password = $('#password')
const password_confirmation = $('#password_confirmation')
const show = $("#show")
const hide = $('#hide')

var mdlSigninFailed = null

var mdlLoading = new bootstrap.Modal(document.getElementById('mdlLoading'), {
    keyboard: false,
    backdrop: 'static'
  })

if($('#mdlSigninFailed').length){
    mdlSigninFailed = new bootstrap.Modal(document.getElementById('mdlSigninFailed'), {
        keyboard: false,
      }).show()
}


$(".password_toggle").on("click",  ()=>{
    console.log("Password toggled")
    if(password.attr("type") == "text"){
        hide.css("display", "inline")
        show.css("display", "none")
        password.attr("type", "password")
        password_confirmation.attr("type", "password")
    }
    else if(password.attr("type") == "password"){
        show.css("display", "inline")
        hide.css("display", "none")
        password.attr("type", "text")
        password_confirmation.attr("type", "text")
    }
})

$('#btnSignin').on('click', ()=>{
    mdlLoading.show()
    
})