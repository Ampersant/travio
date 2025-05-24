
// Конфигурация
const config = {
    defaultPriceRange: [0, 5000],
    itemsPerPage: 8,
    visiblePages: 5
};

// Состояние фильтров
let state = {
    country: '',
    city: '',
    priceMin: config.defaultPriceRange[0],
    priceMax: config.defaultPriceRange[1],
    ratings: [],
    amenities: [],
    types: [],
    page: 1
};

// Инициализация при загрузке
document.addEventListener('DOMContentLoaded', () => {
    initCountries();
    initPriceSlider();
    setupEventListeners();
    loadInitialData();
});

// Основные функции
function initCountries() {
    fetch('/countries/all')
        .then(res => res.json())
        .then(countries => {
            const select = document.getElementById('country-select');
            select.innerHTML = '<option value="">All Countries</option>';
            countries.forEach(c => addOption(select, c.id, c.name));
        });
}

function initPriceSlider() {
    const slider = document.getElementById('price-slider');
    noUiSlider.create(slider, {
        start: config.defaultPriceRange,
        connect: true,
        range: {
            min: config.defaultPriceRange[0],
            max: config.defaultPriceRange[1]
        },
        step: 100
    });

    slider.noUiSlider.on('update', (values) => {
        state.priceMin = parseInt(values[0]);
        state.priceMax = parseInt(values[1]);
        updatePriceDisplay();
    });
}

function setupEventListeners() {
    // Изменение страны
    document.getElementById('country-select').addEventListener('change', e => {
        state.country = e.target.value;
        state.city = '';
        loadCities(state.country);
        refreshResults();
    });

    // Изменение города
    document.getElementById('city-select').addEventListener('change', e => {
        state.city = e.target.value;
        refreshResults();
    });

    // Применение фильтров
    document.getElementById('apply-filters').addEventListener('click', () => {
        state.ratings = getCheckedValues('rating');
        state.amenities = getCheckedValues('amenity');
        state.types = getCheckedValues('type');
        refreshResults();
    });

    // Пагинация
    document.getElementById('pagination').addEventListener('click', e => {
        if (e.target.classList.contains('page-link')) {
            e.preventDefault();
            const page = parseInt(e.target.dataset.page);
            if (!isNaN(page)) {
                state.page = page;
                refreshResults();
            }
        }
    });

    // Сброс фильтров
    document.getElementById('reset-filters').addEventListener('click', () => {
        resetAllFilters();
        refreshResults();
    });
}

// Вспомогательные функции
function addOption(select, value, text) {
    const option = document.createElement('option');
    option.value = value;
    option.textContent = text;
    select.appendChild(option);
}

function getCheckedValues(name) {
    console.log(Array.from(document.querySelectorAll(`input[name="${name}"]:checked`))
        .map(el => el.value));
    return Array.from(document.querySelectorAll(`input[name="${name}"]:checked`))
        .map(el => el.value);
}

function updatePriceDisplay() {
    document.getElementById('price-min-value').textContent = `$${state.priceMin}`;
    document.getElementById('price-max-value').textContent =
        state.priceMax >= 5000 ? `$${state.priceMax}+` : `$${state.priceMax}`;
}

// Работа с городами
function loadCities(countryId) {
    const citySelect = document.getElementById('city-select');
    citySelect.innerHTML = '<option value="">All Cities</option>';

    if (!countryId) return;

    fetch(`/countries/${countryId}/cities`)
        .then(res => res.json())
        .then(cities => cities.forEach(c => addOption(citySelect, c.id, c.name)));
}

// Обновление UI
function updateActiveFilters() {
    const container = document.getElementById('active-filters-container');
    container.innerHTML = '';

    // Ценовой фильтр
    createFilterChip(
        `Price: $${state.priceMin} - $${state.priceMax}`,
        () => resetPriceFilter()
    );

    // Страна
    if (state.country) {
        const name = document.getElementById('country-select').selectedOptions[0].text;
        createFilterChip(`Country: ${name}`, () => resetCountryFilter());
    }

    // Город
    if (state.city) {
        const name = document.getElementById('city-select').selectedOptions[0].text;
        createFilterChip(`City: ${name}`, () => resetCityFilter());
    }

    // Рейтинги
    state.ratings.forEach(r => {
        createFilterChip(`Rating: ${'★'.repeat(r)}`, () => removeRatingFilter(r));
    });

    // Удобства
    state.amenities.forEach(a => {
        const el = document.querySelector(`input[name="amenity"][value="${a}"]`);
        const text = el?.nextElementSibling?.textContent.trim() || `Amenity #${a}`;
        createFilterChip(text, () => removeAmenityFilter(a));
    });

    // Типы
    state.types.forEach(t => {
        const el = document.querySelector(`input[name="type"][value="${t}"]`);
        const text = el?.nextElementSibling?.textContent.trim() || `Type #${t}`;
        createFilterChip(text, () => removeTypeFilter(t));
    });
}

function createFilterChip(text, onClick) {
    const chip = document.createElement('div');
    chip.className = 'filter-chip';
    chip.innerHTML = `
            <span>${text}</span>
            <span class="remove-filter">&times;</span>
        `;
    chip.querySelector('.remove-filter').addEventListener('click', onClick);
    document.getElementById('active-filters-container').appendChild(chip);
}

function updatePagination(data) {
    const pagination = document.getElementById('pagination');
    const pages = generatePagination(data.current_page, data.last_page);
    pagination.innerHTML = pages;
}

function generatePagination(currentPage, lastPage) {
    let html = `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                      <a class="page-link" data-page="${currentPage - 1}">Prev</a>
                    </li>`;

    const start = Math.max(1, currentPage - Math.floor(config.visiblePages / 2));
    const end = Math.min(lastPage, start + config.visiblePages - 1);

    if (start > 1) {
        html += `<li class="page-item"><a class="page-link" data-page="1">1</a></li>`;
        if (start > 2) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
    }

    for (let i = start; i <= end; i++) {
        html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                       <a class="page-link" data-page="${i}">${i}</a>
                     </li>`;
    }

    if (end < lastPage) {
        if (end < lastPage - 1) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        html += `<li class="page-item"><a class="page-link" data-page="${lastPage}">${lastPage}</a></li>`;
    }

    html += `<li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                   <a class="page-link" data-page="${currentPage + 1}">Next</a>
                 </li>`;

    return html;
}

// Работа с данными
function refreshResults() {
    updateActiveFilters();
    updateFilterBadge();

    const params = new URLSearchParams();

    if (state.country) params.set('country', state.country);
    if (state.city) params.set('city', state.city);
    if (state.priceMin !== config.defaultPriceRange[0] || state.priceMax !== config.defaultPriceRange[1]) {
        params.set('priceMin', state.priceMin);
        params.set('priceMax', state.priceMax);
    }

    state.ratings.forEach(r => params.append('ratings[]', r));
    state.amenities.forEach(a => params.append('amenities[]', a));
    state.types.forEach(t => params.append('types[]', t));

    params.set('page', state.page);

    fetch(`/places?${params.toString()}`)
        .then(res => res.json())
        .then(data => {
            renderResults(data.data);
            updatePagination(data);
            document.getElementById('result-count').textContent = data.total;
            document.getElementById('no-results').classList.toggle('d-none', data.total > 0);
        });
}

function renderResults(places) {
    const container = document.getElementById('search-results');

    // Соответствие ID удобств —> HTML иконки
    const amenityIcons = {
        1: '<i class="fas fa-swimming-pool me-1" title="Swimming Pool"></i>',
        2: '<i class="fas fa-wifi me-1" title="Free WiFi"></i>',
        3: '<i class="fas fa-utensils me-1" title="Breakfast Included"></i>',
        4: '<i class="fas fa-parking me-1" title="Free Parking"></i>',
        5: '<i class="fas fa-spa me-1" title="Spa Services"></i>',
        // добавьте остальные при необходимости
    };

    container.innerHTML = places.map(place => {
        // Строка с иконками
        const iconsHtml = place.amenities
            .map(a => amenityIcons[a.id] || '')
            .join('');

        return `
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card destination-card h-100 d-flex flex-column">
                <div class="position-relative">
                    <img src="${place.image_url}" class="card-img-top" alt="${place.name}">
                    <div class="price-badge">$${place.price}</div>
                </div>
                <div class="card-body flex-grow-1">
                    <a href="/places/${place.id}"><h5 class="card-title">${place.name}</h5></a>
                    <p class="card-text text-muted small">${place.description}</p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <span class="rating">★ ${place.rating}</span>
                    <span class="amenities-icons">
                        ${iconsHtml}
                    </span>
                </div>
            </div>
        </div>
        `;
    }).join('');
}



// Сброс фильтров
function resetPriceFilter() {
    state.priceMin = config.defaultPriceRange[0];
    state.priceMax = config.defaultPriceRange[1];
    document.getElementById('price-slider').noUiSlider.set(config.defaultPriceRange);
    refreshResults();
}

function resetCountryFilter() {
    state.country = '';
    state.city = '';
    document.getElementById('country-select').value = '';
    document.getElementById('city-select').innerHTML = '<option value="">All Cities</option>';
    refreshResults();
}

function resetCityFilter() {
    state.city = '';
    document.getElementById('city-select').value = '';
    refreshResults();
}

function removeRatingFilter(rating) {
    state.ratings = state.ratings.filter(r => r !== String(rating));
    document.querySelector(`input[name="rating"][value="${rating}"]`).checked = false;
    refreshResults();
}

function removeAmenityFilter(amenity) {
    state.amenities = state.amenities.filter(a => a !== String(amenity));
    document.querySelector(`input[name="amenity"][value="${amenity}"]`).checked = false;
    refreshResults();
}

function removeTypeFilter(type) {
    state.types = state.types.filter(t => t !== String(type));
    document.querySelector(`input[name="type"][value="${type}"]`).checked = false;
    refreshResults();
}

function resetAllFilters() {
    state = {
        ...state,
        country: '',
        city: '',
        priceMin: config.defaultPriceRange[0],
        priceMax: config.defaultPriceRange[1],
        ratings: [],
        amenities: [],
        types: [],
        page: 1
    };

    document.getElementById('price-slider').noUiSlider.set(config.defaultPriceRange);
    document.querySelectorAll('input[type="checkbox"]').forEach(c => c.checked = false);
    document.getElementById('country-select').value = '';
    document.getElementById('city-select').innerHTML = '<option value="">All Cities</option>';
    refreshResults();
}

function updateFilterBadge() {
    const count = [
        state.country ? 1 : 0,
        state.city ? 1 : 0,
        state.ratings.length,
        state.amenities.length,
        state.types.length,
        1 // Всегда учитываем ценовой фильтр
    ].reduce((a, b) => a + b, 0);

    const badge = document.getElementById('filter-count');
    badge.textContent = count;
    badge.style.display = count > 0 ? 'flex' : 'none';
}

function loadInitialData() {
    refreshResults();
}