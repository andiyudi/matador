@extends('layouts.templates')
@section('content')
<h1>Available Vendor Data</h1>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-responsive" id="vendors-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Core Business</th>
                                <th>Classification</th>
                                <th>Address</th>
                                {{-- <th>Area</th>
                                <th>Director</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Capital</th> --}}
                                <th>Grade</th>
                                {{-- <th>Is Blacklist</th>
                                <th>Blacklist At</th> --}}
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
<div class="modal fade" id="uploadVendorFiles" aria-labelledby="uploadVendorFilesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('vendors.upload') }}" id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadVendorFilesLabel">Upload Vendor Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="existing_vendors">Existing Vendors</label>
                        <div class="col">
                            <select class="form-select select2" id="existing_vendors" name="existing_vendors">
                                <option value="" selected disabled>-- Select Vendor --</option>
                                @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file_type">File Type</label>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="file_type" id="file_type_0" value="0" required>
                                    <label class="form-check-label" for="file_type_0">
                                        Compro
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="file_type" id="file_type_1" value="1">
                                    <label class="form-check-label" for="file_type_1">
                                        Legalitas
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="file_type" id="file_type_2" value="2">
                                    <label class="form-check-label" for="file_type_2">
                                        Hasil Survey
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vendor_file">Vendor File</label>
                        <input type="file" class="form-control" id="vendor_file" name="vendor_file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="uploadButton" class="btn btn-success">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
                { data: 'address', name: 'address' },
                // { data: 'area', name: 'area' },
                // { data: 'director', name: 'director' },
                // { data: 'phone', name: 'phone' },
                // { data: 'email', name: 'email' },
                // { data: 'capital', name: 'capital' },
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
                // { data: 'is_blacklist', name: 'is_blacklist',
                // render: function (data) {
                //         if (data === '0') {
                //             return 'Not Blacklisted';
                //         } else if (data === '1') {
                //             return 'Blacklisted';
                //         } else {
                //             return '-';
                //         }
                //     }
                // },
                // { data: 'blacklist_at', name: 'blacklist_at' },
                {
                data: 'status', name: 'status',
                    render: function (data) {
                        if (data === '0') {
                            return 'Registered';
                        } else if (data === '1') {
                            return 'Active';
                        } else if (data === '2') {
                            return 'Expired';
                        } else {
                            return '-';
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
                return `
                            <a href="/vendors/${row.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                            <a href="/vendors/${row.id}" class="btn btn-sm btn-info">Detail</a>
                            <button type="button" class="btn btn-sm btn-danger delete-vendor" data-id="${row.id}">Delete</button>
                            <button type="button" class="btn btn-sm btn-secondary blacklist-vendor" data-id="${row.id}">Blacklist</button>
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
                        url: `/vendors/${vendorId}`,
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
        // Event handler untuk tombol Blacklist
        $(document).on('click', '.blacklist-vendor', function () {
            var vendorId = $(this).data('id');
            Swal.fire({
                title: 'Blacklist Vendor',
                text: 'Are you sure you want to blacklist this vendor?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Blacklist',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan penambahan ke daftar blacklist ke URL yang sesuai
                    $.ajax({
                        url: `/vendors/${vendorId}/blacklist`,
                        type: 'POST',
                        data: {
                            _method: 'PUT',
                            is_blacklist: 1,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire('Vendor blacklisted successfully', '', 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire('Error blacklisting vendor', '', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var uploadForm = document.getElementById("uploadForm");
        var uploadButton = document.getElementById("uploadButton");

        uploadButton.addEventListener("click", function(event) {
            event.preventDefault();
            uploadForm.submit();
        });
    });
</script>

@endsection
@push('page-action')
<a href="{{ route('vendors.create') }}" class="btn btn-primary mb-3">Add Vendor Data</a>
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#uploadVendorFiles">
    Upload File
</button>

@endpush
