<template>
    <div class="col-xxl-12 col-xl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch pt-5">
            <!--begin::Header-->

            <div
                class="d-flex align-items-center justify-content-between flex-wrap ms-8 mb-2"
            >
                <div class="d-flex align-items-center flex-wrap">
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-5"
                    >
                        <div class="w-auto">
                            <label
                                for="customerCode"
                                class="me-3 col-form-label"
                                >Người gửi</label
                            >
                        </div>
                        <div class="">
                            <input
                                style="width: 316px"
                                type="text"
                                placeholder="Tất cả"
                                class="form-control mb-lg-0 p-2"
                                id="customerCode"
                                v-model="sender"
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto ms-2 me-2"
                    >
                        <div class="w-auto">
                            <label
                                for="customerCode"
                                class="me-5 col-form-label"
                                >Người nhận</label
                            >
                        </div>
                        <div class="w-200px">
                            <input
                                type="text"
                                placeholder="Tất cả"
                                class="form-control mb-lg-0 p-2"
                                id="customerCode"
                                v-model="receiver"
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-6 ms-5"
                    >
                        <div class="w-auto">
                            <label
                                for="customerCode"
                                class="me-5 col-form-label"
                                >Trạng thái</label
                            >
                        </div>
                        <div class="w-200px status-dis-set">
                            <SelectSearch
                                :list-data="systemStatuses"
                                v-model="status_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div>
                    <a
                        style="float: right; margin-top: 2px"
                        href="#"
                        class="btn btn-icon btn-sm btn-icon-bg-primary btn-color-light ms-8"
                        @click="clickSearch()"
                    >
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>
                </div>
            </div>
            <div
                class="d-flex align-items-center justify-content-between flex-wrap ms-5"
            >
                <div class="d-flex align-items-center flex-wrap">
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-5"
                        style="margin-left: 10px"
                    >
                        <div class="w-auto">
                            <label class="me-5 col-form-label" for="checkCreate"
                                >Ngày lập</label
                            >
                        </div>
                        <div class="w-150px">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                id="fromDate"
                                placeholder=""
                                v-model="from_date"
                                :max="to_date"
                            />
                        </div>
                        <div class="w-10px">
                            <label class="col-form-label">-</label>
                        </div>
                        <div class="ms-2 w-150px">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                id="toDate"
                                v-model="to_date"
                                :min="from_date"
                                x
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto ms-2 me-2"
                    >
                        <div class="w-auto">
                            <label
                                for="customerCode"
                                class="me-16 col-form-label"
                                >Dự án</label
                            >
                        </div>
                        <div class="w-200px">
                            <input
                                type="text"
                                placeholder="Tất cả"
                                class="form-control mb-lg-0 p-2"
                                id="customerCode"
                                v-model="project"
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-2 ms-2"
                    >
                        <div class="w-auto">
                            <label
                                for="customerCode"
                                class="ms-3 me-16 col-form-label"
                                >Loại</label
                            >
                        </div>
                        <div class="w-200px">
                            <select class="form-select" v-model="type">
                                <option value="">Tất cả</option>
                                <option value="1">Gửi đi</option>
                                <option value="0">Tiếp nhận</option>
                            </select>
                        </div>
                    </div>
                    <a
                        style="float: right"
                        href="#"
                        class="btn btn-function ms-7"
                        @click="clickCreateDispatch"
                        data-bs-target="#formCreateDispatch"
                        data-bs-toggle="modal"
                        v-if="props.btnAdd"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm</a
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
                                <th class="w-25px">STT</th>
                                <th class="w-85px">Ngày lập</th>
                                <th class="w-125px">Mã công văn/thông báo</th>
                                <th class="w-150px">Tên công văn/thông báo</th>
                                <th class="w-220px">Loại</th>
                                <th class="w-125px">Số công văn/thông báo</th>
                                <th class="w-150px">Ngày hiệu lực</th>
                                <th class="w-150px">Trạng thái</th>
                                <th class="w-200px">Nội dung</th>
                                <th class="w-200px">Ghi chú</th>
                                <th class="w-100px" colspan="2">Hành động</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody
                            v-for="(dispatch, key) in dispatches"
                            :key="key"
                            class="max-h-75 overflow-auto cursor-pointer"
                        >
                            <tr class="max-h-75 overflow-auto cursor-pointer">
                                <td
                                    class="h-40px fw-medium pointer-events-none"
                                    style="
                                        background-color: rgb(243, 237, 179);
                                        font-size: 14px;
                                        padding-left: 3rem;
                                    "
                                    colspan="12"
                                >
                                    <p v-html="key"></p>
                                </td>
                            </tr>
                            <tr
                                v-for="(item, index) in dispatch"
                                :key="index"
                                :class="{ active: item.id == currentIndex }"
                                @click="currentIndex = item.id"
                            >
                                <td>
                                    <span
                                        class="text-dark d-block text-hover-primary w-25px fs-6"
                                    >
                                        {{ index + 1 }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-85px break-text"
                                        :title="item.date"
                                    >
                                        {{ item.date }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-125px break-text"
                                        :title="item.code"
                                    >
                                        {{ item.code }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-150px break-text pb-1 mt-1"
                                        :title="item.name"
                                        >{{ item.name }}
                                    </span>
                                </td>
                                <td>
                                    <p
                                        class="text-dark text-hover-primary d-block text-content w-220px break-text mb-1 pb-1 mt-1"
                                    >
                                        {{
                                            item.type === 1
                                                ? "Gửi đi"
                                                : "Tiếp nhận"
                                        }}
                                    </p>
                                    <div v-if="item.type === 1">
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-220px break-text mb-1 pb-1"
                                            :title="item.sender"
                                        >
                                            Người gửi: {{ item.sender  == 'null' ? '' : item.sender  }}
                                        </p>
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-220px break-text pb-1"
                                            :title="item.receiver"
                                        >
                                            Người nhận: {{ item.receiver == 'null' ? '' : item.receiver }}
                                        </p>
                                    </div>
                                    <div v-if="item.type === 0">
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-220px break-text mb-1 pb-1"
                                            :title="item.receiver"
                                        >
                                            Người nhận: {{ item.receiver == 'null' ? '' : item.receiver }}
                                        </p>
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-220px break-text pb-1"
                                            :title="item.sender"
                                        >
                                            Người gửi: {{ item.sender  == 'null' ? '' : item.sender  }}
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-125px break-text"
                                        :title="item.number"
                                        >{{ item.number }}
                                    </span>
                                </td>
                                <td>
                                    <p
                                        class="text-dark text-hover-primary d-block text-content w-150px break-text mb-1 pb-1"
                                    >
                                        Từ ngày: {{ item.from_date }}
                                    </p>
                                    <p
                                        class="text-dark text-hover-primary d-block text-content w-150px break-text pb-1"
                                    >
                                        Đến ngày: {{ item.to_date }}
                                    </p>
                                </td>
                                <td>
                                    <div
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-150px break-text pb-1 mt-1"
                                        :title="item.status.data.name"
                                    >
                                        {{ item.status.data.name }}
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-200px break-text pb-1 mt-1"
                                        :title="item.content"
                                        >{{ item.content }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-200px break-text pb-1 mt-1"
                                        :title="item.note"
                                        >{{ item.note }}</span
                                    >
                                </td>

                                <td class="w-50px text-center">
                                    <a v-if="item.isEdit"
                                        href="#"
                                        @click="handleUpdate(item)"
                                        data-bs-target="#formCreateDispatch"
                                        data-bs-toggle="modal"
                                        class="btn btn-icon btn-edit btn-sm"
                                        :id="'click-modal-dispatch'"
                                        :class="{ disable: !item.isEdit }"
                                    >
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </td>
                                <td class="w-50px">
                                    <a
                                        href="#"
                                        @click.prevent="handleDelete(item.id)"
                                        class="btn btn-icon btn-delete btn-sm me-1"
                                        v-if="item.isDelete"
                                    >
                                        <i class="fa-solid fa-trash fs-5"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-if="Object.keys(dispatches).length == 0">
                            <tr>
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
    </div>
    <div
        class="modal"
        tabindex="-1"
        id="formCreateDispatch"
        data-bs-keyboard="true"
        data-bs-backdrop="static"
    >
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl modal-scrollable">
            <div class="modal-content min-h-50 max-h-70">
                <div class="modal-header">
                    <!--begin::Close-->
                    <h4 class="modal-title">
                        {{
                            isClickDispatchUpdate
                                ? "Cập nhật công văn, thông báo"
                                : "Thêm công văn, thông báo"
                        }}
                    </h4>
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2"
                        data-bs-dismiss="modal"
                        @click="closeModal()"
                        id="close"
                        aria-label="Close"
                    >
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body p-0 ps-2 pe-2 mb-3">
                    <div class="row col-lg-12 ms-3">
                        <div class="col-lg-6">
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        for="customerCode"
                                        class="required col-form-label"
                                        >Mã công văn, thông báo</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input
                                        type="text"
                                        :disabled="canDisabledCode"
                                        class="form-control text-input"
                                        :class="{
                                            'input-custom-valid': errors.code,
                                            'input-disabled': canDisabledCode,
                                        }"
                                        v-model="formDispatch.code"
                                        @input="
                                            formDispatch.code = textCode(
                                                $event.target.value
                                            )
                                        "
                                        @keyup="validateInput($event)"
                                        placeholder="Nhập mã"
                                        name="target_title"
                                    />
                                    <base-validation :message="errors.code" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        for="taxCode"
                                        class="required col-form-label"
                                        >Tên công văn, thông báo</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input
                                        type="text"
                                        class="form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid': errors.name,
                                        }"
                                        id="taxCode"
                                        v-model="formDispatch.name"
                                    />
                                    <base-validation :message="errors.name" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        for="customerCode"
                                        class="required col-form-label"
                                        >Số công văn, thông báo</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input
                                        type="text"
                                        :disabled="canDisabledCode"
                                        class="form-control text-input"
                                        :class="{
                                            'input-custom-valid': errors.number,
                                            'input-disabled': canDisabledCode,
                                        }"
                                        v-model="formDispatch.number"
                                        @input="
                                            formDispatch.number = textCode(
                                                $event.target.value
                                            )
                                        "
                                        @keyup="validateInput($event)"
                                        placeholder="Nhập mã"
                                        name="target_title"
                                    />
                                    <base-validation :message="errors.number" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        for="status"
                                        class="required col-form-label"
                                        >Dự án</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-6 projects-set-dispatch">
                                    <!-- projects -->
                                    <SelectSearch
                                        :list-data="getProjectsOfUser"
                                        v-model="formDispatch.project_id"
                                        placeholder="--Chọn--"
                                        key-value="id"
                                        key-display="name"
                                    />
                                    <base-validation
                                        :message="errors.project_id"
                                    />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        for="created_at"
                                        class="required col-form-label"
                                        >Từ ngày</label
                                    >
                                    <p>(Ngày hiệu lực)</p>
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input
                                        type="date"
                                        class="form-control mb-lg-0 p-2"
                                        id="fromDate"
                                        placeholder=""
                                        v-model="formDispatch.from_date"
                                        :max="formDispatch.to_date"
                                        :min="moment().format('YYYY-MM-DD')"
                                    />
                                    <base-validation
                                        :message="errors.from_date"
                                    />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        for="inputPassword6"
                                        class="col-form-label"
                                        >Nội dung</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <textarea
                                        class="form-control form-control-solid"
                                        placeholder="Nội dung"
                                        :class="{
                                            'input-custom-valid':
                                                errors.content,
                                        }"
                                        v-model="formDispatch.content"
                                        rows="3"
                                    ></textarea>
                                    <base-validation
                                        :message="errors.content"
                                    />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        style="
                                            border-bottom: 1px solid black;
                                            font-weight: bold;
                                        "
                                        for="inputPassword6"
                                        class="col-form-label"
                                        >Công ty</label
                                    >
                                    <base-validation />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="name" class="col-form-label"
                                        >Người gửi</label
                                    >
                                    <base-validation />
                                </div>
                                <div
                                    class="col-lg-6"
                                    v-if="formDispatch.type == 0"
                                >
                                    <input
                                        style="color: #e0e4ec"
                                        disabled
                                        type="text"
                                        class="form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid': errors.sender,
                                        }"
                                        v-model="formDispatch.sender"
                                        id="name"
                                    />
                                    <base-validation :message="errors.sender" />
                                </div>
                                <div
                                    class="col-lg-6"
                                    v-if="formDispatch.type == 1"
                                >
                                    <input
                                        type="text"
                                        class="form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid': errors.sender,
                                        }"
                                        v-model="formDispatch.sender"
                                        id="name"
                                    />
                                    <base-validation :message="errors.sender" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        for="representative"
                                        class="col-form-label"
                                        >Người nhận</label
                                    >
                                    <base-validation />
                                </div>
                                <div
                                    class="col-lg-6"
                                    v-if="formDispatch.type == 1"
                                >
                                    <input
                                        style="color: #e0e4ec"
                                        disabled
                                        type="text"
                                        class="required form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid':
                                                errors.receiver,
                                        }"
                                        v-model="formDispatch.receiver"
                                    />
                                    <base-validation
                                        :message="errors.receiver"
                                    />
                                </div>
                                <div
                                    class="col-lg-6"
                                    v-if="formDispatch.type == 0"
                                >
                                    <input
                                        type="text"
                                        class="required form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid':
                                                errors.receiver,
                                        }"
                                        v-model="formDispatch.receiver"
                                    />
                                    <base-validation
                                        :message="errors.receiver"
                                    />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5"></div>
                                <div class="col-lg-6">
                                    <input
                                        style="font-size: 13px; display: none"
                                        id="input-length"
                                        multiple
                                        type="file"
                                        @change="onFileChange"
                                    />
                                    <div class="col-lg-12 row">
                                        <span class="col-3">
                                            <label
                                                class="form-control"
                                                for="input-length"
                                                >Chọn
                                            </label>
                                        </span>
                                        <!-- isClickDispatchUpdate -->
                                        <span
                                            :class="
                                                isClickDispatchUpdate
                                                    ? 'd-none'
                                                    : fileCount.length > 0
                                                    ? 'd-none'
                                                    : ''
                                            "
                                            class="col-9"
                                            style="
                                                height: 20px;
                                                line-height: 25px;
                                            "
                                        >
                                            {{
                                                fileCount.length > 0
                                                    ? ""
                                                    : "Không có tệp được chọn"
                                            }}
                                        </span>
                                        <span
                                            :class="
                                                isClickDispatchUpdate
                                                    ? 'd-none'
                                                    : ''
                                            "
                                            v-if="fileCount.length > 0"
                                            class="col-9"
                                            style="
                                                height: 20px;
                                                line-height: 25px;
                                            "
                                        >
                                            {{ fileCount.length }} Tệp
                                        </span>
                                        <div
                                            :class="
                                                isClickDispatchUpdate
                                                    ? 'd-block'
                                                    : 'd-none'
                                            "
                                            class="col-9"
                                            style="
                                                height: 20px;
                                                line-height: 25px;
                                            "
                                        >
                                            {{
                                                isClickDispatchUpdate
                                                    ? handCountUpdate.length > 0
                                                        ? handCountUpdate.length +
                                                          " Tệp"
                                                        : "Không có tệp được chọn"
                                                    : ""
                                            }}
                                        </div>
                                    </div>
                                    <p class="text-danger">{{
                                        errorMessage
                                    }}</p>
                                    <base-validation
                                        :message="errors.filesArr"
                                    />
                                    <span
                                        id="file_count"
                                        class="text-info"
                                    ></span>
                                    <div
                                        v-if="images"
                                        style="
                                            overflow: auto;
                                            width: auto;
                                            max-height: 100px;
                                        "
                                    >
                                        <div
                                            style=""
                                            class="d-flex mt-2"
                                            v-for="(image, index) in images"
                                            :key="index"
                                        >
                                            <button
                                                style="
                                                    padding: 2px;
                                                    border-radius: 5px;
                                                    border: none;
                                                    background: none;
                                                "
                                                @click="
                                                    removeImage(image, index)
                                                "
                                            >
                                                <i
                                                    class="fa-solid fa-trash-can"
                                                ></i>
                                            </button>
                                            <p
                                                style="
                                                    line-height: 20px;
                                                    height: 20px;
                                                    font-size: 14px;
                                                    margin-left: 10px;
                                                "
                                                :title="image.name"
                                            >
                                                {{
                                                    truncateMiddleDispatch(
                                                        image.name,
                                                        25
                                                    )
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label
                                        for="inputPassword6"
                                        class="required col-form-label"
                                        >Loại</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <select
                                        class="form-select"
                                        :class="{
                                            'select-custom-valid': errors.type,
                                        }"
                                        data-placeholder="Chọn trạng thái"
                                        v-model="formDispatch.type"
                                        aria-label="Default select example"
                                    >
                                        <option disabled value="">
                                            --Chọn--
                                        </option>
                                        <option value="1">Gửi đi</option>
                                        <option value="0">Tiếp nhận</option>
                                    </select>
                                    <base-validation :message="errors.type" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label
                                        for="created_at"
                                        class="col-form-label"
                                        >Ngày lập</label
                                    >
                                </div>
                                <div class="col-lg-7">
                                    <input
                                        type="date"
                                        class="form-control mb-lg-0 p-2"
                                        id="fromDate"
                                        placeholder=""
                                        :max="moment().format('YYYY-MM-DD')"
                                        v-model="formDispatch.date"
                                    />
                                    <base-validation :message="errors.date" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label
                                        for="inputPassword6"
                                        class="required col-form-label"
                                        >Trạng thái
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <select
                                        class="form-select"
                                        :class="{
                                            'select-custom-valid':
                                                errors.status_id,
                                        }"
                                        data-placeholder="Chọn trạng thái"
                                        v-model="formDispatch.status_id"
                                        aria-label="Default select example"
                                    >
                                        <option value="">--Chọn---</option>
                                        <option
                                            v-for="(
                                                item, index
                                            ) in systemStatuses"
                                            :key="index"
                                            :value="item.id"
                                            :disabled="item.status == false"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                    <base-validation
                                        :message="errors.status_id"
                                    />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label
                                        for="status"
                                        class="required col-form-label"
                                        >Khách hàng</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-7 customers-set-dispatch">
                                    <span
                                        class="form-control"
                                        style="height: 28px"
                                        >{{
                                            customer ? customer.name : ""
                                        }}</span
                                    >
                                    <base-validation
                                        :message="errors.customer_id"
                                    />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label
                                        for="created_at"
                                        class="required col-form-label"
                                        >Đến ngày</label
                                    >
                                    <p>(Ngày hiệu lực)</p>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input
                                        type="date"
                                        class="form-control mb-lg-0 p-2"
                                        id="fromDate"
                                        placeholder=""
                                        v-model="formDispatch.to_date"
                                        :min="formDispatch.from_date"
                                    />
                                    <base-validation
                                        :message="errors.to_date"
                                    />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label
                                        for="inputPassword6"
                                        class="col-form-label"
                                        >Ghi chú</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <textarea
                                        class="form-control form-control-solid"
                                        placeholder="Nội dung"
                                        :class="{
                                            'input-custom-valid': errors.note,
                                        }"
                                        v-model="formDispatch.note"
                                        rows="3"
                                    ></textarea>
                                    <base-validation :message="errors.note" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        style="
                                            border-bottom: 1px solid black;
                                            font-weight: bold;
                                        "
                                        for="inputPassword6"
                                        class="col-form-label"
                                        >Khách hàng</label
                                    >
                                    <base-validation />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label
                                        for="representative"
                                        class="col-form-label"
                                        >Người nhận</label
                                    >
                                    <base-validation />
                                </div>
                                <div
                                    class="col-lg-7"
                                    v-if="formDispatch.type == 1"
                                >
                                    <input
                                        type="text"
                                        class="required form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid':
                                                errors.receiver,
                                        }"
                                        v-model="formDispatch.receiver"
                                    />
                                    <base-validation
                                        :message="errors.receiver"
                                    />
                                </div>
                                <div
                                    class="col-lg-7"
                                    v-if="formDispatch.type == 0"
                                >
                                    <input
                                        style="color: #e0e4ec"
                                        disabled
                                        type="text"
                                        class="required form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid':
                                                errors.receiver,
                                        }"
                                        v-model="formDispatch.receiver"
                                    />
                                    <base-validation
                                        :message="errors.receiver"
                                    />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label for="name" class="col-form-label"
                                        >Người gửi</label
                                    >
                                    <base-validation />
                                </div>
                                <div
                                    class="col-lg-7"
                                    v-if="formDispatch.type == 1"
                                >
                                    <input
                                        style="color: #e0e4ec"
                                        disabled
                                        type="text"
                                        class="form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid': errors.sender,
                                        }"
                                        v-model="formDispatch.sender"
                                        id="name"
                                    />
                                    <base-validation :message="errors.sender" />
                                </div>
                                <div
                                    class="col-lg-7"
                                    v-if="formDispatch.type == 0"
                                >
                                    <input
                                        type="text"
                                        class="form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid': errors.sender,
                                        }"
                                        v-model="formDispatch.sender"
                                        id="name"
                                    />
                                    <base-validation :message="errors.sender" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="border-top: none">
                    <button
                        type="button"
                        class="btn btn-function me-4"
                        @click.prevent="
                            isClickDispatchUpdate
                                ? updateDispatch()
                                : storeDispatch()
                        "
                    >
                        <i class="fa-solid fa-floppy-disk"></i> Lưu
                    </button>
                    <button
                        type="button"
                        class="btn btn-secondary btn-sm btn-active-color-light"
                        id="close-modal"
                        data-bs-dismiss="modal"
                        @click="closeModal()"
                    >
                        <i class="fa-solid fa-xmark"></i>Đóng
                    </button>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
</template>
<script setup>
import {
    defineProps,
    ref,
    toRef,
    computed,
    watch,
    onBeforeMount,
    reactive,
    onMounted,
} from "vue";
import { helperFunc } from "../../helper/heplerFunction.js";
import moment from "moment";
import { useToast } from "../../helper/toastMessage";
import { sweetAlertMessage } from "../../helper/sweetAlert";
import { textCode, validateInput } from "../../../services/utils";
import SelectSearch from "../input/SelectSearch.vue";
import { useSystemStatusStore } from "../../stores/status";
import { useStoreProjects } from "../../stores/project";
const props = defineProps({
    title: String,
    btnAdd: {
        type: Boolean,
        default: false,
    },
    requestparams: {
        type: Object,
        default: {},
    },
});

const systemStatusStore = useSystemStatusStore();

const systemStatuses = computed(() => {
    return systemStatusStore.getStatusesByDispatch;
});

const project = ref("");
const sender = ref("");
const receiver = ref("");
const type = ref("");
const from_date = ref("");
const status_id = ref("");
const to_date = ref("");

const searchData = reactive({
    project: "",
    sender: "",
    receiver: "",
    type: "",
    from_date: "",
    status_id: "",
    to_date: "",
});
const isRequestParams = ref(false);

const clickSearch = () => {
    isRequestParams.value = true;
    searchData.project = project.value;
    searchData.sender = sender.value;
    searchData.receiver = receiver.value;
    searchData.type = type.value;
    searchData.from_date = from_date.value;
    searchData.status_id = status_id.value;
    searchData.to_date = to_date.value;
    pagination.value.current_page = 1;
    getDispatches(searchData);
};

const formDispatch = reactive({
    code: "",
    name: "",
    type: "",
    date: "",
    number: "",
    project_id: "",
    customer_id: "",
    content: "",
    sender: "",
    receiver: "",
    from_date: "",
    to_date: "",
    note: "",
    status_id: "",
    file: null,
    error_file: "",
    quantity_file: 0
});
// handle chọn số bản ghi / 1 trang
const currentIndex = ref(-1);

let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};

const dispatches = ref([]);
const projects = ref([]);
const customers = ref([]);
const systemStatus = ref([]);
let getMetaPaginate = ref({});
const getDispatches = (params = null) => {
    if (props.requestparams?.code && !isRequestParams.value) {
        project.value = props.requestparams?.code;
        params = { project: props.requestparams?.code };
    }
    KTApp.showPageLoading();
    axios({
        url: "/dispatches/get-all",
        method: "GET",
        params: {
            ...params,
            per_page: selectTotalRecord.value,
            page: pagination.value.current_page,
        },
    })
        .then((res) => {
            const { data, meta } = res.data;
            dispatches.value = data.reduce((group, arr) => {
                const { project_customer_title } = arr;
                group[project_customer_title] =
                    group[project_customer_title] ?? [];
                group[project_customer_title].push(arr);
                return group;
            }, {});
            console.log(dispatches.value);
            getMetaPaginate.value = meta;

            if (props.requestparams?.id && !isRequestParams.value) {
                getProjectsCustomers().then(() => {
                    let dataUpdate = data.filter((item) => {
                        return item.id == props.requestparams?.id;
                    });
                    handleUpdate(dataUpdate[0]);
                    formDispatch.project_id = dataUpdate[0].project?.data?.id;
                    $("#formCreateDispatch").modal("show");
                });
            }
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};

const getProjectsCustomers = (params = null) => {
    // KTApp.showPageLoading();
    return axios({
        url: "/dispatches/get-projects-customers",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data } = res;
            // console.log(meta);
            projects.value = data.getProjectManagement;
            customers.value = data.getCustomer;
            systemStatus.value = data.getSystemStatus;
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            // KTApp.hidePageLoading();
        });
};
const customer = ref(null);
watch(
    () => formDispatch.project_id,
    (newValue) => {
        const project = projects.value.find((x) => x.id == newValue);
        console.log("watch", formDispatch.project_id, projects.value);
        if (project) {
            customer.value = customers.value.find(
                (x) => x.id == project.customer_id
            );
            formDispatch.customer_id = project.customer_id;
        } else {
            formDispatch.customer_id = null;
            customer.value = null;
        }
    }
);

const pagination = computed(() => {
    return getMetaPaginate.value?.pagination
        ? getMetaPaginate.value.pagination
        : { current_page: 1, total_pages: 1, per_page: 30 };
});

const changePage = (newDataPagination) => {
    const requestPaginate = {
        page: newDataPagination.current_page,
        per_page: newDataPagination.per_page,
    };
    selectTotalRecord.value = newDataPagination.per_page;
    pagination.value.current_page = newDataPagination.current_page;
    getDispatches(searchData);
};
const projectStore = useStoreProjects();
// Dự án có quyền
const getProjectsOfUser = computed(() => {
    if (projectStore.$state.projects.data) {
        return projectStore.$state.projects.data;
    } else {
        return projectStore.$state.projects;
    }
});

onMounted(() => {
    getDispatches();
    getProjectsCustomers();
    systemStatusStore.getSystemStatusData();
    projectStore.getAllProjectsData({
        getAll: true,
        contractPermission: true,
    });
});

const errors = ref([]);
const images = ref([]);
const fileCount = ref([]);
const onFileChange = (e) => {
    var files = e.target.files || e.dataTransfer.files;
    if (!files.length) return;
    files.forEach((item) => {
        fileCount.value.push(item);
    });
    createFiles(files);
};
const errorMessage = ref();
const createFiles = (files) => {
    for (var index = 0; index < files.length; index++) {
        let fileName = files[index];
        // Lấy kích thước của tệp ảnh
        let fileSize = fileName.size;
        if (fileSize > 5 * 1024 * 1024) {
            // Hiển thị thông báo lỗi
            errorMessage.value =
                "File " + fileName.name + " must small than 5MB.";
            // Không lưu tệp ảnh
            // return;
        } else {
            // Reset lại thông báo lỗi
            errorMessage.value = "";
        }
        images.value.push(fileName);
    }
};

const fileDeletes = ref([]);
const removeImage = (image, index) => {
    fileDeletes.value.push(image.id);
    images.value.splice(index, 1);
    fileCount.value.splice(index, 1);
    errorMessage.value = "";
};

const storeDispatch = () => {
    let formData = new FormData();
    let hasLargeFile = true;
    for (let i = 0; i < images.value.length; i++) {
        // Lấy file thứ i trong mảng
        let file = images.value[i];
        // Kiểm tra kích thước file
        let fileSize = file.size; // Kích thước file trong byte
        let maxSize = 5 * 1024 * 1024; // Kích thước tối đa cho phép là 5MB
        if (fileSize > maxSize) {
            // Nếu file lớn hơn 5MB, đặt biến hasLargeFile thành true và hiển thị thông báo lỗi
            hasLargeFile = false;
            errorMessage.value = "File " + file.name + " must small than 5MB.";
        } else {
            // Nếu file nhỏ hơn hoặc bằng 5MB, thêm file vào formData với tên khóa là "filesArr[]"
            formData.append("filesArr[]", file);
        }
    }

    if (hasLargeFile) {
        formData.append("code", formDispatch.code);
        formData.append("name", formDispatch.name);
        formData.append("type", formDispatch.type);
        formData.append("date", formDispatch.date);
        formData.append("number", formDispatch.number);
        formData.append("project_id", formDispatch.project_id);
        formData.append("customer_id", formDispatch.customer_id);
        formData.append("content", formDispatch.content);
        formData.append("sender", formDispatch.sender);
        formData.append("receiver", formDispatch.receiver);
        formData.append("from_date", formDispatch.from_date);
        formData.append("to_date", formDispatch.to_date);
        formData.append("note", formDispatch.note.toString());
        formData.append("status_id", formDispatch.status_id);
        KTApp.showPageLoading();
        axios
            .post("/dispatches/store", formData)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById("close");
                btn.click();
                getDispatches();
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
                var errorFile = [];
                Object.entries(errors.value).forEach(([key, val]) => {
                    var keyArr = key.split('.');
                    if(keyArr[0] == "filesArr" && keyArr[1]){
                        errorFile.push('File thứ ' + (parseInt(keyArr[1]) + 1) + ' ' + val[0]);

                    }
                    else if(keyArr[0] == "filesArr") {
                        errorFile.push(val[0]);
                    }

                });
                errors.value.filesArr = errorFile;
            })
            .finally(() => {
                KTApp.hidePageLoading();
            });
    } else {
        for (let i = 0; i < images.value.length; i++) {
            // Lấy file thứ i trong mảng
            let file = images.value[i];
            let fileSize = file.size; // Kích thước file trong byte
            let maxSize = 5 * 1024 * 1024; // Kích thước tối đa cho phép là 5MB
            if (fileSize > maxSize) {
                // Nếu file lớn hơn 5MB, đặt biến hasLargeFile thành true và hiển thị thông báo lỗi
                errorMessage.value =
                    "File " + file.name + " must small than 5MB.";
            }
        }
    }
};

let dispatch_id = ref(0);
let canDisabledCode = ref(false);
let isClickDispatchUpdate = ref(false);

const clickCreateDispatch = () => {
    isClickDispatchUpdate.value = false;
    formDispatch.code = "";
    formDispatch.number = "";
    formDispatch.name = "";
    formDispatch.date = "";
    formDispatch.type = "";
    formDispatch.project_id = "";
    formDispatch.customer_id = "";
    formDispatch.content = "";
    formDispatch.sender = "";
    formDispatch.receiver = "";
    formDispatch.from_date = "";
    formDispatch.to_date = "";
    formDispatch.note = "";
    formDispatch.status_id = "";
    formDispatch.error_file = "";
    formDispatch.quantity_file = 0;
    errors.value = [];

    images.value = [];
    fileCount.value = [];

    canDisabledCode.value = false;
};

const handCountUpdate = ref([]);
const handleUpdate = (item) => {
    dispatch_id.value = item.id;
    isClickDispatchUpdate.value = true;
    formDispatch.code = item.code;
    formDispatch.name = item.name;
    formDispatch.number = item.number;
    formDispatch.date = item.date;
    formDispatch.type = item.type;
    formDispatch.project_id = item.project_id;
    formDispatch.customer_id = item.customer_id;
    formDispatch.content = item.content;
    formDispatch.sender = item.sender;
    formDispatch.receiver = item.receiver;
    formDispatch.from_date = item.from_date;
    formDispatch.to_date = item.to_date;
    formDispatch.status_id = item.status_id;
    formDispatch.note = item.note;
    formDispatch.error_file = item.error_file;
    formDispatch.quantity_file = item.files.length;

    images.value = item.files;
    handCountUpdate.value = item.files;

    errors.value = [];
    canDisabledCode.value = true;
};

const updateDispatch = () => {
    isRequestParams.value = true;
    let formData = new FormData();
    let hasLargeFile = true;
    for (let i = 0; i < images.value.length; i++) {
        // Lấy file thứ i trong mảng
        let file = images.value[i];
        if(file['id'] !== undefined){
            continue;
        }
        // Kiểm tra kích thước file
        let fileSize = file.size; // Kích thước file trong byte
        let maxSize = 5 * 1024 * 1024; // Kích thước tối đa cho phép là 5MB
        if (fileSize > maxSize) {
            // Nếu file lớn hơn 5MB, đặt biến hasLargeFile thành true và hiển thị thông báo lỗi
            hasLargeFile = false;
            errorMessage.value = "File " + file.name + " must small than 5MB.";
        } else {
            // Nếu file nhỏ hơn hoặc bằng 5MB, thêm file vào formData với tên khóa là "filesArr[]"
            formData.append("filesArr[]", file);
        }
    }

    if (hasLargeFile) {
        formData.append("fileDeletes", JSON.stringify(fileDeletes.value));
        formData.append("code", formDispatch.code);
        formData.append("name", formDispatch.name);
        formData.append("type", formDispatch.type);
        formData.append("date", formDispatch.date);
        formData.append("number", formDispatch.number);
        formData.append("project_id", formDispatch.project_id);
        formData.append("customer_id", formDispatch.customer_id);
        formData.append("content", formDispatch.content);
        formData.append("sender", formDispatch.sender);
        formData.append("receiver", formDispatch.receiver);
        formData.append("from_date", formDispatch.from_date);
        formData.append("to_date", formDispatch.to_date);
        formData.append("note", formDispatch.note ? formDispatch.note : "");
        formData.append("status_id", formDispatch.status_id);
        KTApp.showPageLoading();
        axios
            .post("/dispatches/update/" + `${dispatch_id.value}`, formData)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById("close");
                btn.click();
                getDispatches(searchData);
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
                var errorFile = [];
                Object.entries(errors.value).forEach(([key, val]) => {
                    var keyArr = key.split('.');
                    if(keyArr[0] == "filesArr" && keyArr[1]){
                        errorFile.push('File thứ ' + (parseInt(keyArr[1]) + 1 + formDispatch.quantity_file) + ' ' + val[0]);

                    }
                    else if(keyArr[0] == "filesArr") {
                        errorFile.push(val[0]);
                    }

                });
                errors.value.filesArr = errorFile;
            })
            .finally(() => {
                KTApp.hidePageLoading();
            });
    } else {
        for (let i = 0; i < images.value.length; i++) {
            // Lấy file thứ i trong mảng
            let file = images.value[i];
            let fileSize = file.size; // Kích thước file trong byte
            let maxSize = 5 * 1024 * 1024; // Kích thước tối đa cho phép là 5MB
            if (fileSize > maxSize) {
                // Nếu file lớn hơn 5MB, đặt biến hasLargeFile thành true và hiển thị thông báo lỗi
                errorMessage.value =
                    "File " + file.name + " must small than 5MB.";
            }
        }
    }
};
const handleDelete = (id) => {
    sweetAlertMessage
        .messageWarning("Bạn có chắc chắn muốn xóa không?")
        .then(function (result) {
            if (result.value) {
                KTApp.showPageLoading();
                axios
                    .delete("/dispatches/destroy/" + id)
                    .then((res) => {
                        useToast.successToast(res.data.message);
                        const totalRecordOnPage =
                            getMetaPaginate.value.pagination.count;
                        if (totalRecordOnPage - 1 === 0) {
                            getMetaPaginate.value.pagination.current_page -= 1;
                        }
                        if (getMetaPaginate.value.pagination.total - 1 === 0) {
                            getDispatches(searchData);
                            return;
                        }
                        changePage(getMetaPaginate.value.pagination);
                    })
                    .catch((error) => {
                        console.log(error);
                    })
                    .finally(() => {
                        KTApp.hidePageLoading();
                    });
            }
        });
};

const truncateMiddleDispatch = (text, maxLength) => {
    if (text.length <= maxLength) {
        return text;
    }
    var start = Math.ceil(maxLength / 2);
    var end = Math.floor(maxLength / 2);
    return text.slice(0, start) + "..." + text.slice(-end);
};

const closeModal = () => {
    images.value = [];
    fileCount.value = [];
    fileDeletes.value = [];
    // Reset lại thông báo lỗi
    errorMessage.value = "";
    currentIndex.value = -1;
    getDispatches();
};
</script>
<style lang="scss" scoped>
.right-5 {
    right: 50px;
}
</style>

<style lang="scss" scoped>
.input-width,
.va-date-input,
.va-time-input {
    margin: 8px auto;
    width: 100%;
}
</style>
<style>
.projects-set-dispatch .select-box .options-container {
    width: 261px;
}
.customers-set-dispatch .select-box .options-container {
    width: 305px;
}
.customers-set-dispatch .box:disabled {
    property: value;
}
.customer-set .selected {
    padding: 16px 24px 16px 8px !important;
}
.status-dis-set .options-container {
    width: 198px !important;
}
.file-edit-name {
    margin: 5px 0;
}
.file-count-dispatch {
    margin-top: -7px;
    font-size: 13px;
    border: 1px solid rgb(196, 196, 196);
    border-radius: 0 5px 5px 0;
    padding: 7px 140px 5px 6px;
    /* line-height: 10px; */
    width: 100px !important;
    border-left: none;
    /* font-weight: 500; */
    color: #5e6278;
}
.sel-but-file {
    width: 79px;
    height: 30px;
    background-color: #ffffff;
    color: #5e6278;
    border: none;
    cursor: pointer;
    border-radius: 5px 0 0 5px;
    border: 1px solid rgb(196, 196, 196);
    font-size: 13px;
}
.inp-file {
    opacity: 0;
    position: absolute;
    width: 79px;
    height: 30px;
    z-index: 1;
}
.file-empty-dispatch {
    margin-top: -7px;
    font-size: 13px;
    border: 1px solid rgb(196, 196, 196);
    border-radius: 0 5px 5px 0;
    padding: 6px 140px 6px 6px;
    /* line-height: 10px; */
    width: 100px !important;
    border-left: none;
    /* font-weight: 500; */
    display: none;
}
</style>
