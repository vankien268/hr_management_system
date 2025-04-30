<template>
    <div class="card">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">{{ title }}</span>
            </h3>
             <div class="align-items-right">
                    <a href="#" class="btn btn-function me-2" data-bs-target="#formCreateDepartment" data-bs-toggle="modal" v-if="props.btnAdd">
                        <i class="ki-duotone ki-plus fs-2 "></i>Thêm</a>
                </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3 text-nowrap">
            <!--begin::Table container-->
            <div class="table-responsive table-scroll tableFixHead">
                <!--begin::Table-->
                <table class="table table-row-dashed table-bordered table-sm table-data" cellspacing="0"
                        cellpadding="0" border="0" width="325" id="tableid">
                    <!--begin::Table head-->
                    <thead class="fs-6 text-gray-400">
                    <tr class="fw-bold text-muted">
                        <th class="w-40px" style="text-align:center">STT</th>
                        <th style="width:200px;">Mã bộ phận</th>
                        <th style="width:250px;">Tên bộ phận</th>
                        <th style="width:250px;">Ghi chú</th>
                        <th style="width:120px;">Trạng thái</th>
                        <th class="w-120px text-center" colspan="2">Hành động</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        <department-item
                        v-for="(item, index) in departmentListNew"
                        :key-item="index"
                        :key = "index"
                        @delete-department="deleteDepartment"
                        :department-item="item"
                        @show-department-in-modal="showDepartmentInModal"
                        >
                            </department-item>
                    </tbody>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>

    <teleport to="#admin">
         <form-update-department @update-department="updateDepartment" :dataDepartmentInfo="departmentInfoToUpdate" :get-parent-department="getParentDepartment"></form-update-department>
        <form-create-department @store-new-department= "storeNewDepartment" :get-parent-department="getParentDepartment"></form-create-department>
    </teleport>
</template>
<script setup>
import DepartmentItem from "./DepartmentItem.vue";
import {defineProps, ref, onMounted, watch, reactive} from 'vue'
import { helperFunc } from '../../helper/heplerFunction.js'
import FormUpdateDepartment from "./FormUpdateDepartment.vue";
import FormCreateDepartment from "@/components/departments/FormCreateDepartment.vue";
import axios from "axios";
const props = defineProps({
    title: String,
    btnAdd: {
        type: Boolean,
        default: false,
    }
})

const departmentListAPI = ref([]);

const getAllDepartments = () => {
    KTApp.showPageLoading();
    axios.get('/departments/get-all')
        .then((res) => {
            const { getAllDepartment } = res.data;
            departmentListAPI.value = getAllDepartment;

    }).catch((error) => {
        console.log(error);
    }).finally(()=> {
          KTApp.hidePageLoading();
    });
}
// sẽ call api trước khi component được tạo ra
onMounted(() => {
    getAllDepartments()
})
const departmentListNew = ref([]);
const getParentDepartment = ref([]);
// theo dõi sự thay đổi của biến ref
watch(departmentListAPI, (newValue, oldValue) => {
     departmentListNew.value = helperFunc.recursive(true, newValue);
     // get only parent department. Khi dữ liệu thay đổi
     getParentDepartment.value = helperFunc.recursive(true, newValue).filter((item) => (item.status == 1));
})
// thêm
const storeNewDepartment=() => {
    getAllDepartments();
}
// xóa
const deleteDepartment =(data) => {
    getAllDepartments();
}
// sửa
const departmentInfoToUpdate = reactive({
    name: "",
    code: "",
    parent_id: null,
    note: "",
    status: 0,
    id: null
});
const showDepartmentInModal=(data) => {
    departmentInfoToUpdate.code = data.code;
    departmentInfoToUpdate.name = data.name;
    departmentInfoToUpdate.parent_id = data.parent_id;
    departmentInfoToUpdate.note = data.note;
    departmentInfoToUpdate.status = data.status;
    departmentInfoToUpdate.id = data.id;
}
const updateDepartment=()=>{
    getAllDepartments();
}
</script>

<style scoped>
.tableFixHead{
    overflow: auto; height: 590px;
}
.tableFixHead thead th {
    position: sticky; top: 0; z-index: 1;
}

table  { border-collapse: collapse; width: 100%; }
</style>
