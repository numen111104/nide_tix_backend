<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TouristDestination extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "location",
        "open_days",
        "open_time",
        "ticket_price",
        "image_asset",
        "image_urls",
        "is_open",
    ];

    public function ticket() {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get the accessor for the image asset.
     *
     * @return Attribute
     */
    protected function image_asset(): Attribute
    {
        return Attribute::make(
            get: fn ($image_asset) => asset('/storage/destinasi/'.$image_asset),
        );
    } 
}
