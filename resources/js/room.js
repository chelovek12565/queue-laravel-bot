document.addEventListener('DOMContentLoaded', function() {
    const showCreateQueueFormBtn = document.getElementById('showCreateQueueFormBtn');
    const createQueueForm = document.getElementById('createQueueForm');
    const cancelCreateQueueFormBtn = document.getElementById('cancelCreateQueueFormBtn');

    if (showCreateQueueFormBtn && createQueueForm && cancelCreateQueueFormBtn) {
        showCreateQueueFormBtn.addEventListener('click', function() {
            createQueueForm.style.display = 'block';
            showCreateQueueFormBtn.style.display = 'none';
        });

        cancelCreateQueueFormBtn.addEventListener('click', function() {
            createQueueForm.style.display = 'none';
            showCreateQueueFormBtn.style.display = 'block';
            // Clear form fields
            document.getElementById('queueName').value = '';
            document.getElementById('queueDescription').value = '';
        });

        createQueueForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const name = createQueueForm.queueName.value.trim();
            const description = createQueueForm.queueDescription.value.trim();
            const user_id = window.telegramAuth.loadUserFromStorage().id;
            const room_id = document.querySelector('[data-room-id]').getAttribute('data-room-id');

            try {
                const response = await fetch('/api/queue', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        user_id: user_id,
                        room_id: parseInt(room_id),
                        name: name,
                        description: description || null
                    })
                });
                const data = await response.json();
                if (data.success) {
                    createQueueForm.style.display = 'none';
                    showCreateQueueFormBtn.style.display = 'block';
                    createQueueForm.reset();
                    // Reload the page to show the new queue
                    window.location.reload();
                } else {
                    alert(data.message || 'Ошибка при создании очереди');
                }
            } catch (err) {
                alert('Ошибка при создании очереди');
            }
        });
    }
});
