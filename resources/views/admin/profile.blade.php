@extends('layouts.app')

@push('title')
Admin Profile
@endpush

@section('content')
<div class="container mt-5">
    <h2>Admin Profile</h2>
    <p>Email: {{ auth()->user()->email }}</p>
    <!-- Add other info if needed -->
</div>
@endsection
