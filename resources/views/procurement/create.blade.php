@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <h1>Add Job Data</h1>
                <form action="{{ route('vendors.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Job Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="number" class="col-sm-2 col-form-label">Procurement Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number">
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="estimation_time" class="col-sm-2 col-form-label">Estimation Time</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('estimation_time') is-invalid @enderror" id="estimation_time" name="estimation_time">
                            @error('estimation_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="division" class="col-sm-2 col-form-label">Division</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('division') is-invalid @enderror" id="division" name="division">
                            @error('division')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="person_in_charge" class="col-sm-2 col-form-label">Person In Charge</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('person_in_charge') is-invalid @enderror" id="person_in_charge" name="person_in_charge">
                            @error('person_in_charge')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="vendors" class="col-sm-2 col-form-label">Vendors</label>
                        <div class="col-sm-10">
                            <div id="vendors-container">
                                <!-- Vendor fields will be dynamically added here -->
                            </div>
                            <button type="button" class="btn btn-primary mt-2" onclick="addVendorField()">Add Vendor</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function addVendorField() {
        var container = document.getElementById('vendors-container');
        var vendorField = document.createElement('div');
        vendorField.classList.add('mb-2');

        var inputField = document.createElement('input');
        inputField.type = 'text';
        inputField.classList.add('form-control');
        inputField.name = 'vendors[]';
        inputField.placeholder = 'Vendor Name';

        vendorField.appendChild(inputField);
        container.appendChild(vendorField);
    }
</script>
@endsection
@push('page-action')
<a href="{{ route('procurement.index') }}" class="btn btn-primary mb-3">Back</a>
@endpush
