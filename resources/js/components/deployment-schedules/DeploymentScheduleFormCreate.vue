<template>
    <!-- Lịch triển khai -->
     <div
            class="modal fade"
            id="actionCreateDeployment"
            data-bs-keyboard="true"
            data-bs-backdrop="static"
            tabindex="-1"
            aria-hidden="true"
        >
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered max-h-50">
                <!--begin::Modal content-->
                <div class="modal-content rounded" >
                    <!--begin::Modal header-->
                    <div class="modal-header border-0 pb-0">
                        <!--begin::Close-->
                        <h4 class="modal-title">
                            Thêm mới lịch triển khai
                        </h4>
                        <div  @click="closeModalDeploymentSchedule()"
                           class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2"
                            data-bs-dismiss="modal"
                        >
                            <i class="ki-duotone ki-cross fs-1 text-white">
                                <i class="fa-solid fa-xmark fs-3"></i>
                            </i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div
                        class="modal-body pt-0 justify-content-center justify-content-center"
                    >
                        <div class="row col-lg-12 ms-3" >
                            <div class="col-lg-6">
                                <div class="row align-items-center g-3 col-lg-12" style="padding-bottom:17px;">
                                    <div class="col-lg-4">
                                        <label class="fs-6 fw-semibold">
                                            <span class="required text-content text-content"
                                                >Mã lịch triển khai</span
                                            >
                                        </label>
                                    </div>
                                    <div class="col-lg-7">
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Nhập mã lịch triển khai"
                                            v-model="formDeploymentSchedules.deploymentSchedule.data[0].code"
                                            @input="formDeploymentSchedules.deploymentSchedule.data[0].code=textCode($event.target.value)"
                                                        @keyup="validateInput($event)"
                                            :class="{ 'select-custom-valid' :errors? errors['deploymentSchedule.data.0.code']: false}"
                                        />
                                            <div v-if="errors['deploymentSchedule.data.0.code']" class="text-danger pt-2">{{
                                                        errors['deploymentSchedule.data.0.code']?  errors['deploymentSchedule.data.0.code'][0]: ''
                                                    }}</div>
                                    </div>

                                </div>
                                <div class="row g-3 align-items-center col-lg-12" style="padding-bottom:17px;">
                                    <div class="col-lg-4">
                                        <label
                                            class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                        >
                                            <span class="required text-content"
                                                >Tiêu đề lịch triển khai</span
                                            >
                                        </label>

                                    </div>

                                    <div class="col-lg-7">
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Nhập tiêu đề lịch triển khai"
                                            name="target_title"
                                            v-model="formDeploymentSchedules.deploymentSchedule.data[0].title"
                                            :class="{
                                                'input-custom-valid': errors
                                                    ? errors['deploymentSchedule.data.0.title']
                                                    : false,
                                            }"
                                        />
                                        <div v-if="errors['deploymentSchedule.data.0.title']" class="text-danger pt-2">{{
                                                        errors['deploymentSchedule.data.0.title']?   errors['deploymentSchedule.data.0.title'][0]: ''
                                                    }}</div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center col-lg-12" style="padding-bottom:17px;">
                                    <div class="col-lg-4">
                                        <label
                                            class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                        >
                                            <span class="required text-content">Trạng thái</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-7">
                                        <select style="height:29px;" class="form-select"
                                        placeholder="Chọn trạng thái"
                                        :class="{ 'select-custom-valid' :errors? errors['deploymentSchedule.data.0.status_id']: false}"
                                        v-model="formDeploymentSchedules.deploymentSchedule.data[0].status_id" aria-label="Default select example">
                                                  <option :value="null">Chọn</option>
                                                    <option v-for="(
                                                            item, index
                                                        ) in systemStatuses"
                                                        :key="index"
                                                        :value="item.id"
                                                        :disabled="item.status == false"
                                                    >
                                                        {{ item.name }}
                                                    </option>
                                                </select>
                                                <div v-if="errors && errors['deploymentSchedule.data.0.status_id']" class="text-danger pt-2">{{
                                                        errors['deploymentSchedule.data.0.status_id']?  errors['deploymentSchedule.data.0.status_id'][0]: ''
                                                    }}</div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                                    <div class="col-lg-4">
                                        <label
                                            class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                        >
                                            <span class="required text-content"
                                                >Thời gian thực hiện</span
                                            >
                                        </label>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="row g-3 align-items-center col-lg-12">
                                            <div  class="col-lg-6">
                                                    <input type="date"
                                                    :class="{ 'select-custom-valid' :errors? errors['deploymentSchedule.data.0.from_date']: false}"
                                                    class="form-control"
                                                    :max="formDeploymentSchedules.deploymentSchedule.data[0].to_date"
                                                    v-model="formDeploymentSchedules.deploymentSchedule.data[0].from_date">
                                                    <div v-if="errors['deploymentSchedule.data.0.from_date']" class="text-danger pt-2">{{
                                                        errors['deploymentSchedule.data.0.from_date']?  errors['deploymentSchedule.data.0.from_date'][0]: ''
                                                    }}</div>
                                            </div>
                                            <div  class="col-lg-6">
                                                    <input type="date"
                                                    :class="{ 'select-custom-valid' :errors? errors['deploymentSchedule.data.0.to_date']: false}"
                                                    class="form-control"
                                                    :min="formDeploymentSchedules.deploymentSchedule.data[0].from_date"
                                                    v-model="formDeploymentSchedules.deploymentSchedule.data[0].to_date">
                                                    <div v-if="errors['deploymentSchedule.data.0.to_date']" class="text-danger pt-2">{{
                                                        errors['deploymentSchedule.data.0.to_date']?  errors['deploymentSchedule.data.0.to_date'][0]: ''
                                                    }}</div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row g-3 align-items-center col-lg-12" style="padding-bottom:15px;" :style="errors['deploymentSchedule.data.0.project_id']? 'padding-bottom:5px': ''">
                                    <div class="col-lg-4">
                                        <label
                                            class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                        >
                                            <span class="required text-content">Thuộc dự án</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-7">

                                        <select-search-diff
                                            :list-data="projects"
                                            v-model="formDeploymentSchedules.deploymentSchedule.data[0].project_id"
                                            placeholder="Chọn"
                                            :class="{ 'select-custom-valid' :errors?  errors['deploymentSchedule.data.0.project_id']: false}"
                                            key-value="id"
                                            style="border-radius:6px;"
                                            key-display="name"
                                        />
                                        <div v-if="errors['deploymentSchedule.data.0.project_id']" class="text-danger mt-2" >{{
                                                        errors['deploymentSchedule.data.0.project_id']? errors['deploymentSchedule.data.0.project_id'][0] :''
                                                    }}</div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center col-lg-12" style="padding-bottom:17px;"
                                :style="  errors['deploymentSchedule.data.0.project_id']? 'margin-top:1px;': ''">
                                    <div class="col-lg-4">
                                        <label
                                            class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                        >
                                            <span class="required text-content">Loại hợp đồng</span>
                                        </label>
                                    </div>

                                    <div class="col-lg-7">
                                        <select
                                        :class="{ 'select-custom-valid' :errors? errors['deploymentSchedule.data.0.contract_type_id']: false}"
                                            style="height: 29px"
                                            class="form-select"
                                            data-hide-search="true"
                                            data-placeholder="Chọn trạng thái"
                                            name="target_assign"
                                            v-model="formDeploymentSchedules.deploymentSchedule.data[0].contract_type_id"
                                        >
                                            <option :value="null">Chọn</option>
                                            <option v-for="(item,index) in contractTypeLists" :key="index" :value="item.id"
                                            >                {{ item.name }}</option>
                                        </select>
                                        <div v-if="errors['deploymentSchedule.data.0.contract_type_id']" class="text-danger pt-2">{{
                                                        errors['deploymentSchedule.data.0.contract_type_id'] ?
                                                        errors['deploymentSchedule.data.0.contract_type_id'][0]: ''
                                                    }}</div>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                                    <div class="col-lg-4">
                                        <label
                                            class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                        >
                                            <span class="required text-content"
                                                >Ghi chú quan trọng</span
                                            >
                                        </label>
                                    </div>
                                    <div class="col-lg-7">
                                        <textarea style="height:90px;"
                                        :class="{ 'select-custom-valid' :errors? errors['deploymentSchedule.data.0.note']: false}"
                                            type="text"
                                            class="form-control"
                                            placeholder="Nhập mô tả"
                                            name="target_title"
                                            v-model="formDeploymentSchedules.deploymentSchedule.data[0].note"
                                        />
                                        <div v-if="errors['deploymentSchedule.data.0.note']" class="text-danger pt-2">{{
                                                        errors['deploymentSchedule.data.0.note']?
                                                        errors['deploymentSchedule.data.0.note'][0]: ''
                                                    }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="border-top:1.5px solid lightgray;padding-bottom:8px; margin-top:-4px;" ></div>
                        <!-- Chi tiết lịch triển khai theo ngày -->
                        <div class="col-lg-12">
                            <div
                                class="card-header border-0 d-flex justify-content-between align-items-center"
                            >
                                <span class="card-label fw-bold text-content"
                                    >Chi tiết lịch triển khai theo ngày</span
                                >
                                <div class="align-items-center d-flex">
                                    <div @click="addDeploymentScheduleDetailRow()">
                                        <a href="#" class="btn btn-function">
                                            <i class="ki-duotone ki-plus fs-2"></i>Thêm</a
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="card-body py-3">
                                <div class="table-responsive table-scroll-sm text-nowrap" style=" height:31px;min-height: 31vh !important; ">
                                    <table class="table table-row-dashed table-bordered table-data">
                                        <thead>
                                            <tr class="fs-6 text-gray-400">
                                                <th class="w-50px max-w-50px text-center">STT</th>
                                                <th class="w-150px max-w-200px text-center">Ngày</th>
                                                <th style="width:140px;" class="max-w-180px text-center">Ca triển khai</th>
                                                <th class="w-200px max-w-200px text-center">
                                                    Chức năng/sản phẩm
                                                </th>
                                                <th style="width:400px;" class="max-w-400px text-center">Diễn giải</th>
                                                <th style="width:100px;" class="w-auto text-center" colspan="2">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="formDeploymentSchedules.deploymentScheduleDetail.data.length > 0"
                                            v-for="(item, index) in formDeploymentSchedules
                                                .deploymentScheduleDetail.data"
                                            :key="index"
                                            class="max-h-20 overflow-auto cursor-pointer"
                                        >
                                            <tr v-for="(item2, index2) in item" :key="index2">
                                                <td rowspan="3" v-if="item2.shift < 1"
                                                :class="{ 'is-invalid-border-right' : errors['deploymentScheduleDetail.data.' + index + '.' + index2 + '.day']}"
                                                class="text-center text-content">
                                                    {{ index + 1 }}
                                                </td>
                                                <td rowspan="3" v-if="item2.shift < 1"
                                                :class="{ 'is-invalid-border' : errors['deploymentScheduleDetail.data.' + index + '.' + index2 + '.day']}"
                                                :title="errors['deploymentScheduleDetail.data.' + index + '.' + index2 + '.day']?
                                                errors['deploymentScheduleDetail.data.' + index + '.' + index2 + '.day'][0]: ''"
                                                >
                                                    <div>
                                                        <div class="text-center">Ngày {{ index +1 }}</div>
                                                        <hr>
                                                        <input :min="formDeploymentSchedules.deploymentSchedule.data[0].from_date"
                                                            :max="formDeploymentSchedules.deploymentSchedule.data[0].to_date"
                                                        style="background-color: white;"
                                                        v-model="item2.day" @input="selectDay($event,index)" class="text-content text-center" type="date" />
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span>
                                                        {{ item2.shift == 0 ? 'Ca sáng' : item2.shift == 1 ? 'Ca chiều' : 'Ca tối'  }}
                                                    </span>
                                                </td>
                                                <td >
                                                    <input v-model="item2.product_function"
                                                     class="text-content form-control" type="text" />
                                                </td>
                                                <td>
                                                        <input
                                                    v-model="item2.description" :title="item2.description" class="text-content form-control" type="text" />
                                                </td>
                                                <td rowspan="3" v-if="item2.shift < 1" class="text-center">

                                                </td>
                                                <td rowspan="3" v-if="item2.shift < 1" class="text-center">
                                                    <a
                                                        @click="
                                                            removeDeploymentScheduleDetailRow(
                                                                index,
                                                                item
                                                            )
                                                        "
                                                        href="#"
                                                        class="btn btn-icon btn-delete btn-sm"
                                                    >
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody class="max-h-25 overflow-auto cursor-pointer" v-else>
                                                            <tr>
                                                                <td class="text-center" colspan="8">Không có dữ liệu
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div style="border-top:1.5px solid lightgray;padding-bottom:8px;" ></div>
                        <!-- Chuyên viên thực hiện dự án -->
                        <div class="col-lg-12">
                            <div
                                class="card-header border-0 d-flex justify-content-between align-items-center"
                            >
                                <span class="card-label fw-bold text-content">
                                    Chuyên viên thực hiện dự án</span
                                >
                                <div class="align-items-center d-flex">
                                    <div @click="addUserRow()">
                                        <a href="#" class="btn btn-function">
                                            <i class="ki-duotone ki-plus fs-2"></i>Thêm</a
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="card-body py-3">
                                <div class="table-responsive table-scroll-sm text-nowrap"  style="min-height: 26vh !important; height:26px;">
                                    <table class="table table-row-dashed table-bordered table-data">
                                        <thead>
                                            <tr class="fs-6 text-gray-400">
                                                <th class="w-20px max-w-50px">STT</th>
                                                <th class="w-200px max-w-200px">Tên chuyên viên</th>
                                                <th class="w-200px max-w-180px">Số điện thoại</th>
                                                <th class="w-200px max-w-200px">Email</th>
                                                <th class="w-250px max-w-250px">Skype</th>
                                                <th class="w-100px text-center" colspan="2">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody class="max-h-10 overflow-auto cursor-pointer" v-if="formDeploymentSchedules
                                                    .projectImplementer.data.length > 0">
                                            <tr
                                                v-for="(item, index) in formDeploymentSchedules
                                                    .projectImplementer.data"
                                                    :key="index"
                                            >
                                                <td :class="{ 'is-invalid-border-right' : errors['projectImplementer.data.' + index + '.id']}"
                                                class="text-center text-content">
                                                    {{ index + 1 }}
                                                </td>
                                                <td :title="errors['projectImplementer.data.' + index + '.id']"
                                                :class="{ 'is-invalid-border' : errors['projectImplementer.data.' + index + '.id']}">

                                                    <SelectSearchDiffUser
                                                    @changeUser="changeUser"
                                            :list-data="getUsers"
                                                        :disabled="idEdit != index && item.idSave !=0"

                                                        :idSave="item.idSave"
                                                        v-model="item.id"
                                            placeholder="Chọn"
                                            key-value="id"
                                            :indexKey="index"
                                            :class="{ 'select-custom-valid' :errors?  errors['deploymentSchedule.data.0.project_id']: false}"
                                            key-display="name"
                                        />
                                                </td>
                                                <td class="td-background-disabled">
                                                    <input
                                                        :disabled="true"
                                                        class="text-content"
                                                        type="text"
                                                        :value="item.phone"
                                                    />
                                                </td>
                                                <td class="td-background-disabled">
                                                    <input
                                                        class="text-content"
                                                        :disabled="true"
                                                        type="text"
                                                        :value="item.email"
                                                    />
                                                </td>
                                                <td class="td-background-disabled">
                                                    <input
                                                        :disabled="true"
                                                        class="text-content"
                                                        type="text"
                                                        :value="item.skype"
                                                    />
                                                </td>
                                                <td class="text-center w-100px">
                                                    <a href="#" class="btn btn-icon btn-edit btn-sm"
                                                        v-if="idEdit==index && item.idSave !=0" @click="resetIdRowEdit()">
                                                        <i class="fa-solid fa-check fs-5"></i>
                                                    </a>
                                                    <a v-if="idEdit != index && item.idSave !=0" @click="setIdRowEdit(index)" href="#"
                                                        class="btn btn-icon btn-edit btn-sm">
                                                            <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                </td>
                                                <td class="text-center w-100px">
                                                    <a
                                                        @click="removeItemUserRow(index, item)"
                                                        href="#"
                                                        class="btn btn-icon btn-delete btn-sm"
                                                    >
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody class="max-h-25 overflow-auto cursor-pointer" v-else>
                                                            <tr>
                                                                <td class="text-center" colspan="8">Không có dữ liệu
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <!-- Yêu cầu dự án -->
                        <div style="border-top:1.5px solid lightgray;padding-bottom:8px;" ></div>
                        <!-- Chuyên viên thực hiện dự án -->
                        <div class="col-lg-12 mt-3">

                            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                                    <div class="col-lg-4">
                                        <label
                                            class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                        >
                                            <span class="text-content fw-bold"
                                                >Nội dung yêu cầu dự án</span
                                            >
                                        </label>
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea style="height:200px;"
                                            type="text"
                                            class="form-control"
                                            placeholder="Nhập nội dung yêu cầu dự án"
                                            name="target_title"
                                            v-model="formDeploymentSchedules.deploymentSchedule.data[0].project_content"
                                        />

                                    </div>
                                </div>
                        </div>
                    <!-- /body -->
                </div>
                    <!--end::Modal body-->
                     <div class="modal-footer">
                        <!-- them -->
                        <button
                            @click.prevent="
                                    storeDeploymentSchedule()
                            "
                            type="button"
                            class="btn btn-function me-4"
                        >
                        <i class="fa-solid fa-floppy-disk"></i> Ghi lại
                        </button>
                        <button
                                @click="closeModalDeploymentSchedule()"
                                type="button"
                                class="btn btn-secondary btn-sm btn-active-color-light"
                                id="close-modal-deployment-schedule"
                                data-bs-dismiss="modal"
                            >
                                <i class="fa-solid fa-xmark"></i>Đóng
                        </button>
                </div>
                            </div>
                            <!--end::Modal content-->
                        </div>
            <!--end::Modal dialog-->
        </div>
</template>

<script setup>
import {
    computed,
    onBeforeMount,
    onMounted,
    ref,
    watch,
    reactive,
    toRefs,
    defineEmits
} from "vue";
import { useUsers } from "../../stores/user";
import { storeToRefs } from "pinia";
import { useToast } from "../../helper/toastMessage.js";
import { useStoreProjects } from '../../stores/project'
import { helperFunc } from '../../helper/heplerFunction'
import { textCode, validateInput } from '../../../services/utils';
import moment from "moment";
import SelectSearchDiff from '../input/SelectSearchDiff.vue'
import SelectSearchDiffUser from '../input/SelectSearchDiff2.vue'
import { useSystemStatusStore } from "../../stores/status";

const props = defineProps({
    contractTypeLists: {
        type: Array,
        default: []
    },
    deploymentScheduleUpdate: {
        type: Object,
        default: function() {
            return  {
                code: "",
                title: "",
                status: 1,
                from_date: "",
                to_date: "",
                project_id: null,
                contract_type_id: null,
                note: ""
            }
        }
    },
});

const systemStatusStore = useSystemStatusStore();
const systemStatuses = computed(() => {
    // return systemStatusStore.$state.statuses.data ?? [];
    return systemStatusStore.getStatusesByDeploymentSchedules;
});

const projectStore = useStoreProjects();
const projects = computed(() => {
    return projectStore.projectNew;
})
const errors = ref([])

const storeUser = useUsers();

onBeforeMount(() => {
    projectStore.getAllProjectsData({getAll:true});
    storeUser.getUsersData({ getAll: true });
    systemStatusStore.getSystemStatusData();
});

const getUsers = computed(() => {
    return storeUser.users.data;
});

const emit = defineEmits([
    'storeDeploymentSchedule',
]);
// Lịch triển khai
const formDeploymentSchedules = reactive({
    deploymentSchedule: {
        data: [
            {
                code: "",
                title: "",
                status_id: null,
                from_date: "",
                to_date: "",
                project_id: null,
                contract_type_id: null,
                note: "",
                project_content: null
            }
        ],
    },
    projectImplementer: {
        data: [],
    },
    deploymentScheduleDetail: {
        data: [],
    },
    destroyDeployDetailIds: []
});

// Chuyên viên thực hiện
const addUserRow = () => {
    formDeploymentSchedules.projectImplementer.data.push({
        id: null,
        idSave: 0, // id thêm mới chưa lưu vì khi chọn user thì id !=0
        code: "",
        name: "",
        phone: "",
        email: "",
        skype: "",
    });
};
const removeItemUserRow = (key, item) => {
    formDeploymentSchedules.projectImplementer.data.splice(key, 1);
};
// Chi tiết lịch triển khai
const addDeploymentScheduleDetailRow = () => {
    formDeploymentSchedules.deploymentScheduleDetail.data.push([
        {
            id: 0,
            idSave: 0,
            shift: 0,
            day: "",
            product_function: "",
            description: "",
        },
        {
            id: 0,
            idSave: 0,
            shift: 1,
            day: "",
            product_function: "",
            description: "",
        },
        {
            id: 0,
            idSave: 0,
            shift: 2,
            day: "",
            product_function: "",
            description: "",
        },
    ]);
};
const removeDeploymentScheduleDetailRow = (key, item) => {
    formDeploymentSchedules.deploymentScheduleDetail.data.splice(key, 1);
};
const { getUserById } = storeToRefs(storeUser);

const idEdit = ref(-1);
const idSave = ref(0);
const changeUser =(userNew, userIdRoot, index , idSaveOfUser) => {
    idEdit.value = index;
    // id chưa save
    let user = getUserById.value(userIdRoot);
    console.log(idSaveOfUser,'save day');
    if(user && user.idSave != 0 && idSaveOfUser != 0) {
        // console.log(userRoot,userNew, 'idsave')
        idSave.value = user.idSave;
        console.log("chajy khong")
    }
    // console.log(optionId)
    if(userNew == null) {
          formDeploymentSchedules.projectImplementer.data[index] = {
            id: userIdRoot,
            idSave: 0,
            phone: "",
            email: "",
            skype: ""
          }
    }else {
        formDeploymentSchedules.projectImplementer.data[index] = {
            id: userNew.id,
            idSave: idSave.value,
            phone: userNew.phone,
            email: userNew.email,
            skype:userNew.skype
        }
    }
}
// Đồng bộ ngày
const selectDay =(event, index) => {
    let date = event.target.value;
     formDeploymentSchedules.deploymentScheduleDetail.data[index].forEach((item) => {
        item.day = date;
        return item;
     })
}
const resetKeyObjectAboutNumber = (data) => {
    // Lấy một mảng các khóa của đối tượng
    let keys = Object.keys(data);
    // Tạo một biến để lưu khóa mới
    let newKey = 0;

    // Duyệt qua mảng khóa
    for (let i = 0; i < keys.length; i++) {
    // Lấy khóa cũ từ mảng keys
    let oldKey = keys[i];

    // Lấy giá trị của khóa cũ từ đối tượng
    let value = data[oldKey];

    // Định nghĩa thuộc tính mới với khóa mới và giá trị cũ
    Object.defineProperty(data, newKey, {
        value: value,
        writable: true,
        enumerable: true,
        configurable: true
    });

    // Xóa thuộc tính của khóa cũ
    delete data[oldKey];

    // Tăng khóa mới lên
    newKey++;
    }
    return data;
}

const resetData = () => {
    formDeploymentSchedules.deploymentSchedule.data[0].code = "";
        formDeploymentSchedules.deploymentSchedule.data[0].title = "";
        formDeploymentSchedules.deploymentSchedule.data[0].from_date = null;
        formDeploymentSchedules.deploymentSchedule.data[0].to_date = null;
        formDeploymentSchedules.deploymentSchedule.data[0].note = "";
        formDeploymentSchedules.deploymentSchedule.data[0].project_content = "";
        formDeploymentSchedules.deploymentSchedule.data[0].project_id = null;
        formDeploymentSchedules.deploymentSchedule.data[0].contract_type_id = null;
        formDeploymentSchedules.deploymentSchedule.data[0].status_id = null;
        formDeploymentSchedules.projectImplementer.data = []
          formDeploymentSchedules.projectImplementer.data = []

    formDeploymentSchedules.deploymentScheduleDetail.data = []
    formDeploymentSchedules.deploymentScheduleDetail.data = [];

    return true;
};

const storeDeploymentSchedule = () => {
    KTApp.showPageLoading();
    axios
        .post("/deployment-schedule/store", formDeploymentSchedules)
        .then((res) => {
            const { message } = res.data;
            errors.value = [];
            // resetData();
            const btnClick = document.getElementById('close-modal-deployment-schedule');
            btnClick.click();
            useToast.successToast(message);
            emit('storeDeploymentSchedule')
        })
        .catch((error) => {
            errors.value = error.response.data?.errors;
             if ( errors.value) {
                    useToast.errorToast('Dữ liệu không đúng. Vui lòng kiểm tra lại.')
                }
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};

const closeModalDeploymentSchedule = (value = false) => {
    errors.value = [];
     resetData(false);
};


</script>

<style scoped>
.input-custom-valid {
    border: 1px solid red !important;
}
.select-custom-valid {
    border: 1px solid red !important;
}
tr td.td-background-disabled {
    background-color: #e0e4ec;
}
.is-invalid-border-right {
    border-right: 1px solid red !important;
}
.is-invalid-border {
    border: 1px solid red !important;
}
#myInput {
  /* background-image: url('https://www.w3schools.com/css/searchicon.png'); */
  background-position: 10px 12px;
  background-repeat: no-repeat;
  width: 100%;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myUL {
  list-style-type: none;
  padding: 0;
  margin: 0;
  border-bottom: 1px solid #ddd;

}

#myUL li{
  border: 1px solid #ddd;
  margin-top: -1px; /* Prevent double borders */
  background-color: white;
  padding: 10px;
  cursor: pointer;
  text-decoration: none;
  font-size: 13px;
  color: black;
  display: block;
  white-space: nowrap;
}
#myUL li:hover {
    background:lightblue;
}
#active-project {
    background:lightblue;
}
</style>
