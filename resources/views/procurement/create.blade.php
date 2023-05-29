@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <h1>Add Job Data</h1>
                <form action="{{ route('procurement.store') }}" method="POST">
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
                        <label class="col-sm-2 col-form-label">Data Vendor</label>
                        <div class="col-sm-10">
                            <table class="table" id="vendor-table">
                                <thead>
                                    <tr>
                                        <th>Vendor Name</th>
                                        <th>Status</th>
                                        <th>Director</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select class="form-control select2" id="vendor_id" name="vendor_id" onchange="populateVendorData(this)">
                                                <option value="" disabled selected>Select Vendor</option>
                                                @foreach($vendors AS $vendor)
                                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                            @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="vendor_status" id="vendor_status" readonly>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="vendor_director" id="vendor_director" readonly>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="vendor_phone" id="vendor_phone" readonly>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="vendor_email" id="vendor_email" readonly>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="addVendor()">Add Vendor</button>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    // Function to populate vendor data based on the selected option
    function populateVendorData(selectElement) {
        const selectedVendorId = selectElement.value;
        const selectedVendor = getVendorById(selectedVendorId);

        if (selectedVendor) {
            document.getElementById('vendor_status').value = selectedVendor.status;
            document.getElementById('vendor_director').value = selectedVendor.director;
            document.getElementById('vendor_phone').value = selectedVendor.phone;
            document.getElementById('vendor_email').value = selectedVendor.email;
        } else {
            document.getElementById('vendor_status').value = '';
            document.getElementById('vendor_director').value = '';
            document.getElementById('vendor_phone').value = '';
            document.getElementById('vendor_email').value = '';
        }
    }

    // Function to get vendor data by ID
    function getVendorById(vendorId) {
        // Replace vendorsData with the actual data variable that contains vendor information
        const vendorsData = {!! $vendors !!};
        return vendorsData.find(vendor => vendor.id == vendorId);
    }

    // Function to add a new vendor row
    function addVendor() {
        const selectElement = document.getElementById('vendor_id');
        const selectedVendorId = selectElement.value;
        const selectedVendor = getVendorById(selectedVendorId);

        if (selectedVendor) {
            const tbody = document.getElementById('vendor-table').getElementsByTagName('tbody')[0];
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${selectedVendor.name}</td>
                <td>${selectedVendor.status}</td>
                <td>${selectedVendor.director}</td>
                <td>${selectedVendor.phone}</td>
                <td>${selectedVendor.email}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteVendorRow(this)">Delete</button>
                </td>
            `;
            tbody.appendChild(row);
        }
    }

    // Function to delete a vendor row
    function deleteVendorRow(button) {
        const row = button.closest('tr');
        row.remove();
    }
</script>





@endsection
@push('page-action')
<a href="{{ route('procurement.index') }}" class="btn btn-primary mb-3">Back</a>
@endpush
