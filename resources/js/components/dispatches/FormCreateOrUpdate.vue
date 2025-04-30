<template>
   <div
        class="modal"
        tabindex="-1"
        :id="idModal"
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
                            isClickDispatchUpdate && disabledEditDispatchFromNotification?
                                'Thông tin chi tiết công văn, thông báo' :
                                 isClickDispatchUpdate? "Cập nhật công văn, thông báo"
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
                                    <input :disabled="disabledEditDispatchFromNotification"
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
                                    <SelectSearch :disabled="disabledEditDispatchFromNotification"
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
                                    <input :disabled="disabledEditDispatchFromNotification"
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
                                    <textarea :disabled="disabledEditDispatchFromNotification"
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
                                        :disabled="disabledEditDispatchFromNotification"
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
                                    <input :disabled="disabledEditDispatchFromNotification"
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
                                    <input :disabled="disabledEditDispatchFromNotification"
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
                                    <input :disabled="disabledEditDispatchFromNotification"
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
                                               :for="!disabledEditDispatchFromNotification? 'input-length' :''"
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
                                            <button v-if="!disabledEditDispatchFromNotification"
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
                                    <select :disabled="disabledEditDispatchFromNotification"
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
                                    <input :disabled="disabledEditDispatchFromNotification"
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
                                    <select :disabled="disabledEditDispatchFromNotification"
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
                                            ) in systemStatusesDispatchNotification"
                                            :key="index"
                                            :value="item.id"

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
                                    <span :style="disabledEditDispatchFromNotification? 'background-color: #e0e4ec' :''"
                                        class="form-control"
                                        style="height: 28px"
                                        >{{
                                            customer ? customer.name : ""
                                        }}</span
                                    >
                                    <!-- <SelectSearch
                                        disabled
                                        :list-data="customers"
                                        v-model="formDispatch.customer_id"
                                        placeholder="--Chọn--"
                                        key-value="id"
                                        key-display="name"
                                    /> -->
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
                                    <input :disabled="disabledEditDispatchFromNotification"
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
                                    <textarea :disabled="disabledEditDispatchFromNotification"
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
                                    <input :disabled="disabledEditDispatchFromNotification"
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
                                    <input :disabled="disabledEditDispatchFromNotification"
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
                    <button v-if="disabledEditDispatchFromNotification !=true"
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
                        :class="disabledEditDispatchFromNotification != true? 'btn btn-secondary btn-sm btn-active-color-light':'btn btn-function me-4'"
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
import { storeToRefs } from "pinia";
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
    dispatchId: {
        type: Object
    },
    disabledEditDispatchFromNotification: {
        type: Boolean,
        default:false
    },
    idModal: {
        type: String
    }
});

const systemStatusStoreDispatchNotification = useSystemStatusStore();

const systemStatusesDispatchNotification = computed(() => {
    return systemStatusStoreDispatchNotification.getStatusesByDispatch;
});

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
});

let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};

const dispatches = ref([]);
const projects = ref([]);
const customers = ref([]);
const systemStatus = ref([]);

const showDispatch = (dispatchId) => {
    KTApp.showPageLoading();
    axios({
        url: "/dispatches/show/" +dispatchId,
        method: "GET",
    })
        .then((res) => {
            const { data } = res.data;
            handleUpdate(data)
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};
watch(() => props.dispatchId, (newValue, oldValue) => {
    if(newValue != null) {
        showDispatch(newValue)
    }
})
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
        // console.log("watch", formDispatch.project_id, projects.value);
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
    getProjectsCustomers();
     systemStatusStoreDispatchNotification.getSystemStatusData();
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

let dispatch_id = ref(0);
let canDisabledCode = ref(false);
let isClickDispatchUpdate = ref(false);

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

    images.value = item.files;
    handCountUpdate.value = item.files;

    errors.value = [];
    canDisabledCode.value = true;
};
// const updateDispatch = () => {
//     isRequestParams.value = true;
//     if (props.requestparams?.code) {
//         searchData.project = props.requestparams?.code;
//     }
//     let formData = new FormData();
//     const inputFiles = document.getElementById("files");
//     const errorFile = document.getElementById("error-file");
//     let maxFileSize = 5 * 1024 * 1024;
//     let valid = true;
//     for (let i = 0; i < inputFiles.files.length; i++) {
//         let fileSize = inputFiles.files[i].size;
//         if (fileSize > maxFileSize) {
//             valid = false;
//             break;
//         }
//         formData.append("filesArr[]", inputFiles.files[i]);
//     }
//     if (valid) {
//         formData.append("code", formDispatch.code);
//     formData.append("name", formDispatch.name);
//     formData.append("type", formDispatch.type);
//     formData.append("date", formDispatch.date);
//     formData.append("number", formDispatch.number);
//     formData.append("project_id", formDispatch.project_id);
//     formData.append("customer_id", formDispatch.customer_id);
//     formData.append("content", formDispatch.content);
//     formData.append("sender", formDispatch.sender);
//     formData.append("receiver", formDispatch.receiver);
//     formData.append("from_date", formDispatch.from_date);
//     formData.append("to_date", formDispatch.to_date);
//     formData.append("note", formDispatch.note ? formDispatch.note : "");
//     formData.append("status_id", formDispatch.status_id);
//     KTApp.showPageLoading();
//     axios
//         .post("/dispatches/update/" + `${dispatch_id.value}`, formData)
//         .then((res) => {
//             useToast.successToast(res.data.message);
//             const btn = document.getElementById("close");
//             btn.click();
//         })
//         .catch((error) => {
//             errors.value = error.response.data.errors;
//         })
//         .finally(() => {
//             KTApp.hidePageLoading();
//         });
//     } else {
//         errorFile.textContent = "Vui lòng chọn tệp nhỏ hơn 5MB.";
//         // exit the function;
//     }

// };
const truncateMiddleDispatch = (text, maxLength) => {
    if (text.length <= maxLength) {
        return text;
    }
    var start = Math.ceil(maxLength / 2);
    var end = Math.floor(maxLength / 2);
    return text.slice(0, start) + "..." + text.slice(-end);
};
// const closeModal = () => {
//     $("#files").val("");
//     const inputFiles = document.getElementById("files");
//     const output = document.getElementById("file-name");
//     const errorFile = document.getElementById("error-file");
//     inputFiles.value = "";
//     output.textContent = "";
//     errorFile.textContent = "";
// };

const closeModal = () => {
    // // images.value = [];
    // fileCount.value = [];
    // fileDeletes.value = [];
    // // Reset lại thông báo lỗi
    // errorMessage.value = "";
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
/* .projects-set-dispatch .options-container {
    top: 232px!important;
} */
.customers-set-dispatch .select-box .options-container {
    width: 305px;
}
/* .customers-set-dispatch .options-container {
    top: 232px!important;
} */
.customers-set-dispatch .box:disabled {
    property: value;
}
.customer-set .selected {
    padding: 16px 24px 16px 8px !important;
}
/* .status-dis-set .select-box .options-container{
    top: 113px!important;
} */
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
    color: #5E6278;
}
.sel-but-file {
    width: 79px;
    height: 30px;
    background-color: #ffffff;
    color: #5E6278;
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
.file-empty-dispatch{
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
