<div class="aside-secondary d-flex max-h-100">
    <!--begin::Workspace-->
    <div class="aside-workspace my-5" id="kt_aside_wordspace">
        <div class="d-flex h-100 flex-column">
            <!--begin::Wrapper-->
            <div class="flex-column-fluid hover-scroll-y pt-10" data-kt-scroll="true" data-kt-scroll-activate="true"
                data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_wordspace"
                data-kt-scroll-dependencies="#kt_aside_secondary_footer" data-kt-scroll-offset="0px">
                <!--begin::Tab content-->
                <div class="tab-content">
                    {{-- Quản lý - khách hàng, dự án, người dùng --}}
                    <div class="tab-pane fade" id="kt_aside_nav_management" role="tabpanel">
                        <!--begin::Tasks-->
                        <div class="mx-5 text-uppercase">
                            <!--begin::Header-->
                            <p class="fw-bold text-primary fs-4 mb-8 mx-0">Quản lý</p>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="mb-12 ps-4">
                                <!--begin::Item-->
                                <!--begin:Menu item-->
                                @if (App\Helper\check_sub_menu_permission('admin.customers.view') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.customers.view' ? 'active' : '' }}"
                                            href="{{ route('admin.customers.view') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-sharp fa-solid fa-people-group fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo khách hàng') }}</span>
                                            </span>
                                        </a>

                                    </div>
                                @endif

{{--                                @if (App\Helper\check_sub_menu_permission('admin.projects-management.index') == true)--}}
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 {{ Route::current()->getName() == 'admin.hrm-contacts.index' ? 'active' : '' }}"
                                           href="{{ route('admin.hrm-contacts.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-microchip fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Quản lý nhân sự') }}</span>
                                            </span>
                                        </a>

                                    </div>
{{--                                @endif--}}

                                {{--                                @if (App\Helper\check_sub_menu_permission('admin.projects-management.index') == true)--}}
                                <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                    <!--begin:Menu link-->
                                    <a class="menu-link p-0 {{ Route::current()->getName() == 'admin.hrm-contracts.index' ? 'active' : '' }}"
                                       href="{{ route('admin.hrm-contracts.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-microchip fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Quản lý hợp đồng nhân sự') }}</span>
                                            </span>
                                    </a>

                                </div>
                                {{--                                @endif--}}

                                @if (App\Helper\check_sub_menu_permission('admin.projects-management.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 {{ Route::current()->getName() == 'admin.projects-management.index' ? 'active' : '' }}"
                                            href="{{ route('admin.projects-management.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-microchip fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo dự án') }}</span>
                                            </span>
                                        </a>

                                    </div>
                                @endif

{{--                                @if (App\Helper\check_sub_menu_permission('admin.projects-management.index') == true)--}}
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 {{ Route::current()->getName() == 'admin.request-tickets.index' ? 'active' : '' }}"
                                           href="{{ route('admin.request-tickets.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-microchip fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Quản lý phiếu yêu cầu') }}</span>
                                            </span>
                                        </a>

                                    </div>
{{--                                @endif--}}

                                {{--                                @if (App\Helper\check_sub_menu_permission('admin.projects-management.index') == true)--}}
                                <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                    <!--begin:Menu link-->
                                    <a class="menu-link p-0 {{ Route::current()->getName() == 'admin.workflow.index' ? 'active' : '' }}"
                                       href="{{ route('admin.workflow.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-microchip fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo quy trình duyệt') }}</span>
                                            </span>
                                    </a>

                                </div>
                                {{--                                @endif--}}

                                @if (App\Helper\check_sub_menu_permission('admin.contract.view') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 {{ Route::current()->getName() == 'admin.contract.view' ? 'active' : '' }}"
                                            href="{{ route('admin.contract.view') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-file-signature fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo hợp đồng') }}</span>
                                            </span>
                                        </a>

                                    </div>
                                @endif

                                @if (App\Helper\check_sub_menu_permission('admin.deployment_schedule.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 {{ Route::current()->getName() == 'admin.deployment_schedule.index' ? 'active' : '' }}"
                                            href="{{ route('admin.deployment_schedule.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fas fa-calendar-alt fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo lịch triển khai') }}</span>
                                            </span>
                                        </a>

                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.quote.view') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 {{ Route::current()->getName() == 'admin.quote.view' ? 'active' : '' }}"
                                            href="{{ route('admin.quote.view') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fas fa-money-check-alt fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Báo giá sản phẩm') }}</span>
                                            </span>
                                        </a>

                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.deployment-records.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.deployment-records.index' ? 'active' : '' }}"
                                            href="{{ route('admin.deployment-records.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-person-walking-luggage fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo biên bản triển khai') }}</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.acceptance-records.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.acceptance-records.index' ? 'active' : '' }}"
                                            href="{{ route('admin.acceptance-records.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-user-check fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo biên bản nghiệm thu') }}</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.dispatches.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.dispatches.index' ? 'active' : '' }}"
                                            href="{{ route('admin.dispatches.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-sharp fa-solid fa-file-invoice fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo công văn, thông báo') }}</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Tasks-->
                    </div>

                    {{-- Khai báo -  --}}
                    <div class="tab-pane fade" id="kt_aside_nav_declare" role="tabpanel">
                        <!--begin::Customer-->
                        <div class="mx-5 text-uppercase">
                            <!--begin::Header-->
                            <h3 class="fw-bold text-primary fs-4 mb-8 mx-0">Khai báo</h3>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="mb-12 ps-4">
                                <!--begin::Item-->
                                <!--begin:Menu item-->
                                @if (App\Helper\check_sub_menu_permission('admin.statuses.view') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.statuses.view' ? 'active' : '' }}"
                                            href="{{ route('admin.statuses.view') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-sliders fs-2"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo trạng thái') }}</span>
                                            </span>
                                        </a>

                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.departments.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.departments.index' ? 'active' : '' }}"
                                            href="{{ route('admin.departments.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i
                                                        class="va-icon vc-ribbon-icon vc-ribbon-icon-large mdi icon vc-ribbon-icon vc-ribbon-icon-large fa fa-sitemap fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo bộ phận') }}</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.contract_type.view') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.contract_type.view' ? 'active' : '' }}"
                                            href="{{ route('admin.contract_type.view') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-file-contract fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo loại hợp đồng') }}</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.project_types.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.project_types.index' ? 'active' : '' }}"
                                            href="{{ route('admin.project_types.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-microchip fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo loại dự án') }}</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.banks.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.banks.index' ? 'active' : '' }}"
                                            href="{{ route('admin.banks.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-building-columns fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo ngân hàng') }}</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.units.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.units.index' ? 'active' : '' }}"
                                            href="{{ route('admin.units.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-coins fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo đơn vị tính') }}</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.tax-fee-rates.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.tax-fee-rates.index' ? 'active' : '' }}"
                                            href="{{ route('admin.tax-fee-rates.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-sharp fa-solid fa-percent fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo tỷ lệ thuế phí') }}</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.product_group.view') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.product_group.view' ? 'active' : '' }}"
                                            href="{{ route('admin.product_group.view') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-layer-group fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo nhóm sản phẩm') }}</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.products.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 {{ Route::current()->getName() == 'admin.products.index' ? 'active' : '' }}"
                                            href="{{ route('admin.products.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fab fa-product-hunt fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo sản phẩm') }}</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif

{{--                                @if (App\Helper\check_sub_menu_permission('admin.allowances.index') == true)--}}
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 {{ Route::current()->getName() == 'admin.allowances.index' ? 'active' : '' }}"
                                           href="{{ route('admin.allowances.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fab fa-product-hunt fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo phụ cấp') }}</span>
                                            </span>
                                        </a>
                                    </div>
{{--                                @endif--}}


                                {{--                                @if (App\Helper\check_sub_menu_permission('admin.allowances.index') == true)--}}
                                <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                    <!--begin:Menu link-->
                                    <a class="menu-link p-0 {{ Route::current()->getName() == 'admin.taxes.index' ? 'active' : '' }}"
                                       href="{{ route('admin.taxes.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fab fa-product-hunt fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Khai báo thuế') }}</span>
                                            </span>
                                    </a>
                                </div>
                                {{--                                @endif--}}


                                {{--                                @if (App\Helper\check_sub_menu_permission('admin.allowances.index') == true)--}}
                                <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                    <!--begin:Menu link-->
                                    <a class="menu-link p-0 {{ Route::current()->getName() == 'admin.internal-fund.index' ? 'active' : '' }}"
                                       href="{{ route('admin.internal-fund.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fab fa-product-hunt fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Qũy nội bộ') }}</span>
                                            </span>
                                    </a>
                                </div>
                                {{--                                @endif--}}

                                {{--                                @if (App\Helper\check_sub_menu_permission('admin.allowances.index') == true)--}}
                                <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                    <!--begin:Menu link-->
                                    <a class="menu-link p-0 {{ Route::current()->getName() == 'admin.user-leave-days.index' ? 'active' : '' }}"
                                       href="{{ route('admin.user-leave-days.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fab fa-product-hunt fs-4"></i>
                                                </span>
                                                <span
                                                    class="menu-title fw-medium fs-7">{{ trans('Cấu hình nghỉ phép') }}</span>
                                            </span>
                                    </a>
                                </div>
                                {{--                                @endif--}}


                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Tasks-->
                    </div>

                    <div class="tab-pane fade" id="kt_aside_nav_user" role="tabpanel">
                        <!--begin::Tasks-->
                        <div class="mx-5 text-uppercase">
                            <!--begin::Header-->
                            <h3 class="fw-bold text-primary fs-4 mb-8 mx-0">Người dùng</h3>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="mb-12 ps-4">
                                <!--begin::Item-->
                                <!--begin:Menu item-->
                                @if (App\Helper\check_sub_menu_permission('admin.users.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.users.index' ? 'active' : '' }}"
                                            href="{{ route('admin.users.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-users fs-4"></i>
                                                </span>
                                                <span class="menu-title fw-medium fs-7">Khai báo người dùng</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.roles.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.roles.index' ? 'active' : '' }}"
                                            href="{{ route('admin.roles.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-shield-halved fs-4"></i>
                                                </span>
                                                <span class="menu-title fw-medium fs-7">Khai báo nhóm quyền</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Tasks-->
                    </div>

                    <div class="tab-pane fade" id="kt_aside_nav_report" role="tabpanel">
                        <!--begin::Tasks-->
                        <div class="mx-5 text-uppercase">
                            <!--begin::Header-->
                            <h3 class="fw-bold text-primary fs-4 mb-8 mx-0">Báo cáo</h3>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="mb-12 ps-4">
                                <!--begin::Item-->
                                <!--begin:Menu item-->
                                @if (App\Helper\check_sub_menu_permission('admin.reports.customers.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.reports.customers.index' ? 'active' : '' }}"
                                            href="{{ route('admin.reports.customers.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-file-contract fs-4"></i>
                                                </span>
                                                <span class="menu-title fw-medium fs-7">Báo cáo khách hàng</span>
                                            </span>
                                        </a>

                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.reports.projects.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.reports.projects.index' ? 'active' : '' }}"
                                            href="{{ route('admin.reports.projects.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-file-contract fs-4"></i>
                                                </span>
                                                <span class="menu-title fw-medium fs-7">Báo cáo dự án</span>
                                            </span>
                                        </a>

                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.reports.contracts.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.reports.contracts.index' ? 'active' : '' }}"
                                            href="{{ route('admin.reports.contracts.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-file-contract fs-4"></i>
                                                </span>
                                                <span class="menu-title fw-medium fs-7">Báo cáo hợp đồng</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.reports.dispatches.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.reports.dispatches.index' ? 'active' : '' }}"
                                            href="{{ route('admin.reports.dispatches.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-file-contract fs-4"></i>
                                                </span>
                                                <span class="menu-title fw-medium fs-7">Báo cáo công văn, thông
                                                    báo</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.reports.payment-details.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.reports.payment-details.index' ? 'active' : '' }}"
                                            href="{{ route('admin.reports.payment-details.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-file-contract fs-4"></i>
                                                </span>
                                                <span class="menu-title fw-medium fs-7">Báo cáo tiến độ thanh toán hợp
                                                    đồng</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.reports.acceptance-records.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.reports.acceptance-records.index' ? 'active' : '' }}"
                                            href="{{ route('admin.reports.acceptance-records.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-file-contract fs-4"></i>
                                                </span>
                                                <span class="menu-title fw-medium fs-7">Báo cáo tiến độ nghiệm
                                                    thu</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                @if (App\Helper\check_sub_menu_permission('admin.reports.deployment-records.index') == true)
                                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                        <!--begin:Menu link-->
                                        <!--begin:Menu link-->
                                        <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.reports.deployment-records.index' ? 'active' : '' }}"
                                            href="{{ route('admin.reports.deployment-records.index') }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="fa-solid fa-file-contract fs-4"></i>
                                                </span>
                                                <span class="menu-title fw-medium fs-7">Báo cáo tiến độ triển
                                                    khai</span>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                                {{-- <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                                    <!--begin:Menu link-->
                                    <!--begin:Menu link-->
                                    <a class="menu-link p-0 fs-5 {{ Route::current()->getName() == 'admin.reports.payment-detail-projects.index' ? 'active' : '' }}" href="{{ route('admin.reports.payment-detail-projects.index') }}">
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="fa-solid fa-user-pen fs-4"></i>
                                            </span>
                                            <span class="menu-title fw-medium fs-7">Báo cáo chi tiết doanh thu dự án</span>
                                        </span>
                                    </a>
                                </div> --}}

                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Tasks-->
                    </div>

                </div>
                <!--end::Tab content-->
            </div>
            <!--end::Wrapper-->
        </div>
    </div>
    <!--end::Workspace-->
</div>
