<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TouristDestination;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::paginate(10);
        return view('pages.tickets.index', compact("tickets"));
    }

    public function create()
    {
        $tourist_destinations = DB::table('tourist_destinations')->get();
        $users = DB::table('users')->get();
        return view('pages.tickets.create', compact('tourist_destinations', 'users'));
    }

    public function store(Request $request)
    {
        //validate req
        $request->validate([
            "quantity" => "required|numeric",
        ]);


        $ticket = new Ticket;
        $ticket->user_id = $request->user_id;
        $ticket->tourist_destination_id = $request->tourist_destination_id;
        $ticket->booking_code = "NIDE-" . rand(1, 9) . strtoupper(Str::random(5)) . $ticket->user_id . $ticket->timestamps . rand(1, 9) . strtoupper(Str::random(2));
        $ticket->quantity = $request->quantity;
        $ticket->status = "unpaid";

        $tourist_destination = TouristDestination::find($request->tourist_destination_id);
        if ($tourist_destination && is_numeric($tourist_destination->ticket_price) && $tourist_destination->ticket_price > 0) {
            $total_price = $request->quantity * $tourist_destination->ticket_price;
            $ticket->total_price = $total_price;
        } else {
            $ticket->total_price = 0;
        }
        $ticket->save();
        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully');
    }

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('pages.tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $tourist_destinations = DB::table('tourist_destinations')->get();
        $users = DB::table('users')->get();
        return view('pages.tickets.edit', compact('ticket', 'tourist_destinations', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "user_id" => "required",
            "tourist_destination_id" => "required",
            "quantity" => "required|numeric",
        ]);
        $ticket = Ticket::findOrFail($id);
        $ticket->user_id = $request->user_id;
        $ticket->tourist_destination_id = $request->tourist_destination_id;
        $ticket->quantity = $request->quantity;
        $ticket->status = "unpaid";
        $tourist_destination = TouristDestination::find($request->tourist_destination_id);
        if ($tourist_destination && is_numeric($tourist_destination->ticket_price) && $tourist_destination->ticket_price > 0) {
            $total_price = $request->quantity * $tourist_destination->ticket_price;
            $ticket->total_price = $total_price;
        } else {
            $ticket->total_price = 0;
        }
        $ticket->save();
        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully');
    }
}
