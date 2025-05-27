<template>

    <div class="col-xxl-12 col-xxl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch" >
            <!--begin::Header-->
            <div class="card-header border-0 mb-2">
                <div class="row g-2 mt-0 align-items-center w-350px">
                    <div class="w-auto">
                        <h3> {{ typeInsurance === 'WORKER_INSURANCE_PAID' ? "Bảo hiểm người lao động trả": "Bảo hiểm doanh nghiệp trả"}}</h3>
                    </div>
                </div>
                <div class="card-toolbar m-0" >
                    <a  href="#"  @click="chooseTypeInsurance('WORKER_INSURANCE_PAID')" :style="typeInsurance === 'ENTERPRISE_INSURANCE_PAID' ? 'background: #9ca3af !important;': ''"
                        class="btn btn-function" data-bs-toggle="modal" data-bs-target="#modal_contract_type">
                       Bảo hiểm người lao động trả</a>
                    <a  href="#"  @click="chooseTypeInsurance('ENTERPRISE_INSURANCE_PAID')" :style="typeInsurance === 'WORKER_INSURANCE_PAID' ? 'background: #9ca3af !important;': ''"
                        class="btn btn-function" data-bs-toggle="modal" data-bs-target="#modal_contract_type">
                       Bảo hiểm doanh nghiệp trả</a>

                    <a href="#"  @click="addInsuranceRow()" class="btn btn-function" data-bs-toggle="modal" data-bs-target="#modal_contract_type">
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm</a>

                    <button type="button" class="btn btn-function me-4"
                            @click.prevent="
                                   updateSalaryGrade()
                                ">
                        <i class="fa-solid fa-floppy-disk"></i> Cập nhật
                    </button>
                </div>
            </div>

            <div class="card-body py-0" v-if="typeInsurance !== 'WORKER_INSURANCE_PAID'">
                <!--begin::Table container-->
                <div class="table-responsive table-scroll h-78vh text-nowrap">
                    <!--begin::Table-->
                    <table class="table table-row-dashed table-bordered table-hover table-sm table-data" cellspacing="0"
                           cellpadding="0" border="0" width="325" id="tableid">
                        <!--begin::Table head-->
                        <thead>
                        <tr class="fw-bold">
                            <th   rowspan="2" class="w-20px max-w-50px">STT</th>
                            <th rowspan="2" class="w-100px">Ngày bắt đầu</th>
                            <th rowspan="2" class="w-100px">Ngày kết thúc</th>
                            <th  colspan="3" class="w-100px text-center">BHXH</th>
                            <th rowspan="2" class="text-center"  style="width: 150px;">BHTN</th>
                            <th  rowspan="2" class="text-center" style="width: 150px;">BHYT</th>
                            <th  rowspan="2" class="min-w-100px max-w-100px text-center">Tổng</th>
                            <th rowspan="2" class="w-auto text-center" colspan="2">Hành động</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="width: 150px;">HT</th>
                            <th class="text-center" style="width: 150px;">ODS-TS</th>
                            <th class="text-center" style="width: 150px;">TNLĐ-BNN</th>
                        </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody v-for="(item, index) in formInsurances.insurances" :key="index">
                        <!-- Row 1: Tên ngạch lương -->
                        <tr>
                            <td rowspan="3" class="text-center align-middle">{{ index + 1 }}</td>
                            <td>

                                <div class="d-flex">
                                    <input
                                        v-model="formInsurances.insurances[index].start_date"
                                        type="date" style="height: 30px; line-height: 30px; margin-top:5px;"
                                        class="form-control"
                                    />
                                </div>

                            </td>
                            <td>
                                <div class="d-flex">
                                    <input
                                        v-model="formInsurances.insurances[index].end_date"
                                        type="date" style="height: 30px; line-height: 30px; margin-top:5px;"
                                        class="form-control"
                                    />
                                </div>
                               </td>
                            <td>
                                <div class="d-flex">
                                    <input :min="0" :max="100"
                                        v-model="formInsurances.insurances[index].pension_insurance"
                                        type="number" style="height: 30px; line-height: 30px; margin-top:5px;"
                                        class="form-control"
                                    />
                                    <span class="input-group-text" style="height: 30px; line-height: 30px; margin-top:5px;">%</span>
                                </div>

                            </td>
                            <td>
                                <div class="d-flex">
                                    <input :min="0" :max="100"
                                        v-model="formInsurances.insurances[index].sickness_and_maternity_insurance"
                                        type="number" style="height: 30px; line-height: 30px; margin-top:5px;"
                                        class="form-control"
                                    />
                                    <span class="input-group-text" style="height: 30px; line-height: 30px; margin-top:5px;">%</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <input :min="0" :max="100"
                                        v-model="formInsurances.insurances[index].labor_accident_and_occupational_disease_insurance"
                                        type="number" style="height: 30px; line-height: 30px; margin-top:5px;"
                                        class="form-control"
                                    />
                                    <span class="input-group-text" style="height: 30px; line-height: 30px; margin-top:5px;">%</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <input :min="0" :max="100"
                                        v-model="formInsurances.insurances[index].unemployment_insurance"
                                        type="number" style="height: 30px; line-height: 30px; margin-top:5px;"
                                        class="form-control"
                                    />
                                    <span class="input-group-text" style="height: 30px; line-height: 30px; margin-top:5px;">%</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <input :min="0" :max="100"
                                        v-model="formInsurances.insurances[index].health_insurance"
                                        type="number" style="height: 30px; line-height: 30px; margin-top:5px;"
                                        class="form-control"
                                    />
                                    <span class="input-group-text" style="height: 30px; line-height: 30px; margin-top:5px;">%</span>
                                </div>
                            </td>
                            <td class="text-center">
                                {{formatNumber(formInsurances.insurances[index].pension_insurance + formInsurances.insurances[index].sickness_and_maternity_insurance
                                + formInsurances.insurances[index].labor_accident_and_occupational_disease_insurance + formInsurances.insurances[index].unemployment_insurance
                                + formInsurances.insurances[index].health_insurance)
                                }}

                            </td>
                            <td rowspan="3" class="text-center align-middle">
                                <a href="#" class="btn btn-icon btn-delete btn-sm" @click="removeItemUserRow(index, item)">
                                    <i class="fa-solid fa-trash fs-4"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tbody v-if="Object.keys(formInsurances.insurances).length == 0">
                        <tr>
                            <td class="text-center" colspan="12">
                                Không có dữ liệu hiển thị
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
            </div>
            <!--begin::Body-->

<!--            Bảo hiểm người lao động trả -->
            <div class="card-body py-0" v-else>
                <!--begin::Table container-->
                <div class="table-responsive table-scroll h-78vh text-nowrap">
                    <!--begin::Table-->
                    <table class="table table-row-dashed table-bordered table-hover table-sm table-data" cellspacing="0"
                           cellpadding="0" border="0" width="325" id="tableid">
                        <!--begin::Table head-->
                        <thead>
                        <tr class="fw-bold">
                            <th   rowspan="2" class="w-20px max-w-50px">STT</th>
                            <th  colspan="3" class="w-100px max-w-150px text-center">BHXH</th>
                            <th rowspan="2" class="w-100px text-center" style="width: 150px;">BHTN</th>
                            <th  rowspan="2" class="min-w-100px max-w-100px text-center">BHYT</th>
                            <th  rowspan="2" class="min-w-100px max-w-100px text-center">Tổng</th>
                            <th rowspan="2" class="w-auto text-center" colspan="2">Hành động</th>
                        </tr>
                        <tr>
                            <th class="text-center">HT</th>
                            <th class="text-center">ODS - TS</th>
                            <th class="text-center">TNLĐ - BNN</th>
                        </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody v-for="(item, index) in formInsurances.insurances" :key="index">
                        <!-- Row 1: Tên ngạch lương -->
                        <tr>
                            <td rowspan="3" class="text-center align-middle">{{ index + 1 }}</td>
                            <td>
                               <div class="d-flex">
                                   <input :min="0" :max="100"
                                       v-model="formInsurances.insurances[index].pension_insurance"
                                       type="number" style="height: 30px; line-height: 30px; margin-top:5px;"
                                       class="form-control"
                                   />
                                   <span class="input-group-text" style="height: 30px; line-height: 30px; margin-top:5px;">%</span>
                               </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <input :min="0" :max="100"
                                        v-model="formInsurances.insurances[index].sickness_and_maternity_insurance"
                                        type="number" style="height: 30px; line-height: 30px; margin-top:5px;"
                                        class="form-control"
                                    />
                                    <span class="input-group-text" style="height: 30px; line-height: 30px; margin-top:5px;">%</span>
                                </div>
                               </td>
                            <td>
                                <div class="d-flex">
                                    <input :min="0" :max="100"
                                        v-model="formInsurances.insurances[index].labor_accident_and_occupational_disease_insurance"
                                        type="number" style="height: 30px; line-height: 30px; margin-top:5px;"
                                        class="form-control"
                                    />
                                    <span class="input-group-text" style="height: 30px; line-height: 30px; margin-top:5px;">%</span>
                                </div>
                               </td>
                            <td>
                                <div class="d-flex"  style="width: 150px;">
                                    <input :min="0" :max="100"
                                        v-model="formInsurances.insurances[index].unemployment_insurance"
                                        type="number" style="height: 30px; line-height: 30px; margin-top:5px;"
                                        class="form-control"
                                    />
                                    <span class="input-group-text" style="height: 30px; line-height: 30px; margin-top:5px;">%</span>
                                </div>
                              </td>
                            <td>
                                <div class="d-flex">
                                    <input :min="0" :max="100"
                                        v-model="formInsurances.insurances[index].health_insurance"
                                        type="number" style="height: 30px; line-height: 30px; margin-top:5px;"
                                        class="form-control"
                                    />
                                    <span class="input-group-text" style="height: 30px; line-height: 30px; margin-top:5px;">%</span>
                                </div>
                               </td>
                            <td class="text-center">
                                {{formatNumber(formInsurances.insurances[index].pension_insurance + formInsurances.insurances[index].sickness_and_maternity_insurance
                                 + formInsurances.insurances[index].labor_accident_and_occupational_disease_insurance + formInsurances.insurances[index].unemployment_insurance
                                + formInsurances.insurances[index].health_insurance)
                                }}

                            </td>
                            <td rowspan="3" class="text-center align-middle">
                                <a href="#" class="btn btn-icon btn-delete btn-sm" @click="removeItemUserRow(index, item)">
                                    <i class="fa-solid fa-trash fs-4"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tbody v-if="Object.keys(formInsurances.insurances).length == 0">
                        <tr>
                            <td class="text-center" colspan="12">
                                Không có dữ liệu hiển thị
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
            </div>
        </div>
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
    const formInsurances = reactive({
        insurances: [],
        remove_insurance_ids: [],
    });

    const typeInsurance = ref("WORKER_INSURANCE_PAID")

    const chooseTypeInsurance = (type) => {
        typeInsurance.value = type;
        getInfoSalaryGrades({type: type});
    }

    const addInsuranceRow = () => {
        formInsurances.insurances.push({
            id: 0,
            idSave: 0,
            start_date: null,
            end_date: null,
            health_insurance: 0,
            labor_accident_and_occupational_disease_insurance: 0,
            pension_insurance: 0,
            sickness_and_maternity_insurance: 0,
            unemployment_insurance: 0,
        });
    };

    const removeItemUserRow =(key, item)=> {
        formInsurances.insurances.splice(key,1);
        if(item.id > 0) {
            formInsurances.remove_insurance_ids.push(item.id)
        }
    }

    const getInfoSalaryGrades = (params = null) => {
        formInsurances.insurances = [];
        formInsurances.remove_insurance_ids = [];
        KTApp.showPageLoading();
        axios({
            url: "/insurances/get-all",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                data.forEach(item => {
                    formInsurances.insurances.push({
                        id: item.id || 0,
                        idSave: item.idSave || 0,
                        start_date: item.values.start_date || null,
                        end_date: item.values.end_date || null,
                        health_insurance: item.values.health_insurance || 0,
                        labor_accident_and_occupational_disease_insurance: item.values.labor_accident_and_occupational_disease_insurance || 0,
                        pension_insurance: item.values.pension_insurance || 0,
                        sickness_and_maternity_insurance: item.values.sickness_and_maternity_insurance || 0,
                        unemployment_insurance: item.values.unemployment_insurance || 0,
                    });
                });

            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    onMounted(() => {
        getInfoSalaryGrades({type: 'WORKER_INSURANCE_PAID'});
    });

    const errors = ref([]);

    const updateSalaryGrade = () => {
        KTApp.showPageLoading();
        axios
            .put("/insurances/update",  {insurances:formInsurances.insurances, remove_insurance_ids:formInsurances.remove_insurance_ids, ...{type: typeInsurance.value}})
            .then((res) => {
                errors.value = [];
                useToast.successToast(res.data.message);
                getInfoSalaryGrades({type: typeInsurance.value});
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
        formInternalFund.internal_fund = 0;
    }

    const formatNumber = (number = 0) => {
        return Number(number).toLocaleString('vi-VN');
    };

    const onInputMoney = (e, fieldName, index) => {
        const raw = e.target.value;

        // Loại bỏ mọi ký tự không phải số
        const cleaned = raw.replace(/[^\d]/g, '');

        // Nếu không có số nào, set về 0 (hoặc '', tuỳ bạn)
        let unformatted = cleaned ? parseFloat(cleaned) : 0;

        // Gán lại hệ số vào object
        formInsurances.insurances[index][fieldName] = unformatted;

        // Tự động cập nhật value tương ứng nếu là hệ số
        const salaryBasic = parseFloat(formInsurances.insurances[index].attributes.salary_basic || 0);

        // Nếu trường đang thay đổi là coefficient_x, cập nhật value_x
        if (fieldName.startsWith('coefficient_')) {
            const suffix = fieldName.replace('coefficient_', ''); // vd: 'one'
            const valueField = `value_${suffix}`;
            formInsurances.insurances[index][valueField] = parseFloat((unformatted * salaryBasic).toFixed(2));
        }

        // Hiển thị lại với định dạng dấu chấm ngăn cách hàng nghìn
        e.target.value = formatNumber(unformatted);
    };

    const onInputSalaryBasic = (e, fieldName, index) => {
        const raw = e.target.value;

        // Loại bỏ mọi ký tự không phải số
        const cleaned = raw.replace(/[^\d]/g, '');

        // Nếu không có số nào, set về 0 (hoặc '', tuỳ bạn)
        let unformatted = cleaned ? parseInt(cleaned) : 0;

        // Tính lại value_x = coefficient_x * salary_basic
        for (let i = 0; i <= 7; i++) {
            const suffix = numToText(i);
            const coef = parseFloat(formInsurances.insurances[index][`coefficient_${suffix}`] || 0);

            formInsurances.insurances[index][`value_${suffix}`] = coef * unformatted;
        }

        // Gán lại salary_basic
        formInsurances.insurances[index].attributes.salary_basic = unformatted;

        // Hiển thị định dạng lại cho người dùng
        e.target.value = formatNumber(unformatted);
    };

    const numToText = (num) => {
        const map = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight'];
        return map[num] || '';
    };


    const onInputPerformance = (e, fieldName, index) => {
        const raw = e.target.value;

        // Loại bỏ mọi ký tự không phải số
        const cleaned = raw.replace(/[^\d]/g, '');

        // Nếu không có số nào, set về 0 (hoặc '', tuỳ bạn)
        let unformatted = cleaned ? parseInt(cleaned) : 0;

        formInsurances.insurances[index].attributes[fieldName] = unformatted;

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
