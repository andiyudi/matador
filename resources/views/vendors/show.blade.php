@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Show Vendor Data</h1>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $vendor->name }}" readonly>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="core_business_id" class="form-label">Core Business</label>
                            <select class="form-select basic-multiple" name="core_business_id[]" id="core_business" multiple disabled>
                                <option value="" disabled>Pilih Jenis Bisnis</option>
                                @foreach($core_businesses as $core_business)
                                    <option value="{{ $core_business->id }}">{{ $core_business->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="classification_id" class="form-label">Classification</label>
                            <select class="form-select basic-multiple" name="classification_id[]" id="classification" multiple disabled>
                                <option value="" disabled>Pilih Klasifikasi</option>
                                @foreach($classifications as $classification)
                                    <option value="{{ $classification->id }}" {{ in_array($classification->id, $selectedClassifications) ? 'selected' : '' }}>
                                        {{ $classification->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="4" readonly>{{ $vendor->address }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="area" class="form-label">Area</label>
                            <input type="text" class="form-control" id="area" name="area" value="{{ $vendor->area }}" readonly>
                        </div>
                        <div class="col mb-3">
                            <label for="director" class="form-label">Director</label>
                            <input type="text" class="form-control" id="director" name="director" value="{{ $vendor->director }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="phone" class="form-label">Telephone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $vendor->phone }}" readonly>
                        </div>
                        <div class="col mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $vendor->email }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="capital" class="form-label">Capital</label>
                            <input type="text" class="form-control" id="capital" name="capital" value="{{ $vendor->capital }}" readonly>
                        </div>
                        <div class="col mb-3">
                            <label for="grade" class="form-label">Grade</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="grade" id="grade_kecil" value="0" {{ $vendor->grade == 0 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="grade_kecil">Kecil</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="grade" id="grade_menengah" value="1" {{ $vendor->grade == 1 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="grade_menengah">Menengah</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="grade" id="grade_besar" value="2" {{ $vendor->grade == 2 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="grade_besar">Besar</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
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
                                <a href="{{ asset('storage/'.$file->file_path) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p>No files found.</p>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
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
<div class="container">
    <a href="{{ route('vendors.index') }}" class="btn btn-primary">Back</a>
</div>
@endpush
