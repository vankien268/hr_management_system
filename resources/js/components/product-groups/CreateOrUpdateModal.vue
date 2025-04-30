<template>
    <div class="modal fade" tabindex="-1" id="modal_product_group" data-bs-keyboard="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content min-h-50 max-h-75">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{
                            props.group.id != 0
                            ? "Cập nhật nhóm sản phẩm, dịch vụ"
                            : "Thêm mới nhóm sản phẩm, dịch vụ"
                        }}
                    </h4>

                    <div class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2" data-bs-dismiss="modal"
                        @click="closeModal(props.group.id)" aria-label="Close">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                </div>

                <div class="modal-body p-0 ps-2 pe-2 mb-3">
                    <div class="row col-lg-12 ms-3">
                        <div class="col-lg-7">
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="addresss" class="required col-form-label">Danh mục cha</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <select class="form-select" v-model="props.group.parent_id">
                                        <option v-for="(item, index) in props.productGroups.filter(e => e.id != props.group.id)" :key="index" :value="item.id">
                                            {{ item.prefix }} {{ item.name }}</option>
                                    </select>
                                    <base-validation :message="errors.parent_id"/>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="name" class="required col-form-label">Tên nhóm</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control mb-lg-0 p-2"
                                        :class="{ 'input-custom-valid': errors.name }" v-model="props.group.name"
                                        id="name" />
                                    <base-validation :message="errors.name" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="inputPassword6" class="col-form-label">Ghi chú</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <textarea class="form-control form-control-solid" placeholder="Ghi chú"
                                        :class="{ 'input-custom-valid': errors.note }" v-model="props.group.note"
                                        rows="3"></textarea>
                                    <base-validation :message="errors.note" />
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-5">
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label for="Code" class="required col-form-label">Mã nhóm</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" :disabled="props.group.id != 0" id="Code"
                                        @keypress="filterCodeInput($event)" class="required form-control mb-lg-0 p-2"
                                        :class="{ 'input-custom-valid': errors.code }" v-model="props.group.code" />
                                    <base-validation :message="errors.code" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label for="inputPassword6" class="required col-form-label">Thuế</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <select class="form-select" v-model="props.group.tax_id">
                                        <option :value="null">--Chọn--</option>
                                        <option v-for="(item, index) in props.taxList.filter(x =>{
                                            if(props.group.id != 0){
                                                return true;
                                            }
                                            return x.status == true;
                                        })" :key="index" :value="item.id" :disabled="item.status == false">{{
                                            item.rate }}</option>
                                    </select>
                                    <base-validation :message="errors.tax_id"/>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label for="inputPassword6" class="required col-form-label">Phí</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <select class="form-select" v-model="props.group.fee_id">
                                        <option :value="null">--Chọn--</option>
                                        <option v-for="(item, index) in props.feeList.filter(x =>{
                                            if(props.group.id != 0){
                                                return true;
                                            }
                                            return x.status == true;
                                        })" :key="index" :value="item.id" :disabled="item.status == false">{{
                                            item.rate }}</option>
                                    </select>
                                    <base-validation :message="errors.fee_id"/>
                                </div>
                            </div>
                            <div class="row g-2 mt-0 align-items-center col-lg-12" v-if="props.group.id != 0">
                                <div class="col-lg-4">
                                    <label for="status" class="col-form-label">Trạng thái:</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <select class="form-select" id="status" :disabled="props.group.edit_status == false" v-model="props.group.status">
                                        <option :value="false">
                                            Ngừng sử dụng
                                        </option>
                                        <option :value="true">
                                            Sử dụng
                                        </option>
                                    </select>
                                    <base-validation :message="errors.status" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-function me-4" @click="sendData()">
                        <i class="fa-solid fa-floppy-disk"></i> Lưu
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm btn-active-color-light" id="close-modal"
                        data-bs-dismiss="modal" @click="closeModal(props.group.id)">
                        <i class="fa-solid fa-xmark"></i>Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { defineProps, ref, defineEmits, watch } from "vue";
import { useProductGroupStore } from "../../stores/product";
import { getData, create, update } from "../../helper/axiosConfig";
import { useToast } from '../../helper/toastMessage'
import { filterCodeInput, filterNumberInput } from '../../helper/filterInput'

const store = useProductGroupStore();

const props = defineProps({
    productGroups: {
        type: Array,
        default: [],
    },
    group: {
        type: Object,
        default: [],
    },
    taxList: {
        type: Array,
        default: []
    },
    feeList: {
        type: Array,
        default: []
    }
});


const emits = defineEmits(["close-model"]);

const closeModal = (id) => {
    errors.value = [];
    emits('close-model', id);
}

const errors = ref([]);

watch(() => props.group.code, (newValue, oldValue) => {
    props.group.code = newValue.toUpperCase();
})

const sendData = () => {
    console.log(props.group);
    if (props.group.id == 0) {
        create("/products/groups/api", props.group)
            .then((res) => {
                console.log(res.data.data);
                store.getData();
                props.group.id = res.data.data.id;
                const btnClose = document.getElementById("close-modal");
                btnClose.click();
                useToast.successToast('Thêm mới thành công!');
                // btnClose.dataset.bsDismiss = "modal"
            })
            .catch((err) => {
                console.log(err);
                errors.value = err.response.data.errors;
            });
        return;
    }

    update("/products/groups/api/" + props.group.id, props.group)
        .then((res) => {
            store.getData();
            const btnClose = document.getElementById("close-modal");
            btnClose.click();
            useToast.successToast('Cập nhật thành công!');
            // btnClose.dataset.bsDismiss = "modal"
        })
        .catch((err) => {
            errors.value = err.response.data.errors;
            console.log(errors.value);
        });
};
</script>
<style lang="scss" scoped>
.input-width,
.va-date-input,
.va-time-input {
    margin: 8px auto;
    width: 100%;
}
</style>
