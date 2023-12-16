@extends("layouts.layout")
@section("title")
Movie-Grid
@endsection

@section("main")

<!-- ==========Banner-Section========== -->
<section class="banner-section">
    <div class="banner-bg bg_img bg-fixed" data-background="./assets/images/banner/banner02.jpg"></div>
    <div class="container">
        <div class="banner-content">
            <h1 class="title bold">get <span class="color-theme">movie</span> tickets</h1>
            <p>Buy movie tickets in advance, find movie times watch trailers, read movie reviews and much more</p>
        </div>
    </div>
</section>
<!-- ==========Banner-Section========== -->

<!-- ==========Ticket-Search========== -->
<section class="search-ticket-section padding-top pt-lg-0">
    <div class="container">
        <div class="search-tab bg_img" data-background="{{asset('./assets/images/ticket/ticket-bg01.jpg')}}">
            <div class="row align-items-center mb--20">
                <div class="col-lg-6 mb-20">
                    <div class="search-ticket-header">
                        <h6 class="category">welcome to Movie Theatre </h6>
                        <h3 class="title">what are you looking for</h3>
                    </div>
                </div>

            </div>
            <div class="tab-area">
                <div class="tab-item active">

                    <form class="ticket-search-form" action="{{ url('/movie/search') }}" method="post">
                        @csrf
                        <div class="form-group large">
                            <input type="text" name="search_query" placeholder="Search for Movies">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src="{{asset('./assets/images/ticket/city.png')}}" alt="ticket">
                            </div>
                            <span class="type">Genres</span>
                            <select name="genre" class="select-bar">
                                <option value="">All Genre</option>
                                <option value="Adventure">Adventure</option>
                                <option value="Thriller">Thriller</option>
                                <option value="Horror">Horror</option>
                                <option value="Drama">Drama</option>
                                <option value="Romance">Romance</option>
                                <option value="Action">Action</option>
                                <option value="Comedy">Comedy</option>
                                <option value="Sci-Fi">Sci-Fi</option>
                                <option value="Animation">Animation</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src="{{asset('./assets/images/ticket/date.png')}}" alt="ticket">
                            </div>
                            <span class="type">Categories</span>
                            <select name="category" class="select-bar">
                                <option value="">All Category</option>
                                <option value="Bollywood">Bollywood</option>
                                <option value="Hollywood">Hollywood</option>
                                <option value="Tollywood">Tollywood</option>
                                <option value="Lollywood">Lollywood</option>
                            </select>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</section>
<!-- ==========Ticket-Search========== -->

<!-- ==========Movie-Section========== -->
<section class="movie-section padding-top padding-bottom">
    <div class="container">
        <div class="row flex-wrap-reverse justify-content-center">
        <div class="col-lg-3 col-sm-10  mt-50 mt-lg-0">
                <div class="widget-1 widget-facility">
                    <div class="widget-1-body">
                        <ul>
                            <li>
                                <a href="#0">
                                    <span class="img"><img src="{{asset('./assets/images/sidebar/icons/sidebar01.png')}}" alt="sidebar"></span>
                                    <span class="cate">24X7 Care</span>
                                </a>
                            </li>
                            <li>
                                <a href="#0">
                                    <span class="img"><img src="{{asset('./assets/images/sidebar/icons/sidebar02.png')}}" alt="sidebar"></span>
                                    <span class="cate">100% Assurance</span>
                                </a>
                            </li>
                            <li>
                                <a href="#0">
                                    <span class="img"><img src="{{asset('./assets/images/sidebar/icons/sidebar03.png')}}" alt="sidebar"></span>
                                    <span class="cate">Our Promise</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 mb-50 mb-lg-0">
                <div class="filter-tab tab">
                    <div class="filter-area">
                        <div class="filter-main">
                            <div class="left">
                                <div class="item">
                                    <span class="show">Show :</span>
                                    <select class="select-bar">
                                        <option value="12">12</option>
                                        <option value="15">15</option>
                                        <option value="18">18</option>
                                        <option value="21">21</option>
                                        <option value="24">24</option>
                                        <option value="27">27</option>
                                        <option value="30">30</option>
                                    </select>
                                </div>
                                <div class="item">
                                    <span class="show">Sort By :</span>
                                    <select class="select-bar">
                                        <option value="showing">now showing</option>
                                        <option value="exclusive">exclusive</option>
                                        <option value="trending">trending</option>
                                        <option value="most-view">most view</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-item active">
                        <div class="row mb-10 justify-content-center">
                            <!-- Movies Panel -->
                            @if(isset($moviesdata))
                            @foreach($moviesdata as $md)
                            <div class="col-sm-6 col-lg-4">
                                <div class="movie-grid">
                                    <div class="movie-thumb c-thumb">
                                        <a href="{{ url('moviedetail/' . $md->id) }}">
                                            <img src="{{ asset($md->poster) }}" alt="movie">
                                        </a>
                                    </div>
                                    <div class="movie-content bg-one">
                                        <h3 class="title m-0" >
                                            <a href="{{ url('moviedetail/' . $md->id) }}">{{ $md->title }}</a>
                                        </h3>
                                        <h6> IMBD Rating :   {{ $md->rating }}</h6>
                                        <br>
                                        <h6>Genres : {{ $md->genre }}</h6><br>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @if(isset($s_movies)&&$s_movies->count()>0)
                    @foreach($s_movies as $s_movie)
                        <div class="col-sm-6 col-lg-4">
                            <div class="movie-grid">
                                <div class="movie-thumb c-thumb">
                                    <a href="{{ url('moviedetail/' . $s_movie->id) }}">
                                        <img src="{{$s_movie->poster }}" alt="movie">
                                    </a>
                                </div>
                                <div class="movie-content bg-one">
                                    <h3 class="title m-0">
                                        <a href="{{ url('moviedetail/' . $s_movie->id) }}">{{ $s_movie->title }}</a>
                                    </h3>
                                    <h6> IMBD Rating : {{ $s_movie->rating }}</h6>
                                    <br>
                                    <h6>Genres : {{ $s_movie->genre }}</h6>
                                    <br>

                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif


                        </div>
                    </div>

                    <div class="pagination-area text-center">
                    @if(isset($moviesdata))
                    @if($moviesdata->currentPage() > 1)
                            <a href="{{ $moviesdata->previousPageUrl() }}" class="pagination-link">Prev</a>
                        @endif

                        @for ($i = 1; $i <= $moviesdata->lastPage(); $i++)
                            <a href="{{ $moviesdata->url($i) }}" class="pagination-link {{ $moviesdata->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                        @endfor

                        @if($moviesdata->currentPage() < $moviesdata->lastPage())
                            <a href="{{ $moviesdata->nextPageUrl() }}" class="pagination-link">Next</a>
                        @endif
                        @endif

                    


                        @if(isset($s_movies))
                        @if($s_movies->currentPage() > 1)
                            <a href="{{ $s_movies->previousPageUrl() }}" class="pagination-link">Prev</a>
                        @endif

                        @for ($i = 1; $i <= $s_movies->lastPage(); $i++)
                            <a href="{{ $s_movies->url($i) }}" class="pagination-link {{ $s_movies->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                        @endfor

                        @if($s_movies->currentPage() < $s_movies->lastPage())
                            <a href="{{ $s_movies->nextPageUrl() }}" class="pagination-link">Next</a>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==========Movie-Section========== -->
@endsection