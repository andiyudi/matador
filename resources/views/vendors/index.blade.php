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
                    <table class="table" id="vendors-table">
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
                                <th>Status</th>
                                <th>Expired At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@push('scripts')
<script>
    $(function () {
        $('#vendors-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('vendors.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'core_business.name', name: 'core_business.name'},
                {data: 'classifications', name: 'classifications'},
                {data: 'address', name: 'address'},
                {data: 'area', name: 'area'},
                {data: 'director', name: 'director'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                {data: 'capital', name: 'capital'},
                {data: 'grade', name: 'grade'},
                {data: 'status', name: 'status'},
                {data: 'expired_at', name: 'expired_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush



@endsection
@push('page-action')
<a href="{{ route('vendors.create') }}" class="btn btn-primary mb-3">Add Vendor Data</a>
@endpush
