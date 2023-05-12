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
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
       $('#vendors-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}',
            columns: [
                { data: 'id', name: 'id' },
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
                { data: 'grade', name: 'grade' },
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

            ]
        });
     });
    </script>






@endsection
@push('page-action')
<a href="{{ route('vendors.create') }}" class="btn btn-primary mb-3">Add Vendor Data</a>
@endpush
