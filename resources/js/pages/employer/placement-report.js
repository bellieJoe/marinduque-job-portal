

console.log("employers placement report page is connected")


import $ from 'jquery'


new Vue({
    el: '#employerPlacementReport',
    data: {
        startYear: 2021,
        years: [],
        selectedYear: null,
        selectedMonth: null
    },
    methods: {
        reloadReport(){
            let year = this.selectedYear ? this.selectedYear : new Date().getFullYear()
            let month = this.selectedMonth ? this.selectedMonth : new Date().getMonth() 

            location.href = `/${$('#role').val() == 'admin' ? 'admin/reports' : 'employer'}/placement-report/${month}/${year}`

            // console.log(`${this.selectedMonth} ${this.selectedYear}`)

        }
    },
    created() {
        for (let i = this.startYear; i <= new Date().getFullYear(); i++){
            this.years.push(i)
        }
    },
    mounted() {
        this.selectedMonth = parseInt($("#smonth").val()) 
        this.selectedYear = $("#syear").val()
    },
})