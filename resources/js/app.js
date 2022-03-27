import fontawesome from "@fortawesome/fontawesome-free";
import solid from "@fortawesome/fontawesome-free";
import brands from "@fortawesome/fontawesome-free";
import Echo from "laravel-echo";
import $ from 'jquery'

import keyword_analyzer from 'keyword-analyzer'
require('./bootstrap');

import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);





const User = JSON.parse($("#User").val())

// console.log(navigator.onLine)
// console.log(keyword_analyzer.wrest('bar bar bar foo foo foo foo'))



new Vue({
    el: '#internetConnectionDetector',
    data: {
        isOnline: navigator.onLine,
    },
    methods: {
        toggleDetector(){
            setInterval(() => {
                console.log("Detecting Connection")
                this.isOnline = navigator.onLine
            }, 1000);
        }
    },
    mounted() {
        // this.toggleDetector()
  
        // try {
        //     window.Echo.private(`App.Models.User.${User.user_id}`)
        //     .notification((notification) => {
        //         console.log(notification);
        //     });

            
        // } catch (error) {
        //     console.log(error)
        // }
    },
})

// window.onload(function(ev){
//     var modalId = document.getElementById("updateModalId").val
//     var modal = new bootstrap.Modal(document.getElementById("#"+modalId)).show()
// })

