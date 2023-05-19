@extends('layouts.templates')
@php
 $pretitle ='Show';
 $title ='Vendor Data';
@endphp
@section('content')
<h1>Show Vendor Data</h1>
    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $vendor->name }}" readonly>
    </div>
    <div class="mb-3">
        <label for="core_business_id" class="form-label">Core Business</label>
        <select class="form-select basic-multiple" name="core_business_id[]" id="core_business" multiple disabled>
            <option value="" disabled>Pilih Jenis Bisnis</option>
            @foreach($core_businesses as $core_business)
                <option value="{{ $core_business->id }}">{{ $core_business->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="classification_id" class="form-label">Klasifikasi</label>
        <select class="form-select basic-multiple" name="classification_id[]" id="classification" multiple disabled>
            <option value="" disabled>Pilih Klasifikasi</option>
            @foreach($classifications as $classification)
                <option value="{{ $classification->id }}" {{ in_array($classification->id, $selectedClassifications) ? 'selected' : '' }}>
                    {{ $classification->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <input type="text" class="form-control" id="address" name="address" value="{{ $vendor->address }}" readonly>
    </div>
    <div class="mb-3">
        <label for="area" class="form-label">Area</label>
        <input type="text" class="form-control" id="area" name="area" value="{{ $vendor->area }}" readonly>
    </div>
    <div class="mb-3">
        <label for="director" class="form-label">Direktur</label>
        <input type="text" class="form-control" id="director" name="director" value="{{ $vendor->director }}" readonly>
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">Telepon</label>
        <input type="text" class="form-control" id="phone" name="phone" value="{{ $vendor->phone }}" readonly>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $vendor->email }}" readonly>
      </div>
      <div class="mb-3">
        <label for="capital" class="form-label">Modal</label>
        <input type="text" class="form-control" id="capital" name="capital" value="{{ $vendor->capital }}" readonly>
      </div>
      <div class="mb-3">
        <label for="grade" class="form-label">Grade</label>
        <select class="form-control" id="grade" name="grade" disabled>
            <option value="" disabled>-- Select Grade --</option>
            <option value="0" {{ $vendor->grade == 0 ? 'selected' : '' }}>Kecil</option>
            <option value="1" {{ $vendor->grade == 1 ? 'selected' : '' }}>Menengah</option>
            <option value="2" {{ $vendor->grade == 2 ? 'selected' : '' }}>Besar</option>
        </select>
    </div>
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
<td>  @if ($file->file_type == 0)
    Compro
@elseif ($file->file_type == 1)
    Legalitas
@elseif ($file->file_type == 2)
    Hasil Survey
@else
    Unknown
@endif</td>
<td>{{ $file->updated_at }}</td>
<td>
<a href="#" target="_blank">View</a>
</td>
</tr>
@endforeach
</tbody>
</table>
@else
<p>No files found.</p>
@endif
<a href="{{ route('vendors.index') }}" class="btn btn-primary">Back</a>
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
