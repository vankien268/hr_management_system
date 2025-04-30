<template>
    <Modal :title="props.quote.id != 0
        ? 'Thông tin báo giá '
        : 'Thêm mới báo giá '" @close-modal="closeModal(props.quote.id)">
        <template #body>
            <div class="row col-lg-12 ms-1 mb-5 form" style="border-bottom: 1px solid rgb(212, 212, 212);">
                <div class="col-lg-6">
                    <div class="row g-3 align-items-center col-lg-12" v-if="props.quote.id != 0">
                        <div class="col-lg-4">
                            <label for="customerCode" class="required col-form-label">Mã báo giá</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-8">
                            <input type="text" disabled @keypress="filterCodeInput($event)" class="form-control mb-lg-0 p-2"
                                :class="{ 'is-invalid': errors.code }" v-model="props.quote.code" />
                            <base-validation :message="errors.code" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="taxCode" class="required col-form-label">Tiêu đề</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-8">
                            <input type="text" class="form-control mb-lg-0 p-2" id="title"
                                :disabled="props.quote.id != 0 && props.quote.editable === false"
                                :class="{ 'is-invalid': errors.title }" v-model="props.quote.title" />
                            <base-validation :message="errors.title" />
                        </div>
                    </div>
                    <!-- <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="customer_name" class="required col-form-label">Người lập báo giá</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" class="required form-control mb-lg-0 p-2"
                                        :disabled="props.contract.id != 0 && props.quote.editable === false"
                                        :class="{ 'is-invalid': errors.customer_contractor }"
                                        v-model="props.contract.customer_contractor" />
                                    <base-validation :message="errors.customer_contractor" />
                                </div>
                            </div> -->
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="inputPassword6" class="required col-form-label">Ngày báo giá</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-8">
                            <input type="date" class="form-control form-control-datetime mb-lg-0 p-2 w-auto" id="date"
                                :class="{ 'is-invalid': errors.quote_date }"
                                :disabled="props.quote.id != 0 && props.quote.editable === false"
                                v-model="props.quote.quote_date" />
                            <base-validation :message="errors.quote_date" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="name" class=" col-form-label">Người nhận báo giá</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-8">
                            <input type="text" class="form-control mb-lg-0 p-2" id="receiver"
                                :disabled="props.quote.id != 0 && props.quote.editable === false"
                                :class="{ 'is-invalid': errors.receiver }" v-model="props.quote.receiver" />
                            <base-validation :message="errors.receiver" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="status" class=" col-form-label">SDT người nhận</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-8">
                            <input type="text" class="form-control mb-lg-0 p-2" id="phone"
                                :disabled="props.quote.id != 0 && props.quote.editable === false"
                                :class="{ 'is-invalid': errors.phone }" v-model="props.quote.phone" @keypress="filterNumberInput"/>
                            <base-validation :message="errors.phone" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="status" class=" col-form-label">Email người nhận</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-8">
                            <input type="email" class="form-control mb-lg-0 p-2" id="email"
                                :disabled="props.quote.id != 0 && props.quote.editable === false"
                                :class="{ 'is-invalid': errors.email }" v-model="props.quote.email" />
                            <base-validation :message="errors.email" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="customerType" class="required col-form-label">Dự án</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <SelectSearch :class="{
                            'select-custom-valid':
                                errors.project_id
                        }" :list-data="permissionProjects?.length >0? projects.filter((item) => (permissionProjects.includes(item.id))) : projects"
                                :disabled="props.quote.id != 0 && props.quote.editable === false"
                                v-model="props.quote.project_id" placeholder="--Chọn--" key-display="name" key-value="id" />

                            <base-validation :message="errors.project_id" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="customer_name" class="col-form-label">Khách hàng</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <span class="form-control disable" style="height: 28px; background-color: #e1e4ec;">{{ customer ? customer.name : '' }}</span>
                            <base-validation :message="errors.customer_id" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="inputPassword6" class="required col-form-label">Loại hợp đồng</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <SelectSearch :list-data="contractType"
                                :disabled="props.quote.id != 0 && props.quote.editable === false"
                                v-model="props.quote.contract_type_id" key-value="id" placeholder="--Chọn--"
                                key-display="name" />

                            <base-validation :message="errors.contract_type_id" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center align-content-center col-lg-12" v-if="props.quote.id != 0">
                        <div class="col-lg-3">
                            <label for="quote_status" class="required col-form-label">Trạng thái</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <select class="form-select" :class="{ 'is-invalid': errors.status }"
                                v-model="props.quote.status" id="quote_status">
                                <option v-for="(item, index) in statuses" :key="index" :value="item.value">{{ item.name }}
                                </option>
                            </select>
                            <base-validation :message="errors.status" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="customer_name" class="required col-form-label">Người duyệt</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <SelectSearch :list-data="users" v-model="props.quote.approve_id" key-value="id"
                                :disabled="props.quote.id != 0 && props.quote.editable === false" placeholder="--Chọn--"
                                :key-display="['username', 'name']" key-show="name" key="approve_id"/>
                            <base-validation :message="errors.approve_id" />
                        </div>
                    </div>

                </div>
            </div>

            <ListProductPrice :details="props.quote.details"
                :products="props.products.filter(x => x.status == true || props.quote.details.data.some(e => e.product_id == x.id))"
                :disabled="props.quote.id != 0 && props.quote.editable === false" :errors="errorListProduct" />


            <div class="d-flex align-items-center justify-content-end px-20 py-2 " style="margin-right:10px;">
                <span class="fs-5 fw-bold">Tổng cộng:&nbsp; </span>
                <span class="fs-5"> {{ displayPrice(props.quote.total_amount) }} đ</span>
            </div>
               <div class="col-lg-12">
                            <label for="inputPassword6" class="col-form-label">Lưu ý</label>
                  </div>
                <div class="row g-3 col-lg-12">
                         <textarea style="height:100px;" type="text" id="created_at" v-model="props.quote.note"
                                :disabled="props.quote.id != 0 && props.quote.editable === false" class="form-control p-2"
                                :class="{ 'is-invalid': errors.note }" rows="3"></textarea>
                            <base-validation :message="errors.note" />
                </div>
        </template>
        <template #footer>
                  <button  v-if="props.action == 'update'" class="btn btn-danger btn-sm btn-active-color-light" @click="handlExportPdf">Xuất file PDF</button>
            <button type="button" class="btn btn-function me-4" @click="sendData()" v-if="props.action != 'view'">
                <i class="fa-solid fa-floppy-disk"></i> Ghi lại
            </button>
            <button type="button" class="btn btn-function me-4" @click="emits('update-data', 'update')" v-else>
                <i class="fa-solid fa-floppy-disk"></i> Sửa
            </button>
            <button type="button" class="btn btn-secondary btn-sm btn-active-color-light" id="close-modal"
                data-bs-dismiss="modal" @click="closeModal(props.quote.id)">
                <i class="fa-solid fa-xmark"></i>Đóng
            </button>
        </template>
    </Modal>
</template>
<script setup>
import { defineProps, ref, defineEmits, watch, onBeforeMount, computed } from "vue";
import { create, update } from "../../helper/axiosConfig";
import { useToast } from '../../helper/toastMessage'
import { filterCodeInput, filterNumberInput } from '../../helper/filterInput'
import { displayPrice } from '../../../services/utils'
import ListProductPrice from './ListProductPrice.vue'
import SelectSearch from "../input/SelectSearch.vue";
import Modal from "../modal/ScrollModal.vue";

import { useStoreProjects } from "../../stores/project";
import { useContractStore, useContracTypeStore } from "../../stores/contract";
import { useUsers } from "../../stores/user";
import { useQuoteStore } from "../../stores/quote";

const projectStore = useStoreProjects();
const contractTypeStore = useContracTypeStore();
const userStore = useUsers();

const quoteStore = useQuoteStore();

const props = defineProps({
    quote: {
        type: Object,
        default: function () {
            return null;
        },
    },
    types: {
        type: Array,
        default: []
    },
    users: {
        type: Array,
        default: []
    },
    customers: {
        type: Array,
        default: []
    },
    projects: {
        type: Array,
        default: []
    },
    products: {
        type: Array,
        default: []
    },
    action: {
        type: String,
    }
});



const emits = defineEmits(["close-model"]);

const closeModal = (id) => {
    errors.value = [];
    emits('close-model', id);
}

const errors = ref([]);
const errorListProduct = ref([]);

const statuses = computed(() => {
    return quoteStore.$state.statuses.data ?? [];
});
const permissionProjects = ref([]);
const projects = computed(() => {
      permissionProjects.value = projectStore.$state.projects?.permissionProjects;
    if (projectStore.$state.projects.data) {
        var pr = projectStore.$state.projects.data;
        if (props.quote.id != 0 && pr.findIndex(x => x.id === props.quote.project_id) == -1) {
            pr.push(props.quote.project);
        }
    } else {
        var pr = projectStore.$state.projects;
        if (props.quote.id != 0 && pr.findIndex(x => x.id === props.quote.project_id) == -1) {
            console.log('__push');
            pr.push(props.quote.project.data);
        }

    };
    return pr;
});

const customer = ref(null);

const contractType = computed(() => {
    const types = contractTypeStore.$state.types.data;
    if (props.quote.id !== 0) {
        const check = types.findIndex(x => x.id == props.quote.contract_type.data.id);
        if (check == -1) {
            return types.concat([props.quote.contract_type.data]);
        }
    }
    return types;
    // return contractTypeStore.$state.types.data ?? [];
});

const users = computed(() => {
    return userStore.$state.users.data ?? [];
});

const getListProject = (key) => {
    projectStore.getAllProjectsData({
        getAll: true,
        name: key,
        not_loading: true,
        contractPermission: true,
        projectQoutePermission: true
    });
};
const getListUser = (key) => {
    userStore.getUsersData({
        getAll: true,
        name: key,
        not_loading: true,
        contractPermission: true
    });
};

const getListContractType = (key) => {
    contractTypeStore.getContracTypeData(1, 30, {
        getAll: true,
        name: key,
        not_loading: true,
        using: true
    });
};

watch(() => props.quote.details.data, (newValue, oldValue) => {
    var total = 0;
    props.quote.details.data.forEach(element => {
        total += (element.price + '').replaceAll(".", "") * element.quantity;
    });
    props.quote.total_amount = total;
}, { deep: true })

watch(() => props.quote.code, (newValue, oldValue) => {
    props.quote.code = newValue.toUpperCase();
})

watch(() => props.quote.project_id, (newValue, oldValue) => {
    const project = projects.value.find(x => x.id == newValue);
    if (project) {
        props.quote.customer_id = project.customer_id;
        customer.value = project.customer.data;
    } else {
        props.quote.customer_id = null;
        customer.value = null;
    }
})

const sendData = () => {
    const data = props.quote;
    console.log(data);
    if (props.quote.id == 0) {
        create("/quotes/api", data)
            .then((res) => {
                console.log(res.data.data);
                quoteStore.pushData(res.data.data);
                props.quote.id = res.data.data.id;
                const btnClose = document.getElementById("close-modal");
                btnClose.click();
                useToast.successToast('Thêm mới thành công!');
                // btnClose.dataset.bsDismiss = "modal"
            })
            .catch((err) => {
                console.log(err);
                // if(err.response.data.code = 422) {
                //     useToast.errorToast(err.response.data.message)
                //     // return;
                // }
                if (err.response.data.errors) {
                    console.log('abc');
                    errors.value = err.response.data.errors;
                    let e = {};
                    for (var key in err.response.data.errors) {
                        if (key.includes('details.data')) {
                            let k = key.split('.');
                            if (k[2] in e) {
                                e[k[2]].push(...err.response.data.errors[key]);
                            } else {
                                e[k[2]] = err.response.data.errors[key];
                            }
                        }
                    }
                    errorListProduct.value = e;
                    console.log(e);
                }
            });
        return;
    }

    update("/quotes/api/" + props.quote.id, data)
        .then((res) => {
            console.log(res.data);
            const btnClose = document.getElementById("close-modal");
            btnClose.click();
            useToast.successToast('Cập nhật thành công!');
            // btnClose.dataset.bsDismiss = "modal"
        })
        .catch((err) => {
            if (err.response.data.errors) {
                errors.value = err.response.data.errors;
            }
        });
};

onBeforeMount(async () => {
    console.log("... BeforeMount.....");
    quoteStore.getListStatus(props.quote.status ?? 0);
    getListProject();
    getListUser();
    getListContractType();
    customer.value = props.quote.customer ? props.quote.customer.data : null;
});
// Xuất file pdf
const handlExportPdf = () => {
   window.open(`/quotes/export-file-pdf/${props.quote.id}`, '_blank')
}
</script>
<style lang="scss" scoped>
.table {
    tr {
        &.active {
            td {
                background-color: rgb(255, 255, 255);
            }

            input {
                background-color: rgb(255, 255, 255) !important;
            }
        }

    }

    td {
        padding: 0 !important;
        background-color: #e9e9e9;
    }

    input {
        &:not(.is-invalid) {
            border: 0 !important;
        }

        width: 100% !important;
        height: 100% !important;
        box-sizing: border-box !important;
        color: #000000;
        background-color: #e9e9e9 !important;
        border-radius: 0;
        margin: 0 !important;

    }

    &.disable {
        a {
            visibility: hidden !important;
        }
    }

    .is-invalid {
        border: 0 !important;
        border-bottom: 1px solid !important;
        border-color: #ff0000ea !important;
        border-radius: 2px !important;
    }
}

.form-view {

    select:disabled,
    input:disabled,
    textarea:disabled {
        color: #3d3d3d;
        background-color: #f3eeee;
    }
}

.form-control {
    &.form-control-datetime {
        &.is-invalid {
            padding-right: 32px !important;
        }

    }

    select {
        background: #163fc5 !important;
    }

    .modal {
        background-color: #58595a62 !important;
        overflow: hidden;
        padding-right: 0px;
    }
}
.select-custom-valid {
    border: 1px solid red !important;
    border-radius: 5px;
}
</style>
