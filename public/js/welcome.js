/******/ (() => { // webpackBootstrap
/*!*********************************!*\
  !*** ./resources/js/welcome.js ***!
  \*********************************/
document.addEventListener('userReady', function (e) {
  var userData = e.detail.data;
  if (userData.rooms.length !== 0) {
    document.getElementById('welcomeRoomsHeader').style.display = "block";
    Livewire.dispatch('userDataLoaded', {
      user: userData
    });
  } else {
    document.getElementById('welcomeEmptyRoomsHeader').style.display = "block";
  }
});
/******/ })()
;