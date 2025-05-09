<template>
    <div class="row col-lg-12 ms-3">
        <div class="col-lg-6">
            <div class="row align-items-center g-3 col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label class="fs-6 fw-semibold">
                        <span class="required text-content text-content"
                            >Ngày tạo</span
                        >
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        type="text"
                        class="form-control"
                        disabled="disabled"
                        :value="
                            !editProjectModal
                                ? moment().format('DD/MM/YYYY')
                                : getDataUpdate.created_at
                        "
                    />
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="required text-content">Mã dự án</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        v-model="formProject.project.data[0].code"
                        type="text"
                        class="form-control"
                        placeholder="Nhập mã dự án"
                        name="target_title"
                        :disabled="editProjectModal"
                        @input="
                            formProject.project.data[0].code =
                                $event.target.value.toUpperCase()
                        "
                        @keyup="validateInput($event)"
                        :class="{
                            'input-custom-valid': errors
                                ? errors['project.data.0.code']
                                : false,
                        }"
                    />
                    <div class="w-100"></div>
                    <div
                        v-if="errors ? errors['project.data.0.code'] : false"
                        class="text-danger pt-2"
                    >
                        {{ errors["project.data.0.code"][0] }}
                    </div>
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="required text-content">Tên dự án</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        v-model="formProject.project.data[0].name"
                        type="text"
                        class="form-control"
                        placeholder="Nhập mã dự án"
                        name="target_title"
                        :class="{
                            'input-custom-valid': errors['project.data.0.name'],
                        }"
                    />
                    <div
                        v-if="errors['project.data.0.name']"
                        class="text-danger pt-3"
                    >
                        {{ errors["project.data.0.name"][0] }}
                    </div>
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="required text-content">Khách hàng</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <!-- <select
                        style="height: 29px"
                        :class="{
                            'select-custom-valid':
                                errors['project.data.0.customer_id'],
                        }"
                        v-model="formProject.project.data[0].customer_id"
                        class="form-select"
                        data-hide-search="true"
                        data-placeholder="Select a Team Member"
                        name="target_assign"
                    >
                        <option :value="null">Chọn khách hàng</option>
                        <option
                            v-for="(item, index) in getCustomers"
                            :key="index"
                            :value="item.id"
                        >
                            {{ item.name }}
                        </option>
                    </select> -->
                     <span v-if="customerChange < 0"></span>
                    <SelectSearch
                        :class="{
                            'select-custom-valid':
                                errors['project.data.0.customer_id'],
                        }"
                        style="height: 30px;border-radius:8px;"
                        :list-data="customers"
                        v-model="formProject.project.data[0].customer_id"
                        @changDataSelect="changeDataSelectCustomer"
                        placeholder="Chọn khách hàng"
                        key-value="id"
                        key-display="name"
                    />
                    <div
                        v-if="errors['project.data.0.customer_id']"
                        class="text-danger pt-2"
                    >
                        {{ errors["project.data.0.customer_id"][0] }}
                    </div>
                </div>
            </div>
            <!-- đại diện phía khách hàng -->
            <div
                style="border-top: 1px solid lightgrey; width: 90%"
                class="mb-4"
            ></div>
            <div class="fw-semibold mb-6 text-content">
                Đại diện phía khách hàng (Người liên hệ)
            </div>

            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="required text-content">Họ và tên</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        v-model="formProject.contact.data[0].name"
                        type="text"
                        class="form-control"
                        placeholder="Nhập họ và tên"
                        name="target_title"
                        :class="{
                            'input-custom-valid': errors['contact.data.0.name'],
                        }"
                    />
                    <div
                        v-if="errors['contact.data.0.name']"
                        class="text-danger pt-2"
                    >
                        {{ errors["contact.data.0.name"][0] }}
                    </div>
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="required text-content">Số điện thoại</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        type="text"
                        v-model="formProject.contact.data[0].phone"
                        class="form-control"
                        placeholder="Nhập số điện thoại"
                        name="target_title"
                        :class="{
                            'input-custom-valid':
                                errors['contact.data.0.phone'],
                        }"
                    />
                    <div
                        v-if="errors['contact.data.0.phone']"
                        class="text-danger pt-2"
                    >
                        {{ errors["contact.data.0.phone"][0] }}
                    </div>
                </div>
            </div>
            <div class="row align-items-center col-lg-12 g-3 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="required text-content">Email</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        type="text"
                        v-model="formProject.contact.data[0].email"
                        class="form-control"
                        placeholder="Nhập email"
                        name="target_title"
                        :class="{
                            'input-custom-valid':
                                errors['contact.data.0.email'],
                        }"
                    />
                    <div
                        v-if="errors['contact.data.0.email']"
                        class="text-danger pt-2"
                    >
                        {{ errors["contact.data.0.email"][0] }}
                    </div>
                </div>
            </div>

            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="required text-content">Chức vụ</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        type="text"
                        v-model="formProject.contact.data[0].position"
                        class="form-control"
                        placeholder="Nhập chức vụ"
                        name="target_title"
                        :class="{
                            'input-custom-valid':
                                errors['contact.data.0.position'],
                        }"
                    />
                    <div
                        v-if="errors['contact.data.0.position']"
                        class="text-danger pt-2"
                    >
                        {{ errors["contact.data.0.position"][0] }}
                    </div>
                </div>
            </div>

            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="required text-content">Trạng thái</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <select
                        style="height: 29px"
                        class="form-select"
                        :class="{
                            'select-custom-valid':
                                errors['contact.data.0.status'],
                        }"
                        placeholder="Chọn trạng thái"
                        v-model="formProject.contact.data[0].status"
                        aria-label="Default select example"
                    >
                        <option value="1">Hoạt động</option>
                        <option value="0">Ngừng hoạt động</option>
                    </select>
                    <div
                        v-if="errors['contact.data.0.status']"
                        class="text-danger pt-2"
                    >
                        {{ errors["contact.data.0.status"][0] }}
                    </div>
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span>Ghi chú</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        v-model="formProject.contact.data[0].note"
                        type="text"
                        class="form-control"
                        placeholder="Nhập ghi chú"
                        name="target_title"
                        :class="{
                            'input-custom-valid': errors['contact.data.0.note'],
                        }"
                    />
                    <div
                        v-if="errors['contact.data.0.note']"
                        class="text-danger pt-2"
                    >
                        {{ errors["contact.data.0.note"][0] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="required text-content">Khu vực</span>
                    </label>
                </div>

                <div class="col-lg-8">
                    <span v-if="cityChange < 0" ></span>
                    <SelectSearch
                        :class="{
                            'select-custom-valid':
                                errors['project.data.0.city_id'],
                        }"
                        style="height: 30px;border-radius:8px;"
                        :list-data="getCities"
                        v-model="formProject.project.data[0].city_id"
                        placeholder="Chọn khu vực"
                        @changDataSelect="changeDataSelectCity"
                        key-value="id"
                        key-display="name"
                    />
                    <div
                        v-if="errors['project.data.0.city_id']"
                        class="text-danger pt-2"
                    >
                        {{ errors["project.data.0.city_id"][0] }}
                    </div>
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="required text-content"
                            >Phân loại dự án</span
                        >
                    </label>
                </div>

                <div class="col-lg-8">
                    <span v-if="projectTypeChange < 0"></span>
                    <SelectSearch
                        muiltiple
                        :class="{
                            'select-custom-valid':
                                errors['project.data.0.project_type_id'],
                        }"
                        v-model="formProject.project.data[0].project_type_id"
                        style="height: 30px;border-radius:8px; "
                        :list-data="getProjectTypes"
                        @changDataSelect="changeDataSelectProjectType"
                        placeholder="Chọn dự án"
                        key-value="id"
                        key-display="name"
                    />
                    <div
                        v-if="errors['project.data.0.project_type_id']"
                        class="text-danger pt-2"
                    >
                        {{ errors["project.data.0.project_type_id"][0] }}
                    </div>
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="required text-content">Trạng thái</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <select
                        style="height: 29px"
                        class="form-select"
                        :class="{
                            'select-custom-valid':
                                errors['project.data.0.status_id'],
                        }"
                        v-model="formProject.project.data[0].status_id"
                        data-hide-search="true"
                        data-placeholder="Chọn trạng thái"
                        name="target_assign"
                    >
                        <option :value="null">Chọn trạng thái</option>
                        <option
                            v-for="(item, index) in getSystemStatuses"
                            :key="index"
                            :value="item.id"
                        >
                            {{ item.name }}
                        </option>
                    </select>
                    <div
                        v-if="errors['project.data.0.status_id']"
                        class="text-danger pt-2"
                    >
                        {{ errors["project.data.0.status_id"][0] }}
                    </div>
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span>Mô tả sơ bộ</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        :class="{
                            'input-custom-valid':
                                errors['project.data.0.description'],
                        }"
                        v-model="formProject.project.data[0].description"
                        type="text"
                        class="form-control"
                        placeholder="Nhập mô tả"
                        name="target_title"
                    />
                    <div
                        v-if="errors['project.data.0.description']"
                        class="text-danger pt-2"
                    >
                        {{ errors["project.data.0.description"][0] }}
                    </div>
                </div>
            </div>
            <!-- đại diện phí công ty -->
            <div
                style="border-top: 1px solid lightgrey; width: 90%"
                class="mb-4"
            ></div>
            <div class="fw-semibold mb-6 text-content">
                Đại diện phía công ty (Người phụ trách)
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="required text-content">Mã người dùng</span>
                    </label>
                </div>

                <div class="col-lg-8">
                    <SelectSearchUser
                        :class="{
                            'select-custom-valid':
                                errors['user.data.0.user_id'],
                        }"
                        v-model="formProject.user.data[0].user_id"
                        style="height: 30px; border-radius:8px;"
                        :list-data="getUsers"
                        placeholder="Chọn"
                        key-value="id"
                        @changeUser="changeUser"
                        key-display="name"
                    />
                    <div
                        v-if="errors['user.data.0.user_id']"
                        class="text-danger pt-2"
                    >
                        {{ errors["user.data.0.user_id"][0] }}
                    </div>
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="text-content">Họ và tên</span>
                    </label>
                </div>
                <div class="d-flex col-lg-8">
                    <input
                        disabled="disabled"
                        type="text"
                        :value="userById?.name"
                        class="form-control"
                        placeholder="Họ và tên"
                        name="target_title"
                    />
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="text-content">Số điện thoại</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        disabled="disabled"
                        type="text"
                        :value="userById?.phone"
                        class="form-control"
                        placeholder="Số điện thoại"
                        name="target_title"
                    />
                </div>
            </div>

            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="text-content">Email</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        disabled="disabled"
                        type="text"
                        :value="userById?.email"
                        class="form-control"
                        placeholder="Email"
                        name="target_title"
                    />
                </div>
            </div>

            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="text-content">Bộ phận</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        disabled="disabled"
                        type="text"
                        :value="userById?.department_name"
                        class="form-control"
                        placeholder="Bộ phận"
                        name="target_title"
                    />
                </div>
            </div>

            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span class="text-content">Trạng thái</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        disabled="disabled"
                        type="text"
                        :value="userById?.statusName"
                        class="form-control"
                        placeholder="Trạng thái"
                        name="target_title"
                    />
                </div>
            </div>

            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                    >
                        <span>Ghi chú</span>
                    </label>
                </div>
                <div class="col-lg-8">
                    <input
                        :class="{
                            'input-custom-valid': errors['user.data.0.note'],
                        }"
                        v-model="formProject.user.data[0].note"
                        type="text"
                        class="form-control"
                        placeholder="Nhập ghi chú"
                        name="target_title"
                    />
                    <div
                        v-if="errors['user.data.0.note']"
                        class="text-danger pt-2"
                    >
                        {{ errors["user.data.0.note"][0] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button
            @click.prevent="
                !editProjectModal ? storeProject() : updateProject()
            "
            type="button"
            class="btn btn-function me-4"
        >
            <i class="fa-solid fa-floppy-disk"></i> Lưu
        </button>
        <button
            @click="closeModalProject(editProjectModal)"
            type="button"
            class="btn btn-secondary btn-sm btn-active-color-light"
            id="close-modal-project"
            data-bs-dismiss="modal"
        >
            <i class="fa-solid fa-xmark"></i>Đóng
        </button>
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
} from "vue";
import { useProjectType } from "../../stores/projectType";
import { useCustomerStore } from "../../stores/customer";
import { useSystemStatusStore } from "../../stores/status";
import { useCity } from "../../stores/city";
import { useUsers } from "../../stores/user";
import { storeToRefs } from "pinia";
import { useToast } from "../../helper/toastMessage.js";
import { formFieldProject } from "../../stores/project";
import { textCode, validateInput } from "../../../services/utils";
import SelectSearch from "../input/SelectSearch.vue";
import SelectSearchUser from "../input/SelectSearchDiff2.vue";

import moment from "moment";
const props = defineProps({
    editProjectModal: Boolean,
    clickBtnIconClose: {
        type: Boolean,
    },
    getDataUpdate: Object,
    oldUserId: Number,
    clickUpdateBtnIconClose: {
        type: Boolean,
        default: false,
    },
    customers: {
        type: Array,
        default: []
    }
});
const errors = ref([]);
let formProject = reactive(formFieldProject);
const formatData = (item) => {
    if (!item) {
        return formFieldProject;
    }
    return {
        project: {
            data: [
                {
                    code: item.code,
                    name: item.name,
                    customer_id: item.customer_id,
                    city_id: item.city_id,
                    status_id: item.status_id,
                    description: item.description,
                    project_type_id: item.project_type_id,
                },
            ],
        },
        contact: {
            data: [
                {
                    name: item.contacts?.data[0].name,
                    phone: item.contacts?.data[0].phone,
                    email: item.contacts?.data[0].email,
                    position: item.contacts?.data[0].position,
                    note: item.contacts?.data[0].pivot.note,
                    status: item.contacts?.data[0].pivot.status,
                },
            ],
        },
        user: {
            data: [
                {
                    user_id: item.users?.data[0].id,
                    note: item.users?.data[0].pivot.note,
                },
            ],
        },
    };
};
const emit = defineEmits([
    "storeProject",
    "updateProject",
    "resetclickBtnIconClose",
    "resetclickUpdateBtnIconClose"
]);
const userById = reactive({
        id : null,
        phone : null,
         email : null,
       skype: null,
       statusName: null,
       department_name: null

});
const formatCode = (value) => {
   value = value.replace(/[^\w\s]/gi, '');
    value = value.replace(/\s/g, '');
   value = value.toUpperCase();
    return value
}
// Change user
const changeUser =(userNew, userIdRoot, index , idSaveOfUser) => {
    if(userNew == null) {
        userById.id = null;
        userById.name = null;
        userById.phone = null,
        userById.email = null;
        userById.department_name = null;
        userById.statusName = null
        formProject.user.data[0].user_id = null;

    }else {
        userById.id = userNew.id;
        userById.name = userNew.name;
        userById.phone = userNew.phone,
        userById.email = userNew.email;
        userById.skype = userNew.skype
        userById.department_name = userNew.department_name;
        userById.statusName = userNew.statusName;
         formProject.user.data[0].user_id = userNew.id
    }
}
// chang project type
const projectTypeChange = ref(null);
const changeDataSelectProjectType =(projectType) => {
    projectTypeChange.value = projectType?.id
        formProject.project.data[0].project_type_id = projectType?.id
}
// Chang city
const cityChange = ref(null);
const changeDataSelectCity = (city) => {
    formProject.project.data[0].code = formatCode(formProject.project.data[0].code)
    cityChange.value = city?.id
     formProject.project.data[0].city_id = city?.id;
}
const customerChange = ref(null)
const changeDataSelectCustomer =(customer) => {
    customerChange.value = customer?.id
     formProject.project.data[0].customer_id = customer?.id;
}

const resetData = (value) => {
    formProject.project.data[0].name = "";
    formProject.project.data[0].customer_id = null;
    formProject.project.data[0].city_id = null;
    formProject.project.data[0].status_id = null;
    formProject.project.data[0].description = "";
    formProject.project.data[0].project_type_id = null;

    formProject.contact.data[0].name = "";
    formProject.contact.data[0].phone = "";
    formProject.contact.data[0].email = "";
    formProject.contact.data[0].position = "";
    formProject.contact.data[0].note = "";
    formProject.contact.data[0].status = 1;
    formProject.user.data[0].user_id = null;

    formProject.user.data[0].note = "";
    if (!value) {
        formProject.project.data[0].code = "";
    }
    return true;
};
const getProjectID = ref(0);
const getContactID = ref(0);
const getOldUserID = ref(0);
getProjectID.value = props.getDataUpdate?.id;
getContactID.value = props.getDataUpdate?.contacts?.data[0].id;
getOldUserID.value = props.oldUserId;
formProject = { ...formatData(props.getDataUpdate) };

watch(props, (newValue) => {
    formProject = formatData(newValue.getDataUpdate);
    changeUser(newValue.getDataUpdate?.users?.data[0], null, null, null);
    //  formProject.project.data[0].city_id = newValue.getDataUpdate.city?.data?.id
    getProjectID.value = newValue.getDataUpdate?.id;
    getContactID.value = newValue.getDataUpdate?.contacts.data[0].id;
    getOldUserID.value = newValue.getDataUpdate?.users?.data[0].id;
});

const closeModalProject = (value) => {
    errors.value = [];
    if (!value) {
        resetData(value);
        changeUser(null, null, null, null);
         formProject.project.data[0].city_id = null
    } else {
        formProject = { ...formatData(props.getDataUpdate) };
        console.log("update", props.editProjectModal);
         changeDataSelectCity(props.getDataUpdate.city?.data)
         changeUser(props.getDataUpdate.users?.data[0], null, null, null);
    }
};

const storeProjectType = useProjectType();
const storeCustomer = useCustomerStore();
const storeSystemStatus = useSystemStatusStore();
const storeCity = useCity();
const storeUser = useUsers();

onBeforeMount(() => {
    storeProjectType.getAllProjectType({ getAll: true });
    storeCustomer.getData(1, 30, { getAll: true });
    storeSystemStatus.getSystemStatusData();
    storeCity.getCityData();
    storeUser.getUsersData({ getAll: true });
});
const getProjectTypes = computed(() => {
    return storeProjectType.getProjectTypeActive;
});
const getCustomers = computed(() => {
    return storeCustomer.customers?.data;
});
const getSystemStatuses = computed(() => {
    return storeSystemStatus.getStatusesByProject;
});
const getCities = computed(() => {
    return storeCity.cities;
});
const getUsers = computed(() => {
    return storeUser.getUserNotBlock;
});

const storeProject = () => {
    KTApp.showPageLoading();
    axios
        .post("/projects/store", formProject)
        .then((res) => {
            const { message } = res.data;
            errors.value = [];
            resetData(false);
            useToast.successToast(message);
            const btnClick = document.getElementById("close-modal-project");
            btnClick.click();
            emit("storeProject");
        })
        .catch((error) => {
            errors.value = error.response.data?.errors;
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};
const updateProject = () => {
    KTApp.showPageLoading();
    formProject.user.data[0].old_user_id = getOldUserID.value;
    formProject.contact.data[0].contact_id = getContactID.value;
    axios
        .post(`/projects/update/${getProjectID.value}`, formProject)
        .then((res) => {
            const { message } = res.data;
            useToast.successToast(message);
            errors.value = [];
            emit("updateProject");
        })
        .catch((error) => {
            errors.value = error.response.data?.errors;
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};

const { clickBtnIconClose, clickUpdateBtnIconClose } = toRefs(props);
watch(clickBtnIconClose, (newValue) => {
    if (newValue) {
        resetData(null);
        errors.value = [];
        emit("resetclickBtnIconClose", false);
    }
});

watch(clickUpdateBtnIconClose, (newValue) => {
    if (newValue) {
        formProject = { ...formatData(props.getDataUpdate) };
        errors.value = [];
        emit("resetclickUpdateBtnIconClose", false);
    }
});

if (clickBtnIconClose) {
    resetData(null);
    errors.value = [];
    emit("resetclickBtnIconClose", false);
}

</script>

<style scoped>
.input-custom-valid {
    border: 1px solid red !important;
}
.select-custom-valid {
    border: 1px solid red !important;
}
</style>
