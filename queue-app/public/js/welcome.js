/******/ (() => { // webpackBootstrap
/*!*********************************!*\
  !*** ./resources/js/welcome.js ***!
  \*********************************/
document.addEventListener('userReady', function (e) {
  var userData = e.detail.data;
  if (userData.rooms) {
    document.getElementById('welcomeRooms').style.display = "block";
    Livewire.dispatch('userDataLoaded', {
      user: userData
    });
  } else {
    document.getElementById('welcomeHeader').style.display = "block";
  }
});
/******/ })()
;