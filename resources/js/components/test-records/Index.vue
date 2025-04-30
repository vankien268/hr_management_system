<template>
    <div class="col-xxl-12 col-xl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch pt-5">
            <!--begin::Header-->

            <div class="d-flex align-items-center justify-content-between flex-wrap ms-5">
                <div class="d-flex align-items-center flex-wrap">
                    <div class="d-flex align-items-center me-1 flex-wrap w-auto" style="margin-left: 10px;">
                        <div class="w-auto">
                            <label class="col-form-label" for="checkCreate">Ngày gửi</label>
                        </div>
                        <div class="ms-1 me-1 w-125px">
                            <input type="date" class="form-control mb-lg-0 p-2" id="fromDate" placeholder="" :max="moment().format('YYYY-MM-DD')"
                                v-model="searchData.from_date" />
                        </div>
                        <div class="w-10px">
                            <label class="col-form-label">-</label>
                        </div>
                        <div class="ms-1 w-125px">
                            <input type="date" class="form-control mb-lg-0 p-2" id="toDate" v-model="searchData.to_date" :min="searchData.from_date" :max="moment().format('YYYY-MM-DD')" />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto me-2 ms-4">
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label">Dự án</label>
                        </div>
                        <div class="w-100px">
                            <input type="text" placeholder="Tất cả" class="form-control mb-lg-0 p-2" id="customerCode"
                                v-model="searchData.code" />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto me-2">
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label">Người gửi</label>
                        </div>
                        <div class="w-100px">
                            <input type="text" placeholder="Tất cả" class="form-control mb-lg-0 p-2" id="customerCode"
                                v-model="searchData.tax_code" />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto me-2">
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label">Người nhận</label>
                        </div>
                        <div class="w-100px">
                            <input type="text" placeholder="Tất cả" class="form-control mb-lg-0 p-2" id="customerCode"
                                v-model="searchData.tax_code" />
                        </div>
                    </div>
                    <a href="#" class="btn btn-icon btn-sm btn-icon-bg-primary btn-color-light" @click="getData()">
                        <i class="fa-solid fa-magnifying-glass"></i></a>
                </div>
                <div class="align-items-center">
                    <a href="#" style="margin-left: -110px;" class="btn btn-function me-2" data-bs-toggle="modal" data-bs-target="#modal_customer"
                        @click="clickCreate()">
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm</a>
                    <!-- <a href="#" class="btn btn-function me-2" :class="{ disabled: dataUpdate.id == 0 }"
                        data-bs-toggle="modal" data-bs-target="#modal_customer">
                        <i class="fa-regular fa-pen-to-square"></i>Sửa</a>
                    <a href="#" class="btn btn-function" :class="{
                        disabled:
                            dataUpdate.id == 0 || !dataUpdate.is_delete,
                    }" @click="deleteRow(dataUpdate.id)">
                        <i class="fa-solid fa-trash"></i>Xóa</a> -->
                </div>
            </div>

            <div class="card-body py-3">
                <!--begin::Table container-->
                <div class="table-responsive table-scroll h-77vh text-nowrap">
                    <!--begin::Table-->
                    <table class="table table-row-dashed table-bordered table-sm table-data" cellspacing="0" cellpadding="0"
                        border="0" width="325" id="tableid">
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
                                <th class="w-400px text-center">Mã biên bản nghiệm thu</th>
                                <th class="min-w-200px max-w-400px">
                                    Tiêu đề biên bản nghiệm thu
                                </th>
                                <th class="min-w-125px max-w-100">
                                    Ngày gửi
                                </th>
                                <!-- <th class="w-250px">Tên khách hàng</th> -->
                                <th class="min-w-75px">Người gửi</th>
                                <th class="min-w-125px">Người nhận</th>
                                <th class="min-w-125px">Ngày nghiệm thu</th>
                                <th class="min-w-125px">Thời gian bảo hành (Đvi: Tháng)</th>
                                <th class="min-w-125px">Trạng thái</th>
                                <th class="w-300px">Ghi chú</th>
                                <th class="min-w-100px text-center" colspan="2">Hành động</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="max-h-75 overflow-auto cursor-pointer">
                            <tr>
                                <td class="h-40px fw-medium" style="background-color: rgb(243 237 179); font-size:14px;" colspan="12">
                                    Mã dữ án - Tên dự án
                                </td>
                            </tr>
                            <tr v-for="(item, index) in customers" :key="index"
                                :class="{ active: item.id == dataUpdate.id }" @click="setDataUpdate(item)">
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
                                        <span class="fs-5 pb-1 w-100 break-text mb-2">
                                            <span class="badge text-warning text-bg-dark" v-if="item.customer_type == 0">VIP</span>
                                            <span class="badge text-white text-bg-primary" v-if="item.customer_type == 1">NOR</span>
                                            {{ item.name }}
                                        </span>
                                            <!-- <span class="fs-7 text-gray-900 w-100 break-text" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-trigger="hover" :title="item.full_address"><i class="fa-solid fa-location-dot text-dark-emphasis ps-1"></i> {{ item.full_address ?? "" }}</span> -->
                                    </div>
                                </td>
                                <td class="max-w-250px break-text">

                                    <div class="row pt-1 pb-1">
                                        <span class="fs-5 pb-1 w-100 break-text mb-1"><i class="fa-solid fa-user text-dark-emphasis"></i> {{ item.representative_name }}</span>
                                        <span class="fs-7 pb-1 w-100 break-text mb-1" ><i class="fa-solid fa-phone text-dark-emphasis"></i>  {{ item.representative_phone }}</span>
                                        <span class="fs-7 text-gray-900 w-100 break-text " data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-trigger="hover" :title="item.full_address"><i class="fa-solid fa-envelope text-dark-emphasis"></i>  {{ item.representative_email ?? "" }}</span>
                                    </div>
                                </td>
                                <td class="">
                                    {{
                                        item.status.data
                                        ? item.status.data.name
                                        : ""
                                    }}
                                </td>
                                <!-- <td>{{ item.type }}</td> -->
                                <td class="max-w-350px break-text" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-trigger="hover" :title="item.note">{{ item.note }}</td>
                                    <td class="w-50px">
                                    <a href="#" class="btn btn-icon btn-edit btn-sm" @click="setDataUpdate(item)" data-bs-toggle="modal" data-bs-target="#modal_update_status">
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        </a>
                                </td>
                                <td class="w-50px">
                                    <a href="#" class="btn btn-icon btn-delete btn-sm" :class="{'disable' : item.is_delete == false}" @click="deleteRow(item.id)">
                                        <i class="fa-solid fa-trash fs-5"></i>
                                        </a>
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
                <base-pagination :pagination="pagination" @change-page="changePage" />
                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
        <!--end::Tables Widget 9-->
        <CreateOrUpdateModal
            :customer="dataUpdate"
            :statuses="props.statuses"
            :cities="props.cities"
            :districts="props.districts"
            :wards="props.wards"
            :banks="props.banks"
            @close-model="closeModal" />
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
import { useToast } from '../../helper/toastMessage';
import { sweetAlertMessage } from '../../helper/sweetAlert'

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
});

const searchData = reactive({
    code: "",
    tax_code: "",
    from_date: "",
    to_date: moment().format('YYYY-MM-DD'),
});

const dataUpdate = ref({
        id: 0,
        code: '',
        name: '',
        tax_code: '',
        address: '',
        city_id: null,
        district_id: null,
        ward_id: null,
        representative_name: '',
        representative_phone: '',
        representative_email: '',
        status_id: '',
        bank_username: '',
        bank_number: '',
        bank_id: null,
        note: '',
        customer_type: 1,
        created_at: moment().format('YYYY-MM-DD'),
    });

const customers = computed(() => {
    return store.$state.customers.data;
});

const pagination = computed(() => {
    return store.$state.customers.meta
        ? store.$state.customers.meta.pagination
        : { current_page: 1, total_pages: 1, per_page: 30 };
});

watch( () => searchData.to_date, (newValue, oldValue) => {

})

const changePage = (newData) => {
    getData(newData.current_page, newData.per_page);
};

const setDataUpdate = (data) => {
    dataUpdate.value = data;
};

const clickCreate = () => {
    dataUpdate.value = {
        id: 0,
        code: '',
        name: '',
        tax_code: '',
        address: '',
        city_id: null,
        district_id: null,
        ward_id: null,
        representative_name: '',
        representative_phone: '',
        representative_email: '',
        status_id: '',
        bank_username: '',
        bank_number: '',
        bank_id: null,
        note: '',
        customer_type: 1,
        created_at: moment().format('YYYY-MM-DD'),
    };

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
    sweetAlertMessage.messageWarning("Bạn có chắc chắn muốn xóa không?")
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
     .catch((err) => { });
};

const closeModal = (id) => {
    console.log(id);
    if (id != 0) {
        getData();
    }
    clickCreate();
}

onBeforeMount(() => {
    getData();
});
</script>
<style lang="scss" scoped>
.right-5 {
    right: 50px;
}
</style>
