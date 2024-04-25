@php
    $dates = [
        "all" => 'All Days',
        '1' => 'Jan 26th ' . date('Y'),
        '2' => 'Jan 27th ' . date('Y'),
        '3' => 'Jan 28th ' . date('Y'),

        '4' => 'Feb 2nd ' . date('Y'),
        '5' => 'Feb 3rd ' . date('Y'),
        '6' => 'Feb 4th ' . date('Y'),

        '7' => 'Feb 9th ' . date('Y'),
        '8' => 'Feb 10th ' . date('Y'),
        '9' => 'Feb 11th ' . date('Y'),

        '10' => 'Feb 16th ' . date('Y'),
        '11' => 'Feb 17th ' . date('Y'),
        '12' => 'Feb 18th ' . date('Y'),
    ]
@endphp

<!-- Seat Modal -->
<div class="modal fade" id="formModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Book a seat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buyForm">
                <div class="modal-body">
                    <p class="text-danger">A seat cost the sum of <span id="seat-price"></span></p>
                    <div class="mb-4">
                        <input type="text" id="user-name" name="name" required class="form-control rounded-0" placeholder="Name">
                    </div>
                    <div class="mb-4">
                        <input type="email" id="user-email" name="email" required class="form-control rounded-0" placeholder="Email">
                    </div>

                    <select name="days[]" id="user-days" required class="form-control" multiple>
                        <option value="">Select day</option>
                        @foreach ($dates as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>

                    <input type="hidden" id="seat-type" name="type">
                    <input type="hidden" id="seat-id" name="seat_id">
                    <input type="hidden" id="seat-color" name="color">
                    <input type="hidden" id="seat-number" name="seat_number">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary rounded-0">Send Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Ticket Modal -->
<div class="modal fade" id="ticketModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Buy Tickets</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ticketForm">
                <div class="modal-body">
                    <div class="mb-4">
                        <input type="text" name="name" required class="form-control rounded-0" placeholder="Name">
                    </div>
                    <div class="mb-4">
                        <input type="email" name="email" required class="form-control rounded-0" placeholder="Email">
                    </div>

                    <div class="mb-4">
                        <input type="number" min="0" name="total" required class="form-control rounded-0" placeholder="How many?">
                    </div>

                    <select name="day" required class="form-control">
                        <option value="">Select day</option>
                        @foreach ($dates as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary rounded-0">Continute</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Admin Book Modal -->
<div class="modal fade" id="bookModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Book a seat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="bookForm">
                <div class="modal-body">
                    <div class="mb-4">
                        <input type="text" name="name" required class="form-control rounded-0" placeholder="Name">
                    </div>
                    <div class="mb-4">
                        <input type="email" name="email" required class="form-control rounded-0" placeholder="Email">
                    </div>
                    <select name="days[]" id="user-days" required class="form-control" multiple>
                        <option value="">Select day</option>
                        @foreach ($dates as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary px-5 rounded-0">Book</button>
                </div>
            </form>
        </div>
    </div>
</div>
