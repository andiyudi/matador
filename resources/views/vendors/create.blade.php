@extends('layouts.templates')
@php
 $pretitle ='Add';
 $title ='Vendor Data';
@endphp
@section('content')
<h1>Add Vendor Data</h1>
<form action="{{ route('vendors.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="core_business_id" class="form-label">Core Business</label>
        <select class="form-select basic-multiple" name="core_business_id[]" id="core_business" multiple>
            <option value="" disabled>Pilih Jenis Bisnis</option>
            @foreach($core_businesses as $core_business)
                <option value="{{ $core_business->id }}">{{ $core_business->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="classification_id" class="form-label">Klasifikasi</label>
        <select class="form-select basic-multiple" name="classification_id[]" id="classification" multiple>
            <option value="">Pilih Klasifikasi</option>
        </select>
    </div>
    <div class="mb-3">
      <label for="name" class="form-label">Nama</label>
      <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
      <label for="address" class="form-label">Alamat</label>
      <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <div class="mb-3">
      <label for="area" class="form-label">Area</label>
      <input type="text" class="form-control" id="area" name="area" required>
    </div>
    <div class="mb-3">
      <label for="director" class="form-label">Direktur</label>
      <input type="text" class="form-control" id="director" name="director" required>
    </div>
    <div class="mb-3">
      <label for="phone" class="form-label">Telepon</label>
      <input type="text" class="form-control" id="phone" name="phone" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
      <label for="capital" class="form-label">Modal</label>
      <input type="text" class="form-control" id="capital" name="capital" required>
    </div>
    <div class="mb-3">
      <label for="grade" class="form-label">Grade</label>
      <input type="text" class="form-control" id="grade" name="grade" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
  </form>
  <script>
    $(document).ready(function () {
        $('.basic-multiple').select2();
        $('#core_business').change(function () {
            var core_business_id = $(this).val();
            if (core_business_id) {
                $.ajax({
                    url: '/classifications/' + core_business_id + '/getByCoreBusiness',
                    type: 'GET',
                    dataType: 'json',
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
@push('after-style')

@endpush
