<template>
    <div class="col-xxl-12 col-xl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch pt-5">
            <!--begin::Header-->
            <div
                class="d-flex align-items-center justify-content-between flex-wrap ms-5 mb-2"
            >
                <div class="d-flex align-items-center flex-wrap">
                    <div
                        class="d-flex align-items-center flex-wrap w-auto ms-3 me-6"
                    >
                        <div class="w-auto">
                            <label
                                for="customerCode"
                                class="col-form-label me-3"
                                >Người bàn giao</label
                            >
                        </div>
                        <div class="w-350px handover-person-set">
                            <SelectSearch
                                :list-data="handoverPersons"
                                v-model="handover_person"
                                placeholder="Tất cả"
                                key-value="handover_person"
                                key-display="handover_person"
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-6 ms-6"
                    >
                        <div class="w-auto">
                            <label
                                for="customerCode"
                                class="col-form-label me-5"
                                >Người tiếp nhận</label
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
                        class="d-flex align-items-center flex-wrap w-auto ms-5"
                    >
                        <div class="w-auto">
                            <label
                                for="customerCode"
                                class="col-form-label me-5"
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
                </div>
            </div>
            <div
                class="d-flex align-items-center justify-content-between flex-wrap ms-5"
            >
                <div class="d-flex align-items-center flex-wrap">
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-10"
                        style="margin-left: 10px"
                    >
                        <div class="w-auto">
                            <label class="col-form-label" for="checkCreate"
                                >Ngày bàn giao</label
                            >
                        </div>
                        <div class="w-150px ms-5 me-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                id="fromDate"
                                placeholder=""
                                v-model="from_date"
                                :max="to_date"
                            />
                        </div>
                        <div class="w-5px ms-2 me-3">
                            <label class="col-form-label">-</label>
                        </div>
                        <div class="w-150px ms-4">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2 ms-2"
                                id="toDate"
                                v-model="to_date"
                                :min="from_date"
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto ms-5 me-13"
                    >
                        <div class="w-auto">
                            <label
                                for="customerCode"
                                class="col-form-label me-15"
                                >Trạng thái</label
                            >
                        </div>
                        <div class="w-200px status-set">
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
                        href="#"
                        class="btn btn-icon btn-sm btn-icon-bg-primary btn-color-light ms-18"
                        @click="clickSearch"
                    >
                        <i class="fa-solid fa-magnifying-glass"></i
                    ></a>
                    <a
                        style="float: right"
                        href="#"
                        class="btn btn-function ms-5 me-2"
                        @click="clickCreateDeployment"
                        data-bs-target="#formCreateDeployment"
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
                                <th class="w-125px">Mã biên bản triển khai</th>
                                <th class="w-150px">
                                    Tiêu đề biên bản triển khai
                                </th>
                                <th class="w-85px">Ngày bàn giao</th>
                                <th class="w-75px">Người bàn giao</th>
                                <th class="w-75px">Người tiếp nhận</th>
                                <th class="w-215px">Ghi chú</th>
                                <th class="w-125px">Trạng thái</th>
                                <th class="w-100px text-center" colspan="2">
                                    Hành động
                                </th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody
                            v-for="(deployment, key) in deployments"
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
                                    colspan="10"
                                >
                                    {{ key }}
                                </td>
                            </tr>
                            <tr
                                v-for="(item, index) in deployment"
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
                                        class="text-dark text-hover-primary d-block text-content w-125px break-text"
                                        :title="item.code"
                                        >{{ item.code }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-150px break-text pb-1 mt-1"
                                        :title="item.title"
                                        >{{ item.title }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-85px break-text"
                                        :title="item.handover_date"
                                        >{{ item.handover_date }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-75px break-text pb-1 mt-1"
                                        :title="item.handover_person"
                                        >{{ item.handover_person }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-75px break-text pb-1 mt-1"
                                        :title="item.receiver"
                                        >{{ item.receiver }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-215px break-text pb-1 mt-1"
                                        :title="item.note"
                                        >{{ item.note }}</span
                                    >
                                </td>
                                <td>
                                    <div
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-150px break-text pb-1 mt-1"
                                        :title="item.status.data.name"
                                    >
                                        {{ item.status.data.name }}
                                    </div>
                                </td>
                                <td class="w-50px text-center">
                                    <a v-if="item.isEdit"
                                        href="#"
                                        @click="handleUpdate(item)"
                                        data-bs-target="#formCreateDeployment"
                                        data-bs-toggle="modal"
                                        class="btn btn-icon btn-edit btn-sm"
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
                        <tbody v-if="Object.keys(deployments).length == 0">
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
    </div>
    <div
        class="modal"
        tabindex="-1"
        id="formCreateDeployment"
        data-bs-keyboard="true"
        data-bs-backdrop="static"
    >
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content min-h-50 max-h-75">
                <div class="modal-header">
                    <!--begin::Close-->
                    <h4 class="modal-title">
                        {{
                            isClickDeploymentUpdate
                                ? "Cập nhật biên bản triển khai"
                                : "Thêm biên bản triển khai"
                        }}
                    </h4>
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2"
                        data-bs-dismiss="modal"
                        @click="closeModal()"
                        id="close"
                        aria-label="Close"
                    >
                        <p id="thong"></p>
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
                                        >Mã biên bản triển khai</label
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
                                        v-model="formDeployment.code"
                                        @input="
                                            formDeployment.code = textCode(
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
                                        >Tiêu đề biên bản triển khai</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input
                                        type="text"
                                        class="form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid': errors.title,
                                        }"
                                        id="taxCode"
                                        v-model="formDeployment.title"
                                    />
                                    <base-validation :message="errors.title" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        for="name"
                                        class="required col-form-label"
                                        >Người bàn giao</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input
                                        type="text"
                                        class="form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid':
                                                errors.handover_person,
                                        }"
                                        v-model="formDeployment.handover_person"
                                        id="name"
                                    />
                                    <base-validation
                                        :message="errors.handover_person"
                                    />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        for="created_at"
                                        class="required col-form-label"
                                        >Ngày bàn giao</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input
                                        type="date"
                                        class="form-control mb-lg-0 p-2"
                                        id="fromDate"
                                        placeholder=""
                                        v-model="formDeployment.handover_date"
                                    />
                                    <base-validation
                                        :message="errors.handover_date"
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
                                        <span
                                            :class="
                                                isClickDeploymentUpdate
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
                                                isClickDeploymentUpdate
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
                                                isClickDeploymentUpdate
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
                                                isClickDeploymentUpdate
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
                                                    truncateMiddleDeployment(
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
                        <div class="col-lg-6 projects-set-deployment">
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label
                                        for="status"
                                        class="required col-form-label"
                                        >Dự án</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <!-- projects -->
                                    <SelectSearch
                                        :list-data="getProjectsOfUser"
                                        v-model="formDeployment.project_id"
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
                                <div class="col-lg-4">
                                    <label
                                        for="inputPassword6"
                                        class="required col-form-label"
                                        >Trạng thái</label
                                    >
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
                                        v-model="formDeployment.status_id"
                                        aria-label="Default select example"
                                    >
                                        <option disabled value="">
                                            --Chọn---
                                        </option>
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
                                        for="representative"
                                        class="required col-form-label"
                                        >Người tiếp nhận</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input
                                        type="text"
                                        class="required form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid':
                                                errors.receiver,
                                        }"
                                        v-model="formDeployment.receiver"
                                    />
                                    <base-validation
                                        :message="errors.receiver"
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
                                        placeholder="Ghi chú khách hàng"
                                        :class="{
                                            'input-custom-valid': errors.note,
                                        }"
                                        v-model="formDeployment.note"
                                        rows="3"
                                    ></textarea>
                                    <base-validation :message="errors.note" />
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
                            isClickDeploymentUpdate
                                ? updateDeployment()
                                : storeDeployment()
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
import { useCustomerStore } from "../../stores/customer";
import { destroy } from "../../helper/axiosConfig";
import moment from "moment";
import { useToast } from "../../helper/toastMessage";
import { sweetAlertMessage } from "../../helper/sweetAlert";
import { textCode, validateInput } from "../../../services/utils";
import { useSystemStatusStore } from "../../stores/status";
import SelectSearch from "../input/SelectSearch.vue";
import { useStoreProjects } from "../../stores/project";
const props = defineProps({
    title: String,
    btnAdd: {
        type: Boolean,
        default: false,
    },
});

const systemStatusStore = useSystemStatusStore();

const systemStatuses = computed(() => {
    // return systemStatusStore.$state.statuses.data ?? [];
    return systemStatusStore.getStatusesByDeploymentRecords;
});

const project = ref("");
const handover_person = ref("");
const receiver = ref("");
const from_date = ref("");
const status_id = ref("");
const to_date = ref("");

const searchData = reactive({
    project: "",
    handover_person: "",
    receiver: "",
    from_date: "",
    status_id: "",
    to_date: "",
});

const clickSearch = () => {
    searchData.project = project.value;
    searchData.handover_person = handover_person.value;
    searchData.receiver = receiver.value;
    searchData.from_date = from_date.value;
    searchData.status_id = status_id.value;
    searchData.to_date = to_date.value;
    pagination.value.current_page = 1;
    getDeployments(searchData);
};

const formDeployment = reactive({
    code: "",
    title: "",
    project_id: "",
    handover_date: "",
    handover_person: "",
    receiver: "",
    note: "",
    status_id: "",
    file: null,
    error_file: "",
    file_length: 0,
    quantity_file: 0
});
// handle chọn số bản ghi / 1 trang

const currentIndex = ref(-1);

let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};
const handoverPersons = ref([]);
const deployments = ref([]);
const projects = ref([]);
const systemStatus = ref([]);
let getMetaPaginate = ref({});
const getDeployments = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/deployment-records/get-all",
        method: "GET",
        params: {
            ...params,
            per_page: selectTotalRecord.value,
            page: pagination.value.current_page,
        },
    })
        .then((res) => {
            const { data, meta, getHandoverPersons } = res.data;
            handoverPersons.value = getHandoverPersons;
            deployments.value = data.reduce((group, arr) => {
                const { project_title } = arr;
                group[project_title] = group[project_title] ?? [];
                group[project_title].push(arr);
                return group;
            }, {});
            getMetaPaginate.value = meta;
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};

const getProjects = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/deployment-records/get-projects",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data } = res;
            projects.value = data.getProjectManagement;
            systemStatus.value = data.getSystemStatus;
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};
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
    getDeployments(searchData);
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
    getDeployments();
    getProjects();
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

const storeDeployment = () => {
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
        formData.append("code", formDeployment.code);
        formData.append("title", formDeployment.title);
        formData.append("project_id", formDeployment.project_id);
        formData.append("handover_date", formDeployment.handover_date);
        formData.append("handover_person", formDeployment.handover_person);
        formData.append("receiver", formDeployment.receiver);
        formData.append("note", formDeployment.note.toString());
        formData.append("status_id", formDeployment.status_id);
        KTApp.showPageLoading();
        axios
            .post("/deployment-records/store", formData)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById("close");
                btn.click();
                getDeployments();
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

let deployment_id = ref(0);
let canDisabledCode = ref(false);
let isClickDeploymentUpdate = ref(false);

const clickCreateDeployment = () => {
    isClickDeploymentUpdate.value = false;
    formDeployment.code = "";
    formDeployment.title = "";
    formDeployment.project_id = "";
    formDeployment.handover_date = "";
    formDeployment.handover_person = "";
    formDeployment.receiver = "";
    formDeployment.note = "";
    formDeployment.status_id = "";
    formDeployment.error_file = "";
    formDeployment.quantity_file = 0;

    fileCount.value = [];
    images.value = [];

    errors.value = [];
    canDisabledCode.value = false;
};

const handCountUpdate = ref([]);
const handleUpdate = (item) => {
    deployment_id.value = item.id;
    isClickDeploymentUpdate.value = true;
    formDeployment.code = item.code;
    formDeployment.title = item.title;
    formDeployment.project_id = item.project_id;
    formDeployment.handover_date = item.handover_date;
    formDeployment.handover_person = item.handover_person;
    formDeployment.receiver = item.receiver;
    formDeployment.status_id = item.status_id;
    formDeployment.note = item.note;

    formDeployment.error_file = item.error_file;
    formDeployment.quantity_file = item.files.length;

    images.value = item.files;
    // console.log(images.value);
    handCountUpdate.value = item.files;

    errors.value = [];
    canDisabledCode.value = true;
};

const updateDeployment = () => {
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
        formData.append("title", formDeployment.title);
        formData.append("project_id", formDeployment.project_id);
        formData.append("handover_date", formDeployment.handover_date);
        formData.append("handover_person", formDeployment.handover_person);
        formData.append("receiver", formDeployment.receiver);
        formData.append("note", formDeployment.note ? formDeployment.note : "");
        formData.append("status_id", formDeployment.status_id);
        KTApp.showPageLoading();
        axios
            .post(
                "/deployment-records/update/" + `${deployment_id.value}`,
                formData
            )
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById("close");
                btn.click();
                getDeployments(searchData);
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
                var errorFile = [];
                Object.entries(errors.value).forEach(([key, val]) => {
                    var keyArr = key.split('.');
                    if(keyArr[0] == "filesArr" && keyArr[1]){
                        errorFile.push('File thứ ' + (parseInt(keyArr[1]) + 1 + formDeployment.quantity_file) + ' ' + val[0]);

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
                    .delete("/deployment-records/destroy/" + id)
                    .then((res) => {
                        useToast.successToast(res.data.message);
                        const totalRecordOnPage =
                            getMetaPaginate.value.pagination.count;
                        if (totalRecordOnPage - 1 === 0) {
                            getMetaPaginate.value.pagination.current_page -= 1;
                        }
                        if (getMetaPaginate.value.pagination.total - 1 === 0) {
                            getDeployments(searchData);
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

const truncateMiddleDeployment = (text, maxLength) => {
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
    getDeployments();
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
.projects-set-deployment .select-box .options-container {
    width: 305px;
}
/* .projects-set-deployment .options-container {
    top: 405px !important;
} */
.handover-person-set .select-box .options-container {
    width: 350px;
}
/* .handover-person-set .options-container {
    top: 115px !important;
} */
.status-set .select-box .options-container {
    width: 198px;
}
/* .status-set .options-container {
    top: 158px !important;
} */
.file-edit-name {
    margin: 5px 0;
}
.file-count-deployment {
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
.file-empty-deployment {
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
