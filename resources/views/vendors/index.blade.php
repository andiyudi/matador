@extends('layouts.templates')
@php
 $pretitle ='Data';
 $title ='Available Vendor';
@endphp
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
                                <th>Area</th>
                                <th>Director</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Capital</th>
                                <th>Grade</th>
                                {{-- <th>Is Blacklist</th>
                                <th>Blacklist At</th>
                                <th>Status</th>
                                <th>Expired At</th> --}}
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
<div class="modal fade" id="uploadVendorFiles" tabindex="-1" aria-labelledby="uploadVendorFilesLabel" aria-hidden="true">
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
                        <select class="form-control" id="existing_vendors" name="existing_vendors">
                            <option value="" selected disabled>-- Select Vendor --</option>
                            @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file_type">File Type</label>
                        <select class="form-control" id="file_type" name="file_type" required>
                            <option value="" selected disabled>-- Select File Type --</option>
                            <option value="0">Compro</option>
                            <option value="1">Legalitas</option>
                            <option value="2">Hasil Survey</option>
                        </select>
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
                { data: 'area', name: 'area' },
                { data: 'director', name: 'director' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'capital', name: 'capital' },
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
                // {
                // data: 'status', name: 'status',
                //     render: function (data) {
                //         if (data === '0') {
                //             return 'Registered';
                //         } else if (data === '1') {
                //             return 'Active';
                //         } else if (data === '2') {
                //             return 'Expired';
                //         } else {
                //             return '-';
                //         }
                //     }
                // },
                // { data: 'expired_at', name: 'expired_at' },
                {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                return `
                    <a href="/vendors/${row.id}/edit" class="btn btn-sm btn-warning">
                        Edit
                    </a>
                    <a href="/vendors/${row.id}" class="btn btn-sm btn-info">
                        Detail
                    </a>
                    <form action="/vendors/${row.id}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this vendor?')">
                            Delete
                        </button>
                    </form>
                    <form action="/vendors/${row.id}/blacklist" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_blacklist" value="1">
                        <button type="submit" class="btn btn-sm btn-secondary"
                            onclick="return confirm('Are you sure you want to blacklist this vendor?')">
                            Blacklist
                        </button>
                    </form>`;
                }
            }]
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
