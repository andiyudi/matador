@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Detail Job Data</h1>
                    <div class="row mb-3">
                        <label for="periode" class="col-sm-2 col-form-label">Periode</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="periode" name="periode" value="{{ $procurement->periode }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Job Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $procurement->name }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="number" class="col-sm-2 col-form-label">Procurement Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="number" name="number" value="{{ $procurement->number }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="estimation_time" class="col-sm-2 col-form-label">Estimation Time</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="estimation_time" name="estimation_time" value="{{ $procurement->estimation_time }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="division" class="col-sm-2 col-form-label">Division</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="division" name="division" value="{{ $procurement->division->name }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="person_in_charge" class="col-sm-2 col-form-label">Person In Charge</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="person_in_charge" name="person_in_charge" value="{{ $procurement->person_in_charge }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Data Vendor</label>
                        <div class="col-sm-10">
                            <table class="table table-responsive table-bordered table-striped table-hover" id="vendor-table">
                                <thead>
                                    <tr>
                                        <th>Vendor Name</th>
                                        <th>Status</th>
                                        <th>Director</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($procurement->vendors as $vendor)
                                        <tr>
                                            <td>{{ $vendor->name }}</td>
                                            <td>
                                                @if($vendor->status == '0')
                                                <span class="vendor-status">Registered</span>
                                                @elseif($vendor->status == '1')
                                                <span class="vendor-status">Active</span>
                                                @elseif($vendor->status == '2')
                                                <span class="vendor-status">InActive</span>
                                                @elseif($vendor->status == '3')
                                                <span class="vendor-status">Blacklist</span>
                                                @else
                                                <span class="vendor-status"></span>
                                                @endif
                                            </td>
                                            <td>{{ $vendor->director }}</td>
                                            <td>{{ $vendor->phone }}</td>
                                            <td>{{ $vendor->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <h5 class="card-title">Procurement Files</h5>
                    <table class="table table-responsive table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>File Type</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($procurementFiles as $file)
                            <tr>
                                <td>{{ $file->file_name }}</td>
                                <td>
                                    @if ($file->file_type == 0)
                                    File Selected Vendor
                                    @elseif ($file->file_type == 1)
                                    File Cancelled Procurement
                                    @elseif ($file->file_type == 2)
                                    File Repeat Procurement
                                    @elseif ($file->file_type == 3)
                                    File Evaluation Company
                                    @elseif ($file->file_type == 4)
                                    File Evaluation Vendor
                                    @else
                                    Unknown
                                    @endif
                                </td>
                                <td>{{ $file->updated_at }}</td>
                                <td>
                                    <a href="{{ asset('storage/'.$file->file_path) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                                </td>
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
<div class="container">
    @if ($source === 'index')
        <a href="{{ route('procurement.index') }}" class="btn btn-primary">Back</a>
    @elseif ($source === 'data')
        <a href="{{ route('procurement.data') }}" class="btn btn-primary">Back</a>
    @else
        <!-- Default fallback action -->
        <a href="{{ route('procurement.index') }}" class="btn btn-primary">Back</a>
    @endif
</div>
@endpush
