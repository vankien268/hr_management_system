<template lang="">
    <div class="modal fade" tabindex="-1" id="modal_update_status" data-bs-keyboard="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Cập nhật trạng thái</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2 icon-close btn-color-white" data-bs-dismiss="modal" @click="emits('unset-data')"
                        aria-label="Close">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body mt-0 p-0 ps-2 pe-2">
                        <div class="row col-lg-12 ms-2" v-if="props.status">
                            <div class="row g-2 mt-0 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label class="col-form-label">Loại trạng thái</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-8">
                                    <select class="form-select mb-lg-0 p-2 pe-5" v-model="props.status.type" :disabled="props.status.is_delete == false">
                                        <option v-for="(
                                                status, index
                                            ) in props.statusType" :key="index" :value="status.value">
                                            {{ status.name }}
                                        </option>
                                    </select>
                                    <base-validation
                                        :message="errors['type']"/>
                                </div>
                            </div>
                            <div class="row g-2 mt-0 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="inputPassword6" class="required col-form-label">Tên trạng thái</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" class="required form-control mb-lg-0 p-2" v-model="props.status.name" />
                                    <base-validation
                                        :message="errors['name']"
                                         />
                                </div>
                            </div>
                            <div class="row g-2 mt-0 col-lg-12">
                                <div class="col-lg-3">
                                    <label for="inputPassword6" class="col-form-label">Diễn giải:</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <textarea type="text" class="form-control mb-lg-0 p-2" v-model="props.status.note" rows="3"></textarea>
                                    <base-validation
                                        :message="errors['note']"
                                         />
                                </div>
                            </div>
                            <div class="row g-2 mt-0 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="inputPassword6" class="col-form-label">Trạng thái:</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-8">
                                    <select class="form-select mb-lg-0 p-2 pe-5" v-model="props.status.status" >
                                        <option :value="false">
                                            Ngừng sử dụng
                                        </option>
                                        <option :value="true">
                                            Sử dụng
                                        </option>
                                    </select>
                                    <base-validation
                                        :message="errors['status']"
                                         />
                                </div>
                            </div>
                        </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-function me-4" @click="sendData()">
                            <i class="fa-solid fa-floppy-disk"></i> Lưu
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm btn-active-color-light" id="close_modal_update_status" data-bs-dismiss="modal"
                            @click="emits('unset-data')">
                            <i class="fa-solid fa-xmark"></i>Đóng
                        </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, reactive, watch, onBeforeMount } from "vue";
import { update } from "../../helper/axiosConfig";
import { useSystemStatusStore } from '../../stores/status'
import { useToast} from '../../helper/toastMessage'

const store = useSystemStatusStore();
const props = defineProps({
    statusType: {
        type: [Array],
        default: function () {
            return [];
        },
    },
    status: {
        type: Object,
        default: function () {
            return {
                id: 0,
                name: '',
                type: 0,
                note: '',
                status: true,
            };
        }
    },
});

const emits = defineEmits(['unset-data']);

const errors = ref([]);


const cancelUpdate = () => {
    emits('unset-data');
}

const sendData = () => {
    update("/system-status/api/" + props.status.id, props.status)
        .then((res) => {
            useToast.successToast("Cập nhật thành công!");
            const btnClose = document.getElementById('close_modal_update_status');
            btnClose.click();
            // btnClose.dataset.bsDismiss = "modal"
        })
        .catch((err) => {
            errors.value = err.response.data.errors;
            console.log(errors.value);
        });
};

</script>
<style lang=""></style>
