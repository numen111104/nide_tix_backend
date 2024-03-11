@extends('layouts.app')

@section('title', 'Tourist Destination Details')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tourist Destination Details</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('tourist-destinations.index') }}">Tourist Destinations</a></div>
                    <div class="breadcrumb-item active">Destination Details</div>
                </div>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <p>{{ $tourist_destination->name }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <p>{{ $tourist_destination->description }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Location</label>
                                    <p>{{ $tourist_destination->location }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Open Days</label>
                                    <p>{{ $tourist_destination->open_days }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Open Time</label>
                                    <p>{{ $tourist_destination->open_time }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Ticket Price</label>
                                    <p>{{ $tourist_destination->ticket_price }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Is Open?</label>
                                    <p>{{ $tourist_destination->is_open ? 'Yes' : 'No' }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Updated At</label>
                                    <p>{{ $tourist_destination->updated_at }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('tourist-destinations.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
