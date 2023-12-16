@extends("layouts.layout")
@section("title")
Movie-Seat-Plan
@endsection

@section("main")
<!-- ==========Banner-Section========== -->
<section class="details-banner hero-area bg_img seat-plan-banner" data-background="./assets/images/banner/banner04.jpg">
    <div class="container">
        <div class="details-banner-wrapper">
            <div class="details-banner-content style-two">
                <h3 class="title">{{$cinema->Theatre_name}}</h3>
                <div class="tags">
                    <a href="#0">
                        {{$cinema->Theatre_area}}</a>
                    </a>
                    <a href="#0">{{$cinema->Theatre_city}}</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==========Banner-Section========== -->

<!-- ==========Page-Title========== -->
<section class="page-title bg-one">
    <div class="container">
        <div class="page-title-area">
            <div class="item md-order-1">
                <a href="/movieticketplan/{{ $movieId }}" class="custom-button back-button">
                    <i class="flaticon-double-right-arrows-angles"></i>back
                </a>
            </div>
            <div class="item date-item">
                <span class="date">{{$show->date}}</span>
                <select class="select-bar">
                    <option value="sc1" class="timing" data-cinemaid="{{$cinema->id}}" data-showid="{{$show->id}}">{{$show->timing}} </option>
                </select>
            </div>

            <div class="item">
                <h5 class="title">05:00</h5>
                <p>Mins Left</p>
            </div>
        </div>
    </div>
</section>
<!-- ==========Page-Title========== -->




<div class="seat-plan-section padding-bottom padding-top">
    <div class="container">
        <div class="screen-area">
            <h4 class="screen">screen</h4>
            <div class="screen-thumb">
                <img src="./assets/images/movie/screen-thumb.png" alt="movie">
            </div>
            <style>
                .selected-seat {
                    background-color: #FFD700;
                    /* Highlight color for selected seats */
                }
            </style>
            <!-- Iterate over each section -->
            @foreach(['A', 'B', 'C', 'D'] as $section)
            <!-- <h5 class="subtitle"> </h5> -->
            <div class="screen-wrapper">
                <ul class="seat-area">
                    <li class="seat-line">
                        <span>{{ $section }}</span>
                        <ul class="seat--area">
                            <!-- Iterate over seats for the current section -->
                            @foreach($seats as $seat)
                            @if (Str::startsWith($seat->seat_number, $section))
                            <li class="single-seat" data-seat-number="{{ $seat->seat_number }}">
                                <img src="./assets/images/movie/seat01.png" alt="seat"><br>
                                <span>
                                    <pre style="color: white;"> {{ $seat->seat_number }}</pre>
                                </span>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                        <span>{{ $section }}</span>
                    </li>
                </ul>
            </div>
            @endforeach


            <!-- ... Other HTML content ... -->
            <BR></BR>



            <div class="proceed-book bg_img" data-background="./assets/images/movie/movie-bg-proceed.jpg">
                <div class="proceed-to-book">
                    <div class="book-item">
                        <span></span>
                        <h3 class="title   selected_seat_numbers"></h3>
                    </div>

                    <br>
                    <br>

                    <div class="book-item">
                        <span></span>
                        <h3 class="title     selected_seats_price"></h3>
                    </div>
                    <div class="book-item">
                        <a href="/moviecheckout/{{ $show->id ?? 'show_id_not_available' }}/{{ $cinema->id ?? 'cinema_id_not_available' }}" class="custom-button">proceed</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Array to store selected seat numbers
            var selectedSeats = [];

            $('.single-seat').click(function() {
                $(this).toggleClass('selected-seat');
                var seatNumber = $(this).data('seat-number');
                var showId = $('.select-bar option:selected').data('showid');
                var cinemaId = $('.select-bar option:selected').data('cinemaid');



                // Check if the seat is already selected
                var index = selectedSeats.indexOf(seatNumber);
                if (index === -1) {
                    // Seat is not selected, add it to the array
                    selectedSeats.push(seatNumber);
                } else {
                    // Seat is already selected, remove it from the array
                    selectedSeats.splice(index, 1);
                }

                // Update the seat numbers in the "You have Choosed Seat" section
                updateSelectedSeats();

                // Make an Ajax request to update the seat status
                $.ajax({
                    type: 'POST',
                    url: '/update_seat_status',
                    data: {
                        seatNumber: seatNumber,
                        showId: showId,
                        cinemaId: cinemaId,


                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response)
                    },
                    error: function(error) {
                        console.error('Error updating seat status:', error);
                    }
                });
            });

            // Function to update the selected seats in the "You have Choosed Seat" section
            function updateSelectedSeats() {
                // Display the selected seats in the "You have Choosed Seat" section
                var selectedSeatsText = selectedSeats.join(', ');
                $('.selected_seat_numbers').text('You have Choosed Seat: ' + selectedSeatsText);

                // Define the prices for different sections
                var prices = {
                    'A': 1000,
                    'B': 1000,
                    'C': 800,
                    'D': 800,
                };

                // Calculate the total price based on the section of selected seats
                var totalPrice = selectedSeats.reduce(function(total, seat) {
                    var section = seat.charAt(0);
                    return total + prices[section];
                }, 0);

                $('.selected_seats_price').text('Total Price: ' + totalPrice);
            }

        });
    </script>
    @endsection