@extends('layouts.frontend')

@section('title', 'Reservation Form')
@section('meta_description', null)
@section('meta_keywords', null)
@section('meta_image', null)

@section('content')
<div class="container col-md-4 p-4 shadow bg-primary rounded">
    <div class="row">
        <div class="text-center mb-2">
            <img src="{{ asset('assets/img/logo/logo_white.png') }}" alt="Logo" class="img-fluid"
                style="height: auto; width:100px;">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p class="mb-4 text-center text-light">For reservations above 15 people, we ask you to call +32 468/49.55.33
            </p>
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item rounded">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed bg-primary text-light px-0 fw-bolder" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                            aria-controls="flush-collapseOne">
                            <i class="far fa-calendar-alt me-2"></i> Guests
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-utensils"></i></span>
                                    <input type="number" class="form-control" id="guests" placeholder="2"
                                        value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item rounded">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed bg-primary text-light px-0 fw-bolder" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false"
                            aria-controls="flush-collapseTwo">
                            <i class="far fa-calendar-alt me-2"></i> Date
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    <input type="date" class="form-control" id="selected-date"
                                        placeholder="Select a date" readonly>
                                </div>
                            </div>
                            <div id="calendar-controls" class="mt-3">
                                <button id="prev-month">&lt;</button>
                                <span id="current-month-year"></span>
                                <button id="next-month">&gt;</button>
                            </div>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item rounded">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed bg-primary text-light px-0 fw-bolder" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false"
                            aria-controls="flush-collapseThree">
                            <i class="far fa-clock me-2"></i> Time
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    <input type="time" class="form-control" id="time" value="19:00">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-light text-primary btn-block w-100 mt-5">Reserve</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/calendar.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('frontend/js/calendar.js') }}"></script>
    <script>
        // Example usage
        initializeCalendar({
            disabledDatesUrl: "https://example.com/api/disabled-dates",
            disabledWeekdays: [0, 6],
            weekdayComments: {
                0: "Weekend - Rest Day",
                6: "Weekend - Relax",
            },
            disabledDateComments: {
                "2024-08-15": "Holiday",
                "2024-08-20": "Maintenance",
                "2024-08-25": "Meeting",
            },
            inputId: "selected-date",
        });
    </script>
@endpush
