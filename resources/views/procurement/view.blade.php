@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>View Job Vendor</h1>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Jobs Data</h5>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-4 col-form-label">Job Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $procurement->name }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="number" class="col-sm-4 col-form-label">Procurement Number</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="number" name="number" value="{{ $procurement->number }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="estimation_time" class="col-sm-4 col-form-label">Estimation Time</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="estimation_time" name="estimation_time" value="{{ $procurement->estimation_time }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="division" class="col-sm-4 col-form-label">Division</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="division" name="division" value="{{ $procurement->division->name }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="person_in_charge" class="col-sm-4 col-form-label">Person In Charge</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="person_in_charge" name="person_in_charge" value="{{ $procurement->person_in_charge }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Vendor Data</h5>
                                <div class="row mb-3">
                                    <label for="vendor" class="col-sm-4 col-form-label">Vendor Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="vendor" name="vendor" value="{{ $vendor->name }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="status" class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="status" name="status" value="{{ $vendor->status == '1' ? 'Active' : $vendor->status }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="director" class="col-sm-4 col-form-label">Director</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="director" name="director" value="{{ $vendor->director }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="phone" class="col-sm-4 col-form-label">Phone</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $vendor->phone }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="email" name="email" value="{{ $vendor->email }}" readonly>
                                    </div>
                                </div>
                            </div>
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
