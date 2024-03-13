@extends('layouts.app')

@section('title', 'Tourist Destinations')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tourist Destination</h1>
                <div class="section-header-button">
                    <a href="{{ route('tourist-destinations.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active">All Destinations</div>
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
                                <h4>All Tourist Destinations</h4>
                            </div>
                            <div class="card-body">

                                <div class="float-right">
                                    <form method="GET" action="{{ route('tourist-destinations.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <thead class=" text-center"> <!-- Gunakan tag thead untuk header tabel -->
                                            <tr>
                                                <th>Name</th>
                                                <th>Location</th>
                                                <th>Status</th>
                                                <th>Open Days</th>
                                                <th>Image</th> <!-- Kolom baru untuk menampilkan gambar -->
                                                <th>Action</th> <!-- Tetap gunakan tag th untuk judul kolom -->
                                            </tr>
                                        </thead>
                                        <tbody class="text-center"> <!-- Gunakan tag tbody untuk konten tabel -->
                                            @foreach ($tourist_destinations as $destinasi)
                                                <tr>
                                                    <td>{{ $destinasi->name }}</td>
                                                    <td>{{ $destinasi->location }}</td>
                                                    <td>{{ $destinasi->is_open == 1 ? 'Buka' : 'Tutup' }}</td>
                                                    <td>{{ $destinasi->open_days }}</td>
                                                    <td>
                                                        <div style="width: 150px; height: 100px;">
                                                            <img src="{{ asset('storage/destinasi/' . $destinasi->image_asset) }}"
                                                                alt="Image" style="width: 100%; height: 100%;"
                                                                data-toggle="tooltip" title="{{ $destinasi->name }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a href='{{ route('tourist-destinations.edit', $destinasi->id) }}'
                                                                class="btn btn-sm btn-info btn-icon">
                                                                <i class="fas fa-edit"></i>
                                                                Edit
                                                            </a>
                                                            {{-- show --}}
                                                            <a href="{{ route('tourist-destinations.show', $destinasi->id) }}"
                                                                class="btn btn-sm btn-primary btn-icon ml-2">
                                                                <i class="fas fa-eye"></i>
                                                                Show
                                                            </a>
                                                            <form id="deleteForm-{{ $destinasi->id }}"
                                                                action="{{ route('tourist-destinations.destroy', $destinasi->id) }}"
                                                                method="POST" class="ml-2">
                                                              @csrf
                                                              @method('DELETE')
                                                              <button type="button"
                                                                      class="btn btn-sm btn-danger btn-icon confirm-delete"
                                                                      data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                                      data-confirm-yes="$('#deleteForm-{{ $destinasi->id }}').submit();">
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
                                    {{ $tourist_destinations->withQueryString()->links() }}
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>



@endpush
