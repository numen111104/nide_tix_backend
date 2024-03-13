@extends('layouts.app')

@section('title', 'Ticket Details')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Ticket Details</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Tickets</a></div>
                    <div class="breadcrumb-item active">Ticket Details</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Ticket Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>User</label>
                                    <p>{{ $ticket->user->name }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Tourist Destination</label>
                                    <p>{{ $ticket->touristDestination->name }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Booking Code</label>
                                    <p>{{ $ticket->booking_code }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <p>{{ $ticket->quantity }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Created At</label>
                                    <p>{{ $ticket->created_at }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Updated At</label>
                                    <p>{{ $ticket->updated_at }}</p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('tickets.index') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Destination Gallery</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach (json_decode($ticket->touristDestination->image_urls) as $image)
                                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                                            <img src={{ $image }} class="img-fluid" alt={{ $ticket->touristDestination->name }}>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
