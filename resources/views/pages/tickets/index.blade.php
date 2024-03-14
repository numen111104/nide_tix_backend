@extends('layouts.app')

@section('title', 'Tickets')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tickets</h1>
                <div class="section-header-button">
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active">All Tickets</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Tickets</h4>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <thead class=" text-center">
                                            <tr>
                                                <th>Name</th>
                                                <th>Tourist Destination</th>
                                                <th>Booking Code</th>
                                                <th>Quantity</th>
                                                <th>Total Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @foreach ($tickets as $ticket)
                                                <tr>
                                                    <td>{{ $ticket->user->name }}</td>
                                                    <td>{{ $ticket->touristDestination->name }}</td>
                                                    <td>{{ $ticket->booking_code }}</td>
                                                    <td>{{ $ticket->quantity }}</td>
                                                    <td>{{ $ticket->total_price == 0 ? 'Free' : 'Rp' . number_format($ticket->total_price, 0, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="{{ route('tickets.edit', $ticket->id) }}"
                                                                class="btn btn-sm btn-info btn-icon">
                                                                <i class="fas fa-edit"></i>
                                                                Edit
                                                            </a>
                                                            <a href="{{ route('tickets.show', $ticket->id) }}"
                                                                class="btn btn-sm btn-primary btn-icon ml-2">
                                                                <i class="fas fa-eye"></i>
                                                                Show
                                                            </a>
                                                            <form id="deleteForm-{{ $ticket->id }}"
                                                                action="{{ route('tickets.destroy', $ticket->id) }}"
                                                                method="POST" class="ml-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger btn-icon confirm-delete"
                                                                    data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                                    data-confirm-yes="$('#deleteForm-{{ $ticket->id }}').submit();">
                                                                    <i class="fas fa-times"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $tickets->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
