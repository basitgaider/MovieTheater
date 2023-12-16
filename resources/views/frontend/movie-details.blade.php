@extends("layouts.layout")
@section("title")
Movie-Detail
@endsection

@section("main")

<!-- ==========Banner-Section========== -->
<section class="details-banner bg_img" data-background="{{ asset('./assets/images/banner/banner03.jpg') }}">
    <div class="container">
        <div class="details-banner-wrapper">
            <div class="details-banner-thumb">
                <img src=" {{ asset($singlemovie->poster) }}" alt="movie">

            </div>
            <div class="details-banner-content offset-lg-3">
                <h3 class="title">{{ $singlemovie->title }}</h3>
                <div class="tags">
                    <p>{{$singlemovie->Languages}}</p>
                </div>
                <a href="#0" class="button">{{$singlemovie->genre}}</a><br>
                <a href="{{asset($singlemovie->trailer_url)}}" class="video-popup button">
                    Watch Trailer
                </a>
                <div class="social-and-duration">
                    <div class="duration-area">
                        <div class="item">
                            <i class="fas fa-calendar-alt"></i><span>{{$singlemovie->release_date}}</span>
                        </div>
                        <div class="item">
                            <i class="far fa-clock"></i><span>{{$singlemovie->time_duration}}</span>
                        </div>
                    </div>
                    <ul class="social-share">
                        <li><a href="#0"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#0"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#0"><i class="fab fa-pinterest-p"></i></a></li>
                        <li><a href="#0"><i class="fab fa-linkedin-in"></i></a></li>
                        <li><a href="#0"><i class="fab fa-google-plus-g"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==========Banner-Section========== -->
<!-- ==========Book-Section========== -->
<section class="book-section bg-one">
    <div class="container">
        <div class="book-wrapper offset-lg-3">
            <div class="left-side">
                <div class="item">
                    <div class="item-header">
                        <div class="thumb">
                            <img src="{{ asset('assets/images/movie/tomato2.png') }}" alt="movie">
                        </div>
                        <div class="counter-area">
                            <span class="counter-item odometer" data-odometer-final="88">0</span>
                        </div>
                    </div>
                    <p>tomatometer</p>
                </div>
                <div class="item">
                    <div class="item-header">
                        <div class="thumb">
                            <img src="{{asset('assets/images/movie/cake2.png')}}" alt="movie">
                        </div>
                        <div class="counter-area">
                            <span class="counter-item odometer" data-odometer-final="88">0</span>
                        </div>
                    </div>
                    <p>audience Score</p>
                </div>
                <div class="item">
                    <div class="item-header">
                        <h5 class="title">4.5</h5>
                        <div class="rated">
                            <i class="fas fa-heart"></i>
                            <i class="fas fa-heart"></i>
                            <i class="fas fa-heart"></i>
                            <i class="fas fa-heart"></i>
                            <i class="fas fa-heart"></i>
                        </div>
                    </div>
                    <p>Users Rating</p>
                </div>
                <div class="item">
                    <div class="item-header">
                        <div class="rated rate-it">
                            <i class="fas fa-heart"></i>
                            <i class="fas fa-heart"></i>
                            <i class="fas fa-heart"></i>
                            <i class="fas fa-heart"></i>
                            <i class="fas fa-heart"></i>
                        </div>
                        <h5 class="title">0.0</h5>
                    </div>
                    <p><a href="#0">Rate It</a></p>
                </div>
            </div>
            <a href="{{ url('movieticketplan/' . $singlemovie->id) }}" class="custom-button">book tickets</a>
        </div>
    </div>
</section>
<!-- ==========Book-Section==========  -->
<br>
<br>
<br>
<br>

@endsection