<?php

namespace App\Http\Controllers;

use App\Models\booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\contact;
use App\Models\User;
use App\Models\show;
use App\Models\Cinema;
use App\Models\payment;
use App\Models\ticket;
use App\Models\movie_cinema;
use App\Models\seats;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Validator; // Use the Validator facade directly
use Illuminate\Validation\Validator as IlluminateValidator; // Import the Validator class directly
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image; // Corrected use statement for Image
use Illuminate\Support\Facades\Log;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class admincontroller extends Controller
{
    public function button()
    {
        return view("dashboard/button");
    }
    public function chart()
    {
        return view("dashboard/chart");
    }
    public function element()
    {
        return view("dashboard/element");
    }

    public function table()
    {
        return view("dashboard/table");
    }
    public function typography()
    {
        return view("dashboard/typography");
    }


    public function logout()
    {
        Auth::logout();
        return view("frontend/landing");
    }



    //ADD MOVIES

    public function addmovies(Request $req)
    {

        $movies = new movie();

        $validator = Validator::make($req->all(), [
            'title' => 'required|string|max:255',
            'rating' =>  'required|string|max:255',
            'genre' => 'required|string|max:255',
            'trailer_url' => 'required|string|max:255',
            'release_date' => 'required|string|max:255',
            'languages' => 'required|string',
            'category' => 'required|string',
            'poster' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $movies->title = $req->title;
        $movies->rating = $req->rating;
        $movies->genre = $req->genre;
        $movies->trailer_url = $req->trailer_url;
        $movies->release_date = $req->release_date;
        $movies->languages = $req->languages;
        $movies->category = $req->category;
        $movies->time_duration = $req->time_duration;

        // Check if a file is uploaded
        if ($req->hasFile('poster') && $req->file('poster')->isvalid()) {
            $poster = $req->file('poster');
            $ext = rand() . '.' . $poster->getClientOriginalExtension();

            // Save the resized image to the public/uploads directory
            $poster->move(public_path('/uploads/movie-posters/'), $ext);
            // Save the file path to the database
            $movies->poster = '/uploads/movie-posters/' . $ext;
        } else {
            // File upload failed
            return redirect()->back()->with(['error1'=> 'Failed to upload poster image.']);
        }


        // Save the movie to the database

        $movies->save();



        return redirect()->back()->with(["movie_added" => "Movie Added Successfully" ]);
    }

    // Fetching data for movies to display on front end
    public function fetchMoviesData()
    {
        $moviesdata = Movie::paginate(6);
        return view('frontend.movie-grid', compact('moviesdata'));
    }

    // Fetching data for a sigle movie to display on front end
    public function fetch_single_movie_data($id)
    {
        $singlemovie = Movie::Find($id);
        return view('frontend.movie-details', compact('singlemovie'));
    }
    //display frontend for delete.blade.php
    public function delete()
    {
        $moviesdata = Movie::all();
        return view("dashboard/delete", compact('moviesdata'));
    }
    //delete movie function
    public function delete_movie($deleteid)
    {
        $delete_movie_column = Movie::find($deleteid);
        $delete_movie_column->delete();
        return redirect()->back();
    }
    //display frontend for update.blade.php
    public function update($updateid)
    {
        $update_movie_column = Movie::find($updateid);
        return view("dashboard/update", compact('update_movie_column'));
    }

    //update movie function
    public function update_movie(Request $req, $id)
    {
        // Log that the update_movie method has been reached
        Log::info('Reached update_movie method');

        try {
            // Check if $id is a valid positive integer
            if (!is_numeric($id) || $id <= 0) {
                // If not valid, redirect back with an error message
                return redirect()->back()->with('error', 'Invalid movie ID.');
            }

            // Find the movie by its ID, or throw a 404 error if not found
            $updatemovie = Movie::findOrFail($id);

            // Validate the request data using specified rules
            $validator = Validator::make($req->all(), [
                'title' => 'required|string|max:255',
                'rating' =>  'required|string|max:255',
                'genre' => 'required|string|max:255',
                'trailer_url' => 'required|string|max:255',
                'release_date' => 'required|string|max:255',
                'languages' => 'required|string',
                'poster' => 'image|mimes:jpeg,png,jpg,gif,svg,avif|max:2048', // Adjust image validation rules
            ]);

            // If validation fails, redirect back with validation errors and input data
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // If the request contains a new poster file, handle it
            if ($req->hasFile('poster')) {
                // Get information about the uploaded file
                $filenamewithextension = $req->file('poster')->getClientOriginalName();
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $extension = $req->file('poster')->getClientOriginalExtension();
                $filenametostore = $filename . '_' . time() . '.' . $extension;
                $path = $req->file('poster')->storeAs('public/uploads/movie-posters/', $filenametostore);

                // Remove the existing poster file
                Storage::delete('public/uploads/movie-posters/' . $updatemovie->poster);

                // Update the movie model with the new poster filename
                $updatemovie->poster = $filenametostore;
            }

            // Update the movie model with other request data
            $updatemovie->title = $req->title;
            $updatemovie->rating = $req->rating;
            $updatemovie->genre = $req->genre;
            $updatemovie->trailer_url = $req->trailer_url;
            $updatemovie->release_date = $req->release_date;
            $updatemovie->languages = $req->languages;
            $updatemovie->time_duration = $req->time_duration;
            $updatemovie->category = $req->category;

            // Save the updated movie model to the database
            $updatemovie->save();

            // Redirect to the delete dashboard with a success message
            return redirect('/delete')->with(['Movie_updation'=> 'Movie updated successfully.']);
        } catch (\Exception $e) {
            // Log any exceptions that occur during the update process
            Log::error('Error in update_movie: ' . $e->getMessage());

            // If an exception occurs, redirect back with an error message
            return redirect()->back()->with('error', 'An error occurred during the update.');
        }
    }

    //function to add entries in Movie CInema table;
    public function add_movie_cinema(Request $request)
    {
        // Validate the form data (you can customize the validation rules)

        if($request == null){
        $request->validate([
            'Movies' => 'required|array',
            'Cinema' => 'required|array',
        ]);

        // Assuming you have a model named MovieCinema
        foreach ($request->input('Movies') as $movieId) {
            foreach ($request->input('Cinema') as $cinemaId) {
                // Create a new MovieCinema record for each combination of movie and cinema
                movie_cinema::create([
                    'movie_id' => $movieId,
                    'cinema_id' => $cinemaId,
                ]);
            }
        }
        // You can add a success message or redirect the user to another page
        return redirect()->back()->with(['Movie_Cinema_Add'=> 'Movie_Cinema addedsuccessfully.']);
    }else{
        return response()->json("No Movie and Cinema Selected");
    }
}

    //create cinema
    public function add_cinema(Request $request){
        $cinema = new Cinema();
        $cinema->Theatre_name = $request->Theatre_name;
        $cinema->Theatre_city = $request->Theatre_city;
        $cinema->Theatre_area = $request->Theatre_area;
        $cinema->save();
        return redirect()->back()->with('success', 'Cinema addedsuccessfully.');
        

    }

    //function to fetch movie_cinema

    public function fetch_movie_cinema()
    {
        $movies = Movie::all();
        $cinemas = Cinema::all();
        $shows = show::all();

        return view("dashboard.create", compact("movies", "cinemas", "shows"));
    }

    // function to add entries in Shows table
    public function add_shows(Request $request)
    {
        // Validate the form data
        $request->validate([
            'Movies' => 'required|array',
            'Cinema' => 'required|array',
            'timing' => 'required|string',
            'date' => 'required|string',
        ]);

        foreach ($request->input('Movies') as $movieId) {
            foreach ($request->input('Cinema') as $cinemaId) {
                // Find the movie_cinema record based on selected movie and cinema
                $movieCinema = movie_cinema::where('movie_id', $movieId)
                    ->where('cinema_id', $cinemaId)
                    ->first();

                if ($movieCinema) {
                    // Create a new Show record with the found movie_cinema_id
                    Show::create([
                        'movie_cinema_id' => $movieCinema->id,
                        'timing' => $request->input('timing'),
                        'date' => $request->input('date'),
                    ]);
                }
            }
        }
        // Redirect to the dashboard with a success message
        return redirect()->back()->with(['Show_Add'=> 'Shows  addedsuccessfully.']);
    }

    //function to delete entries in movie cinema timings table
    // I will write this function After completing movietickplan page

    //function to retrieve data for specidic movie which id is given in url the data is that in which cinema that movie will be shoed and on what timing
    // public function movieticketplane($movieid){
    // Get the movie_cinema model with the specified id
    // $movie_cinema = movie_cinema_::where('movie_id' ,$movieid )->get();

    public function movieticketplane($movieid)
    {
        // Get the movie_cinema models with the specified movie_id
        $movieCinemas = movie_cinema::where('movie_id', $movieid)->get();

        // Check if any movie_cinemas were found
        if ($movieCinemas->isEmpty()) {
            // Handle the case where no data is found for the given movie ID
            return response()->json(['error' => 'No data found for the specified movie ID'], 404);
        }

        // Now, you can loop through each movie_cinema and retrieve the related information
        $movieInfo = [];

        foreach ($movieCinemas as $movieCinema) {
            // Get cinema name from the Cinema model
            $cinema = Cinema::find($movieCinema->cinema_id);

            // Get timing from the Shows model based on the movie_cinema_id
            $show = Show::where('movie_cinema_id', $movieCinema->id)->first();
            $timing = ($show) ? $show->timing : null;

            // Add the information to the result array
            $movieInfo[] = [
                'cinema_name' => ($cinema) ? $cinema->Theatre_name : null,
                'timing' => $timing,
                'movie_id' => $movieCinema->movie_id,
                'show_id' => $show->id
            ];
        }
        return view("frontend.movie-ticket-plan", compact("movieInfo"));
    }

    //display fronend for seats.blade.php
    public function seats()
    {
        $cinemas = Cinema::all();
        return view("dashboard.seats", compact("cinemas"));
    }


    public function create_seats(Request $request)
    {
        // Validation
        $request->validate([
            'Cinema' => 'required|array',
            'class' => 'required|array',
            'seat_no' => 'required|string',
        ]);

        // Get the selected cinemas and classes
        $cinemas = $request->input('Cinema');
        $classes = $request->input('class');

        // Split the seat numbers entered in the input field
        $seatNumbers = explode(',', $request->input('seat_no'));

        // Loop through selected cinemas, classes, and seat numbers to create seats
        foreach ($cinemas as $cinemaId) {
            foreach ($classes as $class) {
                foreach ($seatNumbers as $seatNumber) {
                    $seat = new Seats();
                    $seat->cinema_id = $cinemaId;
                    $seat->class = $class;
                    $seat->seat_number = trim($seatNumber); // Trim to remove any extra spaces
                    $seat->save();
                }
            }
        }

        return redirect("/create")->with(["seats_created" => "Seats Created Successfully."]);
    }


    public function handleBooking(Request $request)
    {
        $cinemaName = $request->input('cinemaName');
        $timing = $request->input('timing');
        $movieId = $request->input('movieId');

        // Your booking logic goes here

        // Return a response
        return response()->json(['message' => 'Booking successful']);
    }

    // user data fetch

    public function fetch_user()
    {
        $user = User::all();

        return view("dashboard.table", compact("user"));
    }

    // user issue printed

    public function fetch_msg()
    {
        $user = contact::all();

        return view("dashboard.chart", compact("user"))->with(["client_issue" => "Client Issues Printed Succesfully."]);
    }



    public function showSeatPlan(Request $request)
    {
        // Validate showId
        $request->validate([
            'showId' => 'required|exists:shows,id',
        ]);
    
        try {
            // Retrieve the show details along with its associated cinema
            $show = Show::with('movieCinema.cinema')
                ->findOrFail($request->query('showId'));
    
            // Extract the cinema from the show details
            $cinema = $show->movieCinema->cinema;
    
            // Retrieve seats for the specific cinema excluding booked seats
            $seats = seats::where('cinema_id', $cinema->id)
                ->whereNotIn('id', function ($query) use ($show) {
                    $query->select('seat_id')
                        ->from('tickets')
                        ->where('show_id', $show->id)
                        ->where('is_booked', true);
                })
                ->get();
    
            // Pass the data to the view or perform any other actions
            return view('frontend.movie-seat-plan', [
                'show' => $show,
                'seats' => $seats,
                'movieId' => $request->query('movieId'),
                'cinema' => $cinema
            ]);
        } catch (\Exception $e) {
            // Handle exceptions, log the error, and return an appropriate response
            log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching seat information'], 500);
        }
    }
    



    // public function movie_checkout(Request $request)
    // {
    //     $request->validate([
    //         'seatNumber' => 'required|string', 
    //     ]);

    //     try {
    //         // Find the seat based on the seat number
    //         $seat = seats::where('seat_number', $request->input('seatNumber'))->first();

    //         if (!$seat) {
    //             // Handle case where seat is not found
    //             return response()->json(['error' => 'Seat not found'], 404);
    //         }

    //         // Find the ticket based on the seat id
    //         $ticket = Ticket::where('seat_id', $seat->id)->first();

    //         if (!$ticket) {
    //             // Handle case where ticket is not found
    //             return response()->json(['error' => 'Ticket not found'], 404);
    //         }

    //         // Update the is_booked status to true
    //         $ticket->update(['is_booked' => true]);

    //         return view("frontend.movie-checkout");
    //     } catch (\Exception $e) {
    //         // Log the exception or handle it accordingly
    //         Log::error($e->getMessage());
            
    //         return response()->json(['error' => 'An error occurred while updating the ticket'], 500);
    //     }
    // }





    public function ticket_creation($showId)
    {
        // Retrieve the show details
        $show = Show::findOrFail($showId);

        // Get the movieCinema and cinema_id
        $movieCinema = $show->movieCinema;
        $cinemaId = $movieCinema->cinema_id;

        // Retrieve the selected seats for the specified cinema and show
        $selectedSeats = seats::where('cinema_id', $cinemaId)
            ->where('status', 'available') // Assuming 'selected' is the status for chosen seats
            ->pluck('id');

        // If no selected seats found, handle the case
        if ($selectedSeats->isEmpty()) {
            Log::info('No selected seats found for show: ' . $showId);
            return redirect()->back()->with('error', 'No selected seats found for the specified show.');
        }

        // Create tickets for each selected seat
        foreach ($selectedSeats as $seatId) {
            $ticket = new Ticket();
            $ticket->seat_id = $seatId;
            $ticket->show_id = $showId;

            // Determine ticket price based on seat class
            $seat = seats::findOrFail($seatId);
            $ticket->price = ($seat->class === 'Silver') ? 800 : 1000;

            $ticket->is_booked = false;

            // Save the ticket
            $ticket->save();
        }

        // Optionally, you can update the seat status to 'booked' or perform other actions as needed

        // Redirect or return a response
        return redirect()->back()->with(['Tickets_Creation'=> 'Tickets created successfully']);
    }



    public function update_seat_status(Request $request)
    {
        $seatNumber = $request->input('seatNumber');
        $showID = $request->input('showId');
        $cinemaID = $request->input('cinemaId');
    
        // Query seats and tickets
        $seat = seats::where('seat_number', $seatNumber)->where('cinema_id', $cinemaID)->first();
        $ticket = ticket::where('show_id', $showID)->where('seat_id', $seat->id)->first();
    
        // Check if seat and ticket were found
        if (!$seat || !$ticket) {
            return response()->json(['error' => 'Seat or ticket not found'], 404);
        }
    
        // Update ticket status
        $ticket->update(['is_booked' => true]);
    
        // Create a new booking
        $booking = new Booking();
        $booking->ticket_id = $ticket->id;
        $booking->user_id = Auth::id();
        $booking->save();
    
        // Return a response with a 200 OK status
        return response()->json(['showID' => $showID, 'seatNumber' => $seatNumber]);
    }
    
    

    public function movie_checkout($cinemaId, $showId)
    {
        $cinema = Cinema::find($cinemaId);
        $show = Show::find($showId);
        $bookings = Booking::where('user_id', Auth::id())->get();
        $tickets = [];
    
        // Load tickets, seat numbers, and seat classes for each booking
        foreach ($bookings as $booking) {
            $ticket = Ticket::find($booking->ticket_id);
            if ($ticket) {
                $seat = seats::find($ticket->seat_id);
                if ($seat) {
                    $ticket->seat_number = $seat->seat_number;
                    $ticket->seat_class = $seat->class;
                    $tickets[] = $ticket;
                }
            }
        }
    
        return view('frontend.movie-checkout', compact('cinema', 'show', 'tickets'));
    }
    
    public function payment(Request $request){
        $payment = new Payment; // Assuming your model is named "Payment" and follows the naming convention
        $payment->card_details = $request->card_details;
        $payment->card_name = $request->card_name;
        $payment->expiration = $request->expiration;
        $payment->cvv = $request->cvv;
        $payment->save();
    
        return redirect()->back()->with(["payment_status" => "Payment Done"]);
    }
    public function booking_confirmation(){
        return redirect()->back()->with(["booking_confirm" =>"Your Booking Has been Done "]);
    }
    

    public function index_search(Request $request)
    {
        $searchQuery = $request->input('search_query');
        $genre = $request->input('genre');
        $category = $request->input('category');

        $query = Movie::query();

        // Add conditions based on user input
        if (!empty($searchQuery)) {
            $query->where('title', 'like', '%' . $searchQuery . '%');
        }
        if ($genre !== null && $genre !== "") { // Check if $genre is not null or an empty string
            $query->where('genre', 'like', '%' . $genre . '%');
        }

        if (!empty($category)) {
            $query->where('category', $category);
        }

        $s_movies = $query->get();

        return view('frontend.index', ['s_movies' => $s_movies]);
    }
    

    public function movie_search(Request $request)
    {
        $searchQuery = $request->input('search_query');
        $genre = $request->input('genre');
        $category = $request->input('category');
    
        $query = Movie::query();
    
        // Add conditions based on user input
        if (!empty($searchQuery)) {
            $query->where('title', 'like', '%' . $searchQuery . '%');
        }
    
        if ($genre !== null && $genre !== "") { // Check if $genre is not null or an empty string
            $query->where('genre', 'like', '%' . $genre . '%');
        }
    
        if (!empty($category)) {
            $query->where('category', $category);
        }
    
        // Use pagination
        $s_movies = $query->paginate(6); // Set the number of items per page (e.g., 6)
    
        return view('frontend.movie-grid', ['s_movies' => $s_movies]);
    }
    
    

    
}
