@extends("layouts.layout")
@section("title")
Movie-Ticket-Plan
@endsection

@section("main")



<!-- ==========Banner-Section========== -->
<section class="details-banner hero-area bg_img" data-background="./assets/images/banner/banner03.jpg">
    <div class="container">
        <div class="details-banner-wrapper">
            <div class="details-banner-content">
                <h3 class="title">Venus</h3>
                <div class="tags">
                    <a href="#0">English</a>
                    <a href="#0">Hindi</a>
                    <a href="#0">Telegu</a>
                    <a href="#0">Tamil</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==========Banner-Section========== -->


<!-- ==========Movie-Section========== -->
<div class="ticket-plan-section padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 mb-5 mb-lg-0">
                <ul class="seat-plan-wrapper bg-five">
                    @php
                        $prevCinemaName = null;
                    @endphp
                    @foreach($movieInfo as $movie)
                        <li>
                            @if($movie['cinema_name'] !== $prevCinemaName)
                                <div class="movie-name">
                                    <div class="icons">
                                        <i class="far fa-heart"></i>
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <a href="#0" class="name">{{ $movie['cinema_name'] }}</a>
                                    <div class="location-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                </div>
                            @endif
                            <div class="movie-schedule">
                                <div class="item{{ $loop->first ? ' active' : '' }}" data-cinema="{{ $movie['cinema_name'] }}"  data-movie-id="{{ $movie['movie_id'] }}" data-show-id="{{ $movie['show_id'] }}">
                                    {{ $movie['timing'] }}
                                </div>
                            </div>
                        </li>
                        @php
                            $prevCinemaName = $movie['cinema_name'];
                        @endphp
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>





<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>
    $(document).ready(function() {
        $('.item').click(function() {
            var cinemaName = $(this).data('cinema');
            var movieId = $(this).data('movie-id');
            var showId = $(this).data('show-id');


            // Make AJAX request
            $.ajax({
                type: 'POST',
                url: '/handle-booking',
                data: {
                    cinemaName: cinemaName,
                    movieId: movieId,
                    _token: '{{ csrf_token() }}' // Add CSRF token for Laravel
                },
                success: function(response) {
                    // Redirect to movieseatplan page with details
                    window.location.href = '/movieseatplan?cinema=' + cinemaName+ '&movieId=' + movieId + '&showId=' + showId;
                },
                error: function(error) {
                    console.error('Error:', error);
                    // Handle error if needed
                }
            });
        });
    });
</script>

<!-- ==========Movie-Section========== -->

@endsection