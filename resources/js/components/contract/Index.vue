<template>
    <div class="col-xxl-12 col-xl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch pt-5">
            <!--begin::Header-->

            <div
                class="d-flex align-items-center justify-content-between flex-wrap ms-5"
            >
                <div class="d-flex align-items-center col-xl-12">
                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-75px">
                            <label for="customerCode" class="col-form-label"
                                >Số hợp đồng</label
                            ><base-validation />
                        </div>
                        <div class="w-100px ms-1">
                            <input
                                type="text"
                                class="form-control mb-lg-0 p-2"
                                id="customerCode"
                                placeholder="000xxx000"
                                v-model="code"
                            /><base-validation />
                            <!-- <SelectSearch class="w-100px" :list-data="props.customers" key-value="id" key-display="name"/> -->
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-65px">
                            <label for="customerCode" class="col-form-label"
                                >Khách hàng</label
                            ><base-validation />
                        </div>
                        <div class="w-125px">
                            <InputSearch
                                :list-data="customers"
                                v-model="customer_id"
                                key-value="id"
                                :loading="customerLoading"
                                placeholder="Tên khách hàng"
                                :key-display="['name']"
                                key-show="name"
                                @search-data="getListCustomer"
                            />
                            <base-validation />
                        </div>
                    </div>
                    <div class="d-flex align-items-center me-5 w-auto">
                        <div class="w-70px me-1">
                            <label class="col-form-label" for="checkCreate"
                                >Ngày ký</label
                            ><base-validation />
                        </div>
                        <div class="w-auto">
                            <input
                                type="checkbox"
                                class="form-check-sm mb-lg-0 p-2"
                                placeholder=""
                                v-model="is_signing"
                            /><base-validation />
                        </div>
                        <div class="ms-1 me-1 w-125px">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                :disabled="!is_signing"
                                :max="signing_to"
                                placeholder=""
                                v-model="signing_from"
                            />
                            <base-validation :message="errors.signing_from" />
                        </div>
                        <div class="ms-1 w-125px">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                :disabled="!is_signing"
                                :min="signing_from"
                                v-model="signing_to"
                            />
                            <base-validation :message="errors.signing_from" />
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-70px">
                            <label for="customerCode" class="col-form-label"
                                >Trạng thái</label
                            ><base-validation />
                        </div>
                        <div class="w-100px">
                            <select
                                class="form-select break-text"
                                v-model="status_id"
                            >
                                <option :value="null">--Tất cả--</option>
                                <option
                                    v-for="(item, index) in props.statuses"
                                    :key="index"
                                    :value="item.id"
                                >
                                    {{ item.name }}
                                </option></select
                            ><base-validation />
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-85px me-1">
                            <label for="customerCode" class="col-form-label"
                                >Người phụ trách</label
                            ><base-validation />
                        </div>
                        <div class="w-125px">
                            <InputSearch
                                :list-data="users"
                                v-model="user_charge_id"
                                key-value="id"
                                :loading="userLoading"
                                placeholder="Tên người phụ trách"
                                :key-display="['name']"
                                key-show="name"
                                @search-data="getListUser"
                            />
                            <!-- <select class="form-select break-text" v-model="user_charge_id">
                                <option :value="null">--Tất cả--</option>
                                <option v-for="(item, index) in props.users" :key="index" :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select> -->
                            <base-validation />
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center col-xl-12">
                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-75px">
                            <label for="customerCode" class="col-form-label"
                                >Loại hợp đồng</label
                            ><base-validation />
                        </div>
                        <div class="w-100px ms-1">
                            <select
                                class="form-select break-text"
                                v-model="contract_type_id"
                            >
                                <option :value="null">--Tất cả--</option>
                                <option
                                    v-for="(item, index) in props.types"
                                    :key="index"
                                    :value="item.id"
                                >
                                    {{ item.name }}
                                </option></select
                            ><base-validation />
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-65px">
                            <label for="customerCode" class="col-form-label"
                                >Dự án</label
                            ><base-validation />
                        </div>
                        <div class="w-125px">
                            <!-- <select class="form-select break-text" v-model="searchData.project_id">
                                <option :value="null">--Tất cả--</option>
                                <option v-for="(item, index) in props.projects" :key="index" :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select> -->
                            <InputSearch
                                :list-data="projects"
                                v-model="project_id"
                                key-value="id"
                                :loading="projectLoading"
                                placeholder="Tên dự án"
                                :key-display="['name']"
                                key-show="name"
                                @search-data="getListProject"
                            />
                            <base-validation />
                        </div>
                    </div>

                    <div class="d-flex align-items-center me-5 w-auto">
                        <div class="w-70px me-1">
                            <label class="col-form-label" for="checkCreate"
                                >Ngày hết hạn</label
                            ><base-validation />
                        </div>
                        <div class="w-auto">
                            <input
                                type="checkbox"
                                class="form-check-sm mb-lg-0 p-2"
                                placeholder=""
                                v-model="is_expiration"
                            /><base-validation />
                        </div>
                        <div class="ms-1 me-1 w-125px">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                :disabled="!is_expiration"
                                :max="expiration_to"
                                v-model="expiration_from"
                            /><base-validation
                                :message="errors.expiration_from"
                            />
                        </div>
                        <div class="ms-1 w-125px">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                :disabled="!is_expiration"
                                :min="expiration_from"
                                v-model="expiration_to"
                            /><base-validation
                                :message="errors.expiration_to"
                            />
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-70px">
                            <label for="customerCode" class="col-form-label"
                                >Thời gian BH</label
                            ><base-validation />
                        </div>
                        <div class="w-100px">
                            <input
                                type="text"
                                class="form-control mb-lg-0 p-2"
                                placeholder="3 - 36"
                                v-model="warranty_time"
                                min="3"
                                max="36"
                            /><base-validation
                                :message="errors.warranty_time"
                            />
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-auto me-1">
                        <div class="w-85px">
                            <label for="customerCode" class="col-form-label"
                                >Số lần TT</label
                            ><base-validation />
                        </div>
                        <div class="w-125px ms-1">
                            <select
                                class="form-select"
                                v-model="number_payment"
                            >
                                <option :value="null">--Tất cả--</option>
                                <option
                                    v-for="index in 10"
                                    :key="index"
                                    :value="index"
                                >
                                    {{ index }}
                                </option></select
                            ><base-validation />
                        </div>
                    </div>
                </div>
                <div class="align-items-center ms-3">
                    <a
                        href="#"
                        class="btn btn-function me-2"
                        @click="clickSearch()"
                    >
                        <i class="fa-solid fa-magnifying-glass fs-2"></i>Tìm
                        kiếm</a
                    >
                    <a
                        :class="{ 'check-permission': !permissionadd }"
                        href="#"
                        class="btn btn-function me-2"
                        @click="clickCreate()"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm</a
                    >
                    <span
                        :title="
                            !dataUpdate?.canPermissionEditContract == true
                                ? 'Bạn không có quyền sửa'
                                : null
                        "
                    >
                        <a
                            href="#"
                            class="btn btn-function me-2"
                            :class="{
                                disabled: dataUpdate?.id == 0,
                                'check-permission d-none':
                                    !dataUpdate?.canPermissionEditContract,
                            }"
                            @click="
                                () => {
                                    contractStore.toggleShowModal(true);
                                    setAction('update');
                                }
                            "
                        >
                            <i class="fa-regular fa-pen-to-square"></i>Sửa</a
                        >
                    </span>
                    <span
                        :title="
                            !dataUpdate?.canPermissionDeleteContract == true
                                ? 'Bạn không có quyền sửa'
                                : null
                        "
                    >
                        <a
                            href="#"
                            class="btn btn-function"
                            :class="{
                                disabled:
                                    dataUpdate?.id == 0 || !dataUpdate?.is_delete,
                                'check-permission':
                                    !dataUpdate?.canPermissionDeleteContract,
                            }"
                            @click="deleteRow(dataUpdate?.id)"
                        >
                            <i class="fa-solid fa-trash"></i>Xóa</a
                        >
                    </span>
                </div>
            </div>

            <div class="card-body py-3">
                <!--begin::Table container-->
                <div class="table-responsive table-scroll h-65vh text-nowrap">
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
                                <th class="w-100px max-w-125px text-center">
                                    Số hợp đồng
                                </th>
                                <th class="min-w-100px max-w-125px">Ngày kí</th>
                                <th class="min-w-125px max-w-250px">
                                    Loại hợp đồng
                                </th>
                                <!-- <th class="w-250px">Tên khách hàng</th> -->
                                <th class="min-w-200px max-w-350px">
                                    Khách hàng
                                </th>
                                <th class="min-w-100px max-w-125px">
                                    Ngày hết hạn
                                </th>
                                <th class="min-w-125px max-w-200px">
                                    Trạng thái
                                </th>
                                <th
                                    class="max-w-75px text-wrap"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-trigger="hover"
                                    title="Thời gian bảo hành (Tháng)"
                                >
                                    TG BH <span class="fs-7">(Tháng)</span>
                                </th>
                                <th
                                    class="max-w-75px text-wrap"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-trigger="hover"
                                    title="Số lần thanh toán (Lần)"
                                >
                                    SLTT <span class="fs-7">(Lần)</span>
                                </th>
                                <th class="min-w-125px max-w-170px">
                                    Người phụ trách
                                </th>
                                <th class="w-auto">Chi tiết</th>
                                <th class="w-300px">Lịch sử chỉnh sửa</th>
                                <!-- <th class="min-w-125px">Phân loại</th> -->
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody
                            v-for="(contract, key) in contracts"
                            :key="key"
                            class="max-h-75 overflow-auto"
                        >
                            <tr>
                                <td
                                    class="h-40px fw-medium pointer-events-none"
                                    style="
                                        background-color: rgb(243 237 179);
                                        font-size: 14px;
                                        padding-left: 3rem;
                                    "
                                    colspan="12"
                                >
                                    {{ key }}
                                </td>
                            </tr>
                            <tr
                                class="cursor-pointer "
                                v-for="(item, index) in contract"
                                :key="index"
                                :class="{ active: item.id == dataUpdate.id }"

                                @click="setDataUpdate(item)"
                            >
                                <!-- <td>
                  <div class="form-check form-check-sm form-check-custom form-check-solid p-0">
                    <input class="form-check-input widget-9-check" type="checkbox" value="1" />
                  </div>
                </td> -->
                                <td class="text-center">
                                    {{
                                        pagination.per_page *
                                            (pagination.current_page - 1) +
                                        (item.stt + 1)
                                    }}
                                </td>
                                <td>{{ item.code }}</td>
                                <td>{{ item.signing_date }}</td>
                                <td>
                                    {{ item.contract_type?.data?.name ?? "" }}
                                </td>
                                <!-- <td class="max-w-250px break-text" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-trigger="hover" :title="item.name">
                                    {{ item.name }}
                                </td> -->
                                <td class="break-text">
                                    {{ item.project?.data?.customer?.data?.name ?? "" }}
                                </td>
                                <td>{{ item.expiration_date }}</td>
                                <td>{{ item.status?.data?.name ?? "" }}</td>
                                <td class="text-end">
                                    {{ item.warranty_time ?? "" }}
                                </td>
                                <td class="text-end">
                                    {{ item.number_payment ?? "" }}
                                </td>
                                <td>
                                    {{
                                        item.user_charge?.data
                                            ? item.user_charge?.data?.name
                                            : ""
                                    }}
                                </td>
                                <td class="w-50px text-center">
                                    <a
                                        href="#"
                                        class="btn btn-icon btn-edit btn-color-primary btn-sm"
                                        @click="
                                            () => {
                                                contractStore.toggleShowModal(
                                                    true
                                                );
                                                modalAction = 'view';
                                            }
                                        "
                                        ><i
                                            class="fa-solid fa-circle-info fs-2"
                                        ></i
                                    ></a>
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
                        </tbody>
                        <tbody v-if="Object.keys(contracts).length == 0">
                            <tr>
                                <td class="text-center" colspan="12">
                                    Không có dữ liệu hiển thị
                                </td>
                            </tr>
                        </tbody>
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
        <!--end::Tables Widget 9-->
        <CreateOrUpdateModal
            :contract="dataUpdate"
            :statuses="props.statuses"
            :types="props.types"
            @close-model="closeModal"
            :action="modalAction"
            @update-data="setAction"
            v-if="showModal"
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
                    <h4 class="modal-title">LỊCH SỬ CHỈNH SỬA HỢP ĐỒNG</h4>
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
                                class="d-flex align-items-center justify-content-between flex-wrap ms-10"
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
                                                >Số hợp đồng</label
                                            >
                                        </div>
                                        <div class="w-400px ms-7">
                                            <input
                                                style="
                                                    border-radius: 5px;
                                                    min-height: 26px !important;
                                                    height: 26px !important;
                                                "
                                                disabled
                                                type="text"
                                                class="form-control mb-lg-0 p-2"
                                                id="customerCode"
                                                v-model="contractHistoryId"
                                            />
                                            <!-- <SelectSearch
                                                :list-data="getContractHistories"
                                                v-model="contractHistoryId"
                                                placeholder="Tất cả"
                                                key-value="id"
                                                key-display="name"
                                            /> -->
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center flex-wrap w-auto me-4"
                                    >
                                        <div class="w-auto">
                                            <label
                                                for="customerCode"
                                                class="col-form-label"
                                                >Dự án</label
                                            >
                                        </div>
                                        <div
                                            class="w-375px ms-5 con-his-pro-set"
                                        >
                                            <SelectSearch
                                                :list-data="getProjectHistories"
                                                v-model="project_history"
                                                placeholder="Tất cả"
                                                key-value="id"
                                                key-display="name"
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
                                        <div class="w-75px ms-6">
                                            <input
                                            style="
                                                    border-radius: 5px;
                                                    min-height: 26px !important;
                                                    height: 26px !important;
                                                "
                                                type="time"
                                                class="form-control mb-lg-0 p-2"
                                                id="customerCode"
                                                :max="to_hour_history"
                                                v-model="from_hour_history"
                                            />
                                            <button style="position: absolute; top: 47px;left: 164px;border:none;font-size:12px;" @click="resetTimeFormHour()">X</button>
                                        </div>
                                        <div class="ms-1 me-1 w-125px ms-3">
                                            <input
                                            style="
                                                    border-radius: 5px;
                                                    min-height: 26px !important;
                                                    height: 26px !important;
                                                "
                                                type="date"
                                                class="form-control mb-lg-0 p-2"
                                                id="fromDate"
                                                placeholder=""
                                                :max="to_date_history"
                                                v-model="from_date_history"
                                            />
                                            <button style="position: absolute; top: 47px;left: 390px;border:none;font-size:12px;" @click="resetTimeToHour()">X</button>
                                        </div>

                                        <div class="w-75px ms-4">
                                            <input
                                            style="
                                                    border-radius: 5px;
                                                    min-height: 26px !important;
                                                    height: 26px !important;
                                                "
                                                type="time"
                                                class="form-control mb-lg-0 p-2"
                                                id="customerCode"
                                                v-model="to_hour_history"
                                                :min="from_hour_history"
                                            />
                                        </div>
                                        <div class="ms-1 w-125px ms-3">
                                            <input
                                            style="
                                                    border-radius: 5px;
                                                    min-height: 26px !important;
                                                    height: 26px !important;
                                                "
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
                                        <div class="w-150px con-his-edi-set">
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
                                            class="selected break-text w-200px con-his-inf-set"
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
                                        <div class="w-75px ms-6 invisible">
                                            <input
                                                type="time"
                                                class="form-control mb-lg-0 p-2"
                                                id="customerCode"
                                                :max="to_hour_history"
                                                v-model="from_hour_history"
                                            />
                                        </div>
                                        <div class="ms-1 me-1 w-125px ms-3">
                                            <div
                                                v-if="
                                                    errorsHistory[
                                                        'from_date_history'
                                                    ]
                                                "
                                                :title="
                                                    errorsHistory[
                                                        'from_date_history'
                                                    ]
                                                        ? errorsHistory[
                                                              'from_date_history'
                                                          ][0]
                                                        : ''
                                                "
                                                style="width: 125px"
                                                class="text-danger pt-2"
                                            >
                                                {{
                                                    helperFunc.shortString(
                                                        errorsHistory[
                                                            "from_date_history"
                                                        ][0],
                                                        17
                                                    )
                                                }}
                                            </div>
                                        </div>
                                        <div class="w-75px ms-4 invisible">
                                            <input
                                                type="time"
                                                class="form-control mb-lg-0 p-2"
                                                id="customerCode"
                                                v-model="to_hour_history"
                                                :min="from_hour_history"
                                            />
                                        </div>
                                        <div class="ms-1 w-125px ms-3">
                                            <div
                                                v-if="
                                                    errorsHistory[
                                                        'to_date_history'
                                                    ]
                                                "
                                                :title="
                                                    errorsHistory[
                                                        'to_date_history'
                                                    ]
                                                        ? errorsHistory[
                                                              'to_date_history'
                                                          ][0]
                                                        : ''
                                                "
                                                style="width: 125px"
                                                class="text-danger pt-2"
                                            >
                                                {{
                                                    helperFunc.shortString(
                                                        errorsHistory[
                                                            "to_date_history"
                                                        ][0],
                                                        17
                                                    )
                                                }}
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
                                                ) in contractHistories"
                                                :key="index"
                                            >
                                                <td>
                                                    {{ index + 1 }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-dark text-hover-primary d-block text-content w-150px break-text pb-1 mt-1"
                                                        :title="
                                                            moment(
                                                                new Date(
                                                                    item.properties?.attributes?.updated_at
                                                                )
                                                            ).format(
                                                                'hh:mm A DD/MM/YYYY'
                                                            )
                                                            ?
                                                            moment(
                                                                new Date(
                                                                     item.properties?.attributes?.updated_at
                                                                )
                                                            ).format(
                                                                'hh:mm A DD/MM/YYYY'
                                                            )
                                                            : '---'
                                                        "
                                                    >
                                                        {{
                                                            moment(
                                                                new Date(
                                                                     item.properties?.attributes?.updated_at
                                                                )
                                                            ).format(
                                                                "hh:mm A DD/MM/YYYY"
                                                            )
                                                            ?
                                                            moment(
                                                                new Date(
                                                                    item.properties?.attributes?.updated_at
                                                                )
                                                            ).format(
                                                                "hh:mm A DD/MM/YYYY"
                                                            )
                                                            : '---'
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
                                                            Số hợp đồng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'signing_date' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Ngày ký
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'project_id' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Dự án
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Đại diện ký(Phía công ty)"
                                                            v-if="
                                                                key_info ==
                                                                    'user_contractor_id' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Đại diện ký(Phía
                                                            công ty)
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            v-if="
                                                                key_info ==
                                                                    'user_charge_id' &&
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
                                                            title="Đại diện ký(Phía khách hàng)"
                                                            v-if="
                                                                key_info ==
                                                                    'customer_contractor' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Đại diện ký(Phía
                                                            khách hàng)
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Khách hàng"
                                                            v-if="
                                                                key_info ==
                                                                    'customer_id' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Khách hàng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Loại hợp đồng"
                                                            v-if="
                                                                key_info ==
                                                                    'contract_type_id' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Loại hợp đồng
                                                        </span>

                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Giá trị hợp đồng"
                                                            v-if=" getUserPermission.permission_contract_value &&
                                                                key_info ==
                                                                    'contract_value' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Giá trị hợp đồng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Ngày bắt đầu thực hiện"
                                                            v-if="
                                                                key_info ==
                                                                    'start_date' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Ngày bắt đầu thực
                                                            hiện
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Ngày hết hạn hợp đồng"
                                                            v-if="
                                                                key_info ==
                                                                    'expiration_date' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Ngày hết hạn hợp
                                                            đồng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Ngày nghiệm thu hợp đồng"
                                                            v-if="
                                                                key_info ==
                                                                    'hand_over_date' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Ngày nghiệm thu hợp
                                                            đồng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Số lần thanh toán"
                                                            v-if="
                                                                key_info ==
                                                                    'number_payment' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Số lần thanh toán
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Thời gian bảo hành"
                                                            v-if="
                                                                key_info ==
                                                                    'warranty_time' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Thời gian bảo hành
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
                                                            title="Lưu ý quan trọng"
                                                            v-if="
                                                                key_info ==
                                                                    'note_module' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Ghi chú chức năng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Lưu ý quan trọng"
                                                            v-if="
                                                                key_info ==
                                                                    'note_contract' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Lưu ý quan trọng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Ghi chú số lần thanh toán"
                                                            v-if="getUserPermission.canPermisisonViewPaymentContract &&
                                                                key_info ==
                                                                    'note' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Ghi chú số lần thanh toán
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Phân loại khách hàng"
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
                                                        <!-- <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Hợp đồng"
                                                            v-if="
                                                                key_info ==
                                                                    'contract_id' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Hợp đồng
                                                        </span> -->
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Số lần thanh toán"
                                                            v-if="
                                                                key_info ==
                                                                    'payment_times' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Số lần thanh toán
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Số tiền thanh toán dự kiến"
                                                            v-if=" getUserPermission.canPermisisonViewPaymentContract &&
                                                                key_info ==
                                                                    'amount' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Số tiền thanh toán
                                                            dự kiến
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Số tiền thanh toán thực tế"
                                                            v-if=" getUserPermission.canPermisisonViewPaymentContract &&
                                                                key_info ==
                                                                    'actual_amount' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Số tiền thanh toán
                                                            thực tế
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Ngày dự kiến thanh toán"
                                                            v-if=" getUserPermission.canPermisisonViewPaymentContract &&
                                                                key_info ==
                                                                    'expected_payment_date' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Ngày dự kiến thanh
                                                            toán
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Ngày thanh toán thực tế"
                                                            v-if=" getUserPermission.canPermisisonViewPaymentContract &&
                                                                key_info ==
                                                                    'payment_date' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Ngày thanh toán thực
                                                            tế
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Ngày thanh toán thực tế"
                                                            v-if="
                                                                key_info ==
                                                                    'date' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Ngày ký
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Ngày thanh toán thực tế"
                                                            v-if="
                                                                key_info ==
                                                                    'description' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Diễn giải
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Ngày thanh toán thực tế"
                                                            v-if="
                                                                key_info ==
                                                                    'module_id' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Nhóm chức năng
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                            title="Ngày thanh toán thực tế"
                                                            v-if="
                                                                key_info ==
                                                                    'value' &&
                                                                key_info !=
                                                                    'updated_by' &&
                                                                key_info !=
                                                                    'updated_at'
                                                            "
                                                        >
                                                            Giá trị theo hợp
                                                            đồng
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
                                                                    'signing_date' ||
                                                                key_old ==
                                                                    'customer_contractor' ||
                                                                key_old ==
                                                                    'contract_value' ||
                                                                key_old ==
                                                                    'start_date' ||
                                                                key_old ==
                                                                    'expiration_date' ||
                                                                key_old ==
                                                                    'hand_over_date' ||
                                                                key_old ==
                                                                    'number_payment' ||
                                                                key_old ==
                                                                    'warranty_time' ||
                                                                key_old ==
                                                                    'payment_times' ||

                                                                key_old ==
                                                                    'date' ||
                                                                key_old ==
                                                                    'description' ||
                                                                key_old ==
                                                                    'value'
                                                            "
                                                        >

                                                        <span v-if="getUserPermission.permission_contract_value &&  key_old ==
                                                                    'contract_value'">{{ val_old }}</span>
                                                          <span v-if="key_old !=
                                                                    'contract_value'">{{ val_old }}</span>
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'payment_date'
                                                            "
                                                        >
                                                          <span v-if="getUserPermission.canPermisisonViewPaymentContract &&  key_old ==
                                                                    'payment_date'">{{ val_old }}</span>
                                                          <span v-if="key_old !=
                                                                    'payment_date'">{{ val_old }}</span>

                                                        </span>

                                                          <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'amount'
                                                            "
                                                        >
                                                          <span v-if="getUserPermission.canPermisisonViewPaymentContract &&  key_old ==
                                                                    'amount'">{{ val_old }}</span>
                                                          <span v-if="key_old !=
                                                                    'amount'">{{ val_old }}</span>

                                                        </span>

                                                         <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'expected_payment_date'
                                                            "
                                                        >
                                                          <span v-if="getUserPermission.canPermisisonViewPaymentContract &&  key_old ==
                                                                    'expected_payment_date'">{{ val_old }}</span>
                                                          <span v-if="key_old !=
                                                                    'expected_payment_date'">{{ val_old }}</span>

                                                        </span>

                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'actual_amount'
                                                            "
                                                        >
                                                         <span v-if="getUserPermission.canPermisisonViewPaymentContract &&  key_old ==
                                                                    'actual_amount'">{{ val_old }}</span>
                                                          <span v-if="key_old !=
                                                                    'actual_amount'">{{ val_old }}</span>

                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'note_module'
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
                                                                'note_contract'
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
                                                                'note'
                                                            "
                                                        >
                                                            <span v-if="getUserPermission.canPermisisonViewPaymentContract &&  key_old ==
                                                                    'note'">{{ val_old }}</span>
                                                          <span v-if="key_old !=
                                                                    'note'">{{ val_old }}</span>

                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'project_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldProject[0]
                                                                    ? item
                                                                          .jsonOldProject[0]
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
                                                                'user_contractor_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldUserContractor[0]
                                                                    ? item
                                                                          .jsonOldUserContractor[0]
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
                                                                'user_charge_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldUserCharge[0]
                                                                    ? item
                                                                          .jsonOldUserCharge[0]
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
                                                                'customer_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldCustomer[0]
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
                                                                'contract_type_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldContractType[0]
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
                                                                'status_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldSystemStatus[0]
                                                                    ?.name
                                                            }}
                                                        </span>
                                                        <!-- <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'contract_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldContract[0]
                                                                    ? item
                                                                          .jsonOldContract[0]
                                                                          .name
                                                                    : '---'
                                                            }}
                                                        </span> -->
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_old ==
                                                                'module_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonOldModule[0]
                                                                    ? item
                                                                          .jsonOldModule[0]
                                                                          .name
                                                                    : '---'
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
                                                                    'code' ||
                                                                key_attr ==
                                                                    'signing_date' ||
                                                                key_attr ==
                                                                    'customer_contractor' ||
                                                                key_attr ==
                                                                    'contract_value' ||
                                                                key_attr ==
                                                                    'start_date' ||
                                                                key_attr ==
                                                                    'expiration_date' ||
                                                                key_attr ==
                                                                    'hand_over_date' ||
                                                                key_attr ==
                                                                    'number_payment' ||
                                                                key_attr ==
                                                                    'warranty_time' ||
                                                                key_attr ==
                                                                    'payment_times' ||

                                                                key_attr ==
                                                                    'date' ||
                                                                key_attr ==
                                                                    'description' ||
                                                                key_attr ==
                                                                    'value'
                                                            "
                                                        >
                                                          <span v-if="getUserPermission.permission_contract_value &&  key_attr ==
                                                                    'contract_value'">{{ val_attr }}</span>
                                                            <span v-if="key_attr !=
                                                                    'contract_value'">{{ val_attr }}</span>
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'payment_date'
                                                            "
                                                        >
                                                          <span v-if="getUserPermission.canPermisisonViewPaymentContract &&  key_attr ==
                                                                    'payment_date'">{{ val_attr }}</span>
                                                          <span v-if="key_attr !=
                                                                    'payment_date'">{{ val_attr }}</span>

                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'expected_payment_date'
                                                            "
                                                        >
                                                          <span v-if="getUserPermission.canPermisisonViewPaymentContract &&  key_attr ==
                                                                    'expected_payment_date'">{{ val_attr }}</span>
                                                          <span v-if="key_attr !=
                                                                    'expected_payment_date'">{{ val_attr }}</span>

                                                        </span>

                                                         <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'amount'
                                                            "
                                                        >
                                                          <span v-if="getUserPermission.canPermisisonViewPaymentContract &&  key_attr ==
                                                                    'amount'">{{ val_attr }}</span>
                                                          <span v-if="key_attr !=
                                                                    'amount'">{{ val_attr }}</span>

                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'actual_amount'
                                                            "
                                                        >
                                                             <span v-if="getUserPermission.canPermisisonViewPaymentContract &&  key_attr ==
                                                                    'actual_amount'">{{ val_attr }}</span>
                                                          <span v-if="key_attr !=
                                                                    'actual_amount'">{{ val_attr }}</span>
                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'note_module'
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
                                                                'note_contract'
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
                                                           <span v-if="getUserPermission.canPermisisonViewPaymentContract &&  key_attr ==
                                                                    'note'">{{ val_attr }}</span>
                                                          <span v-if="key_attr !=
                                                                    'note'">{{ val_attr }}</span>

                                                        </span>
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'project_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonNewProject[0]
                                                                    ? item
                                                                          .jsonNewProject[0]
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
                                                                'user_contractor_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonNewUserContractor[0]
                                                                    ? item
                                                                          .jsonNewUserContractor[0]
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
                                                                'user_charge_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonNewUserCharge[0]
                                                                    ? item
                                                                          .jsonNewUserCharge[0]
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
                                                                'customer_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonNewCustomer[0]
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
                                                                'contract_type_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonNewContractType[0]
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
                                                                'status_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonNewSystemStatus[0]
                                                                    ?.name
                                                            }}
                                                        </span>
                                                        <!-- <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'contract_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonNewContract[0]
                                                                    ? item
                                                                          .jsonNewContract[0]
                                                                          .name
                                                                    : '---'
                                                            }}
                                                        </span> -->
                                                        <span
                                                            style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                            v-if="
                                                                key_attr ==
                                                                'module_id'
                                                            "
                                                        >
                                                            {{
                                                                item
                                                                    .jsonNewModule[0]
                                                                    ? item
                                                                          .jsonNewModule[0]
                                                                          .name
                                                                    : '---'
                                                            }}
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr
                                                v-if="
                                                    contractHistories.length == 0
                                                "
                                            >
                                                <td
                                                    class="text-center"
                                                    colspan="12"
                                                >
                                                    Không có dữ liệu hiển thị
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <base-pagination
                                    :pagination="paginationHistory"
                                    @change-page="changePageHistoryContracts"
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
import SelectSearch from "../input/SelectSearch.vue";
import InputSearch from "../input/InputSearch.vue";

import {
    defineProps,
    ref,
    computed,
    watch,
    onBeforeMount,
    reactive,
} from "vue";
import { useContractStore } from "../../stores/contract";
import { useCustomerStore } from "../../stores/customer";
import { useStoreProjects } from "../../stores/project";
import { useContracTypeStore } from "../../stores/contract";
import { useUsers } from "../../stores/user";
import { destroy } from "../../helper/axiosConfig";
import moment from "moment";
import { useToast } from "../../helper/toastMessage";
import { sweetAlertMessage } from "../../helper/sweetAlert";
import { helperFunc } from "../../helper/heplerFunction";

const contractStore = useContractStore();
const projectStore = useStoreProjects();
const customerStore = useCustomerStore();
const contractTypeStore = useContracTypeStore();
const userStore = useUsers();

const props = defineProps({
    types: {
        type: Array,
        default: [],
    },
    statuses: {
        Array,
        default: [],
    },
    permissionadd: {
        type: Boolean,
        default: false,
    },
    requestparams: {
        type: Object,
        default: {}
    }
});

const infoList = ref([
    {
        key: "code",
        value: "Số hợp đồng",
    },
    {
        key: "signing_date",
        value: "Ngày ký",
    },
    {
        key: "project_id",
        value: "Dự án",
    },
    {
        key: "user_contractor_id",
        value: "Đại diện ký(Phía công ty)",
    },
    {
        key: "user_charge_id",
        value: "Người phụ trách",
    },
    {
        key: "customer_contractor",
        value: "Đại diện ký(Phía khách hàng)",
    },
    {
        key: "customer_id",
        value: "Khách hàng",
    },
    {
        key: "contract_type_id",
        value: "Loại hợp đồng",
    },
    {
        key: "contract_value",
        value: "Giá trị hợp đồng",
    },
    {
        key: "start_date",
        value: "Ngày bắt đầu thực hiện",
    },
    {
        key: "expiration_date",
        value: "Ngày hết hạn hợp đồng",
    },
    {
        key: "hand_over_date",
        value: "Ngày nghiệm thu hợp đồng",
    },
    {
        key: "number_payment",
        value: "Số lần thanh toán",
    },
    {
        key: "warranty_time",
        value: "Thời gian bảo hành",
    },
    {
        key: "status_id",
        value: "Trạng thái",
    },
    {
        key: "note",
        value: "Ghi chú số lần thanh toán",
    },
    {
        key: "note_contract",
        value: "Lưu ý quan trọng",
    },
    {
        key: "note_module",
        value: "Ghi chú chức năng",
    },
    {
        key: "payment_times",
        value: "Số lần thanh toán",
    },
    {
        key: "amount",
        value: "Số tiền thanh toán dự kiến",
    },
    {
        key: "actual_amount",
        value: "Số tiền thanh toán thực tế",
    },
    {
        key: "expected_payment_date",
        value: "Ngày dự kiến thanh toán",
    },
    {
        key: "payment_date",
        value: "Ngày thanh toán thực tế",
    },
    {
        key: "date",
        value: "Ngày kí",
    },
    {
        key: "code",
        value: "Số của phụ lục",
    },
    {
        key: "description",
        value: "Diễn giải",
    },
    {
        key: "module_id",
        value: "Nhóm chức năng",
    },
    {
        key: "value",
        value: "Giá trị theo hợp đồng",
    },
    {
        key: "description",
        value: "Diễn giải",
    },
]);

// console.log(props.permissionadd)
const code = ref("");
const customer_id = ref(null);
const project_id = ref(null);
const contract_type_id = ref(null);
const status_id = ref(null);
const user_charge_id = ref(null);
const warranty_time = ref(null);
const number_payment = ref(null);
const is_signing = ref(false);
const signing_from = ref(null);
const signing_to = ref(null);
const is_expiration = ref(false);
const expiration_from = ref(null);
const expiration_to = ref(null);
const code_history = ref("");
const project_history = ref("");
const contract = ref("");
const editor = ref("");
const from_date_history = ref(moment().format("YYYY-MM-DD"));
const to_date_history = ref(moment().format("YYYY-MM-DD"));
const from_hour_history = ref(moment().format("HH:mm"));
const to_hour_history = ref(moment().format("HH:mm"));
const info = ref("");
const searchData = reactive({
    code: "",
    customer_id: null,
    project_id: null,
    contract_type_id: null,
    status_id: null,
    user_charge_id: null,
    warranty_time: null,
    number_payment: null,
    is_signing: false,
    signing_from: null,
    signing_to: null,
    is_expiration: false,
    expiration_from: null,
    expiration_to: null,
    code_history: "",
    project_history: "",
    contract: "",
    editor: "",
    from_date_history: "",
    to_date_history: "",
    from_hour_history: "",
    to_hour_history: "",
    info: "",
    contractHistoryId: null
});

const clickSearch = () => {
    searchData.code = code.value;
    searchData.customer_id = customer_id.value;
    searchData.project_id = project_id.value;
    searchData.contract_type_id = contract_type_id.value;
    searchData.status_id = status_id.value;
    searchData.user_charge_id = user_charge_id.value;
    searchData.warranty_time = warranty_time.value;
    searchData.number_payment = number_payment.value;
    searchData.is_signing = is_signing.value;
    searchData.signing_from = signing_from.value;
    searchData.signing_to = signing_to.value;
    searchData.is_expiration = is_expiration.value;
    searchData.expiration_from = expiration_from.value;
    searchData.expiration_to = expiration_to.value;
    getData(1);
};

const clickSearchHistory = () => {
    searchData.code_history = code_history.value;
    searchData.project_history = project_history.value;
    searchData.contract = contract.value;
    searchData.editor = editor.value;
    searchData.from_date_history = from_date_history.value;
    searchData.to_date_history = to_date_history.value;
    searchData.from_hour_history = from_hour_history.value;
    searchData.to_hour_history = to_hour_history.value;
    searchData.info = info.value;
    searchData.contractHistoryId = contractHistoryId.value
    getContractHistory(searchData);
};
const contractHistoryId = ref(null);
const handleViewHistory = (item) => {
    code_history.value = item.code;
    from_date_history.value = null;
    to_date_history.value = null;
    from_hour_history.value = null;
    to_hour_history.value = null;
    contractHistoryId.value = item.code;
    clickSearchHistory();
};

const resetTimeFormHour = () => {
    from_hour_history.value = null;
}
const resetTimeToHour = () => {
    to_hour_history.value = null;
}

let selectTotalRecord = ref(30);
const currentIndex = ref(-1);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};
let getMetaPaginate = ref({});
const contractHistories = ref([]);
const errorsHistory = ref([]);
const getUserPermission = ref([])
const getContractHistory = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/contracts/show",
        method: "GET",
        params: {
            ...params,
            per_page: selectTotalRecord.value,
            page: paginationHistory.value.current_page,
        },
    })
        .then((res) => {
            const { data, meta, userPermission } = res.data;
            contractHistories.value = data;
            getMetaPaginate.value = meta;
            getUserPermission.value =userPermission;
        //     contractHistories.value = contractHistories.value.filter((item) => {
        //     if(
        //         (item.properties.attributes?.actual_amount && userPermission.canPermisisonViewPaymentContract)
        //     || !item.properties.attributes?.actual_amount
        // ) {
        //     let lengthContractValue = Object.entries(item.properties.attributes).length;
        //         if((lengthContractValue == 2 && item.properties.attributes.hasOwnProperty('contract_value')
        //          && userPermission.permission_contract_value)) {
        //             return item;
        //         }
        //         if(item.properties.attributes.hasOwnProperty('contract_value') && lengthContractValue > 2) {
        //             return item;
        //         }
        //     }

        //    })
        //     console.log(contractHistories.value, 'p')

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
const getProjectHistories = ref([]);
const getContractHistories = ref([]);
const getOthers = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/contracts/getOther",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data } = res;
            getUserHistories.value = data.getUsers;
            getProjectHistories.value = data.getProjects;
            getContractHistories.value = data.getContracts;
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};
const paginationHistory = computed(() => {
    return getMetaPaginate.value?.pagination
        ? getMetaPaginate.value.pagination
        : { current_page: 1, total_pages: 1, per_page: 30 };
});

const changePageHistoryContracts = (newDataPagination) => {
    const requestPaginate = {
        page: newDataPagination.current_page,
        per_page: newDataPagination.per_page,
    };
    selectTotalRecord.value = newDataPagination.per_page;
    paginationHistory.value.current_page = newDataPagination.current_page;
    getContractHistory(searchData);
};

const modalAction = ref("view");

const setAction = (action) => {
    modalAction.value = action;
};

const dataUpdate = ref({
    id: 0,
    code: "",
    contract_type_id: null,
    contract_value: "",
    customer_contractor: "",
    customer_id: null,
    expiration_date: null,
    hand_over_date: null,
    note_contract: "",
    number_payment: 1,
    project_id: null,
    signing_date: null,
    start_date: null,
    status_id: null,
    user_contractor_id: null,
    user_charge_id: null,
    warranty_time: null,
    annex_contracts: {
        data: [],
    },
    contract_modules: {
        data: [],
    },
    payment_details: {
        data: [],
    },
});

const errors = computed(() => {
    return contractStore.$state.errors;
});

const showModal = computed(() => {
    return contractStore.$state.showModal ?? false;
});

const contracts = computed(() => {
    return contractStore.$state.contracts.data
        ? helperFunc.groupBy(
              contractStore.$state.contracts.data,
              "project_name"
          )
        : [];
    // return contractStore.$state.contracts.data
    //     ? contractStore.$state.contracts.data.reduce((group, arr) => {
    //         const { project_name } = arr;
    //         group[project_name] = group[project_name] ?? [];
    //         group[project_name].push(arr);
    //         return group;
    //     }, {})
    //     : [];
});

const pagination = computed(() => {
    return contractStore.$state.contracts.meta
        ? contractStore.$state.contracts.meta.pagination
        : { current_page: 1, total_pages: 1, per_page: 30 };
});

const customers = computed(() => {
    return customerStore.$state.customers.data ?? [];
});

const customerLoading = computed(() => {
    return customerStore.$state.loading ?? false;
});

const projects = computed(() => {
    if (projectStore.$state.projects.data) {
        return projectStore.$state.projects.data;
    } else {
        return projectStore.$state.projects;
    }
});

const projectLoading = computed(() => {
    return projectStore.$state.loading ?? false;
});

const contractType = computed(() => {
    return contractTypeStore.$state.types.data ?? [];
});

const users = computed(() => {
    return userStore.$state.users.data ?? [];
});

const userLoading = computed(() => {
    return userStore.$state.loading ?? false;
});

const changePage = (newData) => {
    getData(newData.current_page, newData.per_page);
};

const setDataUpdate = (data, action = "view") => {
    dataUpdate.value = data;
    modalAction.value = action;
};

const clickCreate = () => {
    dataUpdate.value = {
        id: 0,
        code: "",
        contract_type_id: null,
        contract_value: "",
        customer_contractor: "",
        customer_id: null,
        expiration_date: null,
        hand_over_date: null,
        note_contract: "",
        number_payment: 1,
        project_id: null,
        signing_date: null,
        start_date: null,
        status_id: null,
        user_contractor_id: null,
        user_charge_id: null,
        warranty_time: null,
        annex_contracts: {
            data: [],
        },
        contract_modules: {
            data: [],
        },
        payment_details: {
            data: [],
        },
    };
    modalAction.value = "create";
    // console.log('click...');
    contractStore.toggleShowModal(true);
};
const closeModalByRequest = ref(false)
const getData = (
    page = pagination.value.current_page,
    per_page = pagination.value.per_page,
    search = searchData

) => {
    console.log(props.requestparams.code, 'code')
    if(props.requestparams.code && !closeModalByRequest.value) {
        code.value = props.requestparams.code
        search.code = props.requestparams.code;
          // gọi hàm getContractData và sử dụng then() để chờ kết quả
        contractStore.getContractData(page, per_page, search).then(() => {
            // sau khi promise hoàn thành, mở modal và truyền dữ liệu
            contractStore.toggleShowModal(true);
            setDataUpdate(contractStore.$state.contracts.data[0], 'update')
        })

    }else {
        contractStore.getContractData(page, per_page, search);
         console.log(searchData);
    }
};

const getListCustomer = (key) => {
    console.log(key);
    customerStore.getData(1, 1, {
        getAll: true,
        name: key,
        not_loading: true,
    });
};
const getListProject = (key) => {
    console.log(key);
    projectStore.getAllProjectsData({
        getAll: true,
        name: key,
        not_loading: true,
        contractPermission: true,
    });
};
const getListUser = (key) => {
    console.log(key);
    userStore.getUsersData({
        getAll: true,
        name: key,
        not_loading: true,
        contractPermission: true,
    });
};

const deleteRow = (id) => {
    sweetAlertMessage
        .messageWarning("Bạn có chắc chắn muốn xóa không?")
        .then((res) => {
            console.log(res);
            if (res.isConfirmed == true) {
                destroy("/contracts/api/" + id)
                    .then((res) => {
                        console.log(res.data);
                        contractStore.removeData(res.data.data);
                        useToast.successToast("Xóa bản ghi thành công!");
                    })
                    .catch((err) => {
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
        closeModalByRequest.value = true;
        getData();
    }
    clickCreate();
    contractStore.toggleShowModal(false);
};

onBeforeMount(() => {
    getData();
    getContractHistory({
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

label {
    &.col-form-label {
        font-size: 11px !important;
        padding: 2px 0 !important;
    }
}

input {
    &.form-control {
        width: 100%;
        min-height: 24px !important;
        height: 24px !important;
        border-radius: 3px;
        font-size: 12px !important;
    }
}

select {
    &.form-select {
        width: 100%;
        min-height: 24px !important;
        height: 24px !important;
        border-radius: 3px;
        font-size: 12px !important;
        padding: 3px 10px 3px 6px;
        background-position: right 0.15rem center;
    }
}

@media screen and (max-height: 768px) {
    .table-scroll {
        height: 60vh !important;
    }
}

@media screen and (max-height: 720px) {
    .table-scroll {
        height: 58vh !important;
    }
}
.check-permission {
    visibility: hidden;
}
</style>
<style>
.con-his-edi-set .select-box .options-container {
    width: 147px;
}
.con-his-edi-set .options-container {
    top: 195px !important;
}
.con-his-inf-set .select-box .options-container {
    width: 198px;
}
.con-his-inf-set .options-container {
    top: 195px !important;
}
.con-his-pro-set .select-box .options-container {
    width: 500px;
}
.con-his-pro-set .options-container {
    top: 153px !important;
}
</style>
