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
            <!--begin::Row-->
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                <!--begin::Add new card-->
                @if(auth()->user()->hasPermission('user-management', 'roles', 'create'))
                    <div class="ol-md-4">
                        <!--begin::Card-->
                        <div class="card h-md-100">
                            <!--begin::Card body-->
                            <div class="card-body d-flex flex-center">
                                <!--begin::Button-->
                                <button type="button" class="btn btn-clear d-flex flex-column flex-center" data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">
                                    <!--begin::Illustration-->
                                    <img src="assets/media/illustrations/sketchy-1/4.png" alt="" class="mw-100 mh-150px mb-7" />
                                    <!--end::Illustration-->

                                    <!--begin::Label-->
                                    <div class="fw-bolder fs-3 text-gray-600 text-hover-primary">Add Role</div>
                                    <!--end::Label-->
                                </button>
                                <!--begin::Button-->
                            </div>
                            <!--begin::Card body-->
                        </div>
                        <!--begin::Card-->
                    </div>
                @endif
                <!--begin::Add new card-->

                <!--begin::Col-->
                @foreach ($roles as $role)
                    <div class="col-md-4">
                        <!--begin::Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>{{ ucfirst($role->name) }}</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-1">
                                <!--begin::Users-->
                                <div class="fw-bolder text-gray-600 mb-5">{{ ucfirst($role->name) }} role and it's permissions</div>
                                <!--end::Users-->

                                <!--begin::Permissions-->
                                @php
                                    $remainingPermissionsCount = $role->permissions->count() - 4;
                                @endphp

                                <div class="d-flex flex-column text-gray-600">
                                    @if ($role->permissions->isEmpty())
                                        <div class='d-flex align-items-center py-2'>
                                            <span class='bullet bg-primary me-3'></span>
                                            <em>The Role has no Permissions</em>
                                        </div>
                                    @else
                                        @foreach ($role->permissions->take(4) as $permission)
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>{{ $permission->subMenu->menu->name }} —> {{ $permission->subMenu->name }} —> {{ $permission->name }} 
                                            </div>
                                        @endforeach

                                        @if ($remainingPermissionsCount > 0)
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-warning me-3"></span> And {{ $remainingPermissionsCount }} more permissions
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <!--end::Permissions-->
                            </div>
                            <!--end::Card body-->

                            <!--begin::Card footer-->
                            <div class="card-footer flex-wrap pt-0">
                                <a href="javascript:void(0);" class="btn btn-light btn-active-primary my-1 me-3">
                                    View Role
                                </a>

                                @if(auth()->user()->hasPermission('user-management', 'roles', 'update'))
                                    <button onclick="assign_permissions({{ $role->id }})" type="button" class="btn btn-light btn-active-light-primary my-1 me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_assign_permissions">
                                        Assign Permissions
                                    </button>

                                    <button onclick="role_({{ $role->id }})" title="Update Role" class="btn btn-icon btn-active-primary w-40px h-40px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
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

                                @if(auth()->user()->hasPermission('user-management', 'roles', 'delete'))
                                    <button onclick="destroy({{ $role->id }}, '{{ route('user_management.destroy_role', ['id' => ':id']) }}')" title="Delete Role" class="btn btn-icon btn-active-primary w-40px h-40px">
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
                            </div>
                            <!--end::Card footer-->
                        </div>
                        <!--end::Card-->
                    </div>
                @endforeach
                <!--end::Col-->
            </div>
            <!--end::Row-->

            <!--begin::Modals-->
            <!--begin::Modal - Add Role-->
            @include('Access::roles.modals.add')
            <!--end::Modal - Add Role-->

            <!--begin::Modal - Assign Permissions-->
            @include('Access::roles.modals.assign_permissions')
            <!--end::Modal - Assign Permissions-->

            <!--begin::Modal - Update Permissions-->
            @include('Access::roles.modals.update')
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
        function assign_permissions(id) {
            let url = "{{ route('user_management.role', ['id' => ':id']) }}";
            let action = url.replace(':id', id);

            $.ajax({
                url: action,
                method: 'GET',
                success: function (data) {
                    const form = $('#kt_modal_assign_permissions_form');

                    let url = "{{ route('user_management.assign_role_permissions', ['id' => ':id']) }}";
                    let updateUrl = url.replace(':id', id);
                    form.attr('action', updateUrl);

                    form.find('label.form-label.mb-8').html(`Assign Permissions to this <strong><span style="color: #0056b3;">${data.name}</span></strong> Role`);

                    $('input[name="permissions[]"]').prop('checked', false);

                    data.permissions.forEach(function(permission) {
                        $('input[name="permissions[]"]').each(function() {
                            if ($(this).val() == permission.id) {
                                $(this).prop('checked', true);
                            }
                        });
                    });
                },
                error: function (error) {
                    console.error('Error fetching role data:', error);
                }
            });
        }

        function role_(id) {
            let url = "{{ route('user_management.role', ['id' => ':id']) }}";
            let action = url.replace(':id', id);

            $.ajax({
                url: action,
                method: 'GET',
                success: function (data) {
                    const form = $('#kt_modal_update_role_form');

                    let url = "{{ route('user_management.update_role', ['id' => ':id']) }}";
                    let updateUrl = url.replace(':id', id);
                    form.attr('action', updateUrl);

                    form.find('input[name="name"]').val(data.name);
                },
                error: function (error) {
                    console.error('Error fetching role data:', error);
                }
            });
        }
    </script>
@endpush
