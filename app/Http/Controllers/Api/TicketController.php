<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use App\Models\Ticket;
use App\Models\TouristDestination;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function getTicketInfo() {
        $tickets = Ticket::where('user_id', auth()->user()->id)->get();
        $destinations = TouristDestination::find($tickets->tourist_destination_id)->get();
        $users = User::find($tickets->user_id)->get();
        $format_ticket = [
            'id' => $tickets->id,
            'nama_pemesan' => $users->name,
            'nomor_telpon' => $users->phone,
            'nama_wisata' => $destinations->name,
            'open_time' => $destinations->open_time,
            'ticket_price' => $destinations->ticket_price,
            'booking_code' => $tickets->booking_code,
            'quantity' => $tickets->quantity,
            'status' => $tickets->status,
            'total_price' => $tickets->total_price,
        ];
        return new ApiResource(true, "Your Information Ticket", $format_ticket, 200, 'OK', ['WWW-Authenticate' => 'Bearer']);
    }


}
