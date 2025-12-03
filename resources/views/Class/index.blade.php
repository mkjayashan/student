@extends('layouts.app')
@push('title')
    Class
@endpush
@push('nav_brand')
    LMS
@endpush
@section('content')
    @push('page_header_title')
        Class
    @endpush
    @livewire('create-class')
    @include('livewire.class-list')


@endsection


