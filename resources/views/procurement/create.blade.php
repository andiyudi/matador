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
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="number" class="col-sm-2 col-form-label">Procurement Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number" value="{{ old('number') }}">
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="estimation_time" class="col-sm-2 col-form-label">Estimation Time</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('estimation_time') is-invalid @enderror" id="estimation_time" name="estimation_time" value="{{ old('estimation_time') }}">
                            @error('estimation_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="division" class="col-sm-2 col-form-label">Division</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('division') is-invalid @enderror" id="division" name="division" value="{{ old('division') }}">
                            @error('division')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="person_in_charge" class="col-sm-2 col-form-label">Person In Charge</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('person_in_charge') is-invalid @enderror" id="person_in_charge" name="person_in_charge" value="{{ old('person_in_charge') }}">
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
                                            <select class="form-control select2" id="vendor_id" name="vendor_id[]" onchange="populateVendorData(this)" required>
                                                <option value="" disabled selected>Select Vendor</option>
                                                @foreach($vendors AS $vendor)
                                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                            @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <span class="vendor-status"></span>
                                          </td>
                                          <td>
                                            <span class="vendor-director"></span>
                                          </td>
                                          <td>
                                            <span class="vendor-phone"></span>
                                          </td>
                                          <td>
                                            <span class="vendor-email"></span>
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
                    @include('sweetalert::alert')
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

    function populateVendorData(selectElement) {
        const selectedVendorId = selectElement.value;
        const selectedVendor = getVendorById(selectedVendorId);

        if (selectedVendor) {
        const row = selectElement.parentNode.parentNode;

        const statusSpan = row.cells[1].querySelector('.vendor-status');
        if (selectedVendor.status === 0) {
        statusSpan.textContent = 'Registered';
        } else if (selectedVendor.status === 1) {
        statusSpan.textContent = 'Active';
        } else if (selectedVendor.status === 2) {
        statusSpan.textContent = 'Expired';
        } else {
        statusSpan.textContent = 'Rekanan';
        }

    // row.cells[1].querySelector('.vendor-status').textContent = selectedVendor.status;
    row.cells[2].querySelector('.vendor-director').textContent = selectedVendor.director;
    row.cells[3].querySelector('.vendor-phone').textContent = selectedVendor.phone;
    row.cells[4].querySelector('.vendor-email').textContent = selectedVendor.email;
        } else {
        // Reset input fields
        const row = selectElement.parentNode.parentNode;
        row.cells[1].querySelector('.vendor-status').textContent = '';
    row.cells[2].querySelector('.vendor-director').textContent = '';
    row.cells[3].querySelector('.vendor-phone').textContent = '';
    row.cells[4].querySelector('.vendor-email').textContent = '';
  }
        }
    // }

    function getVendorById(vendorId) {
        // Replace vendorsData with the actual data variable that contains vendor information
        const vendorsData = {!! $vendors !!};
        return vendorsData.find(vendor => vendor.id == vendorId);
    }

    function addVendor() {
  const selectElement = document.createElement('select');
  selectElement.className = 'form-control select2';
  selectElement.name = 'vendor_id[]';
  selectElement.onchange = function() {
    populateVendorData(this);
  };

  const optionElement = document.createElement('option');
  optionElement.value = '';
  optionElement.disabled = true;
  optionElement.selected = true;
  optionElement.textContent = 'Select Vendor';

  selectElement.appendChild(optionElement);

  const vendorsData = {!! $vendors !!};
  vendorsData.forEach(function(vendor) {
    const optionElement = document.createElement('option');
    optionElement.value = vendor.id;
    optionElement.textContent = vendor.name;
    selectElement.appendChild(optionElement);
  });

  // Disable selected options
  const selectedOptions = document.querySelectorAll('#vendor-table select.form-control.select2 option:checked');
  selectedOptions.forEach(function(option) {
    const selectedVendorId = option.value;
    selectElement.querySelector(`option[value="${selectedVendorId}"]`).disabled = true;
  });

  const tbody = document.getElementById('vendor-table').getElementsByTagName('tbody')[0];
  const row = document.createElement('tr');
  row.innerHTML = `
    <td></td>
    <td>
    <span class="vendor-status"></span>
  </td>
  <td>
    <span class="vendor-director"></span>
  </td>
  <td>
    <span class="vendor-phone"></span>
  </td>
  <td>
    <span class="vendor-email"></span>
  </td>
    <td>
      <button type="button" class="btn btn-sm btn-danger" onclick="deleteVendorRow(this)">Delete</button>
    </td>
  `;

  const cell = row.cells[0];
  cell.appendChild(selectElement);

  tbody.appendChild(row);

  $('.select2').select2();
}


    function deleteVendorRow(button) {
        const row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

</script>





@endsection
@push('page-action')
<a href="{{ route('procurement.index') }}" class="btn btn-primary mb-3">Back</a>
@endpush
