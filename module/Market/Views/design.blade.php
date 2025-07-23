@extends('layouts.app')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    @include('pages.breadcrumb')
    <!--end::Toolbar-->

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header mt-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1 me-5">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->

                            <input type="text" data-kt-permissions-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_permissions_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-25px">S.N</th>
                                <th class="min-w-125px">Zone Name</th>
                                <th class="min-w-125px">Region Name</th>
                                <th class="min-w-125px">Area Name</th>
                                <th class="min-w-125px">Sub Area Name</th>
                                <th class="min-w-125px">Territory Name</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->

                        <!--begin::Table body-->
                        <tbody class="text-black-200">
                            @foreach ($zones as $key => $zone)
                                <tr>
                                    <!--begin::S.N-->
                                    <td>{{ $key + 1 }}</td>
                                    <!--end::S.N-->

                                    <!--begin::Zone-->
                                    <td>
                                        {{ $zone->name }}
                                        <br>
                                        <span style="color: blueviolet">
                                            @if ($zone->user)
                                                {{ $zone->user->employee->name }} - {{ $zone->user->username }}
                                            @endif
                                        </span>
                                    </td>
                                    <!--end::Zone-->

                                    <td class="fw-bold">—</td>
                                    <td class="fw-bold">—</td>
                                    <td class="fw-bold">—</td>
                                    <td class="fw-bold">—</td>

                                    <!--begin::Action=-->
                                    <td class="text-end">
                                        <!--begin::Employee Change-->
                                        <button 
                                            @if ($zone->user)
                                                onclick="employee('zoneDiv', {{ $zone->user->employee->id }})"
                                            @else
                                                disabled
                                            @endif
                                            class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                            <!--begin::Svg Icon | path: assets/media/icons/duotune/communication/com014.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor"/>
                                                    <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"/>
                                                    <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor"/>
                                                    <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"/>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                        <!--end::Employee Change-->

                                        <!--begin::Employee Add-->
                                        <button
                                            @if (!$zone->user)
                                                onclick="employee_add('zone', {{ $zone->id }})"
                                            @else
                                                disabled
                                            @endif
                                            class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-toggle="modal" data-bs-target="#employee_add">
                                            <!--begin::Svg Icon | path: assets/media/icons/duotune/text/txt001.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"/>
                                                    <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                        <!--end::Employee Add-->
                                    </td>
                                    <!--end::Action=-->
                                </tr>

                                @foreach ($zone->regions as $region)
                                    <tr>
                                        <td></td>
                                        <td></td>

                                        <!--begin::Region-->
                                        <td>
                                            {{ $region->name }}
                                            <br>
                                            <span style="color: blueviolet">
                                                @if ($region->user)
                                                    {{ $region->user->employee->name }} - {{ $region->user->username }}
                                                @endif
                                            </span>
                                        </td>
                                        <!--end::Region-->

                                        <td class="fw-bold">—</td>
                                        <td class="fw-bold">—</td>
                                        <td class="fw-bold">—</td>

                                        <!--begin::Action=-->
                                        <td class="text-end">
                                            <!--begin::Employee Change-->
                                            <button
                                                @if ($region->user)
                                                    onclick="employee('regionDiv', {{ $region->user->employee->id }})"
                                                @else
                                                    disabled
                                                @endif
                                                class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                <!--begin::Svg Icon | path: assets/media/icons/duotune/communication/com013.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor"/>
                                                        <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"/>
                                                        <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor"/>
                                                        <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                            <!--end::Employee Change-->
    
                                            <!--begin::Employee Add-->
                                            <button
                                                @if (!$region->user)
                                                    onclick="employee_add('region', {{ $region->id }})"
                                                @else
                                                    disabled
                                                @endif
                                                class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-toggle="modal" data-bs-target="#employee_add">
                                                <!--begin::Svg Icon | path: assets/media/icons/duotune/text/txt001.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"/>
                                                        <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                            <!--end::Employee Add-->
                                        </td>
                                        <!--end::Action=-->
                                    </tr>

                                    @foreach ($region->areas as $area)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <!--begin::Area-->
                                            <td>
                                                {{ $area->name }}
                                                <br>
                                                <span style="color: blueviolet">
                                                    @if ($area->user)
                                                        {{ $area->user->employee->name }} - {{ $area->user->username }}
                                                    @endif
                                                </span>
                                            </td>
                                            <!--end::Area-->

                                            <td class="fw-bold">—</td>
                                            <td class="fw-bold">—</td>

                                            <!--begin::Action=-->
                                            <td class="text-end">
                                                <!--begin::Employee Change-->
                                                <button 
                                                    @if ($area->user)
                                                        onclick="employee('areaDiv', {{ $area->user->employee->id }})"
                                                    @else
                                                        disabled
                                                    @endif
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                    <!--begin::Svg Icon | path: assets/media/icons/duotune/communication/com013.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor"/>
                                                            <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"/>
                                                            <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor"/>
                                                            <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"/>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                                <!--end::Employee Change-->
        
                                                <!--begin::Employee Add-->
                                                <button
                                                    @if (!$area->user)
                                                        onclick="employee_add('area', {{ $area->id }})"
                                                    @else
                                                        disabled
                                                    @endif
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-toggle="modal" data-bs-target="#employee_add">
                                                    <!--begin::Svg Icon | path: assets/media/icons/duotune/text/txt001.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"/>
                                                            <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                                <!--end::Employee Add-->
                                            </td>
                                            <!--end::Action=-->
                                        </tr>

                                        @foreach ($area->sub_areas as $sub_area)
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                                <!--begin::Sub Area-->
                                                <td>
                                                    {{ $sub_area->name }}
                                                    <br>
                                                    <span style="color: blueviolet">
                                                        @if ($sub_area->user)
                                                            {{ $sub_area->user->employee->name }} - {{ $sub_area->user->username }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <!--end::Sub Area-->

                                                <td class="fw-bold">—</td>

                                                <!--begin::Action=-->
                                                <td class="text-end">
                                                    <!--begin::Employee Change-->
                                                    <button 
                                                        @if ($sub_area->user)
                                                            onclick="employee('subAreaDiv', {{ $sub_area->user->employee->id }})"
                                                        @else
                                                            disabled
                                                        @endif
                                                        class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                        <!--begin::Svg Icon | path: assets/media/icons/duotune/communication/com013.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor"/>
                                                                    <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"/>
                                                                    <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor"/>
                                                                    <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"/>
                                                                </svg>
                                                            </span>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </button>
                                                    <!--end::Employee Change-->
            
                                                    <!--begin::Employee Add-->
                                                    <button
                                                        @if (!$sub_area->user)
                                                            onclick="employee_add('sub_area', {{ $sub_area->id }})"
                                                        @else
                                                            disabled
                                                        @endif
                                                        class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-toggle="modal" data-bs-target="#employee_add">
                                                        <!--begin::Svg Icon | path: assets/media/icons/duotune/text/txt001.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"/>
                                                                <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </button>
                                                    <!--end::Employee Add-->
                                                </td>
                                                <!--end::Action=-->
                                            </tr>

                                            @foreach ($sub_area->territories as $territory)
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>

                                                    <!--begin::Territory-->
                                                    <td>
                                                        {{ $territory->name }}
                                                        <br>
                                                        <span style="color: blueviolet">
                                                            @if ($territory->user)
                                                                {{ $territory->user->employee->name }} - {{ $territory->user->username }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <!--end::Territory-->

                                                    <!--begin::Action=-->
                                                    <td class="text-end">
                                                        <!--begin::Employee Change-->
                                                        <button 
                                                            @if ($territory->user)
                                                                onclick="employee('territoryDiv', {{ $territory->user->employee->id }})"
                                                            @else
                                                                disabled
                                                            @endif
                                                            class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                            <!--begin::Svg Icon | path: assets/media/icons/duotune/communication/com013.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor"/>
                                                                    <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"/>
                                                                    <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor"/>
                                                                    <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"/>
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                        <!--end::Employee Change-->
                
                                                        <!--begin::Employee Add-->
                                                        <button
                                                            @if (!$territory->user)
                                                                onclick="employee_add('territory', {{ $territory->id }})"
                                                            @else
                                                                disabled
                                                            @endif
                                                            class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-toggle="modal" data-bs-target="#employee_add">
                                                            <!--begin::Svg Icon | path: assets/media/icons/duotune/text/txt001.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"/>
                                                                    <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                        <!--end::Employee Add-->
                                                    </td>
                                                    <!--end::Action=-->
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

            <!--begin::Modals-->
            @include('location.employee_change')
            @include('location.employee_add')
            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>  
@endsection