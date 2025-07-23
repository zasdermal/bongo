<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb fw-bold fs-7 my-1">
                @foreach ($breadcrumbs as $breadcrumb)
                    <!--begin::Item-->
                    @if ($breadcrumb['url'])
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ $breadcrumb['url'] }}" class="text-muted text-hover-primary">{{ $breadcrumb['title'] }}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item @if ($loop->last) text-dark @else text-muted @endif">{{ $breadcrumb['title'] }}</li>
                    @endif
                    <!--end::Item-->
                    
                    <!--begin::Item-->
                    @if (!$loop->last)
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                    @endif
                    <!--end::Item-->
                @endforeach
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Container-->
</div>