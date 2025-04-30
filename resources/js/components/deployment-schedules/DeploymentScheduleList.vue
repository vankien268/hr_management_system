<template>
    <div class="card">
        <!--begin::Header-->
        <div class="border-0 pt-3" style="padding: 0 1.8rem;">
            <h3 class="card-title align-items-start flex-column">
                <!-- <span class="card-label fw-bold fs-3 mb-1"
                    >Danh sách người dùng</span
                > -->
            </h3>
             <!-- justify-content-between -->
            <div
                class="d-flex align-items-center flex-wrap mb-0 mt-2 justify-content-between"
            >
                <div class="d-flex align-items-center flex-wrap">
                    <div class="d-flex align-items-center w-425px mb-3 me-5">
                        <div class="w-150px" style="padding-right:20px;">
                            <label class="col-form-label" for="checkCreate" style="font-size:12px; ">Thời gian thực hiện</label>
                        </div>
                        <div style="width:130px;" >

                            <input type="date" v-model="from_date"
                            :max="to_date"
                           class="form-control mb-lg-0 p-2 fs-6" id="fromDate" placeholder="Từ ngày"
                               />
                               <div  v-if="errors['from_date']"  :title="errors['from_date']? errors['from_date'][0]: ''"
                                style="width:150px;" class="text-danger pt-2">
                                    {{  helperFunc.shortString(errors['from_date'][0], 17) }}
                                </div>
                        </div>
                        <div>
                            <label class="col-form-label"  style="font-size:12px;">-</label>
                        </div>
                        <div style="width:130px;">
                            <input type="date"
                            v-model="to_date"
                            :min="from_date"
                            class="form-control mb-lg-0 p-2 fs-6" placeholder="Đến ngày" id="toDate" />
                            <div  v-if="errors['to_date']"  :title="errors['to_date']? errors['to_date'][0]: ''"
                                style="width:150px;" class="text-danger pt-2">
                                    {{  helperFunc.shortString(errors['to_date'][0], 17) }}
                                </div>
                        </div>
                    </div>

                     <div
                    class="d-flex align-items-center flex-wrap mb-3"
                >
                    <div class="w-120px" style="padding-right:20px;">
                        <label class="col-form-label"  style="font-size:12px;">Tiêu đề lịch triển khai</label>
                    </div>
                    <div style="width: 160px">
                        <input
                            type="text"
                               @keydown.enter="
                              handleBtnClickSearch
                            "
                            v-model="title"
                            class="form-control mb-lg-0 p-2"
                            placeholder="Tất cả"
                            style="width:200px;"
                        />
                    </div>
                </div>
                </div>

                 <div class="d-flex mb-3 ">
                    <div class=" me-1 flex-wrap d-flex  justify-content-end " style="padding-left:35px;">
                                    <a
                                        @click="handleBtnClickSearch"
                                        tabindex="0"
                                        href="#"
                                        class="btn btn-function"
                                    >
                                        <i class="fa-solid fa-search"></i>Tìm kiếm</a
                                    >
                            </div>
                            <div class="d-flex justify-content-end">
                                    <a @click="handleAddDeployment"
                                        href="#"
                                        class="btn btn-function me-2"
                                        data-bs-target="#actionCreateDeployment"
                                        data-bs-toggle="modal"
                                        v-if="props.btnAdd"
                                    >
                                        <i class="ki-duotone ki-plus fs-2"></i>Thêm</a
                                    >
                            </div>

                               <div v-if="getIdClick != 0" class="d-flex justify-content-end">
                                    <a @click="handlExportPdf"
                                        href="#"
                                        class="btn btn-function-ranger me-2"
                                    >
                                        <i class="fa-solid fa-file-pdf"></i>Xuất file PDF</a
                                    >
                            </div>
                 </div>
            </div>
            <div
                class="d-flex align-items-center flex-wrap mb-3 justify-content-start "
            >
                <div class="d-flex w-425px flex-wrap me-5">
                    <div class="w-150px">
                        <label for="customerCode"  style="font-size:12px;" class="col-form-label"
                            >Tên / mã dự án</label
                        >
                    </div>
                    <div style="width:205px;">
                        <input
                         placeholder="Tất cả"
                            type="text"
                            @keydown.enter="
                             handleBtnClickSearch
                            "
                            v-model="projectNameOrCode"
                            class="form-control mb-lg-0 p-2"
                            id="customerCode"
                        />
                    </div>
                </div>

                <div class="d-flex" >
                    <div class="min-w-150px" >
                        <label for="customerCode"  style="font-size:12px;" class="col-form-label "
                            >Trạng thái</label
                        >
                    </div>
                    <div style="width: 202px"  >
                        <select

                            v-model="status"
                            class="form-select form-control"
                            aria-label="Default select example"
                        >
                            <option :value="null">Tất cả</option>
                            <option v-for="(item,index) in systemStatuses"
                            :key="index"
                            :value="item.id">{{ item.name }}</option>
                            <!-- <option :value="0">Ngừng sử dụng</option> -->
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3 text-nowrap">
            <!--begin::Table container-->
            <div class="table-responsive table-responsive table-scroll ">
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
                    <thead class="fs-6 text-gray-400">
                        <tr class="fw-bold text-muted">
                            <th class="min-w-40px text-content" style="text-align: center">
                                STT
                            </th>
                            <th style="width:100px;" class="text-content">Mã lịch triển khai</th>
                            <th style="width:250px;"  class="text-content">Tiêu đề lịch triển khai</th>
                            <!-- <th class="min-w-80px">Ngày sinh</th> -->
                            <!-- <th class="min-w-60px">Giới tính</th> -->
                            <th style="width:180px;" class="text-content">
                                <span>Thời gian thực hiện</span><br>
                                </th>
                            <!-- <th class="min-w-100px">Số điện thoại</th> -->
                            <th style="width:80px;" class="text-content">Chi tiết</th>
                            <th style="width:200px;" class="text-content">Ghi chú quan trọng</th>
                            <th style="width:120px;" class="text-content">Trạng thái</th>
                            <th class="min-w-100px text-center text-content" colspan="2">
                                Hành động
                            </th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody
                        v-for="(item, index) in deploymentSchedules"
                        :key="index"
                        class="max-h-75 overflow-auto"
                    >
                        <td
                            class="h-40px fw-medium fs-6 table-bordered"
                            style="
                                background-color: rgb(243 237 179);
                                border-left: 1px solid;
                            "
                            colspan="14"
                        >
                            <span class="text-content">{{ index }}</span>
                        </td>
                        <deployment-schedule-item v-for="(item2, index2) in item"
                            :key="index2"
                            :getIdClick="getIdClick"
                            :deployment-schedule-item="item2"
                            :index="index2"
                            :pagination="pagination"
                            @click="setDataUpdate(item2)"
                            @handle-edit-deployment="handleEditDeployment"
                            @handle-delete-deployment="handleDeleteDeployment"
                        >
                        </deployment-schedule-item>
                    </tbody>
                    <tbody v-if="Object.keys(deploymentSchedules).length == 0">
                            <tr>
                                <td class="text-center" colspan="9">
                                    Không có dữ liệu hiển thị
                                </td>
                            </tr>
                        </tbody>
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
        <DeployScheduleFormCreate
            :contract-type-lists="contractTypeLists"
            @storeDeploymentSchedule="storeDeploymentSchedule"
        ></DeployScheduleFormCreate>

    <!-- sửa -->
    <deployment-schedule-form
                            :isModalEditDeployment="isModalEditDeployment"
                            :deploymentScheduleUpdate="deploymentScheduleUpdate"
                            :contractTypeLists="contractTypeLists"
                            @updateDeploymentScheduleItem="updateDeploymentScheduleItem"
                            :isEdit="isEdit"
                         ></deployment-schedule-form>

</template>

<script setup>
import axios from "axios";
import { helperFunc } from "../../helper/heplerFunction.js";
import { computed, onBeforeMount, reactive, ref, watch, onMounted } from "vue";
import { useToast } from "../../helper/toastMessage.js";
import DeploymentScheduleItem from "./DeploymentScheduleItem.vue";
import DeploymentScheduleForm from "./DeploymentScheduleForm.vue"
import DeployScheduleFormCreate from "./DeploymentScheduleFormCreate.vue";
import { useSystemStatusStore } from "../../stores/status";

const props = defineProps({
    btnAdd: {
        type: Boolean,
        default: false,
    }
})
const systemStatusStore = useSystemStatusStore();
const systemStatuses = computed(() => {
    // return systemStatusStore.$state.statuses.data ?? [];
    return systemStatusStore.getStatusesByDeploymentSchedules;
});
// tìm kiếm
const projectNameOrCode = ref(null);
const status = ref(null);
const from_date = ref(null);
const to_date = ref(null);
const title = ref(null);

const searchDeploymentSchedule = reactive({
    projectNameOrCode: null,
    status: null,
    from_date: null,
    to_date: null,
    title: null,
});

const getAllDeploymentSchedules = ref([]);
const getMetaPaginate = ref({});
const contractTypeLists = ref([]);
const errors = ref([]);
const getAllDeploymentScheduleApi = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/deployment-schedule/get-all",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data, meta, contractTypes } = res.data;
            getAllDeploymentSchedules.value = data;
            getMetaPaginate.value = meta;
            contractTypeLists.value = contractTypes
            errors.value = [];
            // if (res.data?.message) {
            //     useToast.errorToast(res.data?.message);
            // }
        })
        .catch((error) => {
            errors.value = error?.response?.data?.errors;
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};
const updateDeploymentScheduleItem =() => {
    changePage(pagination.value)
}
const storeDeploymentSchedule=() => {
    changePage(pagination)
}
onMounted(() => {
    getAllDeploymentScheduleApi();
    systemStatusStore.getSystemStatusData();
});
const pagination = computed(() => {
    return getMetaPaginate.value?.pagination
        ? getMetaPaginate.value.pagination
        : { current_page: 1, total_pages: 1, per_page: 30 };
});

const deploymentSchedules = computed(() => {
   return getAllDeploymentSchedules.value = helperFunc.groupBy(
        getAllDeploymentSchedules.value,
        "projectNameAndCode"
    );
});
const handleBtnClickSearch = () => {
     searchDeploymentSchedule.title = title.value;
    searchDeploymentSchedule.from_date = from_date.value;
    searchDeploymentSchedule.to_date = to_date.value;
    searchDeploymentSchedule.projectNameOrCode = projectNameOrCode.value;
    searchDeploymentSchedule.status = status.value;
      changePage(pagination);
}
const changePage = (newDataPagination) => {
    let requestPaginate = {
        page: newDataPagination.current_page,
        per_page: newDataPagination.per_page,
    };
    requestPaginate = { ...requestPaginate, ...searchDeploymentSchedule };
    getAllDeploymentScheduleApi(requestPaginate);
};
const isModalEditDeployment = ref(false);
const deploymentScheduleUpdate = ref({})
const isEdit = ref(false);
const handleEditDeployment = (data) => {
    isModalEditDeployment.value = true;
    deploymentScheduleUpdate.value = data.userItem
    isEdit.value = data.isEdit
};
const isModalAddDeployment = ref(false)
const handleAddDeployment = () => {
    isModalAddDeployment.value = true;
}

const handleDeleteDeployment = () => {
    const totalRecordOnPage = getMetaPaginate.value.pagination.count;
    if (totalRecordOnPage - 1 === 0) {
        getMetaPaginate.value.pagination.current_page -= 1;
    }
    if (getMetaPaginate.value.pagination.total - 1 === 0) {
        getAllDeploymentScheduleApi();
    }
    changePage(getMetaPaginate.value.pagination);
};


const getIdClick = ref(0);

const setDataUpdate = (item) => {
     getIdClick.value = item.id
}
// Xuất file pdf
const handlExportPdf = () => {
   window.open(`/deployment-schedule/export-file-pdf/${getIdClick.value}`, '_blank')
}
</script>

<style scoped>
.input-custom-valid {
    border: 1px solid red;
}
.modal-content {
    width: 100%;
}
</style>
