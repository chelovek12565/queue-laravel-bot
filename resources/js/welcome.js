document.addEventListener('userReady', (e) => {
    let userData = e.detail.data;

    if (userData.rooms.length !== 0) {
        document.getElementById('welcomeRoomsHeader').style.display = "block";
        Livewire.dispatch('userDataLoaded', {user: userData});
    } else {
        document.getElementById('welcomeEmptyRoomsHeader').style.display = "block";
    }

});
