<template>
    <div class="modal fade" tabindex="-1" id="modal_contract_type" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" style="transform: translateY(-15%);">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ props.type.id != 0 ? 'Cập nhật loại hợp đồng' : 'Thêm mới loại hợp đồng' }}
                    </h4>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body p-0 ps-2 pe-2../">

                    <div class="row col-lg-12 ms-3">
                        <div class="row g-2 mt-0 align-items-center col-lg-12">
                            <div class="col-lg-4">
                                <label for="inputPassword6" class="required col-form-label">Mã loại hợp đồng</label>
                                <base-validation />
                            </div>
                            <div class="col-lg-7">
                                <input type="text" :disabled="props.type.id != 0" class="required form-control mb-lg-0 p-2"
                                    v-model="props.type.code" @keypress="filterCodeInput($event)" />
                                <base-validation :message="errors['code']" />
                            </div>
                        </div>
                        <div class="row g-2 mt-0 align-items-center col-lg-12">
                            <div class="col-lg-4">
                                <label for="inputPassword6" class="required col-form-label">Tên loại hợp đồng</label>
                                <base-validation />
                            </div>
                            <div class="col-lg-7">
                                <input type="text" class="required form-control mb-lg-0 p-2" v-model="props.type.name" />
                                <base-validation :message="errors['name']" />
                            </div>
                        </div>
                        <div class="row g-2 mt-0 col-lg-12">
                            <div class="col-lg-4">
                                <label for="note" class="col-form-label">Ghi chú</label>
                                <base-validation />
                            </div>
                            <div class="col-lg-7">
                                <textarea type="text" class="form-control mb-lg-0 p-2" id="note" v-model="props.type.note" rows="3"></textarea>
                                <base-validation :message="errors['note']" />
                            </div>
                        </div>
                        <div class="row g-2 mt-0 align-items-center col-lg-12" v-if="props.type.id != 0">
                            <div class="col-lg-4">
                                <label for="status" class="col-form-label">Trạng thái:</label>
                                <base-validation />
                            </div>
                            <div class="col-lg-7">
                                <select class="form-select mb-lg-0 p-2" id="status" v-model="props.type.status">
                                    <option :value="false">
                                        Ngừng sử dụng
                                    </option>
                                    <option :value="true">
                                        Sử dụng
                                    </option>
                                </select>
                                <base-validation :message="errors['status']" />
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-function me-4" @click="sendData()">
                        <i class="fa-solid fa-floppy-disk"></i> Lưu
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm btn-active-color-light" id="close-modal"
                        data-bs-dismiss="modal" @click="closeModal()">
                        <i class="fa-solid fa-xmark"></i>Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { defineProps, ref, defineEmits, watch } from "vue";
import { create, update } from "../../../helper/axiosConfig.js";
import { filterCodeInput, filterNumberInput } from '../../../helper/filterInput'
import { useToast } from '../../../helper/toastMessage'
import { useContracTypeStore } from '../../../stores/contract'

const props = defineProps({
    type: {
        type: Object,
        default: function () {
            return {
                id: 0,
                code: '',
                name: "",
                note: "",
                status: true,
            };
        },
    },
});

const store = useContracTypeStore();

const emits = defineEmits(['close-model']);

const errors = ref([]);

watch(() => props.type.code, (newValue, oldValue) => {
    props.type.code = newValue.toUpperCase();
})

const sendData = () => {
    console.log(props.type);
    if (props.type.id == 0) {
        create("/contracts/types/api", props.type)
            .then((res) => {
                console.log(res.data.data);
                store.pushData(res.data.data);
                const btnClose = document.getElementById('close-modal');
                btnClose.click();
                // btnClose.dataset.bsDismiss = "modal"
            })
            .catch((err) => {
                console.log(err);
                errors.value = err.response.data.errors;

            });
        return;
    }

    update("/contracts/types/api/" + props.type.id, props.type)
        .then((res) => {
            console.log(res.data);
            const btnClose = document.getElementById('close-modal');
            btnClose.click();
        })
        .catch((err) => {
            errors.value = err.response.data.errors;
            console.log(errors.value);
        });
};

const closeModal = () => {
    errors.value = [];
    emits('close-model');
}

</script>
<style lang="scss" scoped>
.max-h-75 {
    max-height: 75%;
}
</style>
