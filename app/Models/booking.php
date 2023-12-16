<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
    use HasFactory;
    public function ticket()
    {
        return $this->belongsTo(ticket::class);
    }
    public function tickets()
    {
        // Assuming your Ticket model is named Ticket
        return $this->hasMany(ticket::class);
    }
    public function show()
    {
        return $this->belongsTo(show::class, 'show_id');
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class, 'cinema_id');
    }
}
