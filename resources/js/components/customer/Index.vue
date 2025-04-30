<template>
    <div class="col-xxl-12 col-xl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch pt-5">
            <!--begin::Header-->

            <div
                class="d-flex align-items-center justify-content-between flex-wrap ms-5"
            >
                <div class="d-flex align-items-center flex-wrap">
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-2"
                    >
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label"
                                >Mã/Tên khách hàng</label
                            >
                        </div>
                        <div class="w-100px">
                            <input
                                type="text"
                                class="form-control mb-lg-0 p-2"
                                id="customerCode"
                                v-model="search"
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-2"
                    >
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label"
                                >Mã số thuế</label
                            >
                        </div>
                        <div class="w-100px">
                            <input
                                type="text"
                                class="form-control mb-lg-0 p-2"
                                id="customerCode"
                                v-model="tax_code"
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center me-1 flex-wrap w-auto"
                    >
                        <div class="w-auto">
                            <label class="col-form-label" for="checkCreate"
                                >Ngày khai báo</label
                            >
                        </div>
                        <div class="ms-1 me-1 w-125px">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                id="fromDate"
                                placeholder=""
                                :max="moment().format('YYYY-MM-DD')"
                                v-model="from_date"
                            />
                        </div>
                        <div class="w-10px">
                            <label class="col-form-label">-</label>
                        </div>
                        <div class="ms-1 w-125px">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                id="toDate"
                                v-model="to_date"
                                :min="from_date"
                                :max="moment().format('YYYY-MM-DD')"
                            />
                        </div>
                    </div>
                    <a
                        href="#"
                        class="btn btn-icon btn-sm btn-icon-bg-primary btn-color-light"
                        @click="clickSearch()"
                    >
                        <i class="fa-solid fa-magnifying-glass"></i
                    ></a>
                </div>
                <div class="align-items-center">
                    <a
                        href="#"
                        class="btn btn-function me-2"
                        v-if="btnAdd"
                        @click="clickCreate()"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm</a
                    >
                    <a
                        href="#"
                        class="btn btn-function me-2"
                        v-if="dataUpdate.id != 0 && dataUpdate.is_edit"
                        @click="() => store.toggleShowModal(true)"
                    >
                        <i class="fa-regular fa-pen-to-square"></i>Sửa</a
                    >
                    <a
                        href="#"
                        class="btn btn-function"
                        v-if="dataUpdate.id != 0 && dataUpdate.is_delete"
                        @click="deleteRow(dataUpdate.id)"
                    >
                        <i class="fa-solid fa-trash"></i>Xóa</a
                    >
                </div>
            </div>

            <div class="card-body py-3">
                <!--begin::Table container-->
                <div class="table-responsive table-scroll h-77vh text-nowrap">
                    <!--begin::Table-->
                    <table
                        class="table table-row-dashed table-bordered table-sm table-data"
                        cellspacing="0"
                        cellpadding="0"
                        border="0"
                        width="325"
                        id="tableid"
                    >
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fs-6 text-gray-400">
                                <!-- <th class="w-20px">
                  <div class="form-check form-check-sm form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                      data-kt-check-target=".widget-9-check" />
                  </div>
                </th> -->
                                <th class="w-50px max-w-50px">STT</th>
                                <th class="w-150px text-center">Ngày tạo</th>
                                <th class="min-w-125px max-w-150px">
                                    Mã khách hàng
                                </th>
                                <th class="min-w-125px max-w-100">
                                    Mã số thuế
                                </th>
                                <!-- <th class="w-250px">Tên khách hàng</th> -->
                                <th class="min-w-400px">Khách hàng</th>
                                <th
                                    class="min-w-125px"
                                    v-if="
                                        props.viewCustomerContact ||
                                        props.viewCustomerPhone
                                    "
                                >
                                    Người đại diện
                                </th>
                                <th class="min-w-125px">Trạng thái</th>
                                 <th class="min-w-125px">Người phụ trách</th>
                                <th class="min-w-350px">Ghi chú</th>
                                <th class="w-300px">Xem lịch sử chỉnh sửa</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="max-h-75 overflow-auto cursor-pointer">
                            <tr
                                v-for="(item, index) in customers"
                                :key="index"
                                :class="{ active: item.id == dataUpdate.id }"
                                @click="setDataUpdate(item)"
                            >
                                <!-- <td>
                  <div class="form-check form-check-sm form-check-custom form-check-solid p-0">
                    <input class="form-check-input widget-9-check" type="checkbox" value="1" />
                  </div>
                </td> -->
                                <td>
                                    {{
                                        (pagination.current_page - 1) *
                                            pagination.per_page +
                                        (index + 1)
                                    }}
                                </td>
                                <td>{{ item.created_at_view }}</td>
                                <td>{{ item.code }}</td>
                                <td>{{ item.tax_code }}</td>
                                <!-- <td class="max-w-250px break-text" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-trigger="hover" :title="item.name">
                                    {{ item.name }}
                                </td> -->
                                <td class="max-w-350px">
                                    <div class="row pt-1 pb-1">
                                        <span
                                            class="fs-5 pb-1 w-100 break-text mb-2"
                                        >
                                            <span
                                                class="badge text-warning text-bg-dark"
                                                v-if="item.customer_type == 1"
                                                >VIP</span
                                            >
                                            <span
                                                class="badge text-white text-bg-primary"
                                                v-if="item.customer_type == 0"
                                                >NOR</span
                                            >
                                            {{ item.name }}
                                        </span>
                                        <span
                                            class="fs-7 text-gray-900 w-100 break-text"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-trigger="hover"
                                            :title="item.full_address"
                                            ><i
                                                class="fa-solid fa-location-dot text-dark-emphasis ps-1"
                                            ></i>
                                            {{ item.full_address ?? "" }}</span
                                        >
                                    </div>
                                </td>
                                <td
                                    class="max-w-250px break-text"
                                    v-if="
                                        props.viewCustomerContact ||
                                        props.viewCustomerPhone
                                    "
                                >
                                    <div class="row pt-1 pb-1">
                                        <span
                                            class="fs-5 pb-1 w-100 break-text mb-1"
                                            v-if="item.representative_name"
                                            ><i
                                                class="fa-solid fa-user text-dark-emphasis"
                                            ></i>
                                            {{
                                                item.representative_name ?? ""
                                            }}</span
                                        >
                                        <span
                                            class="fs-7 pb-1 w-100 break-text mb-1"
                                            v-if="item.representative_phone"
                                            ><i
                                                class="fa-solid fa-phone text-dark-emphasis"
                                            ></i>
                                            {{
                                                item.representative_phone ?? ""
                                            }}</span
                                        >
                                        <span
                                            class="fs-7 text-gray-900 w-100 break-text"
                                            v-if="item.representative_email"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-trigger="hover"
                                            :title="item.full_address"
                                            ><i
                                                class="fa-solid fa-envelope text-dark-emphasis"
                                            ></i>
                                            {{
                                                item.representative_email ?? ""
                                            }}</span
                                        >
                                    </div>
                                </td>

                                <td class="">
                                    {{
                                        item.status.data
                                            ? item.status.data.name
                                            : ""
                                    }}
                                </td>
                                <td
                                    class="max-w-250px break-text"
                                >
                                    <div class="row pt-1 pb-1">
                                        <span
                                            class="fs-5 pb-1 w-100 break-text mb-1"
                                            :title="item.user?.data?.name + ' ('+item.user?.data?.username+') '"
                                            ><i
                                                class="fa-solid fa-user text-dark-emphasis"
                                            ></i>
                                            {{
                                                item.user?.data?.name + ' ('+item.user?.data?.username+') '
                                            }}</span
                                        >
                                        <span
                                            class="fs-7 pb-1 w-100 break-text mb-1"
                                            :title="item.user?.data?.phone"
                                            ><i
                                                class="fa-solid fa-phone text-dark-emphasis"
                                            ></i>
                                            {{
                                                 item.user?.data?.phone  ?? ""
                                            }}</span
                                        >
                                        <span
                                            class="fs-7 text-gray-900 w-100 break-text"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-trigger="hover"
                                            :title="item.user?.data?.email"
                                            ><i
                                                class="fa-solid fa-envelope text-dark-emphasis"
                                            ></i>
                                            {{
                                                item.user?.data?.email ?? ""
                                            }}</span
                                        >
                                    </div>
                                </td>
                                <!-- <td>{{ item.type }}</td> -->
                                <td
                                    class="text-break"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-trigger="hover"
                                    :title="item.note"
                                >
                                    {{ item.note }}
                                </td>
                                <td class="w-300px text-center">
                                    <a
                                        data-bs-target="#formCreateBank"
                                        data-bs-toggle="modal"
                                        href="#"
                                        @click="handleViewHistory(item)"
                                        class="btn btn-icon btn-edit btn-sm btn-customer-history"
                                    >

                                        <i
                                            class="fa-solid fa-clock-rotate-left fs-2 show-customer-history"
                                        >
                                        </i>
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="customers.lenth == 0">
                                <td class="text-center" colspan="12">
                                    Không có dữ liệu hiển thị
                                </td>
                            </tr>
                        </tbody>

                        <!-- <tbody v-else>
              <tr>
                <td>
                  Không có data
                </td>
              </tr>
            </tbody> -->
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <base-pagination
                    :pagination="pagination"
                    @change-page="changePage"
                />
                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
        <!-- {{ props.btnAddVip }} -->
        <!--end::Tables Widget 9-->
        <CreateOrUpdateModal
            :customer="dataUpdate"
            :statuses="props.statuses"
            :cities="props.cities"
            :districts="props.districts"
            :wards="props.wards"
            :banks="props.banks"
            @close-model="closeModal"
            :btn-customer-vip="btnCustomerVip"
            :users="users"
            v-if="showModel"
        />
    </div>
    <div
        class="modal fade"
        id="formCreateBank"
        style="position: fixed"
        data-bs-keyboard="false"
        data-bs-backdrop="static"
    >
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-left border-0 pb-0">
                    <!--begin::Close-->
                    <h4 class="modal-title">LỊCH SỬ CHỈNH SỬA KHÁCH HÀNG</h4>
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2"
                        data-bs-dismiss="modal"
                        @click="closeModalUser"
                        id="close"
                        aria-label="Close"
                    >
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body p-1 pt-0 mt-2">
                    <!--begin:Form-->
                    <div class="col-xxl-12 col-xl-12">
                        <!--begin::Tables Widget 9-->
                        <div class="card card-xxl-stretch">
                            <!--begin::Header-->

                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap ms-8"
                            >
                                <div
                                    class="d-flex align-items-center flex-wrap mb-3"
                                >
                                    <div
                                        class="d-flex align-items-center flex-wrap w-auto me-5"
                                    >
                                        <div class="w-auto">
                                            <label
                                                for="customerCode"
                                                class="col-form-label"
                                                >Mã khách hàng</label
                                            >
                                        </div>
                                        <div class="w-400px ms-3">
                                            <input
                                                disabled
                                                type="text"
                                                class="form-control mb-lg-0 p-2"
                                                id="customerCode"
                                                v-model="code_history"
                                            />
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center flex-wrap w-auto me-4"
                                    >
                                        <div class="w-auto">
                                            <label
                                                for="customerCode"
                                                class="col-form-label"
                                                >Tên khách hàng</label
                                            >
                                        </div>
                                        <div class="w-375px ms-5">
                                            <input
                                                disabled
                                                type="text"
                                                class="form-control mb-lg-0 p-2"
                                                id="customerCode"
                                                v-model="name_history"
                                            />
                                        </div>
                                    </div>
                                    <a
                                        href="#"
                                        class="btn btn-icon btn-sm btn-icon-bg-primary btn-color-light"
                                        @click="clickSearchHistory()"
                                    >
                                        <i
                                            class="fa-solid fa-magnifying-glass"
                                        ></i
                                    ></a>
                                </div>

                                <div
                                    class="d-flex align-items-center flex-wrap"
                                >
                                    <div
                                        class="d-flex align-items-center me-1 flex-wrap w-auto"
                                    >
                                        <div class="w-auto">
                                            <label
                                                class="col-form-label"
                                                for="checkCreate"
                                                >Thời gian sửa</label
                                            >
                                        </div>
                                        <div class="w-100px ms-6">
                                            <input
                                                type="time"
                                                class="form-control mb-lg-0 p-2"
                                                id="customerCode"
                                                :max="to_hour_history"
                                                v-model="from_hour_history"
                                            />
                                            <button style="position: absolute; top: 46px;left: 185px;border:none;font-size:12px;" @click="resetTimeFormHour()">X</button>
                                        </div>
                                        <div class="ms-1 me-1 w-125px ms-3">
                                            <input
                                                type="date"
                                                class="form-control mb-lg-0 p-2"
                                                id="fromDate"
                                                placeholder=""
                                                :max="to_date_history"
                                                v-model="from_date_history"
                                            />
                                        </div>
                                        <div class="w-100px ms-4">
                                            <input
                                                type="time"
                                                class="form-control mb-lg-0 p-2"
                                                id="customerCode"
                                                v-model="to_hour_history"
                                                :min="from_hour_history"
                                            />
                                            <button style="position: absolute; top: 46px;left: 436px;border:none;font-size:12px;" @click="resetTimeToHour()">X</button>
                                        </div>
                                        <div class="ms-1 w-125px ms-3">
                                            <input
                                                type="date"
                                                class="form-control mb-lg-0 p-2"
                                                id="toDate"
                                                v-model="to_date_history"
                                                :min="from_date_history"
                                            />
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center flex-wrap w-auto ms-3 me-3"
                                    >
                                        <div class="w-auto">
                                            <label
                                                for="customerCode"
                                                class="col-form-label me-3"
                                                >Người chỉnh sửa</label
                                            >
                                        </div>
                                        <div class="w-125px cus-edi-set">
                                            <SelectSearch
                                                :list-data="getUserHistories"
                                                v-model="editor"
                                                placeholder="Tất cả"
                                                key-value="id"
                                                key-display="name"
                                            />
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center flex-wrap w-auto me-3"
                                    >
                                        <div class="w-auto">
                                            <label
                                                for="customerCode"
                                                class="col-form-label me-3"
                                                >Thông tin</label
                                            >
                                        </div>
                                        <div
                                            class="selected break-text w-125px cus-inf-set"
                                        >
                                            <SelectSearch
                                                :list-data="infoList"
                                                v-model="info"
                                                placeholder="Tất cả"
                                                key-value="key"
                                                key-display="value"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="d-flex align-items-center flex-wrap"
                                >
                                    <div
                                        class="d-flex align-items-center me-1 flex-wrap w-auto"
                                    >
                                        <div class="w-auto invisible">
                                            <label
                                                class="col-form-label"
                                                for="checkCreate"
                                                >Thời gian sửa</label
                                            >
                                        </div>
                                        <div class="w-100px ms-6 invisible">
                                            <input
                                                type="time"
                                                class="form-control mb-lg-0 p-2"
                                                id="customerCode"
                                                :max="to_hour_history"
                                                v-model="from_hour_history"
                                            />
                                        </div>
                                        <div class="ms-1 me-1 w-125px ms-3">
                                            <div  v-if="errorsHistory['from_date_history']"  :title="errorsHistory['from_date_history']? errorsHistory['from_date_history'][0]: ''"
                                            style="width:125px;" class="text-danger pt-2">
                                                {{  helperFunc.shortString(errorsHistory['from_date_history'][0], 17) }}
                                            </div>
                                        </div>
                                        <div class="w-100px ms-4 invisible">
                                            <input
                                                type="time"
                                                class="form-control mb-lg-0 p-2"
                                                id="customerCode"
                                                v-model="to_hour_history"
                                                :min="from_hour_history"
                                            />
                                        </div>
                                        <div class="ms-1 w-125px ms-3">
                                            <div v-if="errorsHistory['to_date_history']"  :title="errorsHistory['to_date_history']? errorsHistory['to_date_history'][0]: ''"
                                            style="width:125px;" class="text-danger pt-2">
                                                {{  helperFunc.shortString(errorsHistory['to_date_history'][0], 17) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body py-3">
                                <!--begin::Table container-->
                                <div
                                    class="table-responsive table-scroll h-60vh text-nowrap"
                                >
                                    <!--begin::Table-->
                                    <table
                                        class="table table-row-dashed table-bordered table-sm table-data"
                                        cellspacing="0"
                                        cellpadding="0"
                                        border="0"
                                        width="325"
                                        id="tableid"
                                    >
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr class="fs-6 text-gray-400">
                                                <th class="w-50px max-w-50px">
                                                    STT
                                                </th>
                                                <th class="w-150px text-center">
                                                    Thời gian chỉnh sửa
                                                </th>
                                                <th class="w-150px">
                                                    Người chỉnh sửa
                                                </th>
                                                <th class="w-150px">
                                                    Thông tin
                                                </th>
                                                <!-- <th class="w-250px">Tên khách hàng</th> -->
                                                <th class="w-200px">
                                                    Nội dung trước khi chỉnh sửa
                                                </th>
                                                <th class="w-200px">
                                                    Nội dung sau khi chỉnh sửa
                                                </th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody
                                            class="max-h-75 overflow-auto cursor-pointer"
                                        >
                                            <tr
                                                v-for="(
                                                    item, index
                                                ) in customerHistories"
                                                :key="index"
                                            >
                                                <td>
                                                    {{ index + 1 }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-dark text-hover-primary d-block text-content w-150px break-text pb-1 mt-1"
                                                    >
                                                        {{
                                                            moment(
                                                                new Date(
                                                                    item.properties?.attributes?.updated_at
                                                                )
                                                            ).format(
                                                                "hh:mm A DD/MM/YYYY"
                                                            )
                                                        }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-dark text-hover-primary d-block text-content w-150px break-text pb-1 mt-1"
                                                        :title="
                                                            item.user.data.name
                                                        "
                                                        >{{
                                                            item.user.data.name
                                                        }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div
                                                        v-for="(
                                                            val_info, key_info
                                                        ) in item.properties
                                                            .attributes"
                                                        :key="key_info"
                                                    >
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'code' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Mã khách hàng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'created_at' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Ngày khai báo
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'user_id' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Người phụ trách
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'name' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Tên khách hàng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'tax_code' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Mã số thuế
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'address' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Địa chỉ
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'city_id' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Thành phố/Tỉnh
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'district_id' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Quận/huyện
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'ward_id' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Xã/Phường
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="getSystemPermisison.view_representative_name &&
                                                                key_info ==
                                                                    'representative_name' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Tên người đại diện
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="getSystemPermisison.view_representative_email_and_phone &&
                                                                key_info ==
                                                                    'representative_phone' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Số điện thoại người
                                                            đại diện
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="getSystemPermisison.view_representative_email_and_phone &&
                                                                key_info ==
                                                                    'representative_email' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Email người đại diện
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'status_id' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Trạng thái
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'bank_number' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Số tài khoản ngân
                                                            hàng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'bank_username' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Tên tài khoản ngân
                                                            hàng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'bank_id' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Ngân hàng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'note' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Ghi chú khách hàng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'customer_type' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Phân loại khách hàng
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div
                                                        v-for="(
                                                            val_old, key_old
                                                        ) in item.properties
                                                            .old"
                                                        :key="key_old"
                                                    >
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                    'code' ||
                                                                key_old ==
                                                                    'name'
                                                            "
                                                        >
                                                            {{ val_old }}
                                                        </span>

                                                           <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="getSystemPermisison.view_representative_name &&
                                                                key_old ==
                                                                    'representative_name'
                                                            "
                                                        >
                                                            {{ val_old }}
                                                        </span>

                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'note'
                                                            "
                                                        >
                                                            {{
                                                                val_old
                                                                    ? val_old
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'created_at'
                                                            "
                                                        >
                                                            {{
                                                                val_old
                                                                    ?
                                                                    moment(
                                                                new Date(
                                                                    val_old
                                                                )
                                                            ).format(
                                                                'DD/MM/YYYY'
                                                            )
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'bank_username'
                                                            "
                                                        >
                                                            {{
                                                                val_old
                                                                    ? val_old
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'bank_number'
                                                            "
                                                        >
                                                            {{
                                                                val_old
                                                                    ? val_old
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="getSystemPermisison.view_representative_email_and_phone &&
                                                                key_old ==
                                                                'representative_email'
                                                            "
                                                        >
                                                            {{
                                                                val_old
                                                                    ? val_old
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="getSystemPermisison.view_representative_email_and_phone &&
                                                                key_old ==
                                                                'representative_phone'
                                                            "
                                                        >
                                                            {{
                                                                val_old
                                                                    ? val_old
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'address'
                                                            "
                                                        >
                                                            {{
                                                                val_old
                                                                    ? val_old
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'tax_code'
                                                            "
                                                        >
                                                            {{
                                                                val_old
                                                                    ? val_old
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'city_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldCity[0]
                                                                    ? item
                                                                          .jsonOldCity[0]
                                                                          .name
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'district_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldDistrict[0]
                                                                    ? item
                                                                          .jsonOldDistrict[0]
                                                                          .name
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'ward_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldWard[0]
                                                                    ? item
                                                                          .jsonOldWard[0]
                                                                          .name
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'bank_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldBank[0]
                                                                    ? item
                                                                        .jsonOldBank[0]
                                                                        .name
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'user_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldUserChargeCustomer[0]
                                                                    ? item
                                                                        .jsonOldUserChargeCustomer[0].name + ' ( ' + item.jsonOldUserChargeCustomer[0].username + ' )'
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'status_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldSystemStatus[0]
                                                                    ?.name
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'customer_type'
                                                            "
                                                        >
                                                            {{
                                                                val_old === 1
                                                                    ? "Khách Vip"
                                                                    : "Khách thường"
                                                            }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div
                                                        v-for="(
                                                            val_attr, key_attr
                                                        ) in item.properties
                                                            .attributes"
                                                        :key="key_attr"
                                                    >
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                    'name' ||
                                                                key_attr ==
                                                                    'code'
                                                            "
                                                        >
                                                            {{ val_attr }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="getSystemPermisison.view_representative_name &&
                                                                key_attr ==
                                                                    'representative_name'
                                                            "
                                                        >
                                                            {{ val_attr }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'bank_username'
                                                            "
                                                        >
                                                            {{
                                                                val_attr
                                                                    ? val_attr
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'created_at'
                                                            "
                                                        >
                                                            {{
                                                                val_attr
                                                                    ?
                                                                    moment(
                                                                new Date(
                                                                    val_attr
                                                                )
                                                            ).format(
                                                                'DD/MM/YYYY'
                                                            )
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'bank_number'
                                                            "
                                                        >
                                                            {{
                                                                val_attr
                                                                    ? val_attr
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="getSystemPermisison.view_representative_email_and_phone &&
                                                                key_attr ==
                                                                'representative_email'
                                                            "
                                                        >
                                                            {{
                                                                val_attr
                                                                    ? val_attr
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="getSystemPermisison.view_representative_email_and_phone &&
                                                                key_attr ==
                                                                'representative_phone'
                                                            "
                                                        >
                                                            {{
                                                                val_attr
                                                                    ? val_attr
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'address'
                                                            "
                                                        >
                                                            {{
                                                                val_attr
                                                                    ? val_attr
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'tax_code'
                                                            "
                                                        >
                                                            {{
                                                                val_attr
                                                                    ? val_attr
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'note'
                                                            "
                                                        >
                                                            {{
                                                                val_attr
                                                                    ? val_attr
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'city_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonNewCity[0]
                                                                    ? item
                                                                          .jsonNewCity[0]
                                                                          .name
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'user_id'
                                                            "
                                                        >
                                                        {{
                                                                item
                                                                    .jsonNewUserChargeCustomer[0]
                                                                    ? item
                                                                        .jsonNewUserChargeCustomer[0].name + ' ( ' + item.jsonNewUserChargeCustomer[0].username + ' )'
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'district_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonNewDistrict[0]
                                                                    ? item
                                                                          .jsonNewDistrict[0]
                                                                          .name
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'ward_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonNewWard[0]
                                                                    ? item
                                                                          .jsonNewWard[0]
                                                                          .name
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'bank_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonNewBank[0]
                                                                    ? item
                                                                          .jsonNewBank[0]
                                                                          .name
                                                                    : '---'
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'status_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonNewSystemStatus[0]
                                                                    ?.name
                                                            }}
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'customer_type'
                                                            "
                                                        >
                                                            {{
                                                                val_attr === 1
                                                                    ? "Khách Vip"
                                                                    : "Khách thường"
                                                            }}
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr v-if="customers.lenth == 0">
                                                <td
                                                    class="text-center"
                                                    colspan="12"
                                                >
                                                    Không có dữ liệu hiển thị
                                                </td>
                                            </tr>
                                        </tbody>

                                        <!-- <tbody v-else>
              <tr>
                <td>
                  Không có data
                </td>
              </tr>
            </tbody> -->
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <base-pagination
                                    :pagination="paginationHistory"
                                    @change-page="changePageHistoryCustomer"
                                />
                                <!--end::Table container-->
                            </div>
                            <!--begin::Body-->
                        </div>
                        <!-- {{ props.btnAddVip }} -->
                        <!--end::Tables Widget 9-->
                    </div>

                    <!--end:Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
</template>
<script setup>
import CreateOrUpdateModal from "./CreateOrUpdateModal.vue";

import {
    defineProps,
    ref,
    toRef,
    computed,
    watch,
    onBeforeMount,
    reactive,
} from "vue";
import { useCustomerStore } from "../../stores/customer";
import { destroy } from "../../helper/axiosConfig";
import moment from "moment";
import { useToast } from "../../helper/toastMessage";
import { sweetAlertMessage } from "../../helper/sweetAlert";
import SelectSearch from "../input/SelectSearch.vue";
import { helperFunc } from '../../helper/heplerFunction'

const store = useCustomerStore();
const props = defineProps({
    cities: {
        type: Array,
        default: [],
    },
    districts: {
        type: Array,
        default: [],
    },
    wards: {
        type: Array,
        default: [],
    },
    statuses: {
        Array,
        default: [],
    },
    banks: {
        type: Array,
        default: [],
    },
    users: {
        type: Array,
        default: []
    },
    btnAdd: {
        type: Boolean,
        default: false,
    },
    btnCustomerVip: {
        type: Boolean,
        default: false,
    },
    viewCustomerContact: {
        type: Boolean,
        default: false,
    },
    viewCustomerPhone: {
        type: Boolean,
        default: false,
    },
});

const infoList = ref([
    {
        key: "code",
        value: "Mã khách hàng",
    },
    {
        key: "name",
        value: "Tên khách hàng",
    },
    {
        key: "tax_code",
        value: "Mã số thuế",
    },
    {
        key: "city_id",
        value: "Thành phố/Tỉnh",
    },
    {
        key: "district_id",
        value: "Quận/Huyện",
    },
    {
        key: "ward_id",
        value: "Xã/Phường",
    },
    {
        key: "representative_name",
        value: "Số điện thoại người đại diện",
    },
    {
        key: "representative_email",
        value: "Email người đại diện",
    },
    {
        key: "status_id",
        value: "Trạng thái",
    },
    {
        key: "bank_number",
        value: "Số tài khoản ngân hàng",
    },
    {
        key: "bank_username",
        value: "Tên tài khoản ngân hàng",
    },
    {
        key: "bank_id",
        value: "Ngân hàng",
    },
    {
        key: "note",
        value: "Ghi chú khách hàng",
    },
    {
        key: "customer_type",
        value: "Phân loại khách hàng",
    },
    {
        key: "user_id",
        value: "Người phụ trách",
    },
    {
        key: "created_at",
        value: "Ngày khai báo",
    },

]);

const search = ref("");
const tax_code = ref("");
const from_date = ref(null);
const to_date = ref(moment().format("YYYY-MM-DD"));
const code_history = ref("");
const name_history = ref("");
const editor = ref("");
const from_date_history = ref(moment().format("YYYY-MM-DD"));
const to_date_history = ref(moment().format("YYYY-MM-DD"));
const from_hour_history = ref(moment().format("HH:mm"));
const to_hour_history = ref(moment().format("HH:mm"));
const info = ref("");

const searchData = reactive({
    search: "",
    tax_code: "",
    from_date: null,
    to_date: moment().format("YYYY-MM-DD"),
    code_history: "",
    name_history: "",
    editor: "",
    from_date_history: "",
    to_date_history: "",
    from_hour_history: "",
    to_hour_history: "",
    info: "",
});

const clickSearch = () => {
    searchData.search = search.value;
    searchData.tax_code = tax_code.value;
    searchData.from_date = from_date.value;
    searchData.to_date = to_date.value;
    getData(1);
};

const clickSearchHistory = () => {
    searchData.code_history = code_history.value;
    searchData.name_history = name_history.value;
    searchData.editor = editor.value;
    searchData.from_date_history = from_date_history.value;
    searchData.to_date_history = to_date_history.value;
    searchData.from_hour_history = from_hour_history.value;
    searchData.to_hour_history = to_hour_history.value;
    searchData.info = info.value;
    getCustomerHistory(searchData);
};

const dataUpdate = ref({
    id: 0,
    code: "",
    name: "",
    tax_code: "",
    address: "",
    city_id: null,
    district_id: null,
    ward_id: null,
    representative_name: "",
    representative_phone: "",
    representative_email: "",
    status_id: "",
    bank_username: "",
    bank_number: "",
    bank_id: null,
    note: "",
    customer_type: 1,
    created_at: moment().format("YYYY-MM-DD"),
});

const resetTimeFormHour = () => {
    from_hour_history.value = null;
}
const resetTimeToHour = () => {
    to_hour_history.value = null;
}
const currentIndex = ref(-1);

let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};
let getMetaPaginate = ref({});
const customerHistories = ref([]);
const errorsHistory = ref([]);
const getSystemPermisison = ref({});
const getCustomerHistory = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/customers/show",
        method: "GET",
        params: {
            ...params,
            per_page: selectTotalRecord.value,
            page: paginationHistory.value.current_page,
        },
    })
        .then((res) => {
            const { data, meta, system_permission } = res.data;
            customerHistories.value = data;
            getSystemPermisison.value = system_permission;
            getMetaPaginate.value = meta;
        })
        .catch((error) => {
            console.log(error);
            errorsHistory.value = error?.response?.data?.errors;
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};
const getUserHistories = ref([]);
const getOthers = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/customers/getOther",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data } = res;
            getUserHistories.value = data.getUsers;
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};

const handleViewHistory = (item) => {
    code_history.value = item.code;
    name_history.value = item.name;
    from_date_history.value = null;
    to_date_history.value = null;
    from_hour_history.value = null;
    to_hour_history.value = null;
    clickSearchHistory();

};

const paginationHistory = computed(() => {
    return getMetaPaginate.value?.pagination
        ? getMetaPaginate.value.pagination
        : { current_page: 1, total_pages: 1, per_page: 30 };
});

const changePageHistoryCustomer = (newDataPagination) => {
    const requestPaginate = {
        page: newDataPagination.current_page,
        per_page: newDataPagination.per_page,
    };
    selectTotalRecord.value = newDataPagination.per_page;
    paginationHistory.value.current_page = newDataPagination.current_page;
    getCustomerHistory(searchData);
};

const customers = computed(() => {
    return store.$state.customers.data;
});

const pagination = computed(() => {
    return store.$state.customers.meta
        ? store.$state.customers.meta.pagination
        : { current_page: 1, total_pages: 1, per_page: 30 };
});

const showModel = computed(() => {
    return store.$state.showModel ?? false;
});

watch(
    () => searchData.to_date,
    (newValue, oldValue) => {}
);

const changePage = (newData) => {
    getData(newData.current_page, newData.per_page);
};

const setDataUpdate = (data) => {
    dataUpdate.value = data;
};

const clickCreate = () => {
    dataUpdate.value = {
        id: 0,
        code: "",
        name: "",
        tax_code: "",
        address: "",
        city_id: null,
        district_id: null,
        ward_id: null,
        representative_name: "",
        representative_phone: "",
        representative_email: "",
        status_id: "",
        bank_username: "",
        bank_number: "",
        bank_id: null,
        note: "",
        customer_type: 1,
        created_at: moment().format("YYYY-MM-DD"),
    };
    store.toggleShowModal(true);
};

const getData = (
    page = pagination.value.current_page,
    per_page = pagination.value.per_page,
    search = searchData
) => {
    store.getData(page, per_page, search);
    console.log(searchData);
};

const deleteRow = (id) => {
    sweetAlertMessage
        .messageWarning("Bạn có chắc chắn muốn xóa không?")
        .then((res) => {
            console.log(res);
            if (res.isConfirmed == true) {
                destroy("/customers/api/" + id)
                    .then((res) => {
                        console.log(res.data);
                        store.removeData(res.data.data);
                        KTApp.hidePageLoading();
                        useToast.successToast("Xóa bản ghi thành công!");
                    })
                    .catch((err) => {
                        KTApp.hidePageLoading();
                        console.log(err);
                        getData();
                    });
            }
        })
        .catch((err) => {});
};

const closeModal = (id) => {
    console.log(id);
    if (id != 0) {
        getData();
    }
    clickCreate();
    store.toggleShowModal(false);
};

onBeforeMount(() => {
    getData();
    getCustomerHistory({
        // code_history: code_history.value,
        // from_date_history: from_date_history.value,
        // to_date_history: to_date_history.value,
    });
    getOthers();
});
</script>
<style lang="scss" scoped>
.right-5 {
    right: 50px;
}
</style>
<style>
.btn-customer-history .show-customer-history {
    color: black;
}
.cus-edi-set .select-box .options-container {
    width: 123px;
}
.cus-edi-set .options-container {
    top: 244px !important;
}
.cus-inf-set .select-box .options-container {
    width: 123px;
}
.cus-inf-set .options-container {
    top: 244px !important;
}
</style>
