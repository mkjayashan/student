@extends('layouts.app')
@push('title')
    Grade
@endpush
@push('nav_brand')
    LMS
@endpush
@section('content')
    @push('page_header_title')
        Grade
    @endpush
@livewire('create-grade')
    @include('livewire.grade-list', ['grades' => $grades])


@endsection


