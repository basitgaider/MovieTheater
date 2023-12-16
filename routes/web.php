<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admincontroller;
use App\Http\Controllers\usercontroller;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Admin Controller work
Route::controller(admincontroller::class)->group(function (){

    //web pages routes
    route::get("/index", 'index');
    route::get('/button' , 'button');
    route::get('/chart' , 'chart');
    route::get('/element' , 'element');
    route::get('/create' , 'fetch_movie_cinema');

    
    route::get("/movieseatplan", 'showSeatPlan');

    route::get('/delete' , 'delete');
    route::get('/table' , 'table');
    route::get('/typography' , 'typography');
    // fetch user
    route::get('/table' , 'fetch_user');
    // fetch user problem msg
    route::get('/chart' , 'fetch_msg');

    //web pages routes ends
    
    
    //logout function 
    route::get('/logout' , 'logout');
    route::get('/index' , 'index');
    //adding movies
    // route::post('/adding_movie', 'addmovies');
    
}); 

// end of admincontroller


  


// user controller

Route::controller(usercontroller::class)->group(function (){
    
    //web pages routes

    route::get("/about", 'about');
    route::get("/contact", 'contact');
    route::get("/index", 'index');
    // route::get("/moviecheckout", 'moviec');
    route::get("/moviedetails", 'movied2');
    route::get("/moviedetail", 'movied2');
    route::get("/moviegrid", 'movieg');
    route::get("/movielist", 'moviel');
    route::get("/moviesp", 'moviesp');
    route::get("/signin", 'signin');
    route::get("/signup", 'signup');
    route::get("/", 'landing');
    route::post("/insert", 'insert');
    
    // logout
    Route::get('/login',  'create')->name('login');
    Route::post('/logout',  'destroy')->name('logout');

    //end of web pages routes   
    
});

// end of usercontroller 

//Add movie
Route::post('/adding_movie', [adminController::class, 'addmovies']);
Route::post('/adding_cinema', [adminController::class, 'add_cinema']);


//Show movies to display on web 
Route::get('/moviegrid', [adminController::class, 'fetchmoviesdata'])->name('admin.movies');
//Show single movie page
Route::get('/moviedetail/{id}',[admincontroller::class,'fetch_single_movie_data']);
//Delete movie
Route::get('delete_column/{deleteid}',[admincontroller::class,'delete_movie']);
//Update movie frontend
Route::get('/update_column/{updateid}',[admincontroller::class,'update']);
//update movie 
Route::put('/update_movie/{id}', [AdminController::class, 'update_movie']);
//add Movie_Cinema
route::post('/add_movie_cinema', [admincontroller::class, 'add_movie_cinema'])    ;
//add Shows 
Route::post('/add_shows', [AdminController::class, 'add_shows']);
//retrieving data of timings and returning view
Route::get('/movieticketplan/{movieid}', [AdminController::class, 'movieticketplane']);
//Seats
Route::get('/seats', [AdminController::class, 'seats']);



Route::get('/booking_confirmation', [AdminController::class, 'booking_confirmation']);

//Seats_creation
Route::post('/seat_creation', [AdminController::class, 'create_seats']);
 
Route::post('/payment_insertion',[Admincontroller::class, 'payment']);

Route::post('/handle-booking', [AdminController::class,'handleBooking']);
Route::post('/update_seat_status', [AdminController::class,'update_seat_status']);

Route::get('/moviecheckout/{cinemaId}/{showId}', [AdminController::class,'movie_checkout']);





Route::post('/moviecheckout',  [AdminController::class,'movie_checkout']);


//Tickets
Route::get('/ticket_creation/{show_id}', [AdminController::class, 'ticket_creation']);



Route::post('/index/search', [admincontroller::class, 'index_search']);
Route::post('/movie/search', [admincontroller::class, 'movie_search']);



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        if(Auth::User()->Role ==0){
            return view('dashboard/index');
        }
        else
        {
           return view('frontend/index');
        }

    })->name('dashboard');
});



// Route::post('/logout', 'Auth\LoginController@logout')->name('logout');   
