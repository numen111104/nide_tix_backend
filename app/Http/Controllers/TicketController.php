<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TouristDestination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index() {
        $tickets = Ticket::all();
        return view('pages.tickets.index');
    }

    public function create(){
        $tourist_destination = DB::table('tourist_destinations')->get();
        return view('pages.tickets.create', compact('tourist_destination'));
    }

    public function store(Request $request) {
        //validate req
        $request->validate([
            "user_id" => "required",
            "tourist_destination_id" => "required",
            "quantity" => "required|numeric",
        ]);

        //store
        $ticket = new Ticket;
        $ticket->user_id = $request->user_id;
        $ticket->tourist_destination_id = $request->tourist_destination_id;
        $ticket->booking_code = "NIDE-".rand(1000, 9999);
        $ticket->quantity = $request->quantity;
        $ticket->save();
        return redirect()->route('tickets.index');
    }
}
