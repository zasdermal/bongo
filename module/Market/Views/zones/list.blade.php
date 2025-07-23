@extends('Access::layouts.app')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    @include('Access::layouts.breadcrumb')
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
                        <div class="d-flex align-items-center position-relative my-1 me-2">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->

                            <input type="text" data-kt-permissions-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Zone" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        @if(auth()->user()->hasPermission('location', 'zones', 'create'))
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_permission">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->

                                Add Zone
                            </button>
                        @endif
                        <!--end::Button-->
                    </div>
                    <!--end::Card toolbar-->
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
                                <th class="min-w-80px">Name</th>
                                <th class="min-w-80px">Assigned Person</th>
                                <th class="min-w-120px">Description</th>
                                <th class="min-w-80px">Created Date</th>
                                <th class="min-w-80px text-end">Updated Date</th>
                                @if(auth()->user()->hasPermission('location', 'zones', 'update'))
                                    <th class="min-w-80px">Is Active</th>
                                @endif

                                @if(
                                    auth()->user()->hasPermission('location', 'zones', 'update') ||
                                    auth()->user()->hasPermission('location', 'zones', 'delete')
                                )
                                    <th class="text-end min-w-100px">Actions</th>
                                @endif
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->

                        <!--begin::Table body-->
                        <tbody class="text-black-600">
                            @foreach ($zones as $key => $zone)
                                <tr class="hover-row">
                                    <!--begin::S.N=-->
                                    <td>{{ $key + 1 }}</td>
                                    <!--end::S.N=-->

                                    <!--begin::Zone name=-->
                                    <td>{{ $zone->name }}</td>
                                    <!--end::Zone name=-->

                                    <!--begin::Assigned Person=-->
                                    <td>
                                        @if ($zone->user)
                                            {{ $zone->user->name }} - ({{ $zone->user->username }})
                                        @else
                                            Not Assigned
                                        @endif
                                    </td>
                                    <!--end::Assigned Person=-->

                                    <!--begin::Description=-->
                                    <td>{{ $zone->description }}</td>
                                    <!--end::Description=-->

                                    <!--begin::Created Date=-->
                                    <td>{{ $zone->created_at->setTimezone('Asia/Dhaka')->format('d M, Y') }}</td>
                                    <!--end::Created Date=-->

                                    <!--begin::Updated Date=-->
                                    <td class="text-end">{{ $zone->updated_at->setTimezone('Asia/Dhaka')->format('d M, Y') }}</td>
                                    <!--end::Updated Date=-->

                                    <!--begin::Is Active=-->
                                    @if(auth()->user()->hasPermission('location', 'zones', 'update'))
                                        <td>
                                            <select
                                                onchange="statusUpdate(this, {{ $zone->id }}, '{{ route('location.update_zone', ['id' => ':id']) }}')"
                                                data-current_status="{{ $zone->is_active }}"
                                                class="form-select form-select-solid status" 
                                                data-control="select2" 
                                                data-hide-search="true">
                                                <option value="Active" {{ $zone->is_active == 'Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Inactive" {{ $zone->is_active == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </td>
                                    @endif
                                    <!--end::Is Active=-->
                                    
                                    <!--begin::Action=-->
                                    @if(
                                        auth()->user()->hasPermission('location', 'zones', 'update') ||
                                        auth()->user()->hasPermission('location', 'zones', 'delete')
                                    )
                                        <td class="text-end">
                                            <!--begin::Update-->
                                            @if(auth()->user()->hasPermission('location', 'zones', 'update'))
                                                <button onclick="zone({{ $zone->id }})" title="Update Zone" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="currentColor" />
                                                            <path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            @endif
                                            <!--end::Update-->

                                            <!--begin::Delete-->
                                            @if(auth()->user()->hasPermission('location', 'zones', 'delete'))
                                                <button onclick="destroy({{ $zone->id }}, '{{ route('location.destroy_zone', ['id' => ':id']) }}')" title="Delete Zone" class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            @endif
                                            <!--end::Delete-->
                                        </td>
                                    @endif
                                    <!--end::Action=-->
                                </tr>
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
            <!--begin::Modal - Add Zone-->
            @include('Market::zones.modals.add')
            <!--end::Modal - Add Zone-->

            <!--begin::modal - Deactivate-->
            @include('Access::layouts.deactivate')
            <!--end::modal - Deactivate-->

            <!--begin::Modal - Update Permissions-->
            @include('Market::zones.modals.update')
            <!--end::Modal - Update Permissions-->

            <!--begin::modal - Destroy-->
            @include('Access::layouts.destroy')
            <!--end::modal - Destroy-->
            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>  
@endsection

@push('scripts')
    <script>
        function zone(id) {
            let url = "{{ route('location.zone', ['id' => ':id']) }}";
            let action = url.replace(':id', id);

            $.ajax({
                url: action,
                method: 'GET',
                success: function (data) {
                    const form = $('#kt_modal_update_permission_form');
                    
                    let url = "{{ route('location.update_zone', ['id' => ':id']) }}";
                    let updateUrl = url.replace(':id', id);
                    form.attr('action', updateUrl);

                    form.find('input[name="name"]').val(data.zone.name);
                    form.find('input[name="description"]').val(data.zone.description);
                    let name = data.zone.user ? data.zone.user.name : 'Not Assigned';
                    form.find('h6[name="user_name"]').text(name);
                    form.find('select[name="user_id"]').val(data.zone.user_id).trigger('change');
                },
                error: function (error) {
                    console.error('Error fetching zone data:', error);
                }
            });
        }
    </script>
@endpush
