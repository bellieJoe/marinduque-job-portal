import $ from "jquery"
import { lowerCase } from "lodash";
import philippines from 'phil-reg-prov-mun-brgy'

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

// loading screen
$("#loading").css("display", "none")

// console.log(philippines.getCityMunByProvince('0128'))

new Vue({
    el: "#job_search",
    data: {
        jobs: [],
        toastSaveJob: "opacity-0",
        provinces: philippines.provinces,
        city_mun: [],
        
    },
    methods: {


        clearKeywords(){
            $('#job_title_keywords').empty()
        },

        clearFilter(){
            $("#salary_min").val("0")
            $("#salary_max").val("0")
            $("#province").val("")
            $("#municipality").val("")
            
        },

        setCityMun(){
            // console.log($("#province").val())
            philippines.provinces.map((province, i1)=>{
                if($("#province").val() == province.name){
                    this.city_mun = philippines.getCityMunByProvince(province.prov_code)

                }
            })
            
        },

        setCompanyName(val){
            $('#job_title_keywords').empty()
            this.company_name = val
            this.clearKeywords()
            this.clearFilter()
        },


        // generateKeyworks(){
        //     // this.clearFilter()
        //     try {
        //         if($('#keyword').val() ){
        //             console.log("init request")
        //             $.ajax({
        //                 url: "/job-search/keywords",
        //                 method: "post",
        //                 data: { keyword : $('#keyword').val() }
        //             }).fail((res)=>{
        //                 console.log(res)
        //             }).done((res)=>{
        //                 $('#job_title_keywords').empty()
        //                 res.map((val,i)=>{
                            
        //                     $("#job_title_keywords").append($("<option value='" + lowerCase(val.job_title) + "'>"))
        
        //                 })
        //             })
        //         }
        //     } catch (error) {
                
        //     }
            
        // },

        // generateCompanynameKeywords(){
        //     // this.clearFilter()

        //     if($("#company_name").val()){

        //         $.ajax({
        //             url: "/job-search/keyword-company-name",
        //             method: "post",
        //             data: { company_name : this.company_name }
        //         }).fail((res)=>{
        //             console.log(res)
        //         }).done((res)=>{

        //             $("#company_name_keywords").empty()
        //             res.map((val,i)=>{
        //                 $("#company_name_keywords").append($("<option value='" + lowerCase(val.company_name) + "'>"))
        //             })
        //         })
        //     }            
        // },

        search(){
            $("#loading").css("display", "initial")
            // this.clearKeywords()
            // this.clearFilter()
            var a = {
                keyword: this.keyword,
                // company_name : this.company_name,
                province: this.province,
                municipality: this.municipality,
                salary_max: this.salary_max,
                salary_min: this.salary_min
            }
            console.log(a)
            console.log("search results:")

            console.log($("#search_form").serializeArray())

        },

        saveJob(job_id){
            $("#loading").css("display", "initial")
            $.ajax({
                url: `/seeker/job-search/save-job/${job_id}`,
                method: "post",
            }).fail((res)=>{
                // console.log(res)
                location.href = "/error"
            }).done((res)=>{
                console.log(res)
                $("#loading").css("display", "none")
                this.toastSaveJob = "opacity-100"
                setTimeout(() => {
                    this.toastSaveJob = "opacity-0"
                }, 2000);
            })
        }


    },

    created() {
        if($("#province").val()){
            philippines.provinces.map((province, i1)=>{
                if($("#province").val() == province.name){
                    this.city_mun = philippines.getCityMunByProvince(province.prov_code)

                }
            })
        }
    },


})

