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
                            <form class="d-flex align-items-center position-relative my-1" action="{{ route('user_management.users') }}" method="GET">
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

                                    <input name="username" value="{{ request('username') }}" type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search by username" />
                                </div>
                                <!--end::Search-->

                                <!--begin::Is Active-->
                                <div class="w-200 mw-250px me-2">
                                    <!--begin::Select2-->
                                    <select name="is_active" class="form-select form-select-solid" data-control="select2" data-placeholder="Search Is Active" data-kt-ecommerce-product-filter="status" data-hide-search="true">>
                                        <option></option>
                                        <option value="Active" {{ request('is_active') == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ request('is_active') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <!--end::Select2-->
                                </div>
                                <!--end::Is Active-->
    
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                        <!--begin::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Add user-->
                                @if(auth()->user()->hasPermission('user-management', 'users', 'create'))
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        
                                        Add User
                                    </button>
                                @endif
                                <!--end::Add user-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-25px">S.N</th>
                                    <th class="min-w-100px">User</th>
                                    <th class="min-w-70px">Role</th>
                                    <th class="min-w-80px">Designation</th>
                                    <th class="min-w-80px">Contact</th>
                                    <th class="min-w-100px">Joining Date</th>
                                    <th class="min-w-100px text-end">Created Date/Time</th>
                                    @if(auth()->user()->hasPermission('user-management', 'users', 'update'))
                                        <th class="min-w-100px">Is Active</th>
                                    @endif
                                    
                                    @if(
                                        auth()->user()->hasPermission('user-management', 'users', 'update') ||
                                        auth()->user()->hasPermission('user-management', 'users', 'delete')
                                    )
                                        <th class="text-end min-w-100px">Actions</th>
                                    @endif
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->

                            <!--begin::Table body-->
                            <tbody class="text-black-600">
                                <!--begin::Table row-->
                                @foreach ($users as $key => $user)
                                    <tr class="hover-row">
                                        <!--begin::S.N=-->
                                        <td>{{ $users->firstItem() + $key }}</td>
                                        <!--end::S.N=-->

                                        <!--begin::User=-->
                                        <td class="d-flex">
                                            <!--begin::Avatar -->
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <a href="javascript:void(0);">
                                                    <div class="symbol-label">
                                                        {{-- <img src="assets/media/avatars/300-6.jpg" alt="Emma Smith" class="w-100" /> --}}
                                                        {{ ucfirst(substr($user->name, 0, 1)) }}
                                                    </div>
                                                </a>
                                            </div>
                                            <!--end::Avatar-->

                                            <!--begin::User Details-->
                                            <div class="d-flex flex-column">
                                                <span>{{ $user->name }}</span>
                                                <a href="javescript:void(0);" class="text-gray-800 text-hover-primary mb-1">{{ $user->username }}</a>
                                            </div>
                                            <!--begin::User Details-->
                                        </td>
                                        <!--end::User=-->

                                        <!--begin::Role=-->
                                        <td>{{ $user->role->name }}</td>
                                        <!--end::Role=-->

                                        <!--begin::Designation=-->
                                        <td>
                                            @if($user->employee->designation)
                                                {{ $user->employee->designation->name }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <!--end::Designation=-->

                                        <!--begin::Contact=-->
                                        <td>
                                            @if ($user->employee->contact)
                                                {{ $user->employee->contact }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <!--end::Contact=-->

                                        <!--begin::Joining Date-->
                                        <td>
                                            @if ($user->employee->joining_date)
                                                {{ $user->employee->joining_date->setTimezone('Asia/Dhaka')->format('d M, Y') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <!--begin::Joining Date-->

                                        <!--begin::Created Date-->
                                        <td class="text-end">
                                            {{ $user->created_at->setTimezone('Asia/Dhaka')->format('d M, Y') }} <br>
                                            {{ $user->created_at->setTimezone('Asia/Dhaka')->format('h:i A') }}
                                        </td>
                                        <!--begin::Created Date-->

                                        <!--begin::Is Active=-->
                                        @if(auth()->user()->hasPermission('user-management', 'users', 'update'))
                                            <td>
                                                <select
                                                    onchange="statusUpdate(this, {{ $user->id }}, '{{ route('user_management.update_user', ['id' => ':id']) }}')"
                                                    data-current_status="{{ $user->is_active }}"
                                                    class="form-select form-select-solid status" 
                                                    data-control="select2" 
                                                    data-hide-search="true">
                                                    <option value="Active" {{ $user->is_active == 'Active' ? 'selected' : '' }}>Active</option>
                                                    <option value="Inactive" {{ $user->is_active == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </td>
                                        @endif
                                        <!--end::Is Active=-->

                                        <!--begin::Action=-->
                                        @if(
                                            auth()->user()->hasPermission('user-management', 'users', 'update') ||
                                            auth()->user()->hasPermission('user-management', 'users', 'delete')
                                        )
                                            <td class="text-end">
                                                <!--begin::Update-->
                                                @if(auth()->user()->hasPermission('user-management', 'users', 'update'))
                                                    <button onclick="user({{ $user->id }})" title="Update User" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_user">
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
                                                @if(auth()->user()->hasPermission('user-management', 'users', 'delete'))
                                                    <button onclick="destroy({{ $user->id }}, '{{ route('user_management.destroy_user', ['id' => ':id']) }}')" title="Delete User" class="btn btn-icon btn-active-light-primary w-30px h-30px">
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
                                <!--end::Table row-->
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->

                        <div class="pagination-container mt-10">
                            <nav>
                                {{ $users->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </nav>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

                <!--begin::Modals-->
                <!--begin::Modal - Add user-->
                @include('Access::users.modals.add')
                <!--end::Modal - Add user-->

                <!--begin::modal - Deactivate-->
                @include('Access::layouts.deactivate')
                <!--end::modal - Deactivate-->

                <!--begin::Modal - Update user-->
                @include('Access::users.modals.update')
                <!--end::Modal - Update user-->

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
        function user(id) {
            let url = "{{ route('user_management.user', ['id' => ':id']) }}";
            let action = url.replace(':id', id);

            $.ajax({
                url: action,
                method: 'GET',
                success: function (data) {
                    const form = $('#kt_modal_update_user_form');

                    let url = "{{ route('user_management.update_user', ['id' => ':id']) }}";
                    let updateUrl = url.replace(':id', id);
                    form.attr('action', updateUrl);

                    form.find('input[name="username"]').val(data.user.username);
                    form.find('input[name="name"]').val(data.user.name);
                    form.find('select[name="role_id"]').val(data.user.role_id).trigger('change');
                    form.find('input[name="contact"]').val(data.user.employee.contact);
                    form.find('input[name="address"]').val(data.user.employee.address);

                    let joiningDate = data.user.employee.joining_date;
                    if (joiningDate) {
                        let formattedDate = new Date(joiningDate).toISOString().split('T')[0];
                        form.find('input[name="joining_date"]').val(formattedDate);
                    } else {
                        form.find('input[name="joining_date"]').val('');
                    }

                    // Designation
                    $('#designation_id').change(function() {
                        // Get the selected value
                        var selected_value = $(this).find('option:selected').data('designation_slug');

                        // Compare the selected value with the desired designation value
                        if (selected_value === 'sells-manager') {
                            $('#zone_div').show();
                            let name = data.user.employee.zone ? data.user.employee.zone.name : 'Not Assigned';
                            form.find('h6[name="zone_name"]').text(name);
                            form.find('select[name="zone_id"]').val(data.user.employee.zone_id).trigger('change');

                            $('#division_div').hide();
                            $('#region_div').hide();
                            $('#area_div').hide();
                            $('#territory_div').hide();

                        } else if (selected_value === 'divisional-manager') {
                            $('#zone_div').hide();

                            $('#division_div').show();
                            form.find('select[name="division_id"]').val(data.user.employee.division_id).trigger('change');

                            $('#region_div').hide();
                            $('#area_div').hide();
                            $('#territory_div').hide();

                        } else if (selected_value === 'regional-manager') {
                            $('#zone_div').hide();
                            $('#division_div').hide();

                            $('#region_div').show();
                            form.find('select[name="region_id"]').val(data.user.employee.region_id).trigger('change');

                            $('#area_div').hide();
                            $('#territory_div').hide();

                        } else if (selected_value === 'area-sells-manager') {
                            $('#zone_div').hide();
                            $('#division_div').hide();
                            $('#region_div').hide();

                            $('#area_div').show();
                            form.find('select[name="area_id"]').val(data.user.employee.area_id).trigger('change');

                            $('#territory_div').hide();

                        } else if (selected_value === 'marketing-officer') {
                            $('#zone_div').hide();
                            $('#division_div').hide();
                            $('#region_div').hide();
                            $('#area_div').hide();

                            $('#territory_div').show();
                            form.find('select[name="territory_id"]').val(data.user.employee.territory_id).trigger('change');

                        } else {
                            $('#zone_div').hide();
                            $('#division_div').hide();
                            $('#region_div').hide();
                            $('#area_div').hide();
                            $('#territory_div').hide();
                        }
                    });

                    form.find('select[name="designation_id"]').val(data.user.employee.designation_id).trigger('change');
                },
                error: function (error) {
                    console.error('Error fetching user data:', error);
                }
            });
        }
    </script>
@endpush