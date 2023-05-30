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
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Pilih Pemenang Tender</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <select class="form-select" aria-label="Default select example">
                <option selected>Pilih Vendor</option>
                <option value="1">PT. ABC</option>
                <option value="2">PT. DEF</option>
                <option value="3">PT. GHI</option>
            </select>
            <div class="form-group mt-3">
                <input type="file" class="form-control" id="inputGroupFile01">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success">Choose</button>
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
                            return '<span class="badge bg-info">Process</span>';
                        } else if (data === '1') {
                            return '<span class="badge bg-success">Success</span>';
                        } else if (data === '2') {
                            return '<span class="badge bg-danger">Cancelled</span>';
                        } else  {
                            return '-';
                        }
                    }
                },
                {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                return `
                <a href="/procurement/${row.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                <a href="/procurement/${row.id}" class="btn btn-sm btn-info">Detail</a>
                <button type="button" class="btn btn-sm btn-danger delete-procurement" data-id="${row.id}">Delete</button>
                <button type="button" class="btn btn-sm btn-light print-procurement" data-id="${row.id}">Print</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Pick Vendor
                </button>
                <button type="button" class="btn btn-sm btn-dark">Canceled</button>
                `;
                }
            }]
        });
    });
    // Event handler untuk tombol Delete
    $(document).on('click', '.delete-procurement', function () {
            var ProcurementId = $(this).data('id');
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
                        url: `/procurement/${ProcurementId}`,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire('Procurement deleted successfully', '', 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire('Error deleting procurement', '', 'error');
                        }
                    });
                }
            });
        });
</script>

@endsection
@push('page-action')
<a href="{{ route('procurement.create') }}" class="btn btn-primary mb-3">Add Job Data</a>
@endpush
