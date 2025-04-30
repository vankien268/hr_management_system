<template>
    <Modal :title="props.customer.id != 0
        ? 'Cập nhật khách hàng'
        : 'Thêm mới khách hàng'" @close-modal="closeModal(props.customer.id)">
        <template #body>
            <div class="row col-lg-12 ms-3">
                <div class="col-lg-7">
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="customerCode" class="required col-form-label">Mã khách hàng</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-5">
                            <input type="text" :disabled="props.customer.id != 0" id="customerCode"
                                @keypress="filterCodeInput($event)" class="required form-control mb-lg-0 p-2"
                                :class="{ 'input-custom-valid': errors.code }" v-model="props.customer.code" />
                            <base-validation :message="errors.code" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="taxCode" class="col-form-label">Mã số thuế</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control mb-lg-0 p-2"
                                :class="{ 'input-custom-valid': errors.tax_code }" id="taxCode"
                                v-model="props.customer.tax_code" />
                            <base-validation :message="errors.tax_code" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="name" class="required col-form-label">Tên khách hàng</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <input type="text" class="form-control mb-lg-0 p-2"
                                :class="{ 'input-custom-valid': errors.name }" v-model="props.customer.name" id="name" />
                            <base-validation :message="errors.name" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="addresss" class="col-form-label">Địa chỉ</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <div class="row col-lg-12">
                                <div class="col-lg-4">
                                    <SelectSearch :list-data="props.cities" v-model="props.customer.city_id"
                                        placeholder="Tỉnh/Thành phố" key-display="name" key-value="id" />
                                    <!-- <select class="form-select"
                                                v-model="props.customer.city_id">
                                                <option :value="null">Tỉnh/Thành phố</option>
                                                <option v-for="(item, index) in props.cities" :key="index" :value="item.id">{{ item.name }}</option>
                                            </select> -->
                                </div>
                                <div class="col-lg-4">
                                    <SelectSearch :list-data="filterDistricts(props.districts, props.customer.city_id)"
                                        v-model="props.customer.district_id" :disabled="props.customer.city_id == null"
                                        placeholder="Quận/Huyện" key-display="name" key-value="id" />
                                    <base-validation />
                                </div>
                                <div class="col-lg-4">
                                    <SelectSearch :list-data="filterWards(props.wards, props.customer.district_id)"
                                        v-model="props.customer.ward_id" :disabled="props.customer.district_id == null"
                                        placeholder="Phường/Xã" :key-display="['prefix', 'name']" prefix="" key-show="name"
                                        key-value="id" />

                                    <base-validation />
                                </div>
                            </div>
                            <input type="text" class="form-control mb-lg-0 p-2" v-model="props.customer.address"
                                :class="{ 'input-custom-valid': errors.address }" />
                            <base-validation :message="errors.address" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="status" class="required col-form-label">Trạng thái khách</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-5">
                            <select class="form-select" :class="{ 'input-custom-valid': errors.status_id }"
                                v-model="props.customer.status_id">
                                <option value="">--Chọn--</option>
                                <option v-for="(item, index) in systemStatus" :key="index" :value="item.id">{{
                                    item.name }}</option>
                            </select>
                            <base-validation :message="errors.status_id" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="customerType" class="col-form-label">Phân loại khách hàng</label>
                            <base-validation />
                        </div>
                        <div class="d-flex col-lg-7 pb-5">
                            <div class="col-lg-6 form-check form-check-custom form-check-solid" v-if="props.btnCustomerVip">
                                <input class="form-check-input" type="radio" name="customerType" value="1"
                                    v-model="props.customer.customer_type" id="vip" />
                                <label class="form-check-label" for="vip">
                                    Khách hàng VIP
                                </label>
                            </div>
                            <div class="col-lg-6 form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="radio" name="customerType" value="0"
                                    v-model="props.customer.customer_type" id="normal" />
                                <label class="form-check-label" for="normal">
                                    Khách thường
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="inputPassword6" class="col-form-label">Ghi chú</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <textarea class="form-control form-control-solid" placeholder="Ghi chú khách hàng"
                                :class="{ 'input-custom-valid': errors.note }" v-model="props.customer.note"
                                rows="3"></textarea>
                            <base-validation :message="errors.note" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="created_at" class="col-form-label">Ngày khai báo</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-6">
                            <input type="date" id="created_at" disabled v-model="props.customer.created_at"
                                class="form-control mb-lg-0 p-2" />
                            <base-validation />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="representative" class="required col-form-label">Người đại diện</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="required form-control mb-lg-0 p-2"
                                :class="{ 'input-custom-valid': errors.representative_name }"
                                v-model="props.customer.representative_name" />
                            <base-validation :message="errors.representative_name" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="inputPassword6" class="col-form-label">SDT người đại diện</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="required form-control mb-lg-0 p-2"
                                :class="{ 'input-custom-valid': errors.representative_phone }"
                                v-model="props.customer.representative_phone" @keypress="filterNumberInput($event)" />
                            <base-validation :message="errors.representative_phone" />

                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="email" class="col-form-label">Email</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control mb-lg-0 p-2"
                                v-model="props.customer.representative_email"
                                :class="{ 'input-custom-valid': errors.representative_email }" />
                            <base-validation :message="errors.representative_email" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="inputPassword6" class="col-form-label">Ngân hàng</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-6">
                            <SelectSearch :list-data="props.banks" v-model="props.customer.bank_id" placeholder="--Chọn--"
                                key-display="name" key-value="id" />
                            <base-validation />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="inputPassword6" class="col-form-label"
                                :class="{ 'required': props.customer.bank_id != '' }">Số tài khoản</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control mb-lg-0 p-2" :disabled="props.customer.bank_id == null"
                                :class="{ 'input-custom-valid': errors.bank_number }"
                                v-model="props.customer.bank_number"
                                 @keypress="filterNumberInput($event)" />
                            <base-validation :message="errors.bank_number" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="inputPassword6" class="col-form-label"
                                :class="{ 'required': props.customer.bank_id != '' }" >Tên tài khoản</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control mb-lg-0 p-2" @input="props.customer.bank_username = $event.target.value.toUpperCase()"
                              @keydown="filterInputOnlyAZ($event)" :disabled="props.customer.bank_id == null"
                                :class="{ 'input-custom-valid': errors.bank_username }"
                                v-model="props.customer.bank_username" />
                            <base-validation :message="errors.bank_username" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="inputPassword6" class="col-form-label required">Người phụ trách</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-6">
                            <SelectSearchUser :list-data="users" v-model="props.customer.user_id" placeholder="--Chọn--"
                                key-display="name" key-value="id" />

                            <base-validation :message="errors.user_id"/>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <button type="button" class="btn btn-function me-4" @click="sendData()">
                <i class="fa-solid fa-floppy-disk"></i> Lưu
            </button>
            <button type="button" class="btn btn-secondary btn-sm btn-active-color-light" id="close-modal"
                data-bs-dismiss="modal" @click="closeModal(props.customer.id)">
                <i class="fa-solid fa-xmark"></i>Đóng
            </button>
        </template>
    </Modal>
</template>
<script setup>
import { ref, defineEmits, watch, computed, onBeforeMount, onBeforeUnmount } from "vue";
import { useCustomerStore, customer } from "../../stores/customer";
import { useSystemStatusStore } from "../../stores/status";
import { getData, create, update } from "../../helper/axiosConfig";
import { useToast } from '../../helper/toastMessage'
import { filterCodeInput, filterNumberInput, filterInputOnlyAZ } from '../../helper/filterInput'
import SelectSearch from '../input/SelectSearch.vue'
import SelectSearchUser from '../input/SelectSearchUser.vue'
import Modal from '../modal/ScrollModal.vue'

const store = useCustomerStore();
const statusStore = useSystemStatusStore();
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
    },
    users: {
        type:Array,
        default: []
    },
    btnCustomerVip: {
        type: Boolean,
        default: false,
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

const systemStatus = computed(() => {
    console.log(props.customer);
    const stt = statusStore.$state.statuses.data;
    if (props.customer.id !== 0) {
        const check = stt.findIndex(x => x.id == props.customer.status.data.id);
        if (check == -1) {
            return statusStore.$state.statuses.data.concat([props.customer.status.data]);
        }
    }
    return stt;
})

const filterWards = (arr, districtId) => {
    if (districtId != null || districtId != '') {
        return arr.filter(item => item.district_id == districtId);
    }
    return [];
}

watch(() => props.customer.city_id, (newValue, oldValue) => {
    console.log(oldValue);
    if (oldValue !== null) {
        props.customer.district_id = null;
    }
});

watch(() => props.customer.district_id, (newValue, oldValue) => {
    props.customer.ward_id = null
    if (oldValue !== null) {
        props.customer.ward_id = null;
    }
});

// watch(() => props.customer.bank_number, (newValue, oldValue) => {
//     console.log(newValue, 'phone', isNaN(newValue))
//         if (isNaN(newValue)) {
//             return oldValue;
//         }
//         return newValue;
// }, { deep: true })

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
                errors.value = err.response.data.errors ?? [];
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
            errors.value = err.response.data.errors ?? [];
            console.log(errors.value);
        });
};

const getListStatus = (key) => {
    statusStore.getSystemStatusUsingData(key);
};

onBeforeMount(() => {
    getListStatus(2);
});

</script>
<style lang="scss" scoped>
.input-width,
.va-date-input,
.va-time-input {
    margin: 8px auto;
    width: 100%;
}
</style>
