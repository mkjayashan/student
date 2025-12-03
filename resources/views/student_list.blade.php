@extends('app')
@push('title')
    Student List
@endpush
@push('nav_brand')
    LMS
@endpush
@section('content')
@push('page_header_title')
    Student
@endpush
    @livewire('student-register-form')
    @livewire('student-list-table')



@endsection


