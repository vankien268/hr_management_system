<template>
    <Modal
        title="props.contract.id != 0
        ? 'Thông tin hợp đồng'
        : 'Thêm mới hợp đồng'" @close-modal="closeModal(props.contract.id)"
        >
        <template #body>
            <div class="row col-lg-12 ms-1 mb-10 form" style="border-bottom: 1px solid rgb(212, 212, 212);">
                <div class="col-lg-6">
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="customerCode" class="required col-form-label">Số hợp đồng</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-5">
                            <!-- :disabled="props.contract.id != 0" -->
                            <input type="text"  id="customerCode"
                                   class="form-control mb-lg-0 p-2"
                                 />
                            <base-validation :message="errors?.code" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="taxCode" class="required col-form-label">Ngày ký</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <input type="date" class="form-control form-control-datetime w-50 mb-lg-0 p-2"
                                   :disabled="props.contract.id != 0 && props.action == 'view'"
                                   :class="{ 'is-invalid': errors.signing_date }" id="taxCode"
                                 />
                            <base-validation :message="errors.signing_date" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="customer_name" class="required col-form-label">Đại diện ký</label>
                            <label for="customer_name" class="col-form-label">(Phía khách hàng)</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <input type="text" class="required form-control mb-lg-0 p-2"

                                  />
                            <base-validation :message="errors.customer_contractor" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="name" class="required col-form-label">Đại diện ký</label>
                            <label for="name" class="col-form-label">(Phía công ty)</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="status" class="required col-form-label">Người phụ trách</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="customerType" class="required col-form-label">Thuộc dự án</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="customer_name" class="required col-form-label">Khách hàng</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <span :style="disabledEditContractFromNotification? 'background-color: #e0e4ec' :''" class="form-control" style="height: 28px;"></span>
                            <base-validation :message="errors.customer_id" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="inputPassword6" class="required col-form-label">Loại hợp đồng</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <button  type="button" class="btn btn-function me-4" @click="sendData()" >
                <i class="fa-solid fa-floppy-disk"></i> Ghi lại
            </button>
            <button  type="button"
                    class="btn btn-function me-4" @click="emits('update-data', 'update')" >
                <i class="fa-solid fa-floppy-disk"></i> Sửa
            </button>
            <button type="button"
                    :class="'btn btn-function me-4'"
                    id="close-modal"
                    data-bs-dismiss="modal" @click="closeModal(props.contract.id)">
                <i class="fa-solid fa-xmark"></i>Đóng
            </button>
        </template>
    </Modal>
</template>
<script setup>
    import { defineProps, ref, defineEmits, watch, computed, onBeforeMount } from "vue";
    import { create, update } from "../../helper/axiosConfig";
    import { useToast } from '../../helper/toastMessage'
    import { filterCodeInput, filterNumberInput, filterCodeInputNumber } from '../../helper/filterInput'
    import { displayPrice, validateInputCode } from '../../../services/utils'
    import InputSearch from "../input/InputSearch.vue";
    import SelectSearch from "../input/SelectSearch.vue";
    import Modal from '../modal/ScrollModal.vue'
    import { useContractStore } from "../../stores/contract";
    import { useCustomerStore } from "../../stores/customer";
    import { useStoreProjects } from "../../stores/project";
    import { useContracTypeStore } from "../../stores/contract";
    import { useUsers } from "../../stores/user";

    const projectStore = useStoreProjects();
    const customerStore = useCustomerStore();
    const contractTypeStore = useContracTypeStore();
    const userStore = useUsers();


    const contractStore = useContractStore();

    const props = defineProps({
        contract: {
            type: Object,
            default: function () {
                return null;
            },
        },
        statuses: {
            type: Array,
            default: [],
        },
        types: {
            type: Array,
            default: []
        },
        action: {
            type: String,
        },
        disabledEditContractFromNotification: {
            type: Boolean,
            default:false
        },
        contractId: {
            type: Number
        }
    });

    const emits = defineEmits(["close-model"]);

    const closeModal = (id) => {
        errors.value = [];
        indexModule.value = -1;
        indexAnnex.value = -1;
        indexPayment.value = -1;
        emits('close-model', id);
    }
    const permissionProjects = ref([]);
    const projects = computed(() => {
        permissionProjects.value = projectStore.$state.projects?.permissionProjects
        if (projectStore.$state.projects.data) {


            return projectStore.$state.projects.data;
        } else {


            return projectStore.$state.projects;
        };
    });

    const customer = ref(null);

    const contractType = computed(() => {
        return contractTypeStore.$state.types.data ?? [];
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
            projectPermission: true
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

    const errors = ref([]);

    const indexModule = ref(-1);
    const indexAnnex = ref(-1);
    const indexPayment = ref(-1);

    const setIndexModule = (index) => {
        indexModule.value = index;
    }

    const setIndexAnnex = (index) => {
        indexAnnex.value = index;
    }

    const setIndexPayment = (index) => {
        indexPayment.value = index;
    }

    const unsetIndexAnnex = () => {
        indexAnnex.value = -1;
    }

    const unsetIndexModule = () => {
        indexModule.value = -1;
    }

    const unsetIndexPayment = () => {
        indexPayment.value = -1;
    }

    const addItemContractModule = () => {
        props.contract.contract_modules.data.push(
            {
                id: 0,
                module_id: 0,
                module: '',
                contract_id: 0,
                value: '',
                note_module: '',
                status: true,
            }
        )
    }

    const addItemAnnexContract = () => {
        props.contract.annex_contracts.data.push(
            {
                id: 0,
                code: '',
                contract_id: 0,
                date: null,
                description: '',
            }
        )
    }

    const addItemPaymentDetail = () => {
        props.contract.payment_details.data.push(
            {
                id: 0,
                contract_id: 0,
                payment_times: '',
                amount: '',
                expected_payment_date: null,
                payment_date: null,
                note: '',
            }
        )
    }

    const removeItemContractModule = (index) => {
        props.contract.contract_modules.data.splice(index, 1);
    }

    const removeItemAnnexContract = (index) => {
        props.contract.annex_contracts.data.splice(index, 1);
    }

    const removeItemPaymentDetail = (index) => {
        props.contract.payment_details.data.splice(index, 1);
    }

    watch(() => props.contract?.code, (newValue, oldValue) => {
        props.contract.code = newValue.toUpperCase();
    })

    watch(() => props.contract?.project_id, (newValue, oldValue) => {
        const project = projects.value.find(x => x.id == newValue);
        if (project) {
            props.contract.customer_id = project.customer_id;
            customer.value = project.customer.data;
        } else {
            props.contract.customer_id = null;
            customer.value = null;
        }
    })

    watch(() => props.contract?.contract_modules?.data, (newValue, oldValue) => {
        newValue.map(e => {
            if(e.value == 0 && e.value) {
                e.value = 0;
                return e;
            }
            if (typeof (e.value) === "number") {
                e.value = displayPrice(e.value);
            } else {
                if (typeof (e.value) === "string") {
                    e.value = displayPrice(e.value.replaceAll(".", ""));
                }
            }
            return e;
        })
        props.contract.contract_modules.data = newValue;
    }, { deep: true })

    watch(() => props.contract?.payment_details?.data, (newValue, oldValue) => {
        newValue.map(e => {

            if (e.amount == 0 && e.amount) {
                e.amount = 0;
            }

            if (typeof (e.amount) === "number") {
                e.amount = displayPrice(e.amount);

            } else {
                if (typeof (e.amount) === "string") {
                    e.amount = displayPrice(e.amount.replaceAll(".", ""));
                }
            }

            if(e.actual_amount == 0 && e.actual_amount) {
                e.actual_amount = 0;
                return e;
            }
            if (typeof (e.actual_amount) === "number") {
                e.actual_amount = displayPrice(e.actual_amount);
            } else {
                if (typeof (e.actual_amount) === "string") {
                    e.actual_amount = displayPrice(e.actual_amount.replaceAll(".", ""));
                }
            }
            return e;
        })
        props.contract.payment_details.data = newValue;
    }, { deep: true })

    watch(() => props.contract?.contract_value, (newValue, oldValue) => {
        if (typeof (newValue) === "number") {
            props.contract.contract_value = displayPrice(newValue);
        } else {
            if (typeof (newValue) === "string") {
                props.contract.contract_value = displayPrice(newValue.replaceAll(".", ""));
            }
        }

    })

    const sendData = () => {
        const data = props.contract;
        console.log(data);
        if (props.contract.id == 0) {
            create("/contracts/api", data)
                .then((res) => {
                    console.log(res.data.data);
                    contractStore.pushData(res.data.data);
                    props.contract.id = res.data.data.id;
                    const btnClose = document.getElementById("close-modal");
                    btnClose.click();
                    useToast.successToast('Thêm mới thành công!');
                    // btnClose.dataset.bsDismiss = "modal"
                })
                .catch((err) => {
                    console.log(err);
                    if (err.response.data.errors) {
                        errors.value = err.response.data.errors;
                        for (var key in err.response.data.errors) {
                            console.log(key, err.response.data.errors[key]);
                        }
                    }
                });
            return;
        }

        update("/contracts/api/" + props.contract.id, data)
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
    onBeforeMount(() => {
        getListProject();
        getListUser();
        customer.value = props.contract.customer ? props.contract.customer.data : null;
        props.contract.contract_value = displayPrice((props.contract.contract_value + '').replaceAll(".", ""));
        props.contract.payment_details.data = props.contract.payment_details.data.map(e => {
            if (typeof (e.amount) === "number") {
                e.amount = displayPrice(e.amount);
            } else {
                if (typeof (e.amount) === "string") {
                    e.amount = displayPrice(e.amount.replaceAll(".", ""));
                }
            }

            if (typeof (e.actual_amount) === "number") {
                e.actual_amount = displayPrice(e.actual_amount);
            } else {
                if (typeof (e.actual_amount) === "string") {
                    e.actual_amount = displayPrice(e.actual_amount.replaceAll(".", ""));
                }
            }
            return e;
        });
    })
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
    }
    .check-permission {
        visibility: hidden;
    }
    .select-custom-valid {
        border: 1px solid red !important;
        border-radius: 5px;
    }
</style>
