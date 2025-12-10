@extends('layouts.app')
@push('title')
    Teacher List
@endpush
@push('nav_brand')
    LMS
@endpush
@section('content')

    
    @push('page_header_title')
        <i class="bi bi-person-badge me-2"></i>Teacher Management
    @endpush



    
    @livewire('teacher-registration')
       @include('livewire.teacher-form')


    
    </div>
    
             

        
@endsection

