@extends('layouts.templates')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Change Password</h1>
                    <form action="{{ route('password.update') }}" method="post">
                        @csrf
                        @method('put')
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Password" required>
                                <label for="current_password">Current Password</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                <label for="password">New Password</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password" required>
                                <label for="password_confirmation">Confirm Password</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="submit" class="btn btn-pill btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

