console.log('Resume is connected')


new Vue({
    el: "#resume",
    data: {
        isPrinting: false
    },
    methods: {
        async printResume(){
            this.isPrinting = true
            await window.print()

            // this.isPrinting = false
        }
    },
})