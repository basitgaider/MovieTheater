<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class movie_cinema extends Model
{

    protected $fillable = [
        'movie_id',  
        'cinema_id', 
    ];

    use HasFactory;


    public function movie()
{
    return $this->belongsTo(Movie::class, 'movie_id');
}

public function cinema()
{
    return $this->belongsTo(Cinema::class, 'cinema_id');
}

}
