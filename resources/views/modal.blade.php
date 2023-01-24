<!-- Modal -->
<div class="modal fade" id="formModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Book a seat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buyForm">
                <div class="modal-body">
                    <p class="text-danger">A seat cost the sum of ₦50,000</p>
                    <div class="mb-4">
                        <input type="text" id="user-name" name="name" required class="form-control rounded-0" placeholder="Name">
                    </div>
                    <div class="mb-4">
                        <input type="email" id="user-email" name="email" required class="form-control rounded-0" placeholder="Email">
                    </div>

                    <select name="days[]" id="user-days" required class="form-control" multiple>
                        <option value="">Select day</option>
                        <option value="all">All Days</option>
                        <option value="7">Feb 4th, 2023</option>
                        <option value="8">Feb 5th, 2023</option>
                        <option value="13">Feb 11th, 2023</option>
                        <option value="14">Feb 12th, 2023</option>
                        <option value="19">Feb 18th, 2023</option>
                        <option value="20">Feb 19th, 2023</option>
                    </select>

                    <input type="hidden" id="seat-type" name="type">
                    <input type="hidden" id="seat-id" name="seat_id">
                    <input type="hidden" id="seat-number" name="seat_number">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success">Send Booking</button>
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
                        <option value="7">Feb 4th, 2023</option>
                        <option value="8">Feb 5th, 2023</option>
                        <option value="13">Feb 11th, 2023</option>
                        <option value="14">Feb 12th, 2023</option>
                        <option value="19">Feb 19th, 2023</option>
                        <option value="20">Feb 19th, 2023</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success">Continute</button>
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
                        <option value="all">All Days</option>
                        <option value="7">Feb 4th, 2023</option>
                        <option value="8">Feb 5th, 2023</option>
                        <option value="13">Feb 11th, 2023</option>
                        <option value="14">Feb 12th, 2023</option>
                        <option value="19">Feb 18th, 2023</option>
                        <option value="20">Feb 19th, 2023</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success px-5">Book</button>
                </div>
            </form>
        </div>
    </div>
</div>
