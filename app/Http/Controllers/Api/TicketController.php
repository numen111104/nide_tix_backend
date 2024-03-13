<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function getTickets() {
        $tickets = Ticket::where('user_id', auth()->user()->id)->get();
        foreach ($tickets as $ticket) {
            $ticket->image_urls = json_decode($ticket->image_urls);
        }
        return new ApiResource(true, "All Tickets", $tickets, 200, 'OK', ['WWW-Authenticate' => 'Bearer']);

    }
}
