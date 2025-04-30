<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
    integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
    integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="aside-primary d-flex flex-column align-items-lg-center flex-row-auto">
    <!--begin::Logo-->
    <div class="aside-logo d-none d-lg-flex flex-column align-items-center flex-column-auto py-10" id="kt_aside_logo">
        <a href="/dashboard">
            <img alt="Logo" src="{{ asset('assets/media/logos/newway.png') }}" class="h-35px" />
        </a>
    </div>

    <!--end::Logo-->
    <!--begin::Nav-->
    <div class="aside-nav d-flex flex-column align-items-center flex-column-fluid w-100 pt-5 pt-lg-0" id="kt_aside_nav">
        <!--begin::Wrapper-->
        <div class="hover-scroll-overlay-y mb-5 px-5" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-wrappers="#kt_aside_nav" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
            data-kt-scroll-offset="0px">
            <!--begin::Nav-->
            <ul class="nav flex-column w-100" id="kt_aside_nav_tabs">
                @if (App\Helper\check_menu_permission(App\Enums\MenuPermissionEnum::GROUP_MENU_MANAGEMENT) == true)
                    <li class="d-flex flex-wrap justify-content-center menu-li nav-item mb-4 {{ array_search(Route::current()->getName(), Config::get('project.route_uri')['management']) !== false ? 'active' : '' }}"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                        data-bs-dismiss="click" title="{{ trans('Quản lý') }}">
                        <!--begin::Nav link-->
                        <a class="nav-link btn btn-icon btn-color-gray-400 btn-active-light mb-2" data-bs-toggle="tab"
                            href="#kt_aside_nav_management">
                            <i class="fa-sharp fa-solid fa-gear fs-1"></i>
                        </a>
                        <span class="text-uppercase text-center  fs-7 text-gray-400">{{ trans('Quản lý') }}</span>
                        <!--end::Nav link-->
                    </li>
                @endif
                @if (App\Helper\check_menu_permission(App\Enums\MenuPermissionEnum::GROUP_MENU_DECLARE) == true)
                    <li class="d-flex flex-wrap justify-content-center menu-li nav-item mb-4 {{ array_search(Route::current()->getName(), Config::get('project.route_uri')['declare']) !== false ? 'active' : '' }}"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                        data-bs-dismiss="click" title="{{ trans('Khai báo') }}">
                        <!--begin::Nav link-->
                        <a class="nav-link btn btn-icon  btn-color-gray-400 btn-active-light mb-2" data-bs-toggle="tab"
                            href="#kt_aside_nav_declare">
                            <i class="fa-solid fa-plus fs-1"></i>
                        </a>
                        <span class="text-uppercase text-center fs-7 text-gray-400">{{ trans('Khai báo') }}</span>
                        <!--end::Nav link-->
                    </li>
                @endif
                @if (App\Helper\check_menu_permission(App\Enums\MenuPermissionEnum::GROUP_MENU_USER) == true)
                    <li class="d-flex flex-wrap justify-content-center menu-li nav-item mb-4 {{ array_search(Route::current()->getName(), Config::get('project.route_uri')['user']) !== false ? 'active' : '' }}"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                        data-bs-dismiss="click" title="{{ trans('Quản lý người dùng') }}">
                        <!--begin::Nav link-->
                        <a class="nav-link btn btn-icon  btn-color-gray-400 btn-active-light mb-2" data-bs-toggle="tab"
                            href="#kt_aside_nav_user">
                            <i class="fa-solid fa-users-gear fs-1"></i>
                        </a>
                        <span class="text-uppercase text-center fs-7 text-gray-400">{{ trans('Người dùng') }}</span>
                        <!--end::Nav link-->
                    </li>
                @endif
                @if (App\Helper\check_menu_permission(App\Enums\MenuPermissionEnum::GROUP_MENU_REPORT) == true)
                    <li class="d-flex flex-wrap justify-content-center menu-li nav-item mb-4 {{ array_search(Route::current()->getName(), Config::get('project.route_uri')['report']) !== false ? 'active' : '' }}"
                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                        data-bs-dismiss="click" title="{{ trans('Báo cáo') }}">
                        <!--begin::Nav link-->
                        <a class="nav-link btn btn-icon  btn-color-gray-400 btn-active-light mb-2" data-bs-toggle="tab"
                            href="#kt_aside_nav_report">
                            <i class="fa-sharp fa-solid fa-scroll fs-1"></i>
                        </a>
                        <span class="text-uppercase text-center fs-7 text-gray-400">{{ trans('Báo cáo') }}</span>
                        <!--end::Nav link-->
                    </li>
                @endif
                <li class="d-flex flex-wrap justify-content-center menu-li nav-item mb-4 ">
                    <!--begin::Nav link-->
                    <a class="nav-link btn btn-icon  btn-color-gray-400 btn-active-light mb-2"
                        href="{{ route('admin.logout') }}">
                        <i class="fa-solid fa fa-sign-out fs-1"></i>
                    </a>
                    <span class="text-uppercase text-center fs-7 text-gray-400">{{ trans('Đăng xuất') }}</span>
                    <!--end::Nav link-->
                </li>

            </ul>
            <!--end::Tabs-->
        </div>
        <!--end::Nav-->
    </div>
    @php
        $notifications = auth()
            ->user()
            ->notifications()
            ->limit(10)
            ->get()
            ->sortByDesc('created_at');
        $countNotifications = auth()
            ->user()
            ->unreadNotifications->count();
    @endphp
    <!--begin::Footer-->
    <div class="aside-footer d-flex flex-column align-items-center flex-column-auto" id="kt_aside_footer">
        <!--begin::Quick links-->
        <!--begin::User-->
        <!--begin::Notifications-->
        <div class="d-flex align-items-center mb-2" id="form-dispatch">

            <!--begin::Menu wrapper-->

            <div data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Cảnh báo"
                class="cursor-pointer symbol symbol-40px rounded-circle mb-6" data-bs-toggle="modal"
                data-bs-target="#modalNotification">
                <img src="https://cdn-icons-png.flaticon.com/512/3239/3239958.png" alt="image" />
                <div id="notifications"
                    style="position: absolute;z-index:2;top:0%; color:white; border:1px solid red;background:red; border-radius:30px; padding:2px;
                                     right:0%; text-align:left; font-size:12px;
                                 ">
                    {{ $countNotifications }}
                </div>
            </div>
            <!--begin::Menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column w-500px w-lg-375px" data-kt-menu="true"
                id="kt_menu_notifications">
                <!--begin::Heading-->
                <div class="d-flex flex-column bgi-no-repeat rounded-top"
                    style="background-color: var(--bs-primary) !important;">
                    <!--begin::Title-->
                    <h3 class="text-white fw-semibold px-9 mt-5 mb-4" style="font-size:17px;">Danh sách cảnh báo
                        <span class="fs-8 opacity-75 ps-3"></span>
                    </h3>
                </div>
                <!--end::Heading-->
                <!--begin::Tab content-->
                <div class="tab-content ">
                    <!--begin::Tab panel-->
                    <div class="tab-pane fade active show" id="kt_topbar_notifications_1" role="tabpanel">
                        <!--begin::Items-->
                        <div class="scroll-y mh-425px my-5 px-8">
                            <!--begin::Item-->
                            {{-- ['contracts'] --}}

                            @if (count($notifications))
                                <notification-aside-bar></notification-aside-bar>
                            @else
                                <div class="mb-0 me-2 text-center py-2">
                                    Không có dữ liệu hiển thị.
                                </div>
                            @endif

                        </div>
                        <!--end::Items-->
                        <!--begin::View more-->
                        {{-- $countNotifications  --}}
                        <div class="py-2 text-center border-top d-flex">
                            <div>
                                <a href="#" onclick="maskAsRead()"
                                    class="btn btn-color-gray-600 btn-active-color-primary text-content {{ $countNotifications < 1 ? 'disabled' : '' }}">
                                    Đánh dấu đọc tất cả
                                    <i class="ki-duotone ki-arrow-right fs-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i></a>
                            </div>
                            <div>
                                <a href="{{ route('admin.notification.index') }}"
                                    class="btn btn-color-gray-600 btn-active-color-primary text-content">
                                    Xem tất cả
                                    <i class="ki-duotone ki-arrow-right fs-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </a>
                            </div>
                        </div>
                        <!--end::View more-->
                    </div>
                    <!--end::Tab panel-->
                </div>
                <!--end::Tab content-->
            </div>
            <!--end::Menu-->
            <!--end::Menu wrapper-->
        </div>
        <!--end::Notifications-->

        <div class="d-flex align-items-center mb-10" id="kt_header_user_menu_toggle">
            <!--begin::Menu wrapper-->
            <div class="cursor-pointer symbol symbol-40px rounded-circle" data-kt-menu-trigger="click"
                data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-bs-toggle="tooltip"
                data-bs-placement="right" data-bs-dismiss="click"
                title="{{ Auth::user()->name ?? '' }} ({{ Auth::user()->username ?? '' }})">
                <img src="{{ auth()->user()->avatar ? '../storage/' . auth()->user()->avatar : asset('/assets/media/avatars/avatar-default.jpg') }}"
                    class="rounded-circle" alt="image" />
            </div>
            <!--begin::User account menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                data-kt-menu="true">
                <!--begin::Menu item-->

                <div class="menu-item px-3">
                    <div class="menu-content d-flex align-items-center px-3">
                        <!--begin::Avatar-->
                        {{-- asset('storage/user_images/avatar-default.png') --}}
                        <div class="symbol symbol-50px me-5">
                            <img alt="Logo"
                                src="{{ auth()->user()->avatar ? '../storage/' . auth()->user()->avatar : asset('/assets/media/avatars/avatar-default.jpg') }}" />
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Username-->
                        <div class="d-flex flex-column">
                            <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name ?? '' }}
                            </div>
                            <a href="#"
                                class="fw-semibold text-muted text-hover-primary fs-7 mt-1">{{ Auth::user()->username ?? asset('/assets/media/avatars/avatar-default.jpg') }}</a>
                        </div>
                        <!--end::Username-->
                    </div>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator my-2"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->
                <div class="menu-item px-5">
                    <a href="{{ route('admin.users.profile.index') }}"
                        class="menu-link px-5">{{ trans('Thông tin cá nhân') }}</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-5">
                    <a href="{{ route('admin.projects-management.index') }}" class="menu-link px-5">
                        <span class="menu-text">{{ trans('Dự án của tôi') }}</span>
                        <span class="menu-badge">
                            {{-- <span class="badge badge-light-danger badge-circle fw-bold fs-7">3</span> --}}
                        </span>
                    </a>
                </div>
                <!--end::Menu item-->
                {{-- <div class="menu-item px-5">
                    <a href="../../demo7/dist/account/statements.html"
                        class="menu-link px-5">{{ trans('Báo cáo của tôi') }}</a>
                </div> --}}
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator my-2"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->
                {{-- <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                    data-kt-menu-placement="right-end" data-kt-menu-offset="-15px, 0">
                    <a href="#" class="menu-link px-5">
                        <span class="menu-title position-relative">{{ trans('Ngôn ngữ') }}
                            <span
                                class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">Tiếng
                                Việt
                                <img class="w-15px h-15px rounded-1 ms-2"
                                    src="{{ asset('assets/media/flags/vietnam.svg') }}"
                                    alt="" /></span></span>
                    </a>
                    <!--begin::Menu sub-->
                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5 active">
                                <span class="symbol symbol-20px me-4">
                                    <img class="rounded-1" src="{{ asset('assets/media/flags/vietnam.svg') }}"
                                        alt="" />
                                </span>Tiếng Việt</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5">
                                <span class="symbol symbol-20px me-4">
                                    <img class="rounded-1" src="{{ asset('assets/media/flags/united-states.svg') }}"
                                        alt="" />
                                </span>English</a>
                        </div>
                    </div>
                    <!--end::Menu sub-->
                </div> --}}
                <!--end::Menu item-->
                <!--begin::Menu item-->
                {{-- <div class="menu-item px-5 my-1">
                    <a href="../../demo7/dist/account/settings.html" class="menu-link px-5">Đổi mật khẩu</a>
                </div> --}}


                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-5">
                    <a href="{{ route('admin.logout') }}" class="menu-link px-5">Đăng xuất</a>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::User account menu-->
            <!--end::Menu wrapper-->
        </div>
        <!--end::User-->
    </div>
    <!--end::Footer-->
</div>
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"
        integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function maskAsRead() {
            $(document).ready(function() {
                axios.post('update-mask-read')
                    .then((res) => {
                        const {
                            message
                        } = res.data
                        window.location.reload()
                        toastr.success(message, {
                            position: 'top',
                            duration: 5000,
                            onclose: true,
                            dismissible: true,
                        })

                    }).catch((error) => {
                        console.log(error)
                    })
            })
        }
    </script>
@endpush
