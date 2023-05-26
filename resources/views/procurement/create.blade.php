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
                            <table class="table" id="vendor-table">
                                <thead>
                                    <tr>
                                        <th>Vendor Name</th>
                                        <th>Status</th>
                                        <th>PIC</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select class="form-control" onchange="populateVendorData(this)">
                                                <option value="">Select Vendor</option>
                                                <!-- Add your vendor options here -->
                                            </select>
                                        </td>
                                        <td id="vendor-status"></td>
                                        <td id="vendor-pic"></td>
                                        <td id="vendor-phone"></td>
                                        <td id="vendor-email"></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="addVendor()">Add Vendor</button>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody id="vendor-body">
                                    <!-- Vendor rows will be dynamically added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function populateVendorData(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var vendorStatus = selectedOption.getAttribute('data-status');
        var vendorPIC = selectedOption.getAttribute('data-pic');
        var vendorPhone = selectedOption.getAttribute('data-phone');
        var vendorEmail = selectedOption.getAttribute('data-email');

        document.getElementById('vendor-status').textContent = vendorStatus || '-';
        document.getElementById('vendor-pic').textContent = vendorPIC || '-';
        document.getElementById('vendor-phone').textContent = vendorPhone || '-';
        document.getElementById('vendor-email').textContent = vendorEmail || '-';
    }

    function addVendor() {
        var selectElement = document.querySelector('#vendor-table select');
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var vendorName = selectedOption.textContent;
        var vendorStatus = selectedOption.getAttribute('data-status');
        var vendorPIC = selectedOption.getAttribute('data-pic');
        var vendorPhone = selectedOption.getAttribute('data-phone');
        var vendorEmail = selectedOption.getAttribute('data-email');

        var vendorRow = document.createElement('tr');
        var vendorNameCell = document.createElement('td');
        var vendorStatusCell = document.createElement('td');
        var vendorPICCell = document.createElement('td');
        var vendorPhoneCell = document.createElement('td');
        var vendorEmailCell = document.createElement('td');
        var deleteButtonCell = document.createElement('td');
        var deleteButton = document.createElement('button');

        vendorNameCell.textContent = vendorName;
        vendorStatusCell.textContent = vendorStatus || '-';
        vendorPICCell.textContent = vendorPIC || '-';
        vendorPhoneCell.textContent = vendorPhone || '-';
        vendorEmailCell.textContent = vendorEmail || '-';
        deleteButton.textContent = 'Delete';
        deleteButton.classList.add('btn', 'btn-sm', 'btn-danger');
        deleteButton.addEventListener('click', function() {
            vendorRow.remove();
        });

        vendorRow.appendChild(vendorNameCell);
        vendorRow.appendChild(vendorStatusCell);
        vendorRow.appendChild(vendorPICCell);
        vendorRow.appendChild(vendorPhoneCell);
        vendorRow.appendChild(vendorEmailCell);
        deleteButtonCell.appendChild(deleteButton);
        vendorRow.appendChild(deleteButtonCell);

        document.getElementById('vendor-body').appendChild(vendorRow);

        // Reset select option to default
        selectElement.selectedIndex = 0;
        populateVendorData(selectElement);
    }
     // Function to fetch vendor data from the server
    async function fetchVendorData() {
        try {
            const response = await fetch('{{ route("vendors.index") }}');
            const data = await response.json();

            if (data.success) {
                const vendors = data.vendors;
                const selectElement = document.querySelector('#vendor-table select');

                vendors.forEach(vendor => {
                    const option = document.createElement('option');
                    option.value = vendor.id;
                    option.textContent = vendor.name;
                    option.setAttribute('data-status', vendor.status);
                    option.setAttribute('data-pic', vendor.pic);
                    option.setAttribute('data-phone', vendor.phone);
                    option.setAttribute('data-email', vendor.email);
                    selectElement.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error fetching vendor data:', error);
        }
    }

    // Call the fetchVendorData function to populate the select options
    fetchVendorData();
</script>

@endsection
@push('page-action')
<a href="{{ route('procurement.index') }}" class="btn btn-primary mb-3">Back</a>
@endpush
