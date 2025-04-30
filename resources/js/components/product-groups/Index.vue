<template>
    <div class="col-xxl-12 col-xl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch pt-5">
            <!--begin::Header-->
            <div class="d-flex align-items-center justify-content-end flex-wrap mx-7">
                <!-- <div class="d-flex align-items-center flex-wrap">
                    <div class="d-flex align-items-center flex-wrap w-auto me-2">
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label">Mã/Tên</label>
                        </div>
                        <div class="w-100px">
                            <input type="text" class="form-control mb-lg-0 p-2" id="customerCode"
                                v-model="searchData.code" />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto me-2">
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label">Trạng thái</label>
                        </div>
                        <div class="w-100px">
                            <input type="text" class="form-control mb-lg-0 p-2" id="customerCode"
                                v-model="searchData.tax_code" />
                        </div>
                    </div>
                    <a href="#" class="btn btn-icon btn-sm btn-icon-bg-primary btn-color-light" @click="getData()">
                        <i class="fa-solid fa-magnifying-glass"></i></a>
                </div> -->
                <div class="align-items-center">
                    <a href="#" class="btn btn-function me-2" data-bs-toggle="modal" data-bs-target="#modal_product_group"
                        @click="clickCreate()" v-if="props.btnAdd">
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm</a>
                    <a href="#" class="btn btn-function me-2" v-if="dataUpdate.is_edit"
                        data-bs-toggle="modal" data-bs-target="#modal_product_group">
                        <i class="fa-regular fa-pen-to-square"></i>Sửa</a>
                    <!-- <a href="#" class="btn btn-function" :class="{
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
                                <th class="w-150px text-center">Mã nhóm</th>
                                <th class="w-250px">Tên nhóm sản phẩm</th>
                                <th class="min-w-50px w-auto text-center">
                                    Thuế(%)
                                </th>
                                <th class="min-w-50px w-auto text-center">
                                    Phí(%)
                                </th>
                                <th class="min-w-125px max-w-100">
                                    Trạng thái
                                </th>
                                <th class="min-w-350px">Ghi chú</th>
                                <th class="w-50px"></th>
                                <th class="w-50px"></th>
                                <th class="w-50px"></th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="cursor-pointer">
                            <tr v-for="(item, index) in productGroups" :key="index"
                                :class="{ 'active': item.id == dataUpdate.id, 'disabled': item.id == 1 }" @click="setDataUpdate(item)">
                                <td class="w-150px max-w-150px break-text">
                                    {{ item.prefix }}
                                    {{
                                        item.code
                                    }}
                                </td>
                                <td class="w-250px max-w-250px break-text">{{ item.name }}</td>
                                <td class="w-50px max-w-75px text-end">{{ item.tax ? item.tax.data.rate : '' }}</td>
                                <td class="w-50px max-w-75px text-end">{{ item.fee ? item.fee.data.rate : '' }}</td>
                                <td>{{ item.status_text }}</td>
                                <td class="max-w-350px break-text" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-trigger="hover" :title="item.note">{{ item.note }}</td>
                                <td class="w-50px">
                                    <a href="#" class="btn btn-icon btn-sm btn-active-light-primary" v-if="item.is_edit" @click="moveDown(item.id)">
                                        <i class="fa-sharp fa-solid text-gray-800 fs-2 fa-caret-down"></i>
                                    </a>
                                </td>
                                <td class="w-50px">
                                    <a href="#" class="btn btn-icon btn-sm btn-active-light-primary" v-if="item.is_edit" @click="moveUp(item.id)">

                                        <i class="fa-sharp fa-solid text-gray-800 fs-2 fa-caret-up"></i>
                                    </a>
                                </td>
                                <td class="w-50px">
                                    <a href="#" class="btn btn-icon btn-delete btn-sm"
                                        :class="{ 'invisible' : item.id == 1 }" @click="deleteRow(item.id)" v-if="item.is_delete">
                                        <i class="fa-solid fa-trash fs-5"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="productGroups.length == 0">
                                <td class="text-center" colspan="12">
                                    Không có dữ liệu hiển thị
                                </td>
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
        <!--end::Tables Widget 9-->
        <CreateOrUpdateModal :group="dataUpdate" :product-groups="productGroups" :tax-list="props.taxList" :fee-list="props.feeList"
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
import { useProductGroupStore } from "../../stores/product";
import { destroy, update } from "../../helper/axiosConfig";
import moment from "moment";
import { useToast } from '../../helper/toastMessage';
import { sweetAlertMessage } from '../../helper/sweetAlert'

const store = useProductGroupStore();

const props = defineProps({
    taxList: {
        type: Array,
        default: [],
    },
    feeList: {
        type: Array,
        default: [],
    },
    btnAdd: {
        type: Boolean,
        default: false,
    }
});


const searchData = reactive({
    is_delete: true,
});

const dataUpdate = ref({
    id: 0,
    code: '',
    name: '',
    tax_id: null,
    fee_id: null,
    note: '',
    status: true,
    parent_id: 1,
    is_edit : false
});

const productGroups = computed(() => {
    return store.$state.groups.data ?? [];
});

const setDataUpdate = (data) => {
    dataUpdate.value = data;
};

const clickCreate = () => {
    dataUpdate.value = {
        id: 0,
        code: '',
        name: '',
        tax_id: null,
        fee_id: null,
        note: '',
        status: true,
        parent_id: 1,
        is_edit : false
    };

};

const ch = ref('');

const getData = (
    search = searchData
) => {
    store.getData(search);
    console.log(searchData);
};

const moveUp = (id) => {
    clickCreate();
    update("/products/groups/api/move-up/" + id)
        .then((res) => {
            getData();
            useToast.successToast('Cập nhật thành công!');
        })
        .catch((err) => {
            console.log(err);
            getData();
        });
};

const moveDown = (id) => {
    clickCreate();
    update("/products/groups/api/move-down/" + id)
        .then((res) => {
            getData();
            useToast.successToast('Cập nhật thành công!');
        })
        .catch((err) => {
            console.log(err);
            getData();
        });
};

const deleteRow = (id) => {
    sweetAlertMessage.messageWarning("Bạn có chắc chắn muốn xóa không?")
        .then((res) => {
            console.log(res);
            if (res.isConfirmed == true) {
                destroy("/products/groups/api/" + id)
                    .then((res) => {
                        console.log(res.data);
                        getData();
                        useToast.successToast("Xóa bản ghi thành công!");
                    })
                    .catch((err) => {
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
.table {
    tr {
        &.disabled{
            background-color: rgb(240, 239, 239) !important;
            pointer-events: none;
        }
    }
}

</style>
