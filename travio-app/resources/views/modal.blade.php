<!-- Button trigger modal -->

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cartModal">Show planner</button>

<!-- Modal -->
<div id="cartModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Trip planner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Cart table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Place</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items"></tbody>
                </table>

                <!-- Friend participants -->
                <div id="friend-participants" class="mt-3">
                    <h6>Other participants</h6>
                    <div id="friendSelects"></div>
                    <button id="addFriendBtn" class="btn btn-secondary btn-sm">Add participant</button>
                </div>

                <!-- Totals -->
                <div class="mt-3">
                    <p>Total budget: <strong><span id="totalPrice">0</span> $</strong></p>
                    <p>Per person: <strong><span id="pricePerPerson">0</span> $</strong></p>
                </div>
            </div>
            <div class="modal-footer">
                <button id="confirmBookingBtn" class="btn btn-primary">Make a trip!</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(function() {
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        let friends = [];

        $('#cartModal').on('show.bs.modal', function() {
            $.getJSON('/api/friends/all')
                .done((data) => {
                    friends = data; 
                    renderCart();
                });
        });

        function renderCart() {
            const $tbody = $('#cart-items').empty();
            let total = 0;

            // participants count = main + number of selects
            let extraCount = $('#friendSelects .participant-select').length;
            let participants = 1 + extraCount;

            cart.forEach((item, idx) => {
                const ci = new Date(item.check_in);
                const co = new Date(item.check_out);
                let nights = (co - ci) / (1000 * 60 * 60 * 24);
                if (isNaN(nights) || nights < 1) nights = 1;

                let itemTotal = item.price * nights * participants;
                total += itemTotal;

                $tbody.append(`
        <tr>
          <td><a href="/places/${item.id}">${item.name}</a></td>
          <td><input type="date" class="form-control check-in" data-index="${idx}" value="${item.check_in}"></td>
          <td><input type="date" class="form-control check-out" data-index="${idx}" value="${item.check_out}"></td>
          <td>${itemTotal.toFixed(2)}$</td>
          <td><button class="btn btn-danger btn-sm remove-item" data-index="${idx}">Delete</button></td>
        </tr>
      `);
            });

            $('#totalPrice').text(total.toFixed(2));
            $('#pricePerPerson').text(participants ? (total / participants).toFixed(2) : '0.00');

            const available = getAvailableFriends();
            $('#addFriendBtn').prop('disabled', available.length === 0);
        }

        function getSelectedEmails() {
            return $('.friend-select').map((i, el) => el.value).get();
        }

        function getAvailableFriends() {
            const selected = getSelectedEmails();
            return friends.filter(f => !selected.includes(f.email));
        }

        $('#addFriendBtn').click(() => {
            const available = getAvailableFriends();
            if (available.length === 0) {
                alert('No more friends to add');
                return;
            }

            const options = available.map(f => `<option value="${f.email}">${f.name}</option>`).join(
                '');
            const $wrapper = $(
                `<div class="input-group mb-2 participant-select">
        <select class="form-select friend-select">
          <option value="" disabled selected>Select friend</option>
          ${options}
        </select>
        <button type="button" class="btn btn-danger btn-sm remove-select">&times;</button>
      </div>`
            );
            $('#friendSelects').append($wrapper);
            renderCart();
        });

        $(document).on('click', '.remove-select', function() {
            $(this).closest('.participant-select').remove();
            renderCart();
        });

        $(document).on('click', '.remove-item', function() {
            const idx = $(this).data('index');
            cart.splice(idx, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        });

        $(document).on('change', '.check-in, .check-out', function() {
            const idx = $(this).data('index');
            const field = $(this).hasClass('check-in') ? 'check_in' : 'check_out';
            cart[idx][field] = $(this).val();
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        });
        $('#addToCartBtn').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const price = parseFloat($(this).data('price'));

            let today = new Date().toISOString().split('T')[0];
            cart.push({
                id,
                name,
                price,
                check_in: today,
                check_out: today
            });
            localStorage.setItem('cart', JSON.stringify(cart));
            $('#cartModal').modal('show');
        });
        $('#confirmBookingBtn').click(() => {
            if (!cart.length) return alert('Cart is empty');
            const participants = getSelectedEmails();
            $.post('/trip/confirm', {
                items: cart,
                _token: '{{ csrf_token() }}',
                participants: participants
            }).done(() => {
                localStorage.removeItem('cart');
                cart = [];
                renderCart();
                $('#cartModal').modal('hide');
                alert('Booking successful!');
            }).fail(() => alert('Error processing booking.'));
        });
    });
</script>
