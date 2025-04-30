<template>
      <div class="card">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3">
                     <div class="d-flex align-items-center flex-wrap w-auto me-2">
                        <div class="w-120px">
                            <label for="customerCode" class="col-form-label" style="font-size:14px;">Tên loại dự án / code</label>
                        </div>
                        <div class="w-170px mx-2">
                            <input type="text" @keyup.enter="searchNow" v-model="searchProjectType.nameOrCode" style="width: 170px;" class="form-control mb-lg-0 p-2" />
                        </div>
                        <a
                        @click="searchNow(pagination)"
                        tabindex="0"
                        href="#"
                        class="btn btn-function"
                    >
                        <i class="fa-solid fa-search"></i>Tìm kiếm</a
                    >
                    </div>
                </span>
            </h3>
            <div class="card-toolbar">
                <!--begin::Menu-->
                 <div class="align-items-right">
                    <a href="#" class="btn btn-function me-2" v-if="props.btnAdd" @click="clickCreateProjectType" data-bs-target="#formCreateProjectType" data-bs-toggle="modal">
                        <i class="ki-duotone ki-plus fs-2 "></i>Thêm loại dự án</a>
                </div>
                <!--begin::Menu 2-->
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3 text-nowrap">
            <!--begin::Table container-->
            <div class="table-responsive table-responsive table-scroll">
                <!--begin::Table-->
                <table class="table table-row-dashed table-bordered table-sm table-data" cellspacing="0"
                        cellpadding="0" border="0" width="325" id="tableid">
                    <!--begin::Table head-->
                    <thead>
                    <tr class="fs-6 fw-bold text-muted">
                        <th class="min-w-50px" style="text-align:center">STT</th>
                        <th style="width:160px">Mã loại dự án</th>
                        <th style="width:250px">Tên loại dự án</th>
                        <th style="width:250px">Ghi chú</th>
                        <th style="width:120px">Trạng thái</th>
                        <th class="min-w-120px text-center" colspan="2">Hành động</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        <tr v-for="(item, index) in projectTypes" :key="index">
                            <td style="text-align:center"  class="w-1px">
                                <span class="text-dark text-hover-primary">{{ (pagination.per_page*(pagination.current_page - 1)) + 1 + index }}</span>
                            </td>
                            <td style="max-width:160px" class="break-text">
                                <span class="text-dark text-hover-primary"  :title="item.code">
                                    {{ item.code }}
                                    </span>
                            </td>
                            <td style="max-width:250px" class=" break-text">
                                <span class="text-dark text-hover-primary mb-1"
                               :title="item.name">{{ item.name }}</span>
                            </td>

                            <td style="max-width:250px" class="break-text">
                                <span  class="text-dark text-hover-primary mb-1" :title="item.note">{{ item.note }}</span>
                            </td>
                            <td >
                                <div  class="text-red text-hover-primary mb-1"
                                    :class="item.status == 0 ? 'status-badge-danger-color' : 'status-badge-active-color'"
                                >{{ item.status=== 1 ? "Sử dụng" : "Ngừng sử dụng" }}</div>
                            </td>

                            <td class="w-50px text-center">
                                <!-- :class="{'disable' : item.isEdit == false}" -->
                                <a href="#" v-if=" item.isEdit"  @click="handleUpdate(item)" data-bs-target="#formCreateProjectType" data-bs-toggle="modal" class="btn btn-icon btn-edit btn-sm">
                                    <i class="ki-duotone ki-pencil fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </a>
                            </td>
                            <td class="w-50px">
                                <a v-if="item.is_delete_permission" href="#" @click.prevent="handleDelete(item.id)" class="btn btn-icon btn-delete btn-sm me-1"
                                :class="{'disable' : item.isDelete == false}"
                                >
                                    <i class="fa-solid fa-trash fs-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                     <tbody v-if="Object.keys(projectTypes).length == 0">
                            <tr>
                                <td class="text-center" colspan="9">
                                    Không có dữ liệu hiển thị
                                </td>
                            </tr>
                        </tbody>
                </table>
                <!--end::Table-->
            </div>
            <br>
            <!--end::Table container-->
        <base-pagination :pagination="pagination" @change-page="changePage" />
        </div>
        <!--begin::Body-->
    </div>

    <div class="modal fade" id="formCreateProjectType" style="position:fixed;" data-bs-keyboard="true" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-left border-0 pb-0">
						<!--begin::Close-->
						 <h4 class="modal-title ">
                            {{ isClickProjectTypeUpdate ? 'Sửa loại dự án' : 'Thêm mới loại dự án' }}
                         </h4>
						<div @click="closeModalUser" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<i class="ki-duotone ki-cross fs-1 text-black">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
						<!--end::Close-->
				</div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body px-10 px-lg-15 pt-0 pb-15">
                    <!--begin:Form-->
                    <form id="kt_modal_new_target_form" class="form" action="#">
                        <div class="d-flex flex-column mb-8">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fw-semibold mb-2">
                                <span class="required">Mã loại dự án</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" :disabled="canDisabledCode" class="form-control" :class="{  'input-custom-valid' :  errors.name && !canDisabledCode, 'input-disabled': canDisabledCode }"
                            v-model="formProjectType.code"
                                      @keyup="validateInput($event)"
                            @input="formProjectType.code=textCode($event.target.value)" placeholder="Nhập mã loại dự án" name="target_title" />
                            <div class="w-100"></div>
                            <span v-if="errors.code" class="text-danger mt-3">{{ errors.code[0] }}</span>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fw-semibold mb-2">
                                <span class="required">Tên loại dự án</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control" :class="{ 'input-custom-valid' :  errors.name}" v-model="formProjectType.name" placeholder="Nhập tên loại dự án" name="target_title" />
                            <div class="w-100"></div>
                            <span v-if="errors.name" class="text-danger  mt-3">{{ errors.name[0] }}</span>
                        </div>

                        <div class="d-flex flex-column mb-8">
                            <label class="fw-semibold mb-2">Ghi chú</label>
                            <textarea class="form-control" v-model="formProjectType.note" rows="3" name="target_details" placeholder="Nhập nội dung ghi chú"></textarea>
                            <div class="w-100"></div>
                            <span v-if="errors.note" class="text-danger  mt-3">{{ errors.note[0] }}</span>
                        </div>
                        <!--end::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row" v-if="isClickProjectTypeUpdate === true">
                            <label class="required fs-6 fw-semibold mb-2">Trạng thái</label>

                            <select class="form-select" :class="{ 'select-custom-valid' :  errors.status}" data-placeholder="Chọn trạng thái" v-model="formProjectType.status" aria-label="Default select example">
                                <option value="1">Sử dụng</option>
                                <option value="0">Ngừng sử dụng</option>
                            </select>
                            <div class="w-100"></div>
                            <span v-if="errors.status" class="text-danger">{{ errors.status[0] }}</span>
                        </div>

                        <div class="modal-footer">
                        <button type="button" @click.prevent="isClickProjectTypeUpdate ? updateProjectType() : storeProjectType()" class="btn btn-function me-4">
                            <i class="fa-solid fa-floppy-disk"></i> Lưu
                        </button>
                        <button @click="closeModal()"
                            type="button"
                            class="btn btn-secondary btn-sm btn-active-color-light"
                            id="close-modal"
                            data-bs-dismiss="modal"
                        >
                        <i class="fa-solid fa-xmark"></i>Đóng
                        </button>
                 </div>
                        <!--end::Actions-->
                    </form>

                    <!--end:Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
</template>

<script setup>
import { defineProps, ref, reactive, computed, onMounted, toRefs } from 'vue';
import { helperFunc } from '../../helper/heplerFunction.js'
import { sweetAlertMessage } from '../../helper/sweetAlert';
import { useToast } from '../../helper/toastMessage';
import { textCode, validateInput } from '../../../services/utils';
import axios from "axios";

const props = defineProps({
    title: String,
    btnAdd: {
        type: Boolean,
        default: false,
    }

})
const formProjectType = reactive({
    code: "",
    name: "",
    note: "",
})
// handle chọn số bản ghi / 1 trang
let selectTotalRecord = ref(10);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
}
const projectTypes = ref([]);
let getMetaPaginate = ref({});
const getProjectTypes = (params= null) => {
      KTApp.showPageLoading();
    axios({
        url: '/project-types/get-all',
        method: "GET",
        params: params
    })
    .then(res => {
        const { data, meta } = res.data;
        projectTypes.value = data;
        getMetaPaginate.value = meta;
        //  if (res.data?.message) {
        //         useToast.errorToast(res.data?.message);
        //     }
    }).catch(error => {
        console.log(error);
    })
    .finally(()=>{
         KTApp.hidePageLoading();
    })
}
const pagination = computed(() => {
    return getMetaPaginate.value?.pagination ?
    getMetaPaginate.value.pagination : { current_page: 1, total_pages:1, per_page: 30}
});

const changePage = (newDataPagination) => {
    let requestPaginate = {
        page: newDataPagination.current_page,
        per_page: newDataPagination.per_page
    }
    requestPaginate = {...requestPaginate, ...searchProjectType}
    getProjectTypes(requestPaginate);
}
const current_page = toRefs(pagination);
onMounted(() => {
    getProjectTypes();
})

const errors = ref([])
const storeProjectType = ()=>{
     KTApp.showPageLoading();
    axios.post('/project-types/store', formProjectType)
        .then(res => {
            useToast.successToast(res.data.message)
            // $('#formCreateProjectType').modal('hide')
            // $('.modal-backdrop').remove();
            const btnClose = document.getElementById('close-modal');
            btnClose.click();
            getProjectTypes();
        }).catch((error) => {
         errors.value = error.response.data.errors;
    })
    .finally(()=>{
         KTApp.hidePageLoading();
    })
}

let projectType_id = ref(0);
let canDisabledCode = ref(false);
let isClickProjectTypeUpdate = ref(false);

const handleUpdate = (item) => {
    projectType_id.value = item.id;
    isClickProjectTypeUpdate.value = true;
    formProjectType.code = item.code;
    formProjectType.name = item.name;
    formProjectType.note = item.note;
    formProjectType.status = item.status;
    errors.value = [];
    canDisabledCode.value = true;
}
const clickCreateProjectType = () => {
    isClickProjectTypeUpdate.value = false;
    formProjectType.code = "";
    formProjectType.name="";
    formProjectType.note="";
    errors.value = [];
    canDisabledCode.value = false;
}
const updateProjectType = () => {
    //  KTApp.showPageLoading();
    axios.post('/project-types/update/'+ `${projectType_id.value}`, formProjectType)
        .then(res => {
            useToast.successToast(res.data.message)
            // $('#formCreateProjectType').modal('hide')
            // $('.modal-backdrop').remove();
            const btnClose = document.getElementById('close-modal');
            btnClose.click();
            changePage(getMetaPaginate.value.pagination)
        }).catch((error) => {
         errors.value = error.response.data.errors;
    })
}

const handleDelete = (id) => {
    sweetAlertMessage.messageWarning("Bạn có chắc chắn muốn xóa không?")
     .then(function(result) {
        if(result.value) {
             KTApp.showPageLoading();
            axios({
                'url': '/project-types/destroy/'+ id,
                'method' : 'delete'
            })
            .then(res => {
                useToast.successToast(res.data.message)
                    const totalRecordOnPage = getMetaPaginate.value.pagination.count;
                    if (totalRecordOnPage - 1 === 0) {
                        getMetaPaginate.value.pagination.current_page -= 1;
                    }
                    if (getMetaPaginate.value.pagination.total - 1 === 0) {
                        getProjectTypes();
                    }
                 changePage(getMetaPaginate.value.pagination)
            }).catch((error) => {
                console.log(error);
            }).finally(()=>{
                KTApp.hidePageLoading();
            })
        }
    })
}
const closeModal=()=>{
    // $('#formCreateProjectType').modal('hide')
    // $('.modal-backdrop').remove();
    changePage(pagination);
}
// tìm kiếm
const searchProjectType= reactive({
    nameOrCode: ""
})
const searchNow = () => {
    changePage(pagination);
}
</script>

<style scoped>
.input-custom-valid {
    border: 1px solid red;
}
.select-custom-valid {
    border: 1px solid red;
}
.input-disabled {
    background-color: lightgray;
}
</style>
