@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <h1>Add Vendor Data</h1>
                <form action="{{ route('vendors.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Core Business -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="core_business_id" class="form-label">Core Business</label>
                            <select class="form-select basic-multiple @error('core_business_id') is-invalid @enderror" name="core_business_id[]" id="core_business" multiple>
                                <option value="" disabled>Select Core Business</option>
                                @foreach($core_businesses as $core_business)
                                    <option value="{{ $core_business->id }}">{{ $core_business->name }}</option>
                                @endforeach
                            </select>
                            @error('core_business_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Classification -->
                        <div class="col mb-3">
                            <label for="classification_id" class="form-label">Classification</label>
                            <select class="form-select basic-multiple @error('classification_id') is-invalid @enderror" name="classification_id[]" id="classification" multiple>
                                <option value="">Select Classification</option>
                            </select>
                            @error('classification_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="4"></textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Area dan Direktur -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="area" class="form-label">Area</label>
                            <input type="text" class="form-control @error('area') is-invalid @enderror" id="area" name="area">
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="director" class="form-label">Director</label>
                            <input type="text" class="form-control @error('director') is-invalid @enderror" id="director" name="director">
                            @error('director')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Telepon dan Email -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="phone" class="form-label">Telephone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Modal dan Grade -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="capital" class="form-label">Capital</label>
                            <input type="text" class="form-control @error('capital') is-invalid @enderror" id="capital" name="capital">
                            @error('capital')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label class="form-label">Grade</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_kecil" value="0" {{ old('grade') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="grade_kecil">Kecil</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_menengah" value="1" {{ old('grade') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="grade_menengah">Menengah</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_besar" value="2" {{ old('grade') == '2' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="grade_besar">Besar</label>
                                </div>
                            </div>
                            @error('grade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                    @include('sweetalert::alert')
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.basic-multiple').select2();
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
                    }
                });
            } else {
                $('#classification').empty();
                $('#classification').append('<option value="">Pilih Klasifikasi</option>');
            }
        });
    });
</script>

@endsection
@push('page-action')
<a href="{{ route('vendors.index') }}" class="btn btn-primary">Back</a>
@endpush
