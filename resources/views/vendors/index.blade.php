@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Available Vendor Data</h1>
                    <table class="table table-responsive table-bordered table-striped table-hover" id="vendors-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Core Business</th>
                                <th>Classification</th>
                                <th>Director</th>
                                <th>Phone</th>
                                <th>Grade</th>
                                <th>Status</th>
                                <th>Expired At</th>
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
<!-- Modal Blacklist-->
<div class="modal fade" id="uploadVendorFiles" aria-labelledby="uploadVendorFilesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('vendors.upload') }}" id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadVendorFilesLabel">Upload Blacklist Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vendor_name">Vendor Name</label>
                        <input type="hidden" class="form-control" id="id_vendor" name="id_vendor" value="" readonly>
                        <input type="text" class="form-control" id="vendor_name" name="vendor_name" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="type_file">File Type</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_file" id="type_file_3" value="3" checked>
                            <label class="form-check-label" for="type_file_3">
                                Blacklist
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vendor_file">Vendor File</label>
                        <input type="file" class="form-control" id="vendor_file" name="vendor_file" accept=".xlsx,.xls,.pdf,.doc,.docx,.jpg,.jpeg,.png">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="uploadButton" class="btn btn-danger">Upload and Blacklist</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).on('click', '.blacklist-vendor', function () {
    var vendorId = $(this).data('id');
    var vendorName = $(this).closest('tr').find('td:nth-child(2)').text();

    // Set nilai input pada modal
    $('#id_vendor').val(vendorId);
    $('#vendor_name').val(vendorName);
    $('#type_file_3').prop('checked', true);

    // Tampilkan modal
    $('#uploadVendorFiles').modal('show');
});

$('#uploadForm').on('submit', function(e) {
    e.preventDefault();

    var vendorId = $('#id_vendor').val();
    var fileType = $('input[name="type_file"]:checked').val();
    var file = $('#vendor_file').prop('files')[0];

    // Buat objek FormData untuk mengirim file dan data lainnya ke server
    var formData = new FormData();
    formData.append('id_vendor', vendorId);
    formData.append('type_file', fileType);
    formData.append('vendor_file', file);
    formData.append('_token', "{{ csrf_token() }}");

    // Kirim data ke server menggunakan AJAX
    $.ajax({
        url: route('vendors.upload'),
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            // Lakukan blacklist vendor
            blacklistVendor(vendorId);
        },
        error: function(xhr, status, error) {
            // Tangani error jika diperlukan
            console.log(error);
        }
    });
});

function blacklistVendor(vendorId) {
    // Kirim request ke server untuk melakukan blacklist vendor
    $.ajax({
        url: route('vendors.blacklist', { vendor: vendorId }),
        method: 'PUT',
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            var vendorName = $('#vendor_name').val();

            // Tampilkan pesan sukses menggunakan SweetAlert
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Blacklist',
                text: 'File berhasil diupload dan vendor ' + vendorName + ' berhasil di-blacklist',
            }).then(function() {
                // Reload halaman
                window.location.href = route('vendors.data');
            });
        },
        error: function(xhr, status, error) {
            // Tangani error jika diperlukan
            console.log(error);
        }
    });
}
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $(".modal-body"),
            width: '100%'
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#vendors-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('vendors.index') }}',
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
                {
                data: 'core_businesses',
                    render: function (data) {
                        return data.map(function (item, index) {
                            return (index+1) + "." + item.name +"<br>";
                        }).join("");
                        },
                name: 'core_businesses.name'
                },
                {
                data: 'classifications',
                    render: function (data) {
                        return data.map(function (item, index) {
                            return (index+1) + "." + item.name + "<br>";
                        }).join("");
                    },
                name: 'classifications.name'
                },
                { data: 'director', name: 'director' },
                { data: 'phone', name: 'phone' },
                { data: 'grade', name: 'grade',
                render: function (data) {
                        if (data === '0') {
                            return 'Kecil';
                        } else if (data === '1') {
                            return 'Menengah';
                        } else if (data === '2') {
                            return 'Besar';
                        } else  {
                            return '-';
                        }
                    }
                },
                {
                data: 'status', name: 'status',
                    render: function (data) {
                        if (data === '0') {
                            return '<span class="badge bg-info">Registered</span>';
                        } else if (data === '1') {
                            return '<span class="badge bg-success">Active</span>';
                        } else if (data === '2') {
                            return '<span class="badge bg-warning">InActive</span>';
                        } else if (data === '3') {
                            return '<span class="badge bg-danger">Blacklist</span>';
                        } else {
                            return '<span class="badge bg-secondary">Unknown</span>';
                        }
                    }
                },
                { data: 'expired_at', name: 'expired_at' },
                {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    var source = 'index';
                return `
                            <a href="${route('vendors.edit', {vendor: row.id})}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="${route('vendors.show', {vendor: row.id, source:source})}" class="btn btn-sm btn-info">Detail</a>
                            <button type="button" class="btn btn-sm btn-danger delete-vendor" data-id="${row.id}">Delete</button>
                            <button type="button" class="btn btn-sm btn-secondary blacklist-vendor" data-id="${row.id}" data-name="${row.vendor_name}">Blacklist</button>
                        `;
                }
            }]
        });
        // Event handler untuk tombol Delete
        $(document).on('click', '.delete-vendor', function () {
            var vendorId = $(this).data('id');
            Swal.fire({
                title: 'Delete Vendor',
                text: 'Are you sure you want to delete this vendor?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan penghapusan ke URL yang sesuai
                    $.ajax({
                        url: route('vendors.destroy', {vendor: vendorId}),
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire('Vendor deleted successfully', '', 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire('Error deleting vendor', '', 'error');
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
    <a href="{{ route('vendors.create') }}" class="btn btn-primary mb-3">Add Vendor Data</a>
</div>
@endpush
