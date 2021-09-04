import $ from 'jquery'

// password toggling
$('#hide').css('display', 'none')
$('#password_toggle').on('click', ()=>{

    if($('#lblPasswordToggle').text() == 'See password'){
        $('#lblPasswordToggle').text('Hide password')
        $('#show').css('display', 'none')
        $('#hide').css('display', 'inline')
        $('#password').attr('type', 'text')
        $('#password_confirmation').attr('type', 'text')
    }else{
        $('#lblPasswordToggle').text('See password')
        $('#show').css('display', 'inline')
        $('#hide').css('display', 'none')
        $('#password').attr('type', 'password')
        $('#password_confirmation').attr('type', 'password')
    }

})


//laoding 
var mdlLoading = new bootstrap.Modal(document.getElementById('mdlLoading'), {
    keyboard: false,
    backdrop: 'static'
  })

$('#emp_sup').on('click', ()=>{
    mdlLoading.show()
})