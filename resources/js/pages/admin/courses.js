console.log("Courses page is connected")

import $ from "jquery"

new Vue({
    el: "#courses",
    data: {
       
    },
    methods: {
        selectCourseType_changed () {
            let courseType = $("#selectCourseType").val()

            location.href = `/admin/jobs/courses?type=${courseType}`
        }
    },
})