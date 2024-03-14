<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class TouristDestinationController extends Controller
{
    public function getAllDestinasi() {
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
                'image_asset' => asset("storage/destinasi/".$destinasi->image_asset),
                'image_urls' => json_decode($destinasi->image_urls),
            ];

        }
        return new ApiResource(true, "All Destinations", $formatted_destinations, 200, 'OK', ['WWW-Authenticate' => 'Bearer']);
    }

    public function getDestinasiById($id) {
        $tourist_destination = DB::table('tourist_destinations')->where('id', $id)->first();
        $formatted_destination = [
            'id' => $tourist_destination->id,
            'name' => $tourist_destination->name,
            'description' => $tourist_destination->description,
            'location' => $tourist_destination->location,
            'is_open' => $tourist_destination->is_open == 1 ? true : false,
            'open_days' => $tourist_destination->open_days,
            'open_time' => $tourist_destination->open_time,
            'ticket_price' => $tourist_destination->ticket_price,
            'image_asset' => asset("storage/destinasi/".$tourist_destination->image_asset),
            'image_urls' => json_decode($tourist_destination->image_urls),
        ];
        return new ApiResource(true, "Destination Found", $formatted_destination, 200, 'OK', ['WWW-Authenticate' => 'Bearer']);
    }
}
