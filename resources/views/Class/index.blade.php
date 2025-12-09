@extends('layouts.app')
@push('title')
    Class
@endpush
@push('nav_brand')
    LMS
@endpush
@section('content')
    @push('page_header_title')
        <i class="bi bi-building me-2"></i>Class Management
    @endpush
    @livewire('create-class')
    @include('livewire.class-list')


@endsection


