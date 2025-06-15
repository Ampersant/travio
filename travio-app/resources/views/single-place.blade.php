<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">

    <title>Luxury Beachfront Villa | Paradise Getaways</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/single-place.css') }}">
    @vite(['resources/js/app.js'])
    

</head>

<body>
    <div class="container py-5">
        <!-- Property Header -->
        <div class="row mb-5">
            <div class="col-12">
                <h1 class="display-4 fw-bold text-center mb-4" style="color: var(--primary-color);">{{ $place->name }}
                </h1>
                <p class="lead text-center text-muted">{{ $place->destination->description }}</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Property Image -->
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="image-container">
                    <img src="{{ asset('images/' . $place->image_url) }}" class="property-image"
                        alt="Azure Sands Beachfront Villa">
                    <div class="destination-badge beach">
                        {{ $place->destination->destinationType->name }}
                    </div>
                    <div class="price-tag">
                        {{ $place->price }}$<small>/night</small>
                    </div>
                </div>
            </div>

            <!-- Property Details -->
            <div class="col-lg-6">
                @php
                    $rating = $place->rating; // например, 2.4
                    $fullStars = floor($rating); // целая часть → 2
                    $decimal = $rating - $fullStars; // дробная часть → 0.4

                    // Решаем, будет ли половина или «докручиваем» до целой:
                    if ($decimal >= 0.75) {
                        $fullStars++;
                        $halfStars = 0;
                    } elseif ($decimal >= 0.25) {
                        $halfStars = 1;
                    } else {
                        $halfStars = 0;
                    }

                    $emptyStars = 5 - $fullStars - $halfStars;
                @endphp

                <div class="rating mb-3">
                    {{-- Полные звёзды --}}
                    @for ($i = 0; $i < $fullStars; $i++)
                        <i class="fas fa-star"></i>
                    @endfor

                    {{-- Половинчатая звезда (если есть) --}}
                    @if ($halfStars)
                        <i class="fas fa-star-half-alt"></i>
                    @endif

                    {{-- Пустые звёзды --}}
                    @for ($i = 0; $i < $emptyStars; $i++)
                        <i class="far fa-star"></i>
                    @endfor

                    {{-- Сам рейтинг числом --}}
                    <span class="ms-2">{{ number_format($rating, 1) }}</span>
                </div>


                <h3 class="section-title">About This Place</h3>
                <p class="lead">{{ $place->description }}</p>
                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="section-title">Amenities</h3>
                    </div>
                    @foreach ($place->amenities as $amenity)
                        @php
                            // достаём иконку и описание по имени
                            $icon = $amenityIcons[$amenity->name] ?? 'circle';
                            $desc = $amenityDescriptions[$amenity->name] ?? '';
                        @endphp

                        <div class="col-md-4 col-6 text-center mb-4">
                            <div class="amenity-icon">
                                <i class="fas fa-{{ $icon }}"></i>
                            </div>
                            <h5>{{ $amenity->name }}</h5>
                            @if ($desc)
                                <p class="text-muted">{{ $desc }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Booking Card -->

            </div>
            <div class="container col-md-6">
                <div class="card booking-card p-4 mt-5">
                    <h3 class="text-center mb-4">Book Your Stay</h3>
                        @guest
                            <!-- Если не авторизован, перенаправляем на логин -->
                            <button onclick="window.location='{{ route('login') }}'" class="btn btn-primary">
                                Add this place to planer
                            </button>
                        @else
                            <!-- Кнопка для добавления в корзину (AJAX) -->
                            <button id="addToCartBtn" class="btn btn-primary" data-id="{{ $place->id }}"
                                data-name="{{ $place->name }}" data-price="{{ $place->price }}">
                                Add this place to planer
                            </button>
                        @endguest


                    <div class="mt-4 text-center">
                        <p><i class="fas fa-phone me-2"></i> Questions? Call: +1 (555) 123-4567</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('modal')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
