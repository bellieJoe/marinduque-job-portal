import $ from 'jquery'

$("#btnStart").on("click", ()=>{
    $(".sec-1").css("display", "none")
    $(".sec-2").css("display", "inherit")
})

$("#btnNext1").on("click", ()=>{
    $(".p1").css("display", "none")
    $(".p2").css("display", "inherit")
})

$("#btnNext2").on("click", ()=>{
    $(".p2").css("display", "none")
    $(".p3").css("display", "inherit")
})

$("#btnNext3").on("click", ()=>{
    $(".p3").css("display", "none")
    $(".p4").css("display", "inherit")
})

$("#btnNext4").on("click", ()=>{
    $(".p4").css("display", "none")
    $(".p5").css("display", "inherit")
})

$("#btnFindMatch").on("click", ()=>{
    location.href = "/seeker/job-match/results"
})