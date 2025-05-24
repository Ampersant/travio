import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: false, //(import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https'
    enabledTransports: ['ws', 'wss'],
});
const userId = document.head.querySelector('meta[name="user-id"]').content;
window.Echo.private(`notifications.${userId}`)
    .listen('FriendRequestSent', e => {
        console.log('[Echo] FriendRequestSent payload:', e);
        showIncomingRequestToast(e.friendship)
    })
    .listen('FriendRequestResponded', e => {
        console.log('[Echo] FriendRequestRespond payload:', e);
        showResponseToast(e.friendship)
    });

function showIncomingRequestToast(friendship) {
    console.log(friendship)
    const toast = document.createElement('div');
    toast.innerHTML = `
            <div class="toast show position-fixed top-0 end-0 p-3" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                   <strong class="me-auto">New request</strong>
                   <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    User #${friendship.sender_id} sent you a friend-request.
                    <button class="btn btn-sm btn-success" data-bs-dismiss="toast" onclick="acceptRequest(${friendship.id})">Accept</button>
                    <button class="btn btn-sm btn-danger" data-bs-dismiss="toast" onclick="rejectRequest(${friendship.id})">Decline</button>
                </div>
            </div>`;
    document.body.append(toast);
    new bootstrap.Toast(toast).show();
}

window.acceptRequest = function (requestId) {
    // window.bootstrap.Toast(toast).hide();
    axios.post('/api/friends/respond', { friendship_id: requestId, status: 'accepted' });
};
window.rejectRequest = function (requestId) {
    // window.bootstrap.Toast(toast).hide();
    axios.post('/api/friends/respond', { friendship_id: requestId, status: 'declined' });
};

function showResponseToast(friendship) {
    const statusText = friendship.status === 'accepted'
        ? 'accpeted your request'
        : 'declined your request';
    const toast = document.createElement('div');
    toast.innerHTML = `
            <div class="toast show position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    User #${friendship.receiver_id} ${statusText}.
                </div>
            </div>`;
    document.body.append(toast);
    new bootstrap.Toast(toast).show();
}

// function acceptRequest(requestId) {
//     axios.post('/api/friends/respond', {
//         id: requestId,
//         status: 'accepted'
//     });
// }
