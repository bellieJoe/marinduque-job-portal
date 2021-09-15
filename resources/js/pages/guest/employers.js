console.log('Employers page connected')

new Vue({
    el: '#employers',
    data: {

    },
    methods: {
        redirectTo(route){
            location.href = route
        }
    },
})