@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Vendor Evaluation</h1>
                    <table class="table table-responsive" id="evaluation-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Job Name</th>
                                <th>Procurement Number</th>
                                <th>Estimation Time</th>
                                <th>Division</th>
                                <th>Person In Charge</th>
                                <th>Vendors Selected</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--data displayed here-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="evaluation" tabindex="-1" aria-labelledby="evaluationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="evaluationLabel">Upload Penilaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="file_type" name="file_type" value="0" readonly>
                <input type="text" class="form-control" id="procurement_id" name="procurement_id" value="" readonly>
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
<script>
    $(document).ready(function () {
        $('#evaluation-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('procurement.evaluation') }}',
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
                {
                    data: 'division_name',
                    name: 'division_name'
                },
                { data: 'person_in_charge', name: 'person_in_charge' },
                { data: 'vendor_selected', name: 'vendor_selected' },
                { data: 'status', name: 'status',
                render: function (data) {
                        if (data === '1') {
                            return '<span class="badge rounded-pill bg-success">Success</span>';
                        } else  {
                            return '<span class="badge rounded-pill bg-danger">Unknown</span>';
                        }
                    }
                },
                {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                var source = 'evaluation'; // Nilai sumber halaman ini sesuaikan dengan halaman procurement.evaluation
                return `
                <div class="btn-group btn-sm" role="group">
                    <button type="button" class="btn btn-sm btn-dark btn-pill dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="${route('procurement.show', {procurement: row.id, source: source})}">Detail</a></li>
                        <li><a class="dropdown-item evaluation" data-bs-toggle="modal" data-bs-target="#evaluation" id="evaluation_${row.id}" data-id="${row.id}">Upload</a></li>
                    </ul>
                </div>
                `;
                }
            }]
        });
    });
</script>
@endsection
@push('page-action')
<div class="container">
    <a href="{{ route('procurement.index') }}" class="btn btn-primary mb-3">Back To Jobs Data</a>
</div>
@endpush
