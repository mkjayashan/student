@extends('layouts.app')
@push('title')
    Student List
@endpush
@push('nav_brand')
    LMS
@endpush
@section('content')
    @push('page_header_title')
        <i class="bi bi-people me-2"></i>Student Management
    @endpush


    @livewire('student-register-form')
    @livewire('student-list-table')

@endsection


