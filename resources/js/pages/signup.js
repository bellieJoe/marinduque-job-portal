import $ from "jquery"


const password = $('#password')
const show = $("#show")
const hide = $('#hide')


$(".toggle_password").on("click",  ()=>{
    if(password.attr("type") == "text"){
        hide.css("display", "flex")
        show.css("display", "none")
        password.attr("type", "password")
    }
    else if(password.attr("type") == "password"){
        show.css("display", "flex")
        hide.css("display", "none")
        password.attr("type", "text")
    }
});

$('#btnSignup').on('click', ()=>{
    mdlLoading.show()
})

const mdlLoading = new bootstrap.Modal(document.getElementById('mdlLoading'), {
    keyboard: false,
    backdrop: 'static'
  })
