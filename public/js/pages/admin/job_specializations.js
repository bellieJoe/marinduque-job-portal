/******/ (() => { // webpackBootstrap
/*!*********************************************************!*\
  !*** ./resources/js/pages/admin/job_specializations.js ***!
  \*********************************************************/
console.log("Job specialoizations page connected");
new Vue({
  el: "#jobSpecializations",
  data: {
    toggleEdit: null
  },
  methods: {
    editToggle: function editToggle(a) {
      this.toggleEdit = a;
    }
  }
});
/******/ })()
;