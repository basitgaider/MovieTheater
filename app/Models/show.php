<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\seats;
use App\Models\booking;

class Show extends Model
{
    public function bookings()
    {
        return $this->hasMany(booking::class);
    }
// Show.php

public function movieCinema()
{
    return $this->belongsTo(movie_cinema::class, 'movie_cinema_id');
}



    protected $fillable = [
        'movie_cinema_id',
        'timing',
        'date',
    ];

    use HasFactory;

    public function availableSeats()
    {
        $bookedSeatIds = $this->bookings()->pluck('seat_id');
        
        return seats::where('cinema_id', $this->cinema_id)
            ->whereNotIn('id', $bookedSeatIds)
            ->get();
    }
}
