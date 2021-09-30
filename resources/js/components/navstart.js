import $ from "jquery"


$('#logo').on('click', ()=>{
    location.href = "/"
})

$("#sup").on("click", ()=>{
    location.href = "/signup"
})

$("#sin").on("click", ()=>{
    location.href = "/signin"
})

$(".menu").on("click", ()=>{
    if($(".buttons").css("display")){
        if($(".buttons").css("display") == "block"){
            $(".buttons").css("display","none")
        }else{  
            $(".buttons").css("display", "block")
        }
    }else{
        $(".buttons").css("display", "block")
    }
})

$("#logout").on('click', ()=>{
    mdlLoadingLogout.show()
    location.href = "/logout"
})

$('#emp_signup').on('click', ()=>{
    location.href = "/emp_sup"
})


// logout loading
const mdlLoadingLogout = new bootstrap.Modal(document.getElementById('mdlLoadingLogout'), {
    keyboard: false,
    backdrop: 'static'
  })


/* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("main_nav").style.top = "0";
  } else {
    document.getElementById("main_nav").style.top = "-50px";
  }
  prevScrollpos = currentScrollPos;
}

new Vue({
    el: "#main_nav",
    data: {
        mainNav: false,
    },
    methods: {
        toggleMainNav(){
            if (this.mainNav){
                this.mainNav = false
            } else {
                this.mainNav = true
            }
        }
    },
})


