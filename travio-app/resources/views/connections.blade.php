<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="user-id" content="{{ auth()->id() }}">
    <title>Friend Connections</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/connections.css')}}">
    @vite(['resources/js/app.js'])

</head>

<body>
    <div class="container py-5">
        <h1 class="text-center mb-4">Connect with Friends</h1>
        <div class="search-container">
            <div class="input-group mb-4">
                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" id="searchInput" class="form-control border-start-0"
                    placeholder="Search by name..." aria-label="Search friends">
                <button class="btn btn-primary" type="button" id="searchButton" style="border-radius: 0 50px 50px 0;">
                    <i class="fas fa-search me-1"></i> Search
                </button>
            </div>
        </div>
        <div class="row" id="friendsContainer">
            @forelse($users as $user)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="friend-card card h-100">
                        <div class="card-header-bg"></div>
                        <div class="avatar-container">
                            <img src="{{ $user->avatar_url ?? 'https://randomuser.me/api/portraits/men/22.jpg' }}"
                                class="avatar" alt="{{ $user->name }}">
                        </div>
                        <div class="card-body text-center pt-0">
                            <h5 class="friend-name mb-2">{{ $user->name }}</h5>
                            <p class="friend-location">{{ $user->location ?? '' }}</p>
                            <button class="btn btn-outline-primary btn-add" data-id="{{ $user->id }}">
                                <i class="fas fa-user-plus"></i> Add Friend
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-user-friends fa-4x text-muted"></i>
                    <h3 class="mt-3">No users to add</h3>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-add')) {
                let btn = e.target.closest('.btn-add');
                let userId = btn.dataset.id;

                fetch(`/api/friends/request/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        receiver_id: userId
                    })
                }).then(res => {
                    if (res.ok) {
                        btn.textContent = 'Pending';
                        btn.classList.remove('btn-outline-primary');
                        btn.classList.add('btn-added');
                    }
                });
            }
        });
    </script>
</body>

</html>
