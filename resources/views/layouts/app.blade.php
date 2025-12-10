@include('component.head')
<!--begin::App Wrapper-->
<div class="app-wrapper">
    <!--begin::Header-->
    @include('component.navbar')
    <!--end::Header-->
    <!--begin::Sidebar-->
    @include('component.sidebar')
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Row-->
        <div class="row">
    <div class="col-12 text-center">
        <h3 class="mb-0">
            @stack('page_header_title')
        </h3>
    </div>
</div>
<div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">



@yield('content')





            </div>
            <!--end::Container-->
        </div>
    
</div>

                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        
        <!--end::App Content-->
    </main>
    <!--end::App Main-->
    <!--begin::Footer-->
    @include('component.footer')
    <!--end::Footer-->
</div>
<!--end::App Wrapper-->
<!--begin::Script-->
<!--begin::Third Party Plugin(OverlayScrollbars)-->
@include('component.script')




