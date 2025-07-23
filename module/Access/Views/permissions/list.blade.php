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
                        <div class="card-title"></div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Button-->
                                @if(auth()->user()->hasPermission('user-management', 'permissions', 'create'))
                                    <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_permission">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                                                <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                                                <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->

                                        Add Permission
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
                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-25px">S.N</th>
                                    <th class="min-w-80px">Name</th>
                                    <th class="min-w-80px">Assigned Role</th>
                                    <th class="min-w-80px">Created Date</th>
                                    <th class="min-w-80px text-end">Updated Date</th>
                                    @if(
                                        auth()->user()->hasPermission('user-management', 'permissions', 'update') ||
                                        auth()->user()->hasPermission('user-management', 'permissions', 'delete')
                                    )
                                        <th class="text-end min-w-200px">Actions</th>
                                    @endif
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->

                            <!--begin::Table body-->
                            <tbody class="text-black-600">
                                @foreach ($permissions as $key => $permission)
                                    <tr class="hover-row">
                                        <!--begin::S.N=-->
                                        <td>{{ $permissions->firstItem() + $key }}</td>
                                        <!--end::S.N=-->

                                        <!--begin::Name=-->
                                        <td>{{ $permission->name }} {{ $permission->subMenu->name }}</td>
                                        <!--end::Name=-->

                                        <!--begin::Assigned role=-->
                                        <td>
                                            @foreach ($permission->roles as $role)
                                                @if ($role->slug === 'editor')
                                                    <a href="javascript:void(0);" class="badge badge-light-primary fs-7 m-1">{{ ucfirst($role->name) }}</a>
                                                @endif
                                                @if ($role->slug === 'employee')
                                                    <a href="javascript:void(0);" class="badge badge-light-success fs-7 m-1">{{ ucfirst($role->name) }}</a>
                                                @endif
                                            @endforeach
                                        </td>
                                        <!--end::Assigned role=-->

                                        <!--begin::Created Date-->
                                        <td>{{ $permission->created_at->setTimezone('Asia/Dhaka')->format('d M, Y') }}</td>
                                        <!--end::Created Date-->

                                        <!--begin::Updated Date-->
                                        <td class="text-end">{{ $permission->updated_at->setTimezone('Asia/Dhaka')->format('d M, Y') }}</td>
                                        <!--end::Updated Date-->
                                        
                                        <!--begin::Action=-->
                                        @if(
                                            auth()->user()->hasPermission('user-management', 'permissions', 'update') ||
                                            auth()->user()->hasPermission('user-management', 'permissions', 'delete')
                                        )
                                            <td class="text-end">
                                                <!--begin::Update-->
                                                @if(auth()->user()->hasPermission('user-management', 'permissions', 'update'))
                                                    <button onclick="permission({{ $permission->id }})" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
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
                                                @if(auth()->user()->hasPermission('user-management', 'permissions', 'delete'))
                                                    <button onclick="destroy({{ $permission->id }}, '{{ route('user_management.destroy_permission', ['id' => ':id']) }}')" class="btn btn-icon btn-active-light-primary w-30px h-30px">
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

                        <div class="pagination-container mt-10">
                            <nav>
                                {{ $permissions->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </nav>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

                <!--begin::Modals-->
                <!--begin::Modal - Add Permissions-->
                @include('Access::permissions.modals.add')
                <!--end::Modal - Add Permissions-->

                <!--begin::Modal - Update Permissions-->
                @include('Access::permissions.modals.update')
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
        function permission(permission_id) {
            let url = "{{ route('user_management.permission', ['id' => ':permission_id']) }}";
            let action = url.replace(':permission_id', permission_id);

            $.ajax({
                url: action,
                method: 'GET',
                success: function (data) {
                    const form = $('#kt_modal_update_permission_form');
                    
                    let url = "{{ route('user_management.update_permission', ['id' => ':permission_id']) }}";
                    let updateUrl = url.replace(':permission_id', permission_id);
                    form.attr('action', updateUrl);

                    form.find('select[name="sub_menu_id"]').val(data.sub_menu_id).trigger('change');
                    form.find('select[name="name"]').val(data.name).trigger('change');
                },
                error: function (error) {
                    console.error('Error fetching permission data:', error);
                }
            });
        }
    </script>
@endpush