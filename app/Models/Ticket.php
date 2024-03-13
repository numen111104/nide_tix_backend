<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "tourist_destination_id",
        "booking_code",
        "quantity",
        "status",
        "total_price"  
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function touristDestination() {
        return $this->belongsTo(TouristDestination::class);
    }
}
