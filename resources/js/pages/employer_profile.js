import $ from 'jquery'
import phil from 'phil-reg-prov-mun-brgy'

// console.log(JSON.parse(a))
// console.log(JSON.parse($('#init_address').val()).region)

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

var EP = new Vue({
    el: '#EmployerProfile',
    data: {
        samp: "putahhamnida",
        ph: phil,
        employer: {
            company_name : $('#init_company_name').val(),
            contact_person_name : $('#init_contact_person_name').val(),
            contact_number : $('#init_contact_number').val(),
            region : null,
            province : null,
            municipality : null,
            barangay : null,
            description : $('#init_description').val(),
            mission: $('#init_mission').val(),
            vision: $('#init_vision').val(),
        },
        errors: [],
        updating : false
    },
    methods: {
        updateProfile : function(){
            // console.log(this.employer)
            this.errors = []
            this.updating = true
            console.log(this.address)
            var resp = $.ajax({
                url: '/employer/profile/update',
                method: 'POST',
                data: this.employer
            }).fail((res)=>{
                this.errors = resp.responseJSON.errors
                this.updating = false
            }).done((res)=>{
                location.href = '/employer/profile'
                // console.log(resp)
            })
        },

        updateDescription : function(){
            console.log(this.employer.description)
            this.updating = true
            $.ajax({
                url: '/employer/profile/update-description',
                method: 'POST',
                data: { description: this.employer.description}
            }).fail((res)=>{
                this.errors = res.responseJSON.errors
                this.updating = false
            }).done((res)=>{
                location.href = '/employer/profile'
            })
        },

        openEditProfile : function(){
            this.errors = []
            this.employer = {
                company_name : $('#init_company_name').val(),
                contact_person_name : $('#init_contact_person_name').val(),
                contact_number : $('#init_contact_number').val(),
                region : $('#init_address').val() ? JSON.parse($('#init_address').val()).region : null,
                province : $('#init_address').val() ? JSON.parse($('#init_address').val()).province : null,
                municipality: $('#init_address').val() ? JSON.parse($('#init_address').val()).municipality : null,
                barangay : $('#init_address').val() ? JSON.parse($('#init_address').val()).barangay : null,
                description : $('#init_description').val(),
            }
        },

        clear(){
            this.errors = []
            this.employer.mission = $('#init_mission').val()
            this.employer.vision = $('#init_vision').val()
        },

        resetAddress: function(address){
            if(address == 'reg'){
                this.employer.province = null
                this.employer.municipality = null
                this.employer.barangay = null
            }else if(address == 'prov'){
                this.employer.municipality = null
                this.employer.barangay = null
            }else if(address == 'mun'){
                this.employer.barangay = null
            }else if(address == 'brgy'){
                // console.log('brgy')
            }
        },

        setMission(){
            $.ajax({
                url: '/employer/profile/set-mission',
                method: "post",
                data: { mission : this.employer.mission },
                statusCode: {
                    500: ()=>{
                        location.href = "/error"
                    }
                }
            }).fail((res)=>{
                // console.log(res)
                this.errors = res.responseJSON.errors
            }).done(()=>{
                location.href = location.href
            })
        },

        setVision(){
            $.ajax({
                url: '/employer/profile/set-vision',
                method: "post",
                data: { vision : this.employer.vision },
                statusCode: {
                    500: ()=>{
                        // location.href = "/error"
                    }
                }
            }).fail((res)=>{
                console.log(res)
                this.errors = res.responseJSON.errors
            }).done(()=>{
                location.href = location.href
            })
        },

        
    }
})




$(".btnShowOverview").on("click", ()=>{
    $(".btnShowOverview").css("border-bottom", "2px solid steelblue") 
    $(".btnShowOverview").css("color", "steelblue") 
    $(".btnShowJobs").css("color", "initial") 
    $(".btnShowJobs").css("border-bottom", "2px solid white") 
    $(".divJobs").css("display", "none")
    $(".divOverview").css("display", "initial")

})

$(".btnShowJobs").on("click", ()=>{
    $(".btnShowJobs").css("border-bottom", "2px solid steelblue") 
    $(".btnShowJobs").css("color", "steelblue") 
    $(".btnShowOverview").css("color", "initial") 
    $(".btnShowOverview").css("border-bottom", "2px solid white") 
    $(".divJobs").css("display", "initial")
    $(".divOverview").css("display", "none")
})

$('#btnEditProfile').on('click', ()=>{
    console.log("ay naclick")
    mdlEditProfile.show()
})

$('#btnEditDescription').on('click', ()=>{
    console.log("ay naclick si des")
    mdlEditDescription.show()
})

// modals
// show edit profile modal
var mdlEditProfile = new bootstrap.Modal(document.getElementById('mdlEditProfile'), {
    keyboard: false,
  })

var mdlEditDescription = new bootstrap.Modal(document.getElementById('mdlEditDescription'), {
    keyboard: false,
  })



