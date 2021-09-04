/******/ (() => { // webpackBootstrap
/*!*******************************************************!*\
  !*** ./resources/js/pages/admin/add-admin-account.js ***!
  \*******************************************************/
console.log('Add admin account page connected');
new Vue({
  el: '#addAdminAccount',
  data: {
    loading: false
  },
  methods: {
    toggleLoading: function toggleLoading() {
      if (this.loading) {
        this.loading == false;
      } else {
        this.loading = true;
      }
    }
  }
});
/******/ })()
;