<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TouristDestination;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Type\TrueType;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function getAllTicketInfo()
    {
        $data = [];
        // Periksa apakah pengguna sudah login
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $tickets = DB::table('tickets')->where('user_id', $user_id)->get(); // Menggunakan where() untuk mencocokkan user_id
            foreach ($tickets as $ticket) {
                $destination = TouristDestination::find($ticket->tourist_destination_id);
                $user = User::find($ticket->user_id);
                $data[] = [
                    'id' => $ticket->id,
                    'nama_pemesan' => $user->name,
                    'nomor_telpon' => $user->phone,
                    'nama_wisata' => $destination->name,
                    'open_time' => $destination->open_time,
                    'ticket_price' => $destination->ticket_price,
                    'booking_code' => $ticket->booking_code,
                    'is_used' => $ticket->is_used,
                    'quantity' => $ticket->quantity,
                    'status' => $ticket->status,
                    'total_price' => $ticket->total_price,
                ];
            }
            // Kembalikan respons
            if (count($data) > 0) {
                return new ApiResource(true, "Your Information Ticket", $data, 200, 'OK', ['WWW-Authenticate' => 'Bearer']);
            } else {
                return new ApiResource(true, "Ticket Empty", null, 200, 'OK', ['WWW-Authenticate' => 'Bearer']);
            }
        } else {
            return new ApiResource(false, "Unauthorized", null, 401, 'Unauthorized', ['WWW-Authenticate' => 'Bearer']);
        }
    }
    


    public function orderTicket(Request $request)
{
    // Pastikan pengguna telah terautentikasi
    if (!auth()->check()) {
        return new ApiResource(false, "Unauthorized", null, 401, 'Unauthorized', ['WWW-Authenticate' => 'Bearer']);
    }
    $validator = Validator::make($request->all(), [
        'quantity' => 'required',
        'tourist_destination_id' => 'required|exists:tourist_destinations,id', // Menambahkan validasi bahwa destinasi wisata harus ada
    ]); 
    if ($validator->fails()) {
        return new ApiResource(false, $validator->errors()->first(), null, 400, 'Bad Request', ['WWW-Authenticate' => 'Bearer']);
    }
    $tourist_destination = TouristDestination::find($request->tourist_destination_id);
    if (!$tourist_destination) {
        return new ApiResource(false, "Tourist destination not found", null, 404, 'Not Found', ['WWW-Authenticate' => 'Bearer']);
    }
    // Hitung total harga tiket
    $total_price = $request->quantity * $tourist_destination->ticket_price;
    // Buat tiket baru
    $ticket = Ticket::create([
        'user_id' => auth()->id(),
        'tourist_destination_id' => $request->tourist_destination_id,
        'quantity' => $request->quantity,
        'status' => "unpaid",
        'total_price' => $total_price,
    ]);

    // Simpan tiket baru
    $ticket->save();

    $user = User::find(auth()->id());
    $data = [
        'id' => $ticket->id,
        'nama_pemesan' => $user->name,
        'nomor_telpon' => $user->phone,
        'nama_wisata' => $tourist_destination->name,
        'open_time' => $tourist_destination->open_time,
        'ticket_price' => $tourist_destination->ticket_price,
        'is_used' => false,
        'quantity' => $ticket->quantity,
        'status' => $ticket->status,
        'total_price' => $ticket->total_price,
    ];

    return new ApiResource(true, "Ticket created successfully", $data, 201, 'Created', ['WWW-Authenticate' => 'Bearer']);
}
    public function updateTicket(Request $request, $ticketId)
    {
        // Temukan tiket yang ingin diperbarui
        $ticket = Ticket::find($ticketId);
        // Jika tiket tidak ditemukan, kembalikan respons
        if (!$ticket) {
            return new ApiResource(false, "Ticket not found", null, 404, 'Not Found', ['WWW-Authenticate' => 'Bearer']);
        }
        // Validasi data yang diterima
        $validator = Validator::make($request->all(), [
            'quantity' => 'required',
            'tourist_destination_id' => 'required',
        ]);
        // Jika validasi gagal, kembalikan respons dengan pesan kesalahan
        if ($validator->fails()) {
            return new ApiResource(false, $validator->errors()->first(), null, 400, 'Bad Request', ['WWW-Authenticate' => 'Bearer']);
        }
        // Temukan destinasi wisata yang baru
        $tourist_destination = TouristDestination::find($request->tourist_destination_id);
        // Perbarui tiket
        $ticket->update([
            'tourist_destination_id' => $request->tourist_destination_id,
            'quantity' => $request->quantity,
            'total_price' => $request->quantity * $tourist_destination->ticket_price
        ]);
        // Ambil user berdasarkan id
        $user = User::find(auth()->id());
        // Bangun data untuk respons
        $data = [
            'id' => $ticket->id,
            'nama_pemesan' => $user->name,
            'nomor_telpon' => $user->phone,
            'nama_wisata' => $tourist_destination->name,
            'open_time' => $tourist_destination->open_time,
            'ticket_price' => $tourist_destination->ticket_price,
            'booking_code' => $ticket->booking_code,
            'is_used' => $ticket->is_used,
            'quantity' => $ticket->quantity,
            'status' => $ticket->status,
            'total_price' => $ticket->total_price,
        ];
        // Kembalikan respons
        return new ApiResource(true, "Ticket updated successfully", $data, 200, 'OK', ['WWW-Authenticate' => 'Bearer']);
    }
    

    //cancel ticket
    public function cancelTicket($id)
{
    $ticket = Ticket::find($id);
    // Periksa apakah tiket ditemukan
    if (!$ticket) {
        return new ApiResource(false, "Ticket not found", null, 404, 'Not Found', ['WWW-Authenticate' => 'Bearer']);
    }
    // Periksa apakah tiket sudah dibatalkan atau sudah dibayar
    if ($ticket->status == "canceled") {
        return new ApiResource(false, "Ticket already canceled", null, 400, 'Bad Request', ['WWW-Authenticate' => 'Bearer']);
    } elseif ($ticket->status == "paid") {
        return new ApiResource(false, "Unable to cancel ticket, it's already paid", null, 400, 'Bad Request', ['WWW-Authenticate' => 'Bearer']);
    }
    // Periksa apakah pengguna yang ingin membatalkan tiket adalah pemilik tiket
    if ($ticket->user_id != auth()->id()) {
        return new ApiResource(false, "Unauthorized to cancel this ticket", null, 403, 'Forbidden', ['WWW-Authenticate' => 'Bearer']);
    }
    // Update status tiket menjadi dibatalkan
    $ticket->status = "canceled";
    $ticket->save();
    return new ApiResource(true, "Ticket canceled successfully", null, 200, 'OK', ['WWW-Authenticate' => 'Bearer']);
}

public function generateBookingCode($ticketId)
{
    // Temukan tiket berdasarkan ID
    $ticket = Ticket::find($ticketId);
    // Periksa apakah tiket ditemukan
    if (!$ticket) {
        return new ApiResource(false, "Ticket not found", null, 404, 'Not Found', ['WWW-Authenticate' => 'Bearer']);
    }
    // Periksa apakah status tiket sudah "paid"
    if ($ticket->status != "paid") {
        return new ApiResource(false, "Ticket status is not paid yet", null, 400, 'Bad Request', ['WWW-Authenticate' => 'Bearer']);
    }
    // Periksa apakah tiket sudah ada booking code
    if ($ticket->booking_code) {
        return new ApiResource(false, "Booking code already generated", null, 400, 'Bad Request', ['WWW-Authenticate' => 'Bearer']);
    }

    // Generate booking code
    $bookingCode = "NIDE-" . rand(1, 9) . strtoupper(Str::random(5)) . $ticket->user_id . now()->timestamp . rand(1, 9) . strtoupper(Str::random(2));
    // Simpan booking code ke dalam tiket
    $ticket->booking_code = $bookingCode;
    $ticket->save();
    return new ApiResource(true, "Booking code generated successfully", ['booking_code' => $bookingCode], 200, 'OK', ['WWW-Authenticate' => 'Bearer']);
}
public function markTicketAsUsed($bookingCode)
{
    // Temukan tiket berdasarkan booking code
    $ticket = Ticket::where('booking_code', $bookingCode)->first();

    // Periksa apakah tiket ditemukan
    if (!$ticket) {
        return new ApiResource(false, "Ticket not found", null, 404, 'Not Found', ['WWW-Authenticate' => 'Bearer']);
    }

    // Periksa apakah tiket sudah digunakan sebelumnya
    if ($ticket->is_used) {
        return new ApiResource(false, "Ticket already used", null, 400, 'Bad Request', ['WWW-Authenticate' => 'Bearer']);
    }

    // Tandai tiket sebagai "used"
    $ticket->is_used = true;
    $ticket->save();

    return new ApiResource(true, "Ticket marked as used successfully", null, 200, 'OK', ['WWW-Authenticate' => 'Bearer']);
}

}
