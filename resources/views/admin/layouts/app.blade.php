<!DOCTYPE html>
<html lang="vi">
<!--begin::Head-->

<head>
    <base href="" />
    <title>{{ @$pageName }}</title>
    <meta charset="utf-8" />
    <meta name="description"
        content="Phần mềm quản lý dự án Newway" />
    <meta name="keywords"
        content="newway, quản lý dự án, phần mềm" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="website" />
    <meta property="og:title"
        content="Phần mềm quản lý dự án Newway" />
    <meta property="og:site_name" content="Phần mềm quản lý dự án Newway" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}



    <link rel="shortcut icon" href="{{ asset('assets/media/logos/newway.png') }}" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />

    {{-- <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    @vite(['resources/css/sass/style.scss', 'resources/css/app.scss', 'resources/js/app.js'])
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" style="background-image: url()"
    class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-enabled" data-kt-aside-minimize="on">

    <!--begin::Page loading(append to body)-->
    <div class="page-loader flex-column bg-gray-900 bg-opacity-50">
        <span class="spinner-border text-success" role="status"></span>
        <span class="text-light fs-5 fw-semibold mt-5">Loading...</span>
    </div>
    <!--end::Page loading-->
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->

    <div class="d-flex flex-column flex-root" id='admin'>
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Aside-->
            @include('admin.layouts.aside.aside-main')
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                @if (!isset($hideHeader) || $hideHeader === false)
                <div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header"
                    data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                    <!--begin::Container-->

                    <div class="container-xxl d-flex align-items-center justify-content-between"
                        id="kt_header_container">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap mt-n5 mt-lg-0 me-lg-2 pb-2 pb-lg-0"
                            data-kt-swapper="true" data-kt-swapper-mode="prepend"
                            data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                            <!--begin::Heading-->

                                <h1 class="text-dark fw-bold my-0 fs-3 pt-5">{{ @$pageName }}</h1>



                        </div>

                        <div class="d-flex d-lg-none align-items-center ms-n2 me-2">
                            <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_mobile_toggle">
                                <i class="ki-duotone ki-abstract-14 fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <a href="/dashboard" class="d-flex align-items-center">
                                <img alt="Logo" src="{{ asset('assets/media/logos/newway.png') }}" class="h-30px" />
                            </a>
                        </div>
                    </div>

                </div>
                @endif
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid mt-3" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-xxl" id="kt_content_container">
                        @yield('content')
                    </div>

                </div>
                <!--end::Content-->

                {{-- trạng thái internet --}}
                <div class="toast-disconnect">
                    <span class="material-symbols-outlined icon fs-2 me-2">
                        wifi_off
                    </span><span class="fs-5">Kết nối
                        internet của bạn đã bị ngắt.</span>
                </div>
                <div class="toast-connect">
                    <span class="material-symbols-outlined icon fs-2 me-2">
                        wifi
                    </span><span class="fs-5">Kết nối internet được khôi phục.</span>
                </div>

                <!--begin::Footer-->
					<div class="footer py-3 d-flex flex-lg-column bg-white" id="kt_footer">
						<!--begin::Container-->
						<div class="container-xxl d-flex flex-column flex-md-row flex-stack justify-content-between">
							<!--begin::Copyright-->
							{{-- <div class="text-dark order-2 order-md-1">
								<span class="text-gray-400 fw-semibold me-1">Created by</span>
								<a href="https://newwaypms.com/" target="_blank" class="text-muted text-hover-primary fw-semibold me-2 fs-6">NEWWAY </a>
							</div> --}}
							<!--end::Copyright-->
							<!--begin::Menu-->
							{{-- <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
								<li class="menu-item">
									<a href="https://newwaypms.com/" target="_blank" class="menu-link px-2">About</a>
								</li>
								<li class="menu-item">
									<a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
								</li>
								<li class="menu-item">
									<a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
								</li>
							</ul> --}}
							<!--end::Menu-->
                            <div class="text-center d-flex align-items-center me-3 text-muted text-footed">
                                Bản quyền thuộc về <span class="fs-6 mx-2 fw-semibold">Công ty Cổ phần giải pháp công nghệ Newway</span>
                            </div>
                            <div class="text-center d-flex align-items-center text-muted text-footed">
                                Website: <a href="https://newwaypms.com/" target="_blank" class="text-muted text-hover-primary fw-semibold ms-1 fs-7">https://newwaypms.com/</a>
                            </div>
                            <div class="text-center d-flex align-items-center text-muted text-footed">Tel: 1900.636116</div>
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    {{-- <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script> --}}
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

    <script>
        var hostUrl = "assets/";
    </script>

    @stack('js')
</body>

</html>
