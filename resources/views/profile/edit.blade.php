@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>
@endsection

