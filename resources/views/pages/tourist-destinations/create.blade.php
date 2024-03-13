@extends('layouts.app')

@section('title', 'Create Tourist Destination')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Tourist Destination</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('tourist-destinations.index') }}">Tourist Destination</a>
                    </div>
                    <div class="breadcrumb-item active">Create</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Tourist Destination</h2>

                <div class="card">
                    <form action="{{ route('tourist-destinations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h4>Destination Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tourist Destination Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror"
                                    name="description" value="{{ old('description') }}">
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Location</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                    name="location" value="{{ old('location') }}">
                                @error('location')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Open Days</label>
                                <input type="text" class="form-control @error('open_days') is-invalid @enderror"
                                    name="open_days" value="{{ old('open_days') }}">
                                @error('open_days')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Open Time</label>
                                <input type="text" class="form-control @error('open_time') is-invalid @enderror"
                                    name="open_time" value="{{ old('open_time') }}">
                                @error('open_time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Ticket Price</label>
                                <input type="text" class="form-control @error('ticket_price') is-invalid @enderror"
                                    name="ticket_price" value="{{ old('ticket_price') }}">
                                @error('ticket_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label mt-4">Asset Image</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="image_asset">
                                    @error('image_asset')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Is Open</label>
                                <div class="selectgroup selectgroup-pills">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="is_open" value="1" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="is_open" value="0" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Image URLs</label>
                                <div class="image-url-container"> <!-- Tambahkan container untuk input URLs -->
                                    @php
                                        // Ambil nilai dari session jika ada
                                        $imageUrls = session('image_urls', []);
                                    @endphp
                                    @foreach ($imageUrls as $image)
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="image_urls[]"
                                                value="{{ $image }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-danger remove-image-url"
                                                    type="button">Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                    @error('image_urls')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button class="btn btn-success" id="add-image-url" type="button">Add More</button>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        // Fungsi untuk menambahkan input field untuk URL gambar
        function addImageUrlInput() {
            var inputGroup = '<div class="input-group mb-3">' +
                '<input type="text" class="form-control" name="image_urls[]">' +
                '<div class="input-group-append">' +
                '<button class="btn btn-danger remove-image-url" type="button">Remove</button>' +
                '</div>' +
                '</div>';
            $('.image-url-container').append(inputGroup);
            // Reset any previous validation errors
            $('.image-url-container .is-invalid').removeClass('is-invalid');
            $('.image-url-container .invalid-feedback').remove();
        }

        // Fungsi untuk menghapus input field untuk URL gambar
        $(document).on('click', '.remove-image-url', function() {
            $(this).closest('.input-group').remove();
        });

        // Menambahkan event listener untuk tombol "Add More"
        $('#add-image-url').click(function() {
            addImageUrlInput();
        });
    </script>
@endpush
