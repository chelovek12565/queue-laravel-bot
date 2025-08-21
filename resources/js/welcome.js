document.addEventListener('userReady', (e) => {
    const detail = e && e.detail ? e.detail : null;
    // Support both shapes: detail = user, or detail = { data: user }
    let userData = (detail && detail.data) ? detail.data : detail;
    if (!userData && window.telegramAuth) {
        userData = window.telegramAuth.currentUser || null;
    }

    if (!userData) {
        // No user yet; nothing to render
        return;
    }

    if (Array.isArray(userData.rooms) && userData.rooms.length !== 0) {
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
            const user_id = window.telegramAuth.loadUserFromStorage().id;
            try {
                const response = await fetch('/api/room', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        user_id: user_id,
                        name: name,
                        description: description || null
                    })
                });
                const data = await response.json();
                if (data.success) {
                    form.style.display = 'none';
                    showBtn.style.display = 'block';
                    form.reset();
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
