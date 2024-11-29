@extends('layouts.frontend')

@section('title', 'Reservation Form')
@section('meta_description', null)
@section('meta_keywords', null)
@section('meta_image', null)

@section('content')

    <div class="container d_m_tb_60 m_m_tb_60">
        @if ($reserve->reserve == 'Y')
            <div class="center-text-css text-center">
                <h2 class="main_headings d_m_b_30 m_m_b_30">RESERVATION</h2>
                <p class="nomargin">Fill up your information in the Reservation Form and get your reservation confirmation
                    through Mail.</p>
                <hr class="hr-class-hw">
                <br>
            </div>
            <form id="reservationForm" class="needs-validation shadow-sm rounded" novalidate
                style="
                    background-color: #056aff26;
                    padding: 30px;
                ">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="fullname" class="form-label f_label_css">Full Name</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please enter your name.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="phone" class="form-label f_label_css">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please enter your correct phone number.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label f_label_css">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please enter your correct email.
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <label for="resdate" class="form-label f_label_css">
                                    Reservation Date
                                </label>
                                <input type="text" class="form-control" id="resdate">
                            </div> --}}
                            {{-- <div class="col-md-4">
                                <label for="restime" class="form-label f_label_css">Reservation Time</label>
                                <select id="restime" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>...</option>
                                </select>
                            </div> --}}
                            {{-- <div class="col-md-4">
                                <label for="persons" class="form-label f_label_css">Number of Persons</label>
                                <input type="number" class="form-control" id="persons">
                            </div> --}}
                            <div class="col-md-12">
                                <label for="spinst" class="form-label f_label_css">Special Instructions</label>
                                <textarea class="form-control" id="spinst" name="spinst" rows="7" col="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                        <div class="col-12 p-4 shadow bg-primary rounded">
                            <div class="row">
                                <div class="text-center mb-2">
                                    <img src="{{ asset('assets/img/logo/logo_white.png') }}" alt="Logo"
                                        class="img-fluid" style="height: auto; width:100px;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-4 text-center text-light">For reservations above 15 people, we ask you to
                                        call
                                        +32 468/49.55.33
                                    </p>
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item rounded bg-primary">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button
                                                    class="accordion-button collapsed bg-primary text-light px-0 fw-bolder"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                                    aria-controls="flush-collapseOne">
                                                    <i class="far fa-calendar-alt me-2"></i> Guests
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse show"
                                                aria-labelledby="flush-headingOne">
                                                <div class="accordion-body p-0 rounded">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-primary text-light"><i
                                                                    class="fas fa-utensils"></i></span>
                                                            <input type="number" class="form-control bg-primary text-light"
                                                                name="persons" id="persons" placeholder="2" value="2"
                                                                required>
                                                            <div class="invalid-feedback">
                                                                Please enter guests number.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item rounded bg-primary">
                                            <h2 class="accordion-header" id="flush-headingTwo">
                                                <button
                                                    class="accordion-button collapsed bg-primary text-light px-0 fw-bolder"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                                    aria-controls="flush-collapseTwo">
                                                    <i class="far fa-calendar-alt me-2"></i> Date
                                                </button>
                                            </h2>
                                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingTwo">
                                                <div class="accordion-body p-0 rounded">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-primary text-light"><i
                                                                    class="far fa-calendar-alt"></i></span>
                                                            <input type="date"
                                                                class="form-control bg-primary text-light"
                                                                id="selected-date" name="resdate"
                                                                placeholder="Select a date" readonly>
                                                            <input type="date" id="hidden-booking-date" name="resdate"
                                                                required style="display: none">
                                                            <div class="invalid-feedback">
                                                                Please select a booking date.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="calendar-controls" class="mt-3 text-light">
                                                        <button type="button" id="prev-month">&lt;</button>
                                                        <span id="current-month-year"></span>
                                                        <button type="button" id="next-month">&gt;</button>
                                                    </div>
                                                    <div id="calendar" class="mb-3"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item rounded bg-primary">
                                            <h2 class="accordion-header" id="flush-headingThree">
                                                <button
                                                    class="accordion-button collapsed bg-primary text-light px-0 fw-bolder"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapseThree" aria-expanded="false"
                                                    aria-controls="flush-collapseThree">
                                                    <i class="far fa-clock me-2"></i> Time
                                                </button>
                                            </h2>
                                            <div id="flush-collapseThree" class="accordion-collapse show"
                                                aria-labelledby="flush-headingThree">
                                                <div class="accordion-body p-0 rounded">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-primary text-light"><i
                                                                    class="far fa-clock"></i></span>
                                                            <select name="restime" id="restime"
                                                                class="form-control bg-primary text-light time-select"
                                                                required>
                                                                <option value="" disabled selected>Select Your
                                                                    Preferred Time</option>
                                                                <optgroup label="Breakfast">
                                                                    @forelse ($openingHourSlots['today']['slot1'] as $slot1)
                                                                        <option value="{{ $slot1['start'] }}">
                                                                            {{ $slot1['start'] }}
                                                                        </option>
                                                                    @empty
                                                                        <option value="" disabled>No time available
                                                                        </option>
                                                                    @endforelse
                                                                </optgroup>
                                                                <optgroup label="Lunch">
                                                                    @forelse ($openingHourSlots['today']['slot2'] as $slot2)
                                                                        <option value="{{ $slot1['start'] }}">
                                                                            {{ $slot2['start'] }}
                                                                        </option>
                                                                    @empty
                                                                        <option value="" disabled>No time available
                                                                        </option>
                                                                    @endforelse
                                                                </optgroup>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Please select a timing.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-light text-primary btn-block w-100 mt-5"
                                        id="reserveBtn">Reserve</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="text-center">
                <h3>Sorry, Reservation is closed.</h3>
            </div>
        @endif
    </div>

    {{-- Modal for success or error --}}
    <div class="modal fade" id="myModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Booked Successfully!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Thank you for your booking. You'll receive confirmation email soon.
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/calendar.css') }}">
    {{-- Style of select input tag --}}
    <style>
        /* Style the select element */
        .time-select {
            background-color: white;
            /* Dark background */
            color: var(--bs-blue);
            /* White text */
            padding: 5px;
            /* Optional: padding */
            border: 1px solid white;
        }

        /* Style the option elements */
        .time-select option {
            color: white;
            background-color: transparent;
        }

        /* Style the optgroup labels (works in some browsers) */
        .time-select optgroup {
            color: #fff;
        }

        .time-select optgroup option:disabled {
            color: wheat;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectedDate = document.getElementById('selected-date');
            const restimeSelect = document.getElementById('restime');

            // Define your opening hour slots here or get it from server
            const openingHourSlots = @json($openingHourSlots);

            function updateTimes() {
                const currentDate = new Date();
                const currentFormattedDate = defaultDate.toISOString().split('T')[0];
                const hiddenBookingInput = document.getElementById("hidden-booking-date");
                hiddenBookingInput.value = selectedDate
                    .value; // Set value to hidden-booking-date that remove validation

                const date = new Date(selectedDate.value);
                const dayOfWeek = date.getDay(); // 0 (Sunday) to 6 (Saturday)

                // Check whether it is today then adjust according to today timing otherwise show regular timings.
                const slots = (currentFormattedDate == selectedDate.value ? openingHourSlots['today'] :
                    openingHourSlots[dayOfWeek]) || {
                    slot1: [],
                    slot2: []
                };

                // Clear previous options
                restimeSelect.innerHTML = '<option value="" disabled selected>Select Your Preferred Time</option>';

                // Check if there are any slots available
                let hasBreakfast = slots.slot1.length > 0;
                let hasLunch = slots.slot2.length > 0;

                if (hasBreakfast || hasLunch) {
                    // Create breakfast optgroup if there are breakfast slots
                    if (hasBreakfast) {
                        const breakfastOptgroup = document.createElement('optgroup');
                        breakfastOptgroup.label = 'Breakfast';

                        slots.slot1.forEach(slot => {
                            const option = document.createElement('option');
                            option.value = slot.start;
                            option.textContent = slot.start;
                            breakfastOptgroup.appendChild(option);
                        });
                        restimeSelect.appendChild(breakfastOptgroup);
                    }

                    // Create lunch optgroup if there are lunch slots
                    if (hasLunch) {
                        const lunchOptgroup = document.createElement('optgroup');
                        lunchOptgroup.label = 'Lunch';

                        slots.slot2.forEach(slot => {
                            const option = document.createElement('option');
                            option.value = slot.start;
                            option.textContent = slot.start;
                            lunchOptgroup.appendChild(option);
                        });
                        restimeSelect.appendChild(lunchOptgroup);
                    }
                } else {
                    // Add an option indicating no time slots are available
                    const noSlotsOption = document.createElement('option');
                    noSlotsOption.value = "#";
                    noSlotsOption.textContent = "No time slots available";
                    noSlotsOption.disabled = true;
                    restimeSelect.appendChild(noSlotsOption);
                }
            }

            // Handle changing of dates from calendar to date input
            selectedDate.addEventListener('change', updateTimes);

            // Set default date (for demonstration purposes)
            const defaultDate = new Date(); // Today
            const formattedDate = defaultDate.toISOString().split('T')[0];
            const hiddenBookingInput = document.getElementById("hidden-booking-date");
            selectedDate.value = formattedDate;
            // Set value to hidden-booking-date that remove validation
            hiddenBookingInput.value = selectedDate.value;

            // Initialize time slots based on the default date
            // updateTimes();
        });
    </script>

    {{-- For Reserve form --}}
    <script src="{{ asset('frontend/js/calendar.js') }}"></script>
    <script>
        // Example usage
        initializeCalendar({
            disabledDatesUrl: "https://example.com/api/disabled-dates",
            disabledWeekdays: @json($disabledWeekdays->get('days')),
            weekdayComments: @json($disabledWeekdays->get('reasons')),
            disabledDates: @json($disabledDates->get('days')),
            disabledDateComments: @json($disabledDates->get('reasons')),
            inputId: "selected-date",
        });
    </script>

    {{-- Form Validation --}}
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>

    {{-- Form Submit Ajax --}}
    <script>
        // Handle form submit without reload
        document.getElementById('reservationForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission
            var form = event.target;
            if (!form.checkValidity()) {
                event.stopPropagation(); // Stop further event propagation
                form.classList.add('was-validated'); // Add Bootstrap validation classes
                return;
            }
            var myModal = new bootstrap.Modal(document.getElementById('myModal'));

            const submitButton = this.querySelector('#reserveBtn');
            submitButton.disabled = true;
            submitButton.innerText = "Reserving...";

            var formData = new FormData(this);

            fetch("{{ url('routes/frontend/reservation/create') }}", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#myModal .modal-title').innerText = data?.title;
                    document.querySelector('#myModal .modal-body').innerText = data?.message;
                    myModal.show();
                    if (data.status === 'success') {
                        this.reset(); // Reset the form.
                    }
                    submitButton.disabled = false;
                    submitButton.innerText = "Reserve";
                })
                .catch(error => {
                    console.error('Error:', error)
                    submitButton.disabled = false;
                    submitButton.innerText = "Reserve";
                });
        });
    </script>
@endpush
