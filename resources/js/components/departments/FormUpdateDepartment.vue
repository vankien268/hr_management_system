<template>
    <div class="modal fade" data-bs-keyboard="true" data-bs-backdrop="static" id="formUpdateDepartment" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-left">
                    <!--begin::Close-->
                    <h4 class="modal-title ">
                           Sửa bộ phận
                         </h4>
                    <div @click="closeModalEditDepartment()" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <!--begin:Form-->
                    <form id="kt_modal_new_target_form" class="form" action="#">
                        <!--begin::Input group-->
                        <div class="row g-9 mb-8">
                            <div class="col-md-6 fv-row">
                                <label class="required fw-semibold mb-2">Mã bộ phận</label>
                                <!--begin::Input-->
                                <div class="position-relative d-flex align-items-center">
                                    <input class="form-control ps-12" :disabled="true" style=" background-color: lightgray" v-model="formDepartment.code" placeholder="Nhập mã bộ phận" name="due_date" />
                                    <!--end::Datepicker-->
                                </div>
                                <!--end::Input-->
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="fw-semibold mb-2">Cấp cha</label>
                                <select class="form-select" :class="{ 'select-custom-valid' :  errors.parent_id}"  data-placeholder="Chọn trạng thái" v-model="formDepartment.parent_id" aria-label="Default select example">
                                    <option :value="null">Vui lòng chọn</option>
                                    <option :value="item.id" v-for="(item,index) in getParent" :key="index">{{ item.name }}</option>
                                </select>
                                <div class="w-100"></div>
                                <span v-if="errors.parent_id" class="text-danger mt-3">{{ errors.parent_id[0] }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fw-semibold mb-2">
                                <span class="required">Tên bộ phận</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control" :class="{ 'input-custom-valid' :  errors.name}" v-model="formDepartment.name"  placeholder="Nhập tên bộ phận" name="target_title" />
                            <div class="w-100"></div>
                            <span v-if="errors.name" class="text-danger mt-3">{{ errors.name[0] }}</span>
                        </div>

                        <div class="d-flex flex-column mb-8">
                            <label class="fw-semibold mb-2">Ghi chú</label>
                            <textarea class="form-control" rows="3" :class="{ 'input-custom-valid' :  errors.note}" v-model="formDepartment.note" name="target_details" placeholder="Nhập nội dung ghi chú"></textarea>
                            <div class="w-100"></div>
                            <span v-if="errors.note" class="text-danger mt-3">{{ errors.note[0] }}</span>
                        </div>
                        <!--end::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="required fw-semibold mb-2">Trạng thái</label>

                            <select class="form-select" :class="{ 'select-custom-valid' :  errors.status}" data-placeholder="Chọn trạng thái" v-model="formDepartment.status" aria-label="Default select example">
                                <option value="1">Sử dụng</option>
                                <option value="0">Ngừng sử dụng</option>
                            </select>
                            <div class="w-100"></div>
                            <span v-if="errors.status" class="text-danger mt-3">{{ errors.status[0] }}</span>
                        </div>

                        <div class="modal-footer">
                            <button type="button"  @click.prevent="updateDepartment()" class="btn btn-function me-4">
                                <i class="fa-solid fa-floppy-disk"></i> Lưu
                            </button>
                            <button  @click="closeModalEditDepartment()"
                                type="button"
                                class="btn btn-function"
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
import {computed, defineProps, reactive, ref, toRefs, watch} from 'vue';
import { useToast } from '../../helper/toastMessage';
const props = defineProps({
    dataDepartmentInfo: Object,
    getParentDepartment: Array
})
let formDepartment = reactive({
    code: "",
    name: "",
    parent_id: null,
    note: "",
    status: 1
})
let errors = ref([]);
formDepartment = props.dataDepartmentInfo;

const getParent = computed(() => {
    return props.getParentDepartment.filter((item) => (item.id != props.dataDepartmentInfo.id));
})

const emit= defineEmits(['updateDepartment'])
const updateDepartment =() => {
     KTApp.showPageLoading();
    axios.post('/departments/update/'+ `${props.dataDepartmentInfo.id}`, formDepartment)
        .then(res => {
            useToast.successToast(res.data.message)
            // $('#formUpdateDepartment').modal('hide')
            // $('.modal-backdrop').remove();
            const btnClick = document.getElementById('close-modal');
            btnClick.click();
            emit('updateDepartment')
        }).catch((error) => {
         errors.value = error.response.data.errors;
        if(error.response?.data?.code == 403) {
            useToast.errorToast(error.response.data?.errors?.message);
        }
    }).finally(()=> {
          KTApp.hidePageLoading();
    });
}
const closeModalEditDepartment =() => {
    errors.value = [];
    // $('#formUpdateDepartment').modal('hide')
    // $('.modal-backdrop').remove();
}

</script>

<style scoped>
.input-custom-valid {
    border: 1px solid red;
}
.select-custom-valid {
    border: 1px solid red;
}
</style>
