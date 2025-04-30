<template>
    <div class="modal fade" tabindex="-1" id="modal_create_status" data-bs-keyboard="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content min-h-65 max-h-65">
                <div class="modal-header">
                    <h3 class="modal-title">Thêm mới trạng thái</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2 icon-close" data-bs-dismiss="modal" @click="closeModal()"
                        aria-label="Close">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body p-0 ps-2 pe-2">
                    <div v-for="(item, index) in formData" :key="index">
                        <div class="row col-lg-12 ms-1">
                            <div class="row g-3 align-items-center col-lg-3">
                                <div class="col-lg-5">
                                    <label class="col-form-label">Loại trạng thái</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <select class="form-select mb-lg-0 p-2 pe-5" data-placeholder="Select an option"
                                        v-model="item.type">
                                        <option v-for="(status, index) in props.statusType" :key="index"
                                            :value="status.value">
                                            {{ status.name }}
                                        </option>
                                    </select>
                                    <base-validation :message="errors['data.' + index + '.type']
                                        " :data="index" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-4">
                                <div class="col-lg-4">
                                    <label for="inputPassword6" class="required col-form-label">Tên trạng thái</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" class="required form-control mb-lg-0 p-2" v-model="item.name" />
                                    <base-validation :message="errors['data.' + index + '.name']
                                        " :data="index" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-4">
                                <div class="col-lg-3">
                                    <label for="inputPassword6" class="col-form-label">Diễn giải:</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control mb-lg-0 p-2" v-model="item.note" />
                                    <base-validation :message="errors['data.' + index + '.note']" :data="index" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-1 pt-1" v-if="formData.length > 1">
                                <div class="d-flex">
                                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                        @click="removeRow(index)">
                                        <i class="ki-duotone ki-trash fs-2 text-danger">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </a>
                                </div>
                                <div class="fv-plugins-message-container invalid-feedback opacity-0">
                                    <div data-field="text_input" data-validator="notEmpty">
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="card-toolbar mb-2">
                            <a href="#" class="btn btn-function" @click="addRow()">
                                <i class="ki-duotone ki-plus fs-2"></i>Thêm</a>
                        </div>
                        <span class="fs-6 pb-1 ms-3"> Tổng {{ formData.length }}</span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-function me-4" @click="sendData()">
                            <i class="fa-solid fa-floppy-disk"></i> Lưu
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm btn-active-color-light" id="close_modal_create_status" data-bs-dismiss="modal" @click="closeModal()">
                            <i class="fa-solid fa-xmark"></i>Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, reactive, watch, onBeforeMount } from "vue";
import { create} from "../../helper/axiosConfig";
import { useSystemStatusStore } from "../../stores/status";
import { useToast} from '../../helper/toastMessage'
const props = defineProps({
    statusType: {
        type: [Array],
        default: function () {
            return [];
        },
    },
});

const store = useSystemStatusStore();

const formData = reactive([
    {
        type: 0,
        name: "",
        note: "",
    },
]);

const errors = ref([]);

const addRow = () => {
    formData.push({
        type: 0,
        name: "",
        note: "",
    });
};
const removeRow = (index) => {
    formData.splice(index, 1);
};

const click = (e) => {
    e.preventDefault();
    e.stopPropagation();
    console.log("onclick");
};

const closeModal = () => {
    formData.splice(0, formData.length);
    addRow();
    errors.value = [];
}

const sendData = () => {
    create("/system-status/api", {data: formData})
        .then((res) => {
            store.pushData(res.data.data);
            useToast.successToast("Thêm mới thành công!");
            const btnClose = document.getElementById("close_modal_create_status");
            btnClose.click();
            // btnClose.dataset.bsDismiss = "modal"
        })
        .catch((err) => {
            errors.value = err.response.data.errors;
            console.log(errors.value);
        });
};
</script>
<style lang="scss" scoped>
.max-h-75 {
    max-height: 75%;
}
</style>
