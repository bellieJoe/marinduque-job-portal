import $ from "jquery"

console.log(`/user/resend_code/${$("#email").attr("value")}`)

const rcode_modal = new bootstrap.Modal(document.getElementById("resend_code_modal"), {
    keyboard: false,
    backdrop: 'static'
  })

// var toastElList = [].slice.call(document.querySelectorAll('.toast'))
var resend_success = new bootstrap.Toast(document.getElementById("resend_success_toast"))
var resend_error = new bootstrap.Toast(document.getElementById("resend_error_toast"))


$(".pota").on('click', ()=>{
    rcode_modal.show()
    $.ajax({
        method : "GET",
        url : `/user/resend_code/${$("#email").attr("value")}`
    }).done(()=>{
        console.log("Resending code success")
        rcode_modal.hide()
        resend_success.show()
    }).fail(()=>{
        console.log("Resending code error")
        rcode_modal.hide()
        resend_error.show()
    })

})