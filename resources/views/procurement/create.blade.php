@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <h1>Add Job Data</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-action')
<a href="{{ route('procurement.index') }}" class="btn btn-primary mb-3">Back</a>
@endpush
