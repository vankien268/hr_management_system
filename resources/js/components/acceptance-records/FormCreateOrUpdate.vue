<template>
    <div
        class="modal"
        tabindex="-1"
        :id="idModal"
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
                             isClickAcceptanceUpdate && disabledEditAcceptanceFromNotification?
                                'Thông tin chi tiết biên bản nghiệm thu' :
                                 isClickAcceptanceUpdate? "Cập nhật biên bản nghiệm thu"
                                : "Thêm biên bản nghiệm thu"
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
                                        >Mã biên bản nghiệm thu</label
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
                                        v-model="formAcceptance.code"
                                        @input="
                                            formAcceptance.code = textCode(
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
                                        >Tiêu đề biên bản nghiệm thu</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input :disabled="disabledEditAcceptanceFromNotification"
                                        type="text"
                                        class="form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid': errors.title,
                                        }"
                                        id="taxCode"
                                        v-model="formAcceptance.title"
                                    />
                                    <base-validation :message="errors.title" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        for="created_at"
                                        class="required col-form-label"
                                        >Ngày gửi</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input :disabled="disabledEditAcceptanceFromNotification"
                                        type="date"
                                        class="form-control mb-lg-0 p-2"
                                        id="fromDate"
                                        placeholder=""
                                        v-model="formAcceptance.sent_date"
                                    />
                                    <base-validation
                                        :message="errors.sent_date"
                                    />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        for="name"
                                        class="required col-form-label"
                                        >Người gửi</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input :disabled="disabledEditAcceptanceFromNotification"
                                        type="text"
                                        class="form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid': errors.sender,
                                        }"
                                        v-model="formAcceptance.sender"
                                        id="name"
                                    />
                                    <base-validation :message="errors.sender" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label
                                        for="inputPassword6"
                                        class="col-form-label"
                                        >Ghi chú</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <textarea :disabled="disabledEditAcceptanceFromNotification"
                                        class="form-control form-control-solid"
                                        placeholder="Ghi chú khách hàng"
                                        :class="{
                                            'input-custom-valid': errors.note,
                                        }"
                                        v-model="formAcceptance.note"
                                        rows="3"
                                    ></textarea>
                                    <base-validation :message="errors.note" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 projects-set-acceptance">
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
                                    <SelectSearch :disabled="disabledEditAcceptanceFromNotification"
                                        :list-data="getProjectsOfUser"
                                        v-model="formAcceptance.project_id"
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
                                    <select :disabled="disabledEditAcceptanceFromNotification"
                                        class="form-select"
                                        :class="{
                                            'select-custom-valid':
                                                errors.status_id,
                                        }"
                                        data-placeholder="Chọn trạng thái"
                                        v-model="formAcceptance.status_id"
                                        aria-label="Default select example"
                                    >
                                        <option value="">--Chọn---</option>
                                        <option
                                            v-for="(
                                                item, index
                                            ) in systemStatusesAcceptanceNotification"
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
                                        for="created_at"
                                        class="required col-form-label"
                                        >Ngày nghiệm thu</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input :disabled="disabledEditAcceptanceFromNotification"
                                        type="date"
                                        class="form-control mb-lg-0 p-2"
                                        id="fromDate"
                                        placeholder=""
                                        v-model="formAcceptance.acceptance_date"
                                    />
                                    <base-validation
                                        :message="errors.acceptance_date"
                                    />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label
                                        for="representative"
                                        class="required col-form-label"
                                        >Người nhận</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input :disabled="disabledEditAcceptanceFromNotification"
                                        type="text"
                                        class="required form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid':
                                                errors.receiver,
                                        }"
                                        v-model="formAcceptance.receiver"
                                    />
                                    <base-validation
                                        :message="errors.receiver"
                                    />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label
                                        for="representative"
                                        class="required col-form-label"
                                        >Thời gian bảo hành</label
                                    >
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input :disabled="disabledEditAcceptanceFromNotification"
                                        type="text"
                                        class="required form-control mb-lg-0 p-2"
                                        :class="{
                                            'input-custom-valid':
                                                errors.warranty_period,
                                        }"
                                        v-model="formAcceptance.warranty_period"
                                        @input="setupRate($event)"
                                        @keyup="validateInput($event)"
                                    />
                                    <base-validation
                                        :message="errors.warranty_period"
                                    />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4"></div>
                                <!-- isClickAcceptanceUpdate -->
                                <div class="col-lg-7">
                                    <input :disabled="disabledEditAcceptanceFromNotification"
                                        style="font-size: 13px; display: none"

                                        multiple
                                        type="file"
                                        @change="onFileChange"
                                    />
                                    <div class="col-lg-12 row">
                                        <span class="col-3">
                                            <label
                                                class="form-control"
                                                :for="disabledEditAcceptanceFromNotification? 'input-length' :''"
                                                >Chọn
                                            </label>
                                        </span>
                                        <span
                                            :class="
                                                isClickAcceptanceUpdate
                                                    ? 'd-none'
                                                    : fileCount?.length > 0
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
                                                fileCount?.length > 0
                                                    ? ""
                                                    : "Không có tệp được chọn"
                                            }}
                                        </span>
                                        <span
                                            :class="
                                                isClickAcceptanceUpdate
                                                    ? 'd-none'
                                                    : ''
                                            "
                                            v-if="fileCount?.length > 0"
                                            class="col-9"
                                            style="
                                                height: 20px;
                                                line-height: 25px;
                                            "
                                        >
                                            {{ fileCount?.length }} Tệp
                                        </span>
                                        <div
                                            :class="
                                                isClickAcceptanceUpdate
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
                                                isClickAcceptanceUpdate
                                                    ? handCountUpdate?.length > 0
                                                        ? handCountUpdate?.length +
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
                                            <button v-if="!disabledEditAcceptanceFromNotification"
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
                                                    truncateMiddleAcceptance(
                                                        image.name,
                                                        30
                                                    )
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="border-top: none">
                    <button v-if="disabledEditAcceptanceFromNotification != true"
                        type="button"
                        class="btn btn-function me-4"
                        @click.prevent="
                            isClickAcceptanceUpdate
                                ? updateAcceptance()
                                : storeAcceptance()
                        "
                    >
                        <i class="fa-solid fa-floppy-disk"></i> Lưu
                    </button>
                    <button
                        type="button"
                        :class="disabledEditAcceptanceFromNotification != true? 'btn btn-secondary btn-sm btn-active-color-light':'btn btn-function me-4'"
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
    requesturl: {
        type: Object,
        default: {},
    },
    acceptanceId: {
        type: Number
    },
     disabledEditAcceptanceFromNotification: {
        type: Boolean,
        default:false
    },
    idModal: {
        type: String
    }
});

const systemStatusStoreAcceptanceNotification = useSystemStatusStore();

const systemStatusesAcceptanceNotification = computed(() => {
    return systemStatusStoreAcceptanceNotification.getStatusesByAcceptance;
});

const project = ref("");
const sender = ref("");
const receiver = ref("");
const from_date = ref("");
const status_id = ref("");
const to_date = ref("");

const searchData = reactive({
    project: "",
    sender: "",
    receiver: "",
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
    searchData.from_date = from_date.value;
    searchData.status_id = status_id.value;
    searchData.to_date = to_date.value;
    pagination.value.current_page = 1;
};

const formAcceptance = reactive({
    code: "",
    title: "",
    project_id: "",
    sent_date: "",
    acceptance_date: "",
    sender: "",
    receiver: "",
    warranty_period: "",
    note: "",
    status_id: "",
    file: null,
    error_file: "",
    file_length: 0,
});
// handle chọn số bản ghi / 1 trang
const currentIndex = ref(-1);

let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};
const acceptances = ref([]);
const projects = ref([]);
const systemStatus = ref([]);
let getMetaPaginate = ref({});
const dataShowRecord = ref({});
const showAcceptanceRecord = (id) => {
     KTApp.showPageLoading();
    return axios({
        url: "/acceptance-records/show/" + id,
        method: "GET",
    })
        .then((res) => {
            const { acceptanceRecord } = res.data;
            dataShowRecord.value = acceptanceRecord;
        })
        .catch((error) => {
            console.log(error);
        }).finally(() => {
            KTApp.hidePageLoading();
        });
};

watch(() => props.acceptanceId, (newValue, oldValue) => {
    if(newValue) {
        showAcceptanceRecord(newValue).then(() => {
                    handleUpdate(dataShowRecord.value);
                }).catch((error) => {
            console.log(error);
        });
    }
})

const getProjects = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/acceptance-records/get-projects",
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
const projectStore = useStoreProjects();
// Dự án có quyền
const getProjectsOfUser = computed(() => {
    if (projectStore.$state.projects.data) {
        return projectStore.$state.projects.data;
    } else {
        return projectStore.$state.projects;
    }
});


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

};

onMounted(() => {
    getProjects();
    systemStatusStoreAcceptanceNotification.getSystemStatusData();
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

let acceptance_id = ref(0);
let canDisabledCode = ref(false);
let isClickAcceptanceUpdate = ref(false);
const files = ref([]);

const handCountUpdate = ref([]);
const handleUpdate = (item) => {
    acceptance_id.value = item.id;
    isClickAcceptanceUpdate.value = true;
    formAcceptance.code = item.code;
    formAcceptance.title = item.title;
    formAcceptance.project_id = item.project_id;
    formAcceptance.sent_date = item.sent_date;
    formAcceptance.acceptance_date = item.acceptance_date;
    formAcceptance.sender = item.sender;
    formAcceptance.receiver = item.receiver;
    formAcceptance.warranty_period = item.warranty_period;
    formAcceptance.status_id = item.status_id;
    formAcceptance.note = item.note;
    formAcceptance.error_file = item.error_file;

    images.value = item.files;
    handCountUpdate.value = item.files;

    errors.value = [];
    canDisabledCode.value = true;
};

const clickCreateAcceptance = () => {
    isClickAcceptanceUpdate.value = false;
    formAcceptance.code = "";
    formAcceptance.title = "";
    formAcceptance.project_id = "";
    formAcceptance.sent_date = "";
    formAcceptance.acceptance_date = "";
    formAcceptance.sender = "";
    formAcceptance.receiver = "";
    formAcceptance.warranty_period = "";
    formAcceptance.note = "";
    formAcceptance.status_id = "";
    formAcceptance.error_file = "";
    errors.value = [];
    canDisabledCode.value = false;
};
const updateAcceptance = () => {
    isRequestParams.value = true;
    let formData = new FormData();
    const inputFiles = document.getElementById("files");
    const errorFile = document.getElementById("error-file");
    let maxFileSize = 5 * 1024 * 1024;
    let valid = true;

    for (let i = 0; i < inputFiles.files.length; i++) {
        let fileSize = inputFiles.files[i].size;
        if (fileSize > maxFileSize) {
            valid = false;
            break;
        }
        formData.append("filesArr[]", inputFiles.files[i]);
    }
    if (valid) {
        formData.append("title", formAcceptance.title);
        formData.append("project_id", formAcceptance.project_id);
        formData.append("sent_date", formAcceptance.sent_date);
        formData.append("acceptance_date", formAcceptance.acceptance_date);
        formData.append("sender", formAcceptance.sender);
        formData.append("receiver", formAcceptance.receiver);
        formData.append("warranty_period", formAcceptance.warranty_period);
        formData.append("note", formAcceptance.note ? formAcceptance.note : "");
        formData.append("status_id", formAcceptance.status_id);
        KTApp.showPageLoading();
        axios
            .post(
                "/acceptance-records/update/" + `${acceptance_id.value}`,
                formData
            )
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById("close");
                btn.click();

            })
            .catch((error) => {
                errors.value = error.response.data.errors;
            })
            .finally(() => {
                KTApp.hidePageLoading();
            });
    } else {
        errorFile.textContent = "Vui lòng chọn tệp nhỏ hơn 5MB.";
        // exit the function;
    }
};
const emits = defineEmits(['updateAcceptanceId'])
const setupRate = (event) => {
    if (isNaN(event.target.value)) {
        formAcceptance.warranty_period = 0;
        return;
    }
    formAcceptance.warranty_period = textCode(event.target.value);
};

// const closeModal = () => {
//     // if(props.acceptanceId) {
//     //    emits('updateAcceptanceId')
//     //    clickCreateAcceptance();
//     // }
//     $("#files").val("");
//     const inputFiles = document.getElementById("files");
//     const output = document.getElementById("file-name");
//     const errorFile = document.getElementById("error-file");
//     inputFiles.value = "";
//     output.textContent = "";
//     errorFile.textContent = "";
//     currentIndex.value = -1;
// };
const closeModal = () => {
    // images.value = [];
    // fileCount.value = [];
    // fileDeletes.value = [];
    // // Reset lại thông báo lỗi
    // errorMessage.value = "";
    // currentIndex.value = -1;
};
const truncateMiddleAcceptance = (text, maxLength) => {
    if (text.length <= maxLength) {
        return text;
    }
    var start = Math.ceil(maxLength / 2);
    var end = Math.floor(maxLength / 2);
    return text.slice(0, start) + "..." + text.slice(-end);
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
.projects-set-acceptance .select-box .options-container {
    width: 305px;
}

/* .projects-set-acceptance .options-container {
    top: 257px !important;
} */
.status-acc-set .select-box .options-container {
    width: 148px;
}
/* .status-acc-set .options-container {
    top: 112px !important;
} */
.file-edit-name {
    margin: 5px 0;

}
.file-count-acceptance {

    margin-top: -7px;
    font-size: 13px;
    border: 1px solid rgb(196, 196, 196);
    border-radius: 0 5px 5px 0;
    padding: 7px 184px 5px 6px;
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
.file-empty-acceptance {
    margin-top: -7px;
    font-size: 13px;
    border: 1px solid rgb(196, 196, 196);
    border-radius: 0 5px 5px 0;
    padding: 6px 184px 6px 6px;
    /* line-height: 10px; */
    width: 100px !important;
    border-left: none;
    /* font-weight: 500; */
    display: none;

}
</style>
