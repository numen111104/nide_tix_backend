<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class TouristDestinationController extends Controller
{
    public function getDestinasi() {
        $tourist_destinations = DB::table('tourist_destinations')->get();
        $formatted_destinations = [];
        foreach ($tourist_destinations as $destinasi) {
            $formatted_destinations[] = [
                'id' => $destinasi->id,
                'name' => $destinasi->name,
                'description' => $destinasi->description,
                'location' => $destinasi->location,
                'is_open' => $destinasi->is_open == 1 ? true : false,
                'open_days' => $destinasi->open_days,
                'open_time' => $destinasi->open_time,
                'ticket_price' => $destinasi->ticket_price,
                'image_asset' => asset($destinasi->image_asset),
                'image_urls' => json_decode("storage/destinasi/".$destinasi->image_urls),
            ];

        }
        return new ApiResource(true, "All Destinations", $formatted_destinations, 200, 'OK', ['WWW-Authenticate' => 'Bearer']);
    }
}
