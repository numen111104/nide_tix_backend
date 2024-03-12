<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TouristDestination;

class TouristDestinationController extends Controller
{
    //index
    public function index()
    {
        $tourist_destinations = TouristDestination::paginate(5);
        return view('pages.tourist-destinations.index', compact('tourist_destinations'));
    }

    //create
    public function create()
    {
        return view('pages.tourist-destinations.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "description" => "required|min:25",
            "location" => "required",
            "open_days" => "required",
            "open_time" => "required",
            "ticket_price" => "required",
            'image_asset' => 'image|mimes:webp,JPG,jpeg,png,jpg,gif|max:2048',
            'image_urls' => 'required|array|min:3',
            'image_urls.*' => 'url',
            'is_open' => 'required|boolean',
        ]);
        
        $tourist_destination = new TouristDestination;
        $tourist_destination->name = $request->name;
        $tourist_destination->description = $request->description;
        $tourist_destination->location = $request->location;
        $tourist_destination->open_days = $request->open_days;
        $tourist_destination->open_time = $request->open_time;
        $tourist_destination->ticket_price = $request->ticket_price;
        $tourist_destination->image_urls = json_encode($request->image_urls);
        $tourist_destination->is_open = $request->is_open;
        
        
        //save image_asset
        if ($request->hasFile('image_asset')) {
            $image = $request->file('image_asset');
            $imageName = $image->getClientOriginalName(); // Ambil nama asli file
            $imagePath = $image->storeAs('public/destinasi', $imageName); // Simpan file di direktori tertentu
            // Simpan hanya nama file dalam database
            $tourist_destination->image_asset = $imageName;
        }
        $tourist_destination->save();
        session()->flash('image_urls', $request->input('image_urls'));

        return redirect()->route('tourist-destinations.index')->with('success', 'Tourist Destination created successfully');
    }

    //show
    public function show($id)
    {
        $tourist_destination = TouristDestination::findOrFail($id);
        return view('pages.tourist-destinations.show', compact('tourist_destination'));
    }

    //edit
    public function edit($id)
    {
        $tourist_destination = TouristDestination::findOrFail($id);
        return view('pages.tourist-destinations.edit', compact('tourist_destination'));
    }

    //update
    public function update(Request $request, $id)
    {

        $request->validate([
            "name" => "required",
            "description" => "required|min:25",
            "location" => "required",
            "open_days" => "required",
            "open_time" => "required",
            "ticket_price" => "required",
            'image_urls' => 'required|array|min:3',
            'image_urls.*' => 'url',
            'is_open' => 'required|boolean',
        ], [
            'image_urls.required' => 'The image URLs field is required.',
            'image_urls.size' => 'The image URLs must have at least 3 elements.',
            'image_urls.*.url' => 'The image URLs must be a valid URL.',
        ]);

        $tourist_destination = TouristDestination::find($id);
        $tourist_destination->name = $request->name;
        $tourist_destination->description = $request->description;
        $tourist_destination->location = $request->location;
        $tourist_destination->open_days = $request->open_days;
        $tourist_destination->open_time = $request->open_time;
        $tourist_destination->ticket_price = $request->ticket_price;

        $tourist_destination->image_urls = json_encode($request->image_urls);
        $tourist_destination->is_open = $request->is_open;


        if ($request->hasFile('image_asset')) {
            $image = $request->file('image_asset');
            $imageName = $image->getClientOriginalName(); // Ambil nama asli file
            $imagePath = $image->storeAs('public/destinasi', $imageName); // Simpan file di direktori tertentu
            // Simpan hanya nama file dalam database
            $tourist_destination->image_asset = $imageName;
        }
        $tourist_destination->save();




        return redirect()->route('tourist-destinations.index')->with('success', 'Tourist Destination updated successfully');
    }

    public function destroy($id)
    {
        $tourist_destination = TouristDestination::find($id);
        $tourist_destination->delete();
        return redirect()->route('tourist-destinations.index')->with('success', 'Tourist Destination deleted successfully');
    }
}
