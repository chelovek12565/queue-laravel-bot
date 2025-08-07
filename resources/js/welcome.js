document.addEventListener('userReady', (e) => {
    let userData = e.detail.data;

    if (userData.rooms.length !== 0) {
        document.getElementById('welcomeRoomsHeader').style.display = "block";
        Livewire.dispatch('userDataLoaded', {user: userData});
    } else {
        document.getElementById('welcomeEmptyRoomsHeader').style.display = "block";
    }
});

// --- Room creation form logic ---
document.addEventListener('DOMContentLoaded', function () {
    const showBtn = document.getElementById('showCreateRoomFormBtn');
    const form = document.getElementById('createRoomForm');
    const cancelBtn = document.getElementById('cancelCreateRoomFormBtn');

    if (showBtn && form && cancelBtn) {
        showBtn.addEventListener('click', function () {
            form.style.display = 'block';
            showBtn.style.display = 'none';
        });
        cancelBtn.addEventListener('click', function () {
            form.style.display = 'none';
            showBtn.style.display = 'block';
            form.reset();
        });
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            const name = form.roomName.value.trim();
            const description = form.roomDescription.value.trim();
            // TODO: Replace with actual user_id from context/session
            const user_id = sessionStorage.getItem('userId') || 1;
            try {
                const response = await fetch('/api/room', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        user_id,
                        name,
                        description: description || null
                    })
                });
                const data = await response.json();
                if (data.success) {
                    form.style.display = 'none';
                    showBtn.style.display = 'block';
                    form.reset();
                    // Optionally refresh room list or show a message
                    Livewire.dispatch('roomCreated', {room: data.data});
                } else {
                    alert(data.message || 'Ошибка при создании комнаты');
                }
            } catch (err) {
                alert('Ошибка при создании комнаты');
            }
        });
    }
});
