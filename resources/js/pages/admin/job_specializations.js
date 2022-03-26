console.log("Job specialoizations page connected")

new Vue({
    el: "#jobSpecializations",
    data: {
        toggleEdit: null,

    },
    methods: {
        editToggle(a){
            this.toggleEdit  = a
        }
    },
})