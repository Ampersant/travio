<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Agency - Find Your Perfect Destination</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"
        integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/search-page.css') }}">
</head>

<body>
    @include('templates.header')
    <!-- Search Header -->
    <div class="search-header">
        <div class="container img-bg rellax m-5">
            <h1 class="display-4 fw-bold mb-4">Find Your Perfect Destination</h1>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Country</label>
                    <select class="form-select" id="country-select">
                        <option value="">All Countries</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">City</label>
                    <select class="form-select" id="city-select">
                        <option value="">All Cities</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Search Controls -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-0">Popular Destinations</h2>
                <p class="text-muted small mb-0">Found <span id="result-count">0</span> results</p>
            </div>
            <!-- Active Filters Cloud -->
            <div class="row mb-3" id="active-filters">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-2" id="active-filters-container">
                    </div>
                </div>
            </div>
            <div class="row mb-3" id="active-filters">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-2" id="active-filters-container">
                    </div>
                </div>
            </div>

            <button class="btn btn-primary filter-btn" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter me-2"></i> Filters
                <span class="filter-badge" id="filter-count">0</span>
            </button>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-4 g-4 m-3" id="search-results">
        {{-- Results --}}
    </div>

    <div class="row d-none" id="no-results">
        <div class="col-12">
            <div class="no-results text-center py-5">
                <div>
                    <i class="fas fa-map-marked-alt fa-3x mb-3 text-muted"></i>
                    <h3 class="h4">No destinations found</h3>
                    <p class="text-muted">Try adjusting your search criteria or filters</p>
                    <button class="btn btn-outline-primary mt-3" id="reset-filters" style="color: #343661">Reset all
                        filters</button>
                </div>
            </div>
        </div>
    </div>
    <nav aria-label="Search results pagination" class="mt-5">
        <ul class="pagination justify-content-center" id="pagination">
        </ul>
    </nav>
    </div>

    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Destinations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">Price Range</h6>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span id="price-min-value">$0</span>
                                    <span id="price-max-value">$5000+</span>
                                </div>
                                <div id="price-slider"></div>
                            </div>

                            <h6 class="mb-3">Rating</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="rating" value="5"
                                    id="rating-5" checked>
                                <label class="form-check-label" for="rating-5">
                                    ★★★★★
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="rating" value="4"
                                    id="rating-4" checked>
                                <label class="form-check-label" for="rating-4">
                                    ★★★★
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="rating" value="3"
                                    id="rating-3" checked>
                                <label class="form-check-label" for="rating-3">
                                    ★★★
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="mb-3">Amenities</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="amenity" value="1"
                                    id="amenity-pool">
                                <label class="form-check-label" for="amenity-pool">
                                    <i class="fas fa-swimming-pool me-2"></i> Swimming Pool
                                </label>

                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="amenity" value="2"
                                    id="amenity-wifi">
                                <label class="form-check-label" for="amenity-wifi">
                                    <i class="fas fa-wifi me-2"></i> Free WiFi
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" name="amenity" type="checkbox" value="3"
                                    id="amenity-breakfast">
                                <label class="form-check-label" for="amenity-breakfast">
                                    <i class="fas fa-utensils me-2"></i> Breakfast Included
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" name="amenity" type="checkbox" value="4"
                                    id="amenity-parking">
                                <label class="form-check-label" for="amenity-parking">
                                    <i class="fas fa-parking me-2"></i> Free Parking
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" name="amenity" type="checkbox" value="5"
                                    id="amenity-spa">
                                <label class="form-check-label" for="amenity-spa">
                                    <i class="fas fa-spa me-2"></i> Spa Services
                                </label>
                            </div>

                            <h6 class="mb-3 mt-4">Destination Type</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="type" value="1"
                                    id="type-beach" checked>
                                <label class="form-check-label" for="type-beach">
                                    <i class="fas fa-umbrella-beach me-2"></i> Beach
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" name="type" type="checkbox" value="2"
                                    id="type-mountain" checked>
                                <label class="form-check-label" for="type-mountain">
                                    <i class="fas fa-mountain me-2"></i> Mountain
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" name="type" type="checkbox" value="3"
                                    id="type-city" checked>
                                <label class="form-check-label" for="type-city">
                                    <i class="fas fa-city me-2"></i> City
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="apply-filters">Apply Filters</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"
        integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rellax/1.12.1/rellax.js"
        integrity="sha512-qk0XupXlge1h9I63+bC7K8850xgWnUjTgSNkfLnsqc7dWdx4031UbKjKs2cuRxsNXymkSjyzSCiryVouU74zkg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/search-filter.js') }}"></script>
</body>

</html>
