<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    // Movie.php

// Assuming 'title' is the column representing the movie name
protected $fillable = ['title'];

}
