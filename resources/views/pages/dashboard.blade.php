@extends('layouts.templates')
@php
 $pretitle ='Home';
 $title ='Dashboard';
@endphp
@section('content')
<h1>Welcome to Dashboard, {{ auth()->user()->name }}</h1>
@endsection