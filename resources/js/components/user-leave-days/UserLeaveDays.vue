<template>
    <div class="card">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Cấu hình nghỉ phép</span>
            </h3>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body py-3 text-nowrap">
            <div class="row mb-5">
                <div class="col-md-6">
                    <label for="value" class="form-label">Số ngày phép hàng tháng</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            id="value"
                            :value="formatNumber(formUserLeaveDays.number_of_monthly_leave_days)"
                            @input="onInputMoney($event, 'number_of_monthly_leave_days')"
                            :class="{
                                    'input-custom-valid': errors.number_of_monthly_leave_days,
                                }"
                        />
                    </div>
                    <div class="w-100"></div>
                    <span
                        v-if="errors?.number_of_monthly_leave_days"
                        class="text-danger mt-3"
                    >{{ errors?.number_of_monthly_leave_days[0] }}</span
                    >
                </div>
            </div>

            <button class="btn btn-function" @click="updateNumberOfMonthlyLeaveDays">Cập nhật</button>
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
    const formUserLeaveDays = reactive({
        number_of_monthly_leave_days: 0,
    });

    const getInfoNumberOfMonthlyLeaveDays = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/user-leave-days/info",
            method: "GET",
            params: params,
        })
            .then((res) => {
                formUserLeaveDays.number_of_monthly_leave_days = res?.data?.number_of_monthly_leave_days;
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    onMounted(() => {
        getInfoNumberOfMonthlyLeaveDays();
    });

    const errors = ref([]);

    const updateNumberOfMonthlyLeaveDays = () => {
        KTApp.showPageLoading();
        axios
            .put("/user-leave-days/update", formUserLeaveDays)
            .then((res) => {
                errors.value = [];
                useToast.successToast(res.data.message);
                getInfoNumberOfMonthlyLeaveDays();
            })
            .catch((error) => {
                errors.value = error.response?.data?.errors;
                if(error.response?.data?.code == 403) {
                    useToast.errorToast(error.response.data?.errors?.message);
                }
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    function changeInternalFundType() {
        formUserLeaveDays.number_of_monthly_leave_days = 0;
    }

    const formatNumber = (number = 0) => {
        return Number(number).toLocaleString('vi-VN');
    };

    const onInputMoney = (e, fieldName) => {
        const raw = e.target.value;

        // Loại bỏ mọi ký tự không phải số
        const cleaned = raw.replace(/[^\d]/g, '');

        // Nếu không có số nào, set về 0 (hoặc '', tuỳ bạn)
        let unformatted = cleaned ? parseInt(cleaned) : 0;

        // Nếu là percent thì không cho vượt quá 100
        if (unformatted > 30) {
            unformatted = 30;
        }

        formUserLeaveDays[fieldName] = unformatted;

        // Hiển thị lại với format dấu chấm
        e.target.value = formatNumber(unformatted);
    };


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
