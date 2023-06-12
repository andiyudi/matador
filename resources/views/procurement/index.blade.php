@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Job Description</h1>
                    <table class="table table-responsive" id="procurement-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Job Name</th>
                                <th>Procurement Number</th>
                                <th>Estimation Time</th>
                                <th>Division</th>
                                <th>Person In Charge</th>
                                <th>Vendors</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Print -->
<div class="modal fade" id="print" tabindex="-1" aria-labelledby="printLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="printForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="printPopupLabel">Fill in the details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="creatorName" class="form-label">Creator Name</label>
                        <input type="text" class="form-control" id="creatorName" placeholder="Enter creator name">
                    </div>
                    <div class="mb-3">
                        <label for="creatorPosition" class="form-label">Creator Position</label>
                        <input type="text" class="form-control" id="creatorPosition" placeholder="Enter creator position">
                    </div>
                    <div class="mb-3">
                        <label for="supervisorName" class="form-label">Supervisor Name</label>
                        <input type="text" class="form-control" id="supervisorName" placeholder="Enter supervisor name">
                    </div>
                    <div class="mb-3">
                        <label for="supervisorPosition" class="form-label">Supervisor Position</label>
                        <input type="text" class="form-control" id="supervisorPosition" placeholder="Enter supervisor position">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="printBtn">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- Modal Vendor -->
    <div class="modal fade" id="vendor" tabindex="-1" aria-labelledby="vendorLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorLabel">Pilih Pemenang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="file_type" name="file_type" value="0" readonly>
                    <input type="text" class="form-control" id="procurement_id" name="procurement_id" value="" readonly>
                    <select id="vendor_id" name="vendor_id" class="form-select" aria-label="Select Vendor">
                        <option selected disabled>Select Vendor</option>
                    </select>
                    <div class="mt-3">
                        <label for="procurement_file" class="form-label">Upload File</label>
                        <input type="file" class="form-control" id="procurement_file" accept=".pdf" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="selectVendorBtn">Select</button>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
$(document).ready(function () {
        $('#procurement-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('procurement.index') }}',
            columns: [
                {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                name: 'row_number',
                searchable: false,
                orderable: false,
                },
                { data: 'name', name: 'name' },
                { data: 'number', name: 'number' },
                { data: 'estimation_time', name: 'estimation_time' },
                { data: 'division', name: 'division' },
                { data: 'person_in_charge', name: 'person_in_charge' },
                {
                    data: 'vendors',
                    render: function (data) {
                        return data.map(function (item, index) {
                            return (index+1) + "." + item.name + "<br>";
                        }).join("");
                    },
                name: 'vendors.name'
                },
                { data: 'status', name: 'status',
                render: function (data) {
                        if (data === '0') {
                            return '<span class="badge rounded-pill bg-info">Process</span>';
                        } else if (data === '1') {
                            return '<span class="badge rounded-pill bg-success">Success</span>';
                        } else if (data === '2') {
                            return '<span class="badge rounded-pill bg-danger">Cancelled</span>';
                        } else  {
                            return '-';
                        }
                    }
                },
                {
                    data: 'status',
      name: 'status',
      orderable: false,
      searchable: false,
      render: function (data, type, row) {
        var actionButtons = '';

        if (data === '0') {
          actionButtons += '<a class="dropdown-item edit-procurement" id="editButton_' + row.id + '" href="' + route('procurement.edit', {procurement: row.id}) + '">Edit</a>';
          actionButtons += '<a class="dropdown-item" href="' + route('procurement.show', {procurement: row.id}) + '">Detail</a>';
          actionButtons += '<a type="button" class="dropdown-item delete-procurement" id="deleteButton_' + row.id + '" data-id="' + row.id + '">Delete</a>';
          actionButtons += '<a type="button" class="dropdown-item print-procurement" data-bs-toggle="modal" data-bs-target="#print" id="printButton_' + row.id + '" data-id="' + row.id + '">Print</a>';
          actionButtons += '<a class="dropdown-item pick-vendor" data-bs-toggle="modal" data-bs-target="#vendor" id="pickVendorButton_' + row.id + '" data-id="' + row.id + '">Pick Vendor</a>';
          actionButtons += '<a type="button" class="dropdown-item cancel-procurement" id="cancelButton_' + row.id + '" data-id="' + row.id + '">Canceled</a>';
        } else if (data === '1') {
          actionButtons += '<a class="dropdown-item" href="' + route('procurement.show', {procurement: row.id}) + '">Detail</a>';
          actionButtons += '<a type="button" class="dropdown-item cancel-procurement" id="cancelButton_' + row.id + '" data-id="' + row.id + '">Canceled</a>';
        } else if (data === '2') {
          actionButtons += '<a class="dropdown-item" href="' + route('procurement.show', {procurement: row.id}) + '">Detail</a>';
        }

        return `
          <div class="btn-group btn-sm" role="group">
            <button type="button" class="btn btn-sm btn-dark btn-pill dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              Action
            </button>
            <ul class="dropdown-menu">
              ` + actionButtons + `
            </ul>
          </div>
        `;
                }
            }]
        });

    // Handle form submission for printing
    $('#printForm').submit(function (e) {
        e.preventDefault();

        var creatorName = $('#creatorName').val();
        var creatorPosition = $('#creatorPosition').val();
        var supervisorName = $('#supervisorName').val();
        var supervisorPosition = $('#supervisorPosition').val();
        var id = $('#printBtn').data('id');

        // Redirect to print page with filled data as query parameters
        var printUrl = route('procurement.print', id) +
            '?creatorName=' + encodeURIComponent(creatorName) +
            '&creatorPosition=' + encodeURIComponent(creatorPosition) +
            '&supervisorName=' + encodeURIComponent(supervisorName) +
            '&supervisorPosition=' + encodeURIComponent(supervisorPosition);
        window.location.href = printUrl;
    });

    $(document).on('click', '.print-procurement', function () {
        var id = $(this).data('id');
        $('#printBtn').data('id', id);
        $('#print').modal('show');
    });

    $(document).on('click', '.pick-vendor', function () {
            var procurement_id = $(this).data('id');
            $('#procurement_id').val(procurement_id);

            $.ajax({
                url: route('procurement.vendors', procurement_id),
                type: 'GET',
                success: function (response) {
                    // Populate vendor select element
                    populateVendorSelect(response.vendors, response.selectedVendors);
                    $('#vendor').modal('show');
                },
                error: function (xhr) {
                    console.log(xhr);
                    // Handle error if the request fails
                }
            });
        });

        function populateVendorSelect(vendors, selectedVendors) {
            var selectElement = $('#vendor_id');
            selectElement.empty();

            // Add default option (not selected)
            selectElement.append('<option selected disabled>Select Vendor</option>');

            for (var i = 0; i < vendors.length; i++) {
                var vendor = vendors[i];
                var option = '<option value="' + vendor.id + '"';

                // Check if this vendor is selected
                if (selectedVendors.includes(vendor.id)) {
                    option += ' selected';
                }

                option += '>' + vendor.name + '</option>';
                selectElement.append(option);
            }
        }

        $(document).on('click', '#selectVendorBtn', function () {
        var procurementId = $('#procurement_id').val();
        var selectedVendorId = $('#vendor_id').val();
        var fileType = $('#file_type').val();
        var fileInput = document.getElementById('procurement_file');
        var file = fileInput.files[0];

        var formData = new FormData();
        formData.append('file', file);
        formData.append('procurementId', procurementId);
        formData.append('fileType', fileType);

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        $.ajax({
            url: route('procurement.upload'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                var fileId = response.file.id;
                // Update the selected vendor's is_selected column in the procurement_vendor table
                updateSelectedVendor(procurementId, selectedVendorId, fileId);
            },
            error: function (xhr) {
                console.log(xhr);
                // Handle the error if the file upload fails
            }
        });
    });

    function updateSelectedVendor(procurementId, vendorId, fileId) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        $.ajax({
            url: route('procurement.update_selected_vendor'),
            type: 'POST',
            data: {
                vendorId: vendorId,
                procurementId: procurementId
            },
            success: function (response) {
                // Handle the response after the update succeeds

               // Close the modal
            $('#vendor').modal('hide');

            // Perform other actions after the update succeeds
            Swal.fire('Vendor selected successfully', '', 'success').then(() => {
                // Reload the page
                location.reload();
            });
        },
            error: function (xhr) {
                Swal.fire('Error selected vendor', '', 'error');
                console.log(xhr);
                // Handle the error if the update fails
            }
        });
    }
    // Event handler untuk tombol Canceled Event
    $(document).on('click', '.cancel-procurement', function () {
            var procurementId = $(this).data('id');
            Swal.fire({
                title: 'Cancel Job',
                text: 'Are you sure you want to cancel this job?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan penambahan ke daftar blacklist ke URL yang sesuai
                    $.ajax({
                        url: route('procurement.cancel', {procurement: procurementId}),
                        type: 'POST',
                        data: {
                            _method: 'PUT',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire('Jobs canceled successfully', '', 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire('Error canceled jobs', '', 'error');
                        }
                    });
                }
            });
    });
    // Event handler untuk tombol Delete
    $(document).on('click', '.delete-procurement', function () {
            var procurementId = $(this).data('id');
            Swal.fire({
                title: 'Delete Job',
                text: 'Are you sure you want to delete this job?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan penghapusan ke URL yang sesuai
                    $.ajax({
                        url: route('procurement.destroy', {procurement: procurementId}),
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire('Job deleted successfully', '', 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire('Error deleting job', '', 'error');
                        }
                    });
                }
            });
    });
});
</script>
@endsection
@push('page-action')
<div class="container">
    <a href="{{ route('procurement.create') }}" class="btn btn-primary mb-3">Add Job Data</a>
</div>
@endpush
@push('after-style')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
