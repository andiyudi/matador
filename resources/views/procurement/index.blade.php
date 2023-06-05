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
<div class="modal fade" id="print" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalLabel">Print Procurement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="printForm">
                    <div class="mb-3">
                        <label for="creatorName" class="form-label">Creator Name</label>
                        <input type="text" class="form-control" id="creatorName" name="creatorName" required>
                    </div>
                    <div class="mb-3">
                        <label for="creatorPosition" class="form-label">Creator Position</label>
                        <input type="text" class="form-control" id="creatorPosition" name="creatorPosition" required>
                    </div>
                    <div class="mb-3">
                        <label for="supervisorName" class="form-label">Supervisor Name</label>
                        <input type="text" class="form-control" id="supervisorName" name="supervisorName" required>
                    </div>
                    <div class="mb-3">
                        <label for="supervisorPosition" class="form-label">Supervisor Position</label>
                        <input type="text" class="form-control" id="supervisorPosition" name="supervisorPosition" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitPrintForm()">Print</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Pilih Vendor -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            ...
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Understood</button>
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
                <div class="btn-group btn-sm" role="group">
                    <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                    </button>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/procurement/${row.id}/edit">Edit</a></li>
                    <li><a class="dropdown-item" href="/procurement/${row.id}">Detail</a></li>
                    <li><a type="button" class="dropdown-item delete-procurement" data-id="${row.id}">Delete</a></li>
                    <li><a type="button" class="dropdown-item print-procurement" data-bs-toggle="modal" data-bs-target="#print" data-id="${row.id}">Print</a></li>
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="/procurement/${row.id}">Pick Vendor</a></li>
                    <li><a type="button" class="dropdown-item cancel-procurement" data-id="${row.id}">Canceled</a></li>
                    </ul>
                </div>
                `;
                }
            }]
        });
        function submitPrintForm() {
        // Mengambil nilai dari input form
        var creatorName = document.getElementById('creatorName').value;
        var creatorPosition = document.getElementById('creatorPosition').value;
        var supervisorName = document.getElementById('supervisorName').value;
        var supervisorPosition = document.getElementById('supervisorPosition').value;

        // Mendapatkan ID procurement dari tombol print yang diklik
        var procurementId = event.target.getAttribute('data-id');

        // Membuat URL dengan mengirim parameter data form dan ID procurement
        var printUrl = "/procurement/" + procurementId + "/print?" +
            "creatorName=" + encodeURIComponent(creatorName) +
            "&creatorPosition=" + encodeURIComponent(creatorPosition) +
            "&supervisorName=" + encodeURIComponent(supervisorName) +
            "&supervisorPosition=" + encodeURIComponent(supervisorPosition);

        // Membuka pop-up window untuk mencetak dengan URL yang telah dibuat
        window.open(printUrl, '_blank');
        event.preventDefault();
        $('#print').modal('hide');
    }
    });

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
                        url: `/procurement/${procurementId}/cancel`,
                        type: 'POST',
                        data: {
                            _method: 'PUT',
                            is_blacklist: 1,
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
                        url: `/procurement/${procurementId}`,
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


</script>
@endsection
@push('page-action')
<div class="container">
    <a href="{{ route('procurement.create') }}" class="btn btn-primary mb-3">Add Job Data</a>
</div>
@endpush
