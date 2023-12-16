@extends("layout.layout")
@section("title")
Dashboard Home
@endsection
@section("main")

<!-- Movies Create Form -->
<div class="container-fluid pt-4 px-4">

    <div class=" bg-secondary  rounded  p-4">
        <h2 class="mb-4">Create Movies</h2>
    <form action="/adding_movie" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="title" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Rating</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="rating" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Trailers Url</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="trailer_url" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Release Date</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="release_date" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Languages</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="languages" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Time Duration</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="time_duration" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-10">
                <input class="form-control bg-dark " type="text" name="category" required>
            </div>
        </div>
        
        
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Genre</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="genre" required>
            </div>
        </div>
        

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Poster</label>
            <div class="col-sm-10">
                <input class="form-control bg-dark " type="file" name="poster" required>
            </div>
        </div>
        

        
        <button type="submit" class="btn btn-primary">Create</button>
        @csrf
    </form>
</div>





<!-- Cinemas Create Form -->
<div class="bg-secondary rounded  p-4">
    <h2 class="mb-4">Create Cinema</h2>
    <form action="/adding_cinema" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Theatre Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="Theatre_name" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Theatre Area</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="Theatre_area" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Theatre City</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="Theatre_city" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
        @csrf
    </form>
</div>



<!-- Adding  Movie id and Cinema id and timings for the shows available on each cinema-->

<div class="bg-secondary rounded  p-4">
    <div class="bg-secondary rounded h-100 p-4">
        <!-- Table for help to add cinema id in the movie_cinema_timing_table -->
        <h2 class="mb-4">Seats Creation For Each Cinema</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>S.NO </th>
                        <th>THEATRE NAME</th>
                        <th>THEATRE AREA</th>
                        <th>THEATRE CITY</th>
                        <th><a href="/seats" class="btn btn-primary m-2">Create Seats</a></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($cinemas as $cine)
                    <tr>
                        <td>{{$cine->id}}</td>
                        <td>{{$cine->Theatre_name}}</td>
                        <td>{{$cine->Theatre_area}}</td>
                        <td>{{$cine->Theatre_city}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <h2 class="mb-4">Add Movie_Cinema</h2>
    <form action="/add_movie_cinema" class="form-control bg-secondary" method="POST" enctype="multipart/form-data">
        <h5><label for="Movies">Movies</label></h5>
        <select class="form-control bg-dark" name="Movies[]" id="movies" multiple>
            @foreach($movies as $movie)
            <option value="{{ $movie->id }}" aria-required="true" >{{ $movie->title }}</option>
            @endforeach
        </select><br>

        <h5><label for="Cinemas">Cinemas</label></h5>
        <select name="Cinema[]" class="form-control bg-dark" id="cinemas" multiple>
            @foreach($cinemas as $cinema)
            <option value="{{ $cinema->id }}" aria-required="true">{{ $cinema->Theatre_name }}</option>
            @endforeach
        </select><br>

        <button type="submit" class="btn btn-primary">Add</button>
        @csrf
    </form>

    <br>
    <br>
    <br>
    <br>


    <h2 class="mb-4">Add Shows</h2>
    <form action="/add_shows" class="form-control bg-secondary" method="POST" enctype="multipart/form-data">
        <h5><label for="Movies">Movies</label></h5>

        <select class="form-control bg-dark" name="Movies[]" id="movies" multiple>
            @if($movies)
            @foreach($movies as $movieItem)
            <option value="{{ $movieItem->id }}">{{ $movieItem->title }}</option>
            @endforeach
            @endif
        </select><br>

        <h5><label for="Cinemas">Cinemas</label></h5>
        <select class="form-control bg-dark" name="Cinema[]" id="cinemas" multiple>
            @if($cinemas)
            @foreach($cinemas as $cinemaItem)
            <option value="{{ $cinemaItem->id }}">{{ $cinemaItem->Theatre_name }}</option>
            @endforeach
            @endif()
        </select><br>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Timing</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="timing" required>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Date</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="date" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Add</button>
        @csrf
    </form>
    <br>
    <br>
    <br>



    <div class="bg-secondary rounded h-100 p-4">
        <!-- Table for help to add cinema id in the movie_cinema_timing_table -->
        <h2 class="mb-4">Tickets Creation For Each Show</h2>
        <div class="table-responsive">
        <table class="table">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Movie Name</th>
            <th>Cinema Name</th>
            <th>Timing</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
                @foreach($shows as $show)
                <tr>
                    <td>{{ $show->id }}</td>
                    <td>{{ $show->movieCinema->movie->title }}</td>
                    <td>{{ $show->movieCinema->cinema->Theatre_name }}</td>
                    <td>{{ $show->timing }}</td>
                    <td>{{ $show->date }}</td>
                    <td><a href="/ticket_creation/{{$show->id}}" class="btn btn-primary m-2">Create Tickets</a></td>
                </tr>
                @endforeach
    </tbody>
</table>

        </div>
    </div>



</div>
</div>
<!-- Movie editing start-->
<!-- 
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Hoverable Table</h6>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>John</td>
                                        <td>Doe</td>
                                        <td>jhon@email.com</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>mark@email.com</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>jacob@email.com</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
<!-- Movie editing end-->

@endsection