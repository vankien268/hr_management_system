<template>
    <div class="modal fade" tabindex="-1" id="modal_customer" data-bs-keyboard="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content min-h-50 max-h-75">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{
                            props.customer.id != 0
                            ? "Cập nhật biên bản nghiệm thu"
                            : "Thêm biên bản nghiệm thu"
                        }}
                    </h4>

                    <div class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2" data-bs-dismiss="modal"  @click="closeModal(props.customer.id)"
                        aria-label="Close">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                </div>

                <div class="modal-body p-0 ps-2 pe-2 mb-3">
                    <div class="row col-lg-12 ms-3">
                        <div class="col-lg-6">
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="customerCode" class="required col-form-label">Mã biên bản nghiệm thu</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" :disabled="props.customer.id != 0" id="customerCode" @keypress="filterCodeInput($event)"
                                        class="required form-control mb-lg-0 p-2" :class="{ 'input-custom-valid': errors.code}" v-model="props.customer.code" />
                                    <base-validation :message="errors.code" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="taxCode" class="required col-form-label">Tiêu đề biên bản nghiệm thu</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control mb-lg-0 p-2" :class="{ 'input-custom-valid': errors.tax_code}" id="taxCode"
                                        v-model="props.customer.tax_code" />
                                        <base-validation :message="errors.tax_code" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="name" class="required col-form-label">Ngày gửi</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control mb-lg-0 p-2" :class="{ 'input-custom-valid': errors.name}" v-model="props.customer.name"
                                        id="name" />
                                        <base-validation :message="errors.name" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="name" class="required col-form-label">Người gửi</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control mb-lg-0 p-2" :class="{ 'input-custom-valid': errors.name}" v-model="props.customer.name"
                                        id="name" />
                                        <base-validation :message="errors.name" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="inputPassword6" class="col-form-label">Ghi chú</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-6">
                                    <textarea class="form-control form-control-solid" placeholder="Ghi chú khách hàng" :class="{ 'input-custom-valid': errors.note}" v-model="props.customer.note" rows="3"></textarea>
                                    <base-validation :message="errors.note" />
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label for="status" class="required col-form-label">Dự án</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <select class="form-select" :class="{ 'input-custom-valid': errors.status_id}"
                                            v-model="props.customer.status_id">
                                                <option value="">--Chọn--</option>
                                                <option v-for="(item, index) in props.statuses" :key="index" :value="item.id">{{ item.name }}</option>
                                            </select>
                                            <base-validation :message="errors.status_id" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label for="inputPassword6" class="required col-form-label">Trạng thái</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <select class="form-select"
                                            v-model="props.customer.bank_id">
                                                <option :value="null">--Chọn--</option>
                                                <option v-for="(item, index) in props.banks" :key="index" :value="item.id">{{ item.name }}</option>
                                            </select>
                                    <base-validation />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label for="created_at" class="required col-form-label">Ngày nghiệm thu</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input type="date" id="created_at" disabled v-model="props.customer.created_at"
                                        class="form-control mb-lg-0 p-2" />
                                    <base-validation />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label for="representative" class="required col-form-label">Người nhận</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" class="required form-control mb-lg-0 p-2" :class="{ 'input-custom-valid': errors.representative_name}"
                                        v-model="props.customer.representative_name" />
                                        <base-validation :message="errors.representative_name" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-4">
                                    <label for="representative" class="required col-form-label">Thời gian bảo hành</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-5">
                                    <input type="text" class="required form-control mb-lg-0 p-2" :class="{ 'input-custom-valid': errors.representative_name}"
                                        v-model="props.customer.representative_name" />
                                        <base-validation :message="errors.representative_name" />
                                </div>
                                <div class="col-lg-2">
                                    <input disabled type="text" class="required form-control mb-lg-0 p-2" :class="{ 'input-custom-valid': errors.representative_name}"
                                        v-model="props.customer.representative_name" />
                                        <base-validation :message="errors.representative_name" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-function me-4" @click="sendData()">
                        <i class="fa-solid fa-floppy-disk"></i> Lưu
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm btn-active-color-light" id="close-modal" data-bs-dismiss="modal"
                        @click="closeModal(props.customer.id)">
                        <i class="fa-solid fa-xmark"></i>Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { defineProps, ref, defineEmits, watch } from "vue";
import { useCustomerStore, customer } from "../../stores/customer";
import { getData, create, update } from "../../helper/axiosConfig";
import { useToast } from '../../helper/toastMessage'
import { filterCodeInput, filterNumberInput } from '../../helper/filterInput'

const store = useCustomerStore();

const props = defineProps({
    customer: {
        type: Object,
        default: function () {
            return customer;
        },
    },
    statuses: {
        type: Array,
        default: [],
    },
    cities: {
        type: Array,
        default: []
    },
    districts: {
        type: Array,
        default: []
    },
    wards: {
        type: Array,
        default: []
    },
    banks: {
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

const filterDistricts = (arr, cityId) => {
    if (cityId != null || cityId != '') {
        return arr.filter(item => item.city_id == cityId);
    }
    return [];
}

watch(() => props.customer.code, (newValue, oldValue) => {
    props.customer.code = newValue.toUpperCase();
})

const filterWards = (arr, districtId) => {
    if (districtId != null || districtId != '') {
        return arr.filter(item => item.district_id == districtId);
    }
    return [];
}

watch(() => props.customer.city_id, (newValue, oldValue) => {
    console.log(oldValue);
    if (oldValue != null) {
        props.customer.district_id = null;
    }
});

watch(() => props.customer.district_id, (newValue, oldValue) => {
    props.customer.ward_id = null
    if (oldValue !== null) {

    }
});

const taxCodeList = () => {
    getData('https://api.vietqr.io/v2/business/0108737085')
        .then((res) => {
                console.log(res.data);
                // btnClose.dataset.bsDismiss = "modal"
            })
            .catch((err) => {
                console.log(err);
            });
}

const sendData = () => {
    taxCodeList();
    console.log(props.customer);
    if (props.customer.id == 0) {
        create("/customers/api", props.customer)
            .then((res) => {
                console.log(res.data.data);
                store.pushData(res.data.data);
                props.customer.id = res.data.data.id;
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

    update("/customers/api/" + props.customer.id, props.customer)
    .then((res) => {
            console.log(res.data);
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
