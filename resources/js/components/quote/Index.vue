<template>
    <div class="col-xxl-12 col-xl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch pt-5">
            <!--begin::Header-->
            <div class="d-flex align-items-center justify-content-between flex-wrap ms-5">
                <div class="d-flex align-items-baseline col-xl-12">
                    <div class="d-flex align-items-center me-1 w-425px">

                        <div class="w-70px me-1">
                            <label class="col-form-label" for="checkCreate">Ngày báo giá</label><base-validation />
                        </div>
                        <div class="w-auto">
                            <input type="checkbox" class="form-check-sm mb-lg-0 p-2" placeholder=""
                                v-model="is_search_date" /><base-validation />
                        </div>
                        <div class="ms-1 me-1 w-150px">
                            <input type="date" class="form-control mb-lg-0 p-2" :disabled="!is_search_date" :max="to_date"
                                v-model="from_date" /><base-validation :message="errors.from_date" />
                        </div>
                        <div class="ms-1 w-150px">
                            <input type="date" class="form-control mb-lg-0 p-2" :disabled="!is_search_date" :min="from_date"
                                v-model="to_date" /><base-validation :message="errors.to_date" />
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-225px me-4">
                        <div class="w-65px">
                            <label for="customerCode" class="col-form-label">Dự án</label><base-validation />
                        </div>
                        <div class="w-150px">
                            <!-- <SelectSearch :list-data="props.projects" v-model="searchData.project_id" key-value="id"
                                key-display="name" /> -->
                            <InputSearch :list-data="projects" v-model="project_id" key-value="id" :loading="projectLoading"
                                placeholder="Tên dự án" :key-display="['name']" key-show="name"
                                @search-data="getListProject" />
                            <base-validation />
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-auto me-4">
                        <div class="w-75px w-80px me-2">
                            <label for="customerCode" class="col-form-label">Người lập</label><base-validation />
                        </div>
                        <div class="w-100px ms-1">
                            <input type="text" class="form-control mb-lg-0 p-2" id="customerCode" placeholder=""
                                v-model="created_by" /><base-validation />
                            <!-- <SelectSearch class="w-100px" :list-data="props.customers" key-value="id" key-display="name"/> -->
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-auto me-2">
                        <div class="w-75px me-1">
                            <label for="customerCode" class="col-form-label">Người nhận</label><base-validation />
                        </div>
                        <div class="w-100px ms-1">
                            <input type="text" class="form-control mb-lg-0 p-2" id="customerCode" placeholder=""
                                v-model="receiver" /><base-validation />
                            <!-- <SelectSearch class="w-100px" :list-data="props.customers" key-value="id" key-display="name"/> -->
                        </div>
                    </div>
                    <div class="d-flex">
                        <a href="#" class="btn btn-function" @click="clickSearch()">
                            <i class="fa-solid fa-magnifying-glass fs-2"></i></a>

                    </div>
                    <div v-if="dataUpdate.id != 0" class="d-flex">
                        <a @click="handlExportPdf" href="#" class="btn btn-function-ranger me-2">
                            Xuất file PDF</a>

                    </div>
                    <!-- <div class="d-flex justify-content-end">
                            <a @click="handlExportPdf"
                                        href="#"
                                        class="btn btn-function-ranger me-2"
                                    >
                                        <i class="fa-solid fa-file-pdf"></i>Xuất file PDF</a
                                    >
                            </div> -->
                </div>
                <div class="d-flex align-items-baseline col-xl-12">
                    <div class="d-flex align-items-center w-auto me-3">
                        <div class="w-75px">
                            <label for="customerCode" class="col-form-label">Mã báo giá</label><base-validation />
                        </div>
                        <div class="w-100px">
                            <input type="text" class="form-control mb-lg-0 p-2" id="customerCode" placeholder=""
                                v-model="code" /><base-validation />
                            <!-- <SelectSearch class="w-100px" :list-data="props.customers" key-value="id" key-display="name"/> -->
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-auto me-4">
                        <div class="w-65px">
                            <label for="customerCode" class="col-form-label">Khách hàng</label><base-validation />
                        </div>
                        <div class="w-150px">
                            <!-- <SelectSearch :list-data="customers" v-model="searchData.customer_id" key-value="id"
                                key-display="name" /> -->
                            <InputSearch :list-data="customers" v-model="customer_id" key-value="id"
                                :loading="customerLoading" placeholder="Tên khách hàng" :key-display="['name']"
                                key-show="name" @search-data="getListCustomer" />
                            <base-validation />
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-250px me-1">
                        <div class="w-75px me-2">
                            <label for="customerCode" class="col-form-label">Loại hợp đồng</label><base-validation />
                        </div>
                        <div class="w-150px">
                            <SelectSearch :list-data="props.types" v-model="contract_type_id" key-value="id"
                                key-display="name" />
                            <base-validation />
                        </div>
                    </div>

                    <div class="d-flex align-items-center w-auto me-1">
                        <div class="w-80px me-2">
                            <label for="customerCode" class="col-form-label">Sdt người nhận</label><base-validation />
                        </div>
                        <div class="w-100px ms-1">
                            <input type="text" class="form-control mb-lg-0 p-2" id="customerCode" placeholder="+84xxx"
                                v-model="phone" /><base-validation />
                            <!-- <SelectSearch class="w-100px" :list-data="props.customers" key-value="id" key-display="name"/> -->
                        </div>
                    </div>
                    <div class="min-w-250px ms-3">
                        <a href="#" v-if="permissionadd" class="btn btn-function" @click="clickCreate()">
                            <i class="ki-duotone ki-plus fs-2"></i>Thêm</a>
                        <a href="#" v-if="dataUpdate.canUserPermissionEditQuote || permissionSystemEditQuote" class="btn btn-function me-2"
                            :class="{ disabled: dataUpdate.id == 0 }"
                            @click="() => { store.toggleShowModal(true), setAction('update') }">
                            <i class="fa-regular fa-pen-to-square"></i>Sửa</a>
                        <a v-if="dataUpdate.canUserPermissionDeleteQuote || permissionSystemDeleteQuote" href="#" class="btn btn-function" :class="{
                            disabled:
                                dataUpdate.id == 0 || !dataUpdate.is_delete,
                        }" @click="deleteRow(dataUpdate.id)">
                            <i class="fa-solid fa-trash"></i>Xóa</a>
                        <!-- <a href="#" class="btn btn-function" :class="{'disabled': dataUpdate.id == 0}" @click="() => { store.toggleShowModal(true), setAction('update') }">
                            <i class="fa-solid fa-circle-info"></i>Xem</a> -->
                    </div>
                </div>
            </div>
            <div class="card-body px-4 py-3">
                <!--begin::Table container-->
                <div class="table-responsive table-scroll h-65vh text-nowrap">
                    <!--begin::Table-->
                    <table class="table table-row-dashed table-bordered table-sm table-data" cellspacing="0" cellpadding="0"
                        border="0" width="325" id="tableid">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fs-6 text-gray-400">
                                <th class="w-50px max-w-50px">STT</th>
                                <th class="w-100px text-center">Mã báo giá</th>
                                <th class="min-w-200px max-w-200px">Tiêu đề</th>
                                <th class="w-100px">Ngày báo giá</th>
                                <th class="min-w-150px">Người lập</th>
                                <th class="min-w-150px">Loại hợp đồng</th>
                                <th class="max-w-200px">Người nhận</th>
                                <th class="w-150px">Tình trạng</th>
                                <th class="min-w-100px">Tổng tiền</th>
                                <th class="min-w-600px">Lưu ý</th>
                                <!-- <th class="min-w-125px">Phân loại</th> -->
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody v-for="(quote, key) in quotes" :key="key" class="max-h-75 overflow-auto">
                            <tr>
                                <td class="h-50px fw-medium pointer-events-none" style="
                                        background-color: rgb(243 237 179); font-size:14px;
                                        padding-left: 3rem;
                                    " colspan="12">
                                    <span v-html="key"></span>
                                </td>
                            </tr>
                            <tr class="" v-for="(item, index) in quote" :key="index"
                                :class="{ active: item.id == dataUpdate.id }" @click="setDataUpdate(item)">
                                <td class="text-center">
                                    {{ (pagination.per_page) * (pagination.current_page - 1) + (item.stt + 1) }}
                                </td>
                                <td>{{ item.code }}</td>
                                <td class="text-break">{{ item.title }}</td>
                                <td>
                                    {{ moment(new Date(item.quote_date)).format(
                                        "DD/MM/YYYY"
                                    ) }}
                                </td>
                                <td class="text-break">
                                    {{
                                        item.created_by
                                        ? item.created_by.name +
                                        "(" +
                                        item.created_by.username + ")"
                                        : ""
                                    }}
                                </td>
                                <td class="text-break">
                                    {{
                                        item.contract_type
                                        ? item.contract_type.data.name
                                        : ""
                                    }}
                                </td>
                                <td class="max-w-200px">
                                    <div class="row pt-1 pb-1">
                                        <span class="fs-5 pb-1 w-100 break-text mb-1"><i
                                                class="fa-solid fa-user text-dark-emphasis"></i>
                                            {{ item.receiver }}</span>
                                        <span class="fs-7 pb-1 w-100 break-text mb-1"><i
                                                class="fa-solid fa-phone text-dark-emphasis fs-8"></i>
                                            {{ item.phone }}</span>
                                        <span class="fs-7 text-gray-900 w-100 break-text"><i
                                                class="fa-solid fa-envelope text-dark-emphasis fs-8"></i>
                                            {{ item.email ?? "" }}</span>
                                    </div>
                                </td>
                                <td class="min-w-125px max-w-125px">
                                    <select class="form-select mb-2" v-if="item.canApproveQuote" v-model="item.status" @change="changeStatus($event, item)" @focus="selectStatusFocus($event, item.status)">
                                        <option v-for="(stt, index) in item.list_status" :key="index"
                                             :value="stt.value">{{ stt.name ?? "" }}</option>
                                    </select>
                                    <p class="mb-2 w-100 break-text ms-2 mb-1" v-else>
                                        {{ item.text_status ?? "" }}
                                    </p>
                                    <p class="w-100 break-text mb-1 ms-2">
                                        {{
                                            item.approve_by
                                            ? item.approve_by.data.name +
                                            "(" +
                                            item.approve_by.data.username + ")"
                                            : ""
                                        }}
                                    </p>
                                </td>
                                <td class="text-end">
                                    {{ displayPrice(item.total_amount) ?? "" }}
                                </td>
                                <td class="text-break" style="line-height: 20px;">
                                    {{ item.note ?? "" }}
                                </td>
                                <!-- <td class="w-50px text-center">
                                    <a href="#" class="btn btn-icon btn-icon-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal_quote" @click="setDataUpdate(item, 'view')">
                                        <i class="fa-solid fa-file-invoice fs-4"></i>
                                    </a>
                                </td> -->
                            </tr>
                        </tbody>
                        <tbody v-if="Object.keys(quotes).length == 0">
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
                <base-pagination :pagination="pagination" @change-page="changePage" />
                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
        <!--end::Tables Widget 9-->
        <CreateOrUpdateModal :quote="dataUpdate" :types="props.types" :projects="props.projects" :customers="customers"
            :users="props.users" :products="props.products" @close-model="closeModal" :action="modalAction"
            @update-data="setAction" v-if="showModel" />
    </div>
</template>
<script setup>
import CreateOrUpdateModal from "./CreateOrUpdateModal.vue";
import SelectSearch from "../input/SelectSearch.vue";
import InputSearch from "../input/InputSearch.vue";
import Modal from "../modal/ScrollModal.vue";

import {
    defineProps,
    ref,
    computed,
    watch,
    onBeforeMount,
    reactive,
} from "vue";
import { useQuoteStore } from "../../stores/quote";
import { useCustomerStore } from "../../stores/customer";
import { useStoreProjects } from "../../stores/project";
import { useContracTypeStore } from "../../stores/contract";
import { destroy } from "../../helper/axiosConfig";
import moment from "moment";
import { useToast } from "../../helper/toastMessage";
import { sweetAlertMessage } from "../../helper/sweetAlert";
import { displayPrice } from '../../../services/utils'
import { helperFunc } from '../../helper/heplerFunction'


const store = useQuoteStore();
const customerStore = useCustomerStore();
const projectStore = useStoreProjects();
const contractTypeStore = useContracTypeStore();

const props = defineProps({
    types: {
        type: Array,
        default: [],
    },
    products: {
        type: Array,
        default: [],
    },
    permissionadd: Boolean,
    approvePermission: {
        type: Boolean,
        default: false,
    },
    permissionSystemEditQuote: {
        type: Boolean,
        default: false,
    },
    permissionSystemDeleteQuote: {
        type: Boolean,
        default: false,
    }
});

const showModel = computed(() => {
    return store.$state.showModel;
});

const is_search_date = ref(false);
const from_date = ref(null);
const to_date = ref(null);
const code = ref('');
const project_id = ref(null);
const customer_id = ref(null);
const contract_type_id = ref(null);
const created_by = ref(null);
const receiver = ref('');
const phone = ref('');

const searchData = reactive({
    is_search_date: false,
    from_date: null,
    to_date: null,
    code: "",
    project_id: null,
    customer_id: null,
    contract_type_id: null,
    created_by: null,
    receiver: "",
    phone: "",
});

const clickSearch = () => {
    searchData.is_search_date = is_search_date.value;
    searchData.from_date = from_date.value;
    searchData.to_date = to_date.value;
    searchData.code = code.value;
    searchData.project_id = project_id.value;
    searchData.customer_id = customer_id.value;
    searchData.contract_type_id = contract_type_id.value;
    searchData.created_by = created_by.value;
    searchData.receiver = receiver.value;
    searchData.phone = phone.value;
    getData(1);
}

const modalAction = ref("view");

const oldValueStatus = ref(null);

const setAction = (action) => {
    modalAction.value = action;
};

const dataUpdate = ref({
    id: 0,
    code: "",
    title: "",
    contract_type_id: null,
    project_id: null,
    customer_id: null,
    approve_id: null,
    quote_date: moment().format("YYYY-MM-DD"),
    receiver: "",
    email: "",
    phone: "",
    note: "",
    status: 0,
    total_amount: 0,
    details: {
        data: [],
    },
});

const errors = computed(() => {
    console.log(store.$state.errors);
    return store.$state.errors ?? [];
});

const quotes = computed(() => {
    return store.$state.quotes.data
        ? helperFunc.groupBy(store.$state.quotes.data, 'project_title') : [];
});

const pagination = computed(() => {
    return store.$state.quotes.meta
        ? store.$state.quotes.meta.pagination
        : { current_page: 1, total_pages: 1, per_page: 30 };
});

const customers = computed(() => {
    return customerStore.$state.customers.data ?? [];
});

const customerLoading = computed(() => {
    return customerStore.$state.loading ?? [];
});

const projects = computed(() => {
    if (projectStore.$state.projects.data) {
        return projectStore.$state.projects.data;
    } else {
        return projectStore.$state.projects;
    };
});

const projectLoading = computed(() => {
    return projectStore.$state.loading ?? [];
});

const contractType = computed(() => {
    return contractTypeStore.$state.types.data ?? [];
});

const contractTypeLoading = computed(() => {
    return contractTypeStore.$state.loading ?? [];
});

const changePage = (newData) => {
    getData(newData.current_page, newData.per_page);
};

const setDataUpdate = (data, action = "view") => {
    dataUpdate.value = data;
    modalAction.value = action;
    // store.toggleShowModal(true);
};

const clickCreate = () => {
    dataUpdate.value = {
        id: 0,
        code: "",
        title: "",
        contract_type_id: null,
        project_id: null,
        customer_id: null,
        approve_id: null,
        quote_date: moment().format("YYYY-MM-DD"),
        receiver: "",
        email: "",
        phone: "",
        note: "",
        status: 0,
        total_amount: 0,
        details: {
            data: [],
        },
    };
    modalAction.value = "create";
    store.toggleShowModal(true);
};

const getData = (
    page = pagination.value.current_page,
    per_page = pagination.value.per_page,
    search = searchData
) => {
    store.getData(page, per_page, search);
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
    });
};


const deleteRow = (id) => {
    store.deleteRow(id);
};

const closeModal = (id) => {
    console.log(id);
    if (id != 0) {
        getData();
    }
    clickCreate();
    store.toggleShowModal(false);
};

const selectStatusFocus = (event, value) => {
    document.activeElement.blur();
    oldValueStatus.value = value;
}

const changeStatus = (event, item) => {
    const change = store.changeStatus(item.id, event.target.value);
    console.log(change);
    if (change == false) {
        item.status = oldValueStatus.value;
        store.updateData(item);
    }

}

onBeforeMount(() => {
    getData();
    getListProject();
    getListCustomer();
});

// Xuất file pdf
const handlExportPdf = () => {
    window.open(`/quotes/export-file-pdf/${dataUpdate.value.id}`, '_blank')
}
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

.table-scroll {
    height: calc(100vh - 255px) !important;
}

.check-permission {
    visibility: hidden;
}
</style>
