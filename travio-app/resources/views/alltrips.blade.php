<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Trips Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/alltrips-page.css') }}">
</head>

<body>
    <div class="container py-4">
        <!-- Header Section -->
        <div class="header-section">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-5 fw-bold mb-3">My Trips</h1>
                    <p class="mb-0">Manage and track all your upcoming and past adventures</p>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-0"><i
                                    class="bi bi-search text-white"></i></span>
                            <input type="text" class="form-control search-box" placeholder="Search trips...">
                        </div>
                        <button class="btn filter-btn rounded-pill px-3">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <a href="{{ route('search') }}" class="btn add-trip-btn rounded-pill px-3 ms-auto">
                            <i class="bi bi-plus-lg me-2"></i> New Trip
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button"
                    role="tab">All Trips</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="planning-tab" data-bs-toggle="tab" data-bs-target="#planning"
                    type="button" role="tab">Active</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="ongoing-tab" data-bs-toggle="tab" data-bs-target="#ongoing" type="button"
                    role="tab">Drafted</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed"
                    type="button" role="tab">Finished</button>
            </li>
        </ul>

        <!-- Trip Cards -->
        <div class="tab-content" id="myTabContent">
            @if (!$user_trips->isEmpty())
                <div class="tab-pane fade show active" id="all" role="tabpanel">
                    <!-- Trip 1 -->
                    @foreach ($user_trips as $trip)
                        <div class="card mb-4 trip-card">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="https://images.unsplash.com/photo-1503917988258-f87a78e3c995?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                                        class="img-fluid trip-img" alt="Italian Alps">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <a href="{{ route('planner.show', $trip->id) }}">
                                                <h3 class="card-title h5 mb-0">{{ $trip->name }}</h3>
                                            </a>
                                            <span class="status-badge status-ongoing">{{ $trip->status }}</span>
                                        </div>

                                        <div class="destinations-list mb-2">
                                            @foreach ($trip->places as $place)
                                                <span class="destination-badge">{{ $place->name }}</span>
                                            @endforeach

                                        </div>

                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex">
                                                    @foreach ($trip->users as $user)
                                                        <img src="{{ $user->avatar_url }}" class="participant-avatar"
                                                            alt="Participant">
                                                    @endforeach

                                                </div>
                                                <span class="ms-2 text-muted small">{{ count($trip->users) }}
                                                    participants</span>
                                            </div>

                                            <a href="/chats" class="chat-link">
                                                <i class="bi bi-chat-left-text me-1"></i> Discuss via chats
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="container">
                    <h2>There is no trips <a href="{{ route('search') }}">create one</a> to start</h2>
                </div>
            @endif


            <div class="tab-pane fade" id="planning" role="tabpanel">
            </div>
            <div class="tab-pane fade" id="ongoing" role="tabpanel">
            </div>
            <div class="tab-pane fade" id="completed" role="tabpanel">
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple search functionality
        document.querySelector('.search-box').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const tripCards = document.querySelectorAll('.trip-card');

            tripCards.forEach(card => {
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Tab switching with localStorage persistence
        const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabEls.forEach(tabEl => {
            tabEl.addEventListener('click', function(event) {
                localStorage.setItem('activeTab', event.target.getAttribute('data-bs-target'));
            });
        });

        // On page load, check for active tab in localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                const tabTrigger = new bootstrap.Tab(document.querySelector(`[data-bs-target="${activeTab}"]`));
                tabTrigger.show();
            }
        });
    </script>
</body>

</html>
