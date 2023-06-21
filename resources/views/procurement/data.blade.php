@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Vendor Evaluation</h1>
                    <table class="table table-responsive table-bordered table-striped table-hover" id="evaluation-table">
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
<script>
    $(document).ready(function () {
        $('#evaluation-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('procurement.data') }}',
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
                            return '<span class="badge rounded-pill bg-secondary">Unknown</span>';
                        }
                    }
                },
                {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                var source = 'data'; // Nilai sumber halaman ini sesuaikan dengan halaman procurement.data
                return `
                <div class="btn-group btn-sm" role="group">
                    <button type="button" class="btn btn-sm btn-dark btn-pill dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a type="button" class="dropdown-item" href="${route('procurement.evaluation', {id: row.id, source: source})}">Evaluation</a></li>
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
