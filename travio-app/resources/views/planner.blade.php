<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Планировщик поездки</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .destination-card {
            transition: all 0.3s ease;
        }

        .destination-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .budget-progress {
            height: 25px;
            border-radius: 12px;
        }

        .participant-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        .add-btn {
            transition: all 0.2s ease;
        }

        .add-btn:hover {
            transform: scale(1.05);
        }

        .total-budget {
            font-size: 1.2rem;
            font-weight: bold;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-4">
        @include('templates.back-button')
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="text-center mb-3">Trip planner</h1>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Travel route</h3>
                    <button class="btn btn-primary add-btn" data-bs-toggle="modal"
                        data-bs-target="#addDestinationModal">
                        <i class="bi bi-plus-lg"></i> Add destination
                    </button>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total budget</h5>
                        <div class="d-flex align-items-center">
                            <span class="total-budget me-2">{{ $trip->sum_price }}$</span>
                            <span class="text-muted">for {{ count($trip->places) }} place(s)</span>
                        </div>
                        <div class="progress mt-2 budget-progress">
                            <div id="progressbar" class="progress-bar bg-success" role="progressbar" style="width: 0%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--  --}}
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Participtiants</h5>
                        @foreach ($trip->users as $user)
                            <div class="d-flex align-items-center mb-2">
                                <div class="participant-avatar bg-primary me-2">{{ mb_substr($user->name, 0, 1) }}</div>
                                <span>{{ $user->name }}`s <span class="fw-bold"> share ID:
                                        {{ $user->id }}</span></span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="destinationsContainer">
            <!-- Места назначения будут добавляться сюда -->

            @foreach ($trip->places as $place)
                <div class="col-md-6 col-lg-4 md-6">
                    <div class="card destination-card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $place->name }}</h5>
                                <button class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $place->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <div class="d-flex justify-content-between text-muted small mb-3">
                                <span>{{ $place->pivot->check_in }}</span>
                                <span>-</span>
                                <span>{{ $place->pivot->check_out }}</span>
                                <span>{{ \Carbon\Carbon::parse($place->pivot->check_in)->diffInDays(\Carbon\Carbon::parse($place->pivot->check_out)) }}
                                    days</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-bold">{{ $place->pivot->price }}$ per 1 day</span>
                                <button class="btn btn-sm btn-outline-primary edit-budget-btn"
                                    data-place-id="{{ $place->id }}" data-place-name="{{ $place->name }}"
                                    data-place-price="{{ $place->pivot->price }}"
                                    data-place-shares='@json(json_decode($place->pivot->shares, true))'> <i class="bi bi-pencil"></i> Edit
                                    shares
                                </button>
                            </div>
                            <div class="budget-distribution">
                                @php
                                    $shares = json_decode($place->pivot->shares, true);
                                    $amount = $shares[$user->id];
                                @endphp
                                @foreach ($trip->users as $participiant)
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span>{{ $participiant->name }}:</span>
                                        <span class="fw-bold">{{ $amount }}$</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>

    <!-- Modal to add place(destination) -->
    <div class="modal fade" id="addDestinationModal" tabindex="-1" aria-labelledby="addDestinationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDestinationModalLabel">Add destination</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDestinationForm">
                        @csrf
                        <div class="mb-3">
                            <label for="destinationName" class="form-label">Place name</label>
                            <input type="text" class="form-control" id="destinationName" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="checkInDate" class="form-label">Check-In</label>
                                <input type="date" class="form-control" id="checkInDate" required>
                            </div>
                            <div class="col-md-6">
                                <label for="checkOutDate" class="form-label">Check-Out</label>
                                <input type="date" class="form-control" id="checkOutDate" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="destinationPrice" class="form-label">Price ($)</label>
                            <input type="number" class="form-control" id="destinationPrice" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Participiants:</label>
                            @php
                                $user = auth()->user();
                                print_r($user->name);
                                $friends = $user->friends;
                            @endphp
                            @foreach ($friends as $friend)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $friend->name }}"
                                        id="friend{{ $friend->id }}" checked>
                                    <label class="form-check-label" for="friend{{ $friend->id }}">
                                        {{ $friend->name }}
                                    </label>
                                </div>
                            @endforeach

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                    <button type="button" class="btn btn-primary" id="saveDestinationBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to edit budget -->
    <div class="modal fade" id="editBudgetModal" tabindex="-1" aria-labelledby="editBudgetModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBudgetModalLabel">Edit Budget</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBudgetForm">
                        <div class="mb-3">
                            <label for="destinationNameEdit" class="form-label">Destination</label>
                            <input type="text" class="form-control" id="destinationNameEdit" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="totalPriceEdit" class="form-label">Total Price ($)</label>
                            <input type="text" class="form-control" id="totalPriceEdit" disabled>
                        </div>
                        <div id="editBudgetFields" class="mb-3">
                            <!-- Dynamic participant fields will be added here -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveBudgetBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const progressBar = document.getElementById('progressbar');
            let total = @json($trip->sum_price);
            const progressPercentage = Math.min(100, (total / 10000) * 100);
            progressBar.style.width = `${progressPercentage}%`;
            progressBar.textContent = `${Math.round(progressPercentage)}%`;

            if (progressPercentage > 80) {
                progressBar.classList.remove('bg-success', 'bg-warning');
                progressBar.classList.add('bg-danger');
            } else if (progressPercentage > 50) {
                progressBar.classList.remove('bg-success', 'bg-danger');
                progressBar.classList.add('bg-warning');
            } else {
                progressBar.classList.remove('bg-warning', 'bg-danger');
                progressBar.classList.add('bg-success');
            }

            // Добавляем обработчики для кнопок удаления
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = parseInt(this.getAttribute('data-id'));
                    deleteDestination(id);
                });
            });

            function deleteDestination($id) {

            }

            const editModal = document.getElementById('editBudgetModal');
            editModal.addEventListener('show.bs.modal', event => {
                const btn = event.relatedTarget;
                const placeId = btn.getAttribute('data-place-id');
                const placeName = btn.getAttribute('data-place-name');
                const placePrice = btn.getAttribute('data-place-price');
                const shares = JSON.parse(btn.getAttribute('data-place-shares'));


                document.getElementById('destinationNameEdit').value = placeName;
                document.getElementById('totalPriceEdit').value = placePrice;

                const editBudgetFields = document.getElementById('editBudgetFields');
                editBudgetFields.innerHTML = '';

                Object.keys(shares).forEach(participant => {
                    const field = document.createElement('div');
                    field.className = 'mb-3';
                    field.innerHTML = `
                        <label for="share-${participant}" class="form-label">${participant}'s Share ($)</label>
                        <input type="number" class="form-control" id="share-${participant}" value="${shares[participant]}" min="0">
                    `;
                    editBudgetFields.appendChild(field);
                });

                document.getElementById('saveBudgetBtn').onclick = function() {
                    const updatedShares = {};
                    Object.keys(shares).forEach(participant => {
                        updatedShares[participant] = parseFloat(document.getElementById(
                            `share-${participant}`).value) || 0;
                    });

                    // Here you can send the updated shares to the server via an API call
                    console.log({
                        placeId,
                        updatedShares
                    });

                    bootstrap.Modal.getInstance(editModal).hide();
                };
            });

            document.querySelectorAll('.edit-budget-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const placeId = btn.getAttribute('data-place-id');
                    const placeName = btn.getAttribute('data-place-name');
                    const placePrice = btn.getAttribute('data-place-price');
                    const shares = JSON.parse(btn.getAttribute('data-place-shares'));

                    document.getElementById('destinationNameEdit').value = placeName;
                    document.getElementById('totalPriceEdit').value = placePrice;

                    const editBudgetFields = document.getElementById('editBudgetFields');
                    editBudgetFields.innerHTML = '';

                    Object.keys(shares).forEach(participant => {
                        const field = document.createElement('div');
                        field.className = 'mb-3';
                        field.innerHTML = `
                            <label for="share-${participant}" class="form-label">${participant}'s Share ($)</label>
                            <input type="number" class="form-control" id="share-${participant}" value="${shares[participant]}" min="0">
                        `;
                        editBudgetFields.appendChild(field);
                    });

                    const saveButton = document.getElementById('saveBudgetBtn');
                    saveButton.onclick = function() {
                        const updatedShares = {};
                        Object.keys(shares).forEach(participant => {
                            updatedShares[participant] = parseFloat(document
                                .getElementById(`share-${participant}`).value) || 0;
                        });

                        console.log('Updated shares for place ID:', placeId, updatedShares);

                        // Here you can send the updated shares to the server via an API call
                        // Example:
                        // fetch(`/api/places/${placeId}/shares`, {
                        //     method: 'PUT',
                        //     headers: {
                        //         'Content-Type': 'application/json'
                        //     },
                        //     body: JSON.stringify({ shares: updatedShares })
                        // });

                        bootstrap.Modal.getInstance(document.getElementById('editBudgetModal'))
                            .hide();
                    };

                    const modal = new bootstrap.Modal(document.getElementById('editBudgetModal'));
                    modal.show();
                });
            });
        });
    </script>
</body>

</html>
