$(function () {
    // Инициализация корзины из localStorage
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');

    // Функция перерисовки корзины в модальном окне
    function renderCart() {
        const $tbody = $('#cart-items').empty();
        let total = 0;

        cart.forEach((item, index) => {
            // Рассчитываем количество ночей
            let checkIn = new Date(item.check_in);
            let checkOut = new Date(item.check_out);
            let nights = (checkOut - checkIn) / (1000 * 60 * 60 * 24);
            if (isNaN(nights) || nights < 1) nights = 1;

            // Рассчитываем стоимость за это место
            let itemTotal = item.price * nights * item.guests;
            total += itemTotal;

            // Создаём строку таблицы
            let row = `<tr>
                <td>${item.name}</td>
                <td><input type="date" class="form-control check-in" data-index="${index}" value="${item.check_in}"></td>
                <td><input type="date" class="form-control check-out" data-index="${index}" value="${item.check_out}"></td>
                <td><input type="number" min="1" class="form-control guests" data-index="${index}" value="${item.guests}"></td>
                <td>${itemTotal.toFixed(2)}$.</td>
                <td><button class="btn btn-danger btn-sm remove-item" data-index="${index}">Удалить</button></td>
            </tr>`;
            $tbody.append(row);
        });

        // Обновляем итоги
        $('#totalPrice').text(total.toFixed(2));
        let participants = cart.length > 0 ? 1 + $('#emailInputs input').length : 0;
        let perPerson = participants ? (total / participants).toFixed(2) : 0;
        $('#pricePerPerson').text(perPerson);
    }

    // Добавить место в корзину
    $('#addToCartBtn').click(function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const price = parseFloat($(this).data('price'));

        // По умолчанию ставим сегодняшнюю дату и одного гостя
        let today = new Date().toISOString().split('T')[0];
        cart.push({
            id: id,
            name: name,
            price: price,
            check_in: today,
            check_out: today,
        });
        localStorage.setItem('cart', JSON.stringify(cart));
        alert('Place added to planner');
    });

    // Удалить место из корзины
    $(document).on('click', '.remove-item', function () {
        let idx = $(this).data('index');
        cart.splice(idx, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
    });

    // Обработка изменений дат и количества гостей
    $(document).on('change', '.check-in, .check-out, .guests', function () {
        let idx = $(this).data('index');
        let field = $(this).hasClass('check-in') ? 'check_in' :
            $(this).hasClass('check-out') ? 'check_out' : 'guests';
        cart[idx][field] = $(this).val();
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
    });

    // Добавить дополнительного участника
    $('#addEmailBtn').click(function () {
        $('#emailInputs').append('<input type="email" class="form-control mb-2" placeholder="Email участника">');
        renderCart();
    });

    // Настройка AJAX-запроса с CSRF-токеном (Laravel)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Подтвердить бронирование (отправка на сервер)
    $('#confirmBookingBtn').click(function () {
        if (cart.length === 0) {
            alert('Корзина пуста');
            return;
        }
        // Сбор данных корзины и участников
        let participants = [];
        $('#emailInputs input').each(function () {
            if (this.value) {
                participants.push(this.value);
            }
        });

        $.ajax({
            url: '{{ route('trip.confirm') }}',
            method: 'POST',
            data: {
                items: JSON.stringify(cart),
                participants: JSON.stringify(participants)
            },
            success: function (response) {
                // Очистка корзины после успешного создания Trip
                localStorage.removeItem('cart');
                cart = [];
                renderCart();
                $('#cartModal').modal('hide');
                alert('Бронирование успешно оформлено!');
            },
            error: function () {
                alert('Ошибка при оформлении бронирования.');
            }
        });
    });

    // При открытии модального окна заполняем корзину из localStorage
    $('#cartModal').on('show.bs.modal', function () {
        renderCart();
    });
});