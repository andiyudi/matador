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
                        @foreach($vendors as $vendor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $vendor->name }}</td>
                                 <td>
                                    {{ 'data-core-businesses' }}
                                </td>
                                <td>
                                   {{ 'data-classifications'}}
                                </td>
                                <td>{{ $vendor->address }}</td>
                                <td>{{ $vendor->area }}</td>
                                <td>{{ $vendor->director }}</td>
                                <td>{{ $vendor->phone }}</td>
                                <td>{{ $vendor->email }}</td>
                                <td>{{ $vendor->capital }}</td>
                                <td>{{ $vendor->grade }}</td>
                                <td>{{ $vendor->status }}</td>
                                <td>{{ $vendor->expired_at }}</td>
                                <td>{{ $loop->iteration }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>







@endsection
@push('page-action')
<a href="{{ route('vendors.create') }}" class="btn btn-primary mb-3">Add Vendor Data</a>
@endpush
