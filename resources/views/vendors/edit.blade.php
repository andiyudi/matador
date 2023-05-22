@extends('layouts.templates')
@section('content')
<h1>Edit Vendor Data</h1>
<form action="{{ route('vendors.update', $vendor->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $vendor->name }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="row">
        <div class="col mb-3">
            <label for="core_business_id" class="form-label">Core Business</label>
            <select class="form-select basic-multiple @error('core_business_id') is-invalid @enderror" name="core_business_id[]" id="core_business" multiple>
                <option value="" disabled>Pilih Jenis Bisnis</option>
                @foreach($core_businesses as $core_business)
                    <option value="{{ $core_business->id }}">{{ $core_business->name }}</option>
                @endforeach
            </select>
            @error('core_business_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col mb-3">
            <label for="classification_id" class="form-label">Classification</label>
            <select class="form-select basic-multiple @error('classification_id') is-invalid @enderror" name="classification_id[]" id="classification" multiple>
                <option value="" disabled>Pilih Klasifikasi</option>
                @foreach($classifications as $classification)
                    <option value="{{ $classification->id }}" {{ in_array($classification->id, $selectedClassifications) ? 'selected' : '' }}>
                        {{ $classification->name }}
                    </option>
                @endforeach
            </select>
            @error('classification_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="4">{{ $vendor->address }}</textarea>
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="row">
        <div class="col mb-3">
            <label for="area" class="form-label">Area</label>
            <input type="text" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ $vendor->area }}">
            @error('area')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col mb-3">
            <label for="director" class="form-label">Director</label>
            <input type="text" class="form-control @error('director') is-invalid @enderror" id="director" name="director" value="{{ $vendor->director }}">
            @error('director')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label for="phone" class="form-label">Telephone</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $vendor->phone }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $vendor->email }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label for="capital" class="form-label">Capital</label>
            <input type="text" class="form-control @error('capital') is-invalid @enderror" id="capital" name="capital" value="{{ $vendor->capital }}">
            @error('capital')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col mb-3">
            <label for="grade" class="form-label">Grade</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_kecil" value="0" {{ $vendor->grade == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="grade_kecil">Kecil</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_menengah" value="1" {{ $vendor->grade == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="grade_menengah">Menengah</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_besar" value="2" {{ $vendor->grade == 2 ? 'checked' : '' }}>
                    <label class="form-check-label" for="grade_besar">Besar</label>
                </div>
            </div>
            @error('grade')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    @include('sweetalert::alert')
</form>
<h3>Existing Files:</h3>
@if($vendor_files && $vendor_files->count() > 0)
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>File Type</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vendor_files as $file)
        <tr>
            <td>{{ $file->file_name }}</td>
            <td>@if ($file->file_type == 0)
                Compro
                @elseif ($file->file_type == 1)
                Legalitas
                @elseif ($file->file_type == 2)
                Hasil Survey
                @else
                Unknown
                @endif
            </td>
            <td>{{ $file->updated_at }}</td>
            <td>
                <a href="#" target="_blank">View</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $file->id }}').submit();">Delete</a>
                <form id="delete-form-{{ $file->id }}" action="#" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No files found.</p>
@endif
<script>
    $(document).ready(function () {
        $('.basic-multiple').select2();

        // Set selected core businesses
        var selectedCoreBusiness = {!! json_encode($selectedCoreBusinesses) !!};
        $('#core_business').val(selectedCoreBusiness).trigger('change');

        $('#core_business').change(function () {
            var core_business_ids = $(this).val();
            if (core_business_ids) {
                $.ajax({
                    url: '/classifications/getByCoreBusiness',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        core_business_ids: core_business_ids
                    },
                    success: function (data) {
                        $('#classification').empty();
                        $('#classification').append('<option value="" disabled>Pilih Klasifikasi</option>');
                        $.each(data, function (key, value) {
                            $('#classification').append('<option value="' + key + '">' + value + '</option>');
                        });

                        // Set selected classifications
                        var selectedClassifications = {!! json_encode($selectedClassifications) !!};
                        $('#classification').val(selectedClassifications).trigger('change');
                    }
                });
            } else {
                $('#classification').empty();
                $('#classification').append('<option value="" disabled>Pilih Klasifikasi</option>');
            }
        });
    });
</script>
@endsection
@push('page-action')
<a href="{{ route('vendors.index') }}" class="btn btn-primary">Back</a>
@endpush
