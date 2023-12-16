<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contact;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;


class usercontroller extends Controller
{
    public function about(){
        return view("frontend/about");
    }
    public function contact(){
        return view("frontend/contact");
    }
    
    public function index()
    {
        // Fetch the first 6 movies (or adjust the logic based on your requirements)
        $movies = Movie::take(6)->get();

        return view('frontend.index', compact('movies'));
    }
    public function moviec(){
        return view("frontend/movie-checkout");
    }
    public function movied2(){
        return view("frontend/movie-details-2");
    }
    public function movied(){
        return view("frontend/movie-details");
    }
    // public function movieg(){
    //     return view("frontend/movie-grid");
    // }
    public function moviel(){
        return view("frontend/movie-list");
    }
    public function moviesp(){
        return view("frontend/moviesp");
    }
    // public function movietp(){
    //     return view("frontend/movie-ticket-plan");
    // }
    public function signin(){
        return view("frontend/sign-in");
    }
    public function signup(){
        return view("frontend/sign-up");
    }
    public function landing(){
        return view("frontend/landing");
    }

    public function insert(Request $req)
    {
        $user = new contact;
        $user->Name = $req->name;
        $user->Email = $req->email;
        $user->Subject = $req->subject;
        $user->Message = $req->message;
        $user->save();

        return redirect()->back()->with("msg" , "Your Message sent to admin");
    }

    // logout
    public function create()
    {
        return view('auth.login');
    }


    public function destroy(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }
  
}
