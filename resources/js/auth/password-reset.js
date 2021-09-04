import $ from 'jquery'

console.log("gumenesei hehe")

$('#btnReset').on('click', ()=>{
    console.log("show modal")
    mdlLoading.show()
})

$('#btnGoSignin').on('click', ()=>{
    location.href = '/signin'
})

$('#btnUpdatePassword').on('click', ()=>{
    mdlLoading.show()
})

var mdlEmailStatus = null
var mdlResetSuccess = null

if($('#mdlEmailStatus').length){
    mdlEmailStatus = new bootstrap.Modal(document.getElementById('mdlEmailStatus'), {
        keyboard: false,
        backdrop: 'static'
    }).show()
}
if($('#mdlResetSuccess').length){
    mdlResetSuccess = new bootstrap.Modal(document.getElementById('mdlResetSuccess'), {
        keyboard: false,
        backdrop: 'static'
    }).show()
}


const mdlLoading = new bootstrap.Modal(document.getElementById('mdlLoading'), {
    keyboard: false,
    backdrop: 'static'
  })





