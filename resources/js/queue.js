function toggleQueueMembership(queueId, isCurrentlyInQueue) {
    const userId = window.telegramAuth.loadUserFromStorage().id;
    
    const button = event.target;
    button.disabled = true;
    
    const endpoint = isCurrentlyInQueue ? '/api/user/queue/remove' : '/api/user/queue/assign';
    const actionText = isCurrentlyInQueue ? 'Покидаем очередь...' : 'Присоединяемся...';
    button.textContent = actionText;
    
    fetch(endpoint, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            user_id: userId,
            queue_id: queueId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Livewire.dispatch('refresh-queue-users');
            
            // Update button appearance
            if (isCurrentlyInQueue) {
                button.classList.remove('btn-danger');
                button.classList.add('btn-primary');
                button.textContent = 'Присоединиться к очереди';
                button.onclick = function() { toggleQueueMembership(queueId, false); };
            } else {
                button.classList.remove('btn-primary');
                button.classList.add('btn-danger');
                button.textContent = 'Покинуть очередь';
                button.onclick = function() { toggleQueueMembership(queueId, true); };
            }
            
            const message = isCurrentlyInQueue ? 'Вы успешно покинули очередь!' : 'Вы успешно присоединились к очереди!';
            alert(message);
        } else {
            alert('Ошибка: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const errorMessage = isCurrentlyInQueue ? 'Произошла ошибка при выходе из очереди.' : 'Произошла ошибка при присоединении к очереди.';
        alert(errorMessage);
    })
    .finally(() => {
        button.disabled = false;
    });
}
