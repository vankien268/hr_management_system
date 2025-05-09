<template>
    <div class="card">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Quỹ nội bộ</span>
            </h3>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body py-3 text-nowrap">
            <div class="row mb-5">
                <div class="col-md-6">
                    <label for="calculation_method" class="form-label">Cách tính</label>
                    <select @change="changeInternalFundType()" style="height: 43px;" v-model="formInternalFund.internal_fund_type" class="form-select" id="calculation_method">
                        <option value="percent">Phần trăm</option>
                        <option value="money">Số tiền</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="value" class="form-label">Giá trị</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            id="value"
                            v-model="formInternalFund.internal_fund"
                        />
                        <span class="input-group-text" v-if="formInternalFund.internal_fund_type === 'percent'">%</span>
                        <span class="input-group-text" v-else>VNĐ</span>
                    </div>
                    <div class="w-100"></div>
                    <span
                        v-if="errors?.internal_fund"
                        class="text-danger mt-3"
                    >{{ errors?.internal_fund[0] }}</span
                    >
                </div>
            </div>

            <button class="btn btn-function" @click="updateInternalFund">Cập nhật</button>
        </div>
        <!--end::Body-->
    </div>
</template>

<script setup>
    import { defineProps, ref, reactive, computed, onMounted } from "vue";
    import { helperFunc } from "../../helper/heplerFunction.js";
    import { sweetAlertMessage } from "../../helper/sweetAlert";
    import { useToast } from "../../helper/toastMessage";
    import axios from "axios";
    const props = defineProps({
        title: String,
        btnAdd: {
            type: Boolean,
            default: false,
        }
    });
    const formInternalFund = reactive({
        internal_fund: 0,
        internal_fund_type: "percent",
    });

    const getInfoInternalFund = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/internal-fund/info",
            method: "GET",
            params: params,
        })
            .then((res) => {
                formInternalFund.internal_fund = res?.data?.internal_fund;
                formInternalFund.internal_fund_type = res?.data?.internal_fund_type;
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    onMounted(() => {
        getInfoInternalFund();
    });

    const errors = ref([]);

    const updateInternalFund = () => {
        KTApp.showPageLoading();
        axios
            .put("/internal-fund/update", formInternalFund)
            .then((res) => {
                errors.value = [];
                useToast.successToast(res.data.message);
                getInfoInternalFund();
            })
            .catch((error) => {
                errors.value = error.response?.data?.errors;
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    function changeInternalFundType() {
        formInternalFund.internal_fund = 0;
    }
</script>

<style scoped>
    .input-custom-valid {
        border: 1px solid red !important;
    }
    .select-custom-valid {
        border: 1px solid red;
    }
    .input-disabled {
        background-color: lightgray;
    }
    .set-with-modal {
        height: 58vh !important;
    }

    .text-input {
        font-size: 13px;
    }

    /*.is-invalid {*/
    /*    border: 1px !important;*/
    /*    border-bottom: 1px solid !important;*/
    /*    border-color: #ff0000ea !important;*/
    /*    border-radius: 2px !important;*/
    /*}*/
</style>
