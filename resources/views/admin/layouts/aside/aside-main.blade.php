<div id="kt_aside" class="aside aside-extended max-h-100" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Primary-->
    @include('admin.layouts.aside.aside-left')
    <!--end::Primary-->
    <!--begin::Secondary-->
    @include('admin.layouts.aside.aside-right')
    <!--end::Secondary-->
    <!--begin::Aside Toggle-->
    <button id="kt_aside_toggle"
        class="aside-toggle btn btn-sm btn-icon btn-color-white btn-primary btn-active-primary position-absolute translate-middle start-100 end-0 bottom-25 shadow-sm d-none d-lg-flex active"
        data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
        data-kt-toggle-name="aside-minimize"><i class="ki-duotone ki-arrow-left fs-2 rotate-180"><span
                class="path1"></span><span class="path2"></span></i></button>
    <!--end::Aside Toggle-->
</div>

