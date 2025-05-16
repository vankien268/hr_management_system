<template>

    <div class="col-xxl-12 col-xxl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch" >
            <!--begin::Header-->
            <div class="card-header border-0 mb-2">
                <div class="row g-2 mt-0 align-items-center w-350px">
                    <div class="w-auto">
                       <h3> Danh sách thang bậc lương</h3>
                    </div>
                </div>
                <div class="card-toolbar m-0" >
                    <a href="#"  @click="addSalaryGradeRow()" class="btn btn-function" data-bs-toggle="modal" data-bs-target="#modal_contract_type">
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm</a>

                    <button type="button" class="btn btn-function me-4"
                            @click.prevent="
                                   updateSalaryGrade()
                                ">
                        <i class="fa-solid fa-floppy-disk"></i> Cập nhật
                    </button>
                </div>
            </div>

            <div class="card-body py-0">
                <!--begin::Table container-->
                <div class="table-responsive table-scroll h-78vh text-nowrap">
                    <!--begin::Table-->
                    <table class="table table-row-dashed table-bordered table-hover table-sm table-data" cellspacing="0"
                           cellpadding="0" border="0" width="325" id="tableid">
                        <!--begin::Table head-->
                        <thead>
                        <tr class="fw-bold fs-6 text-gray-800">
                            <th class="w-20px max-w-50px">STT</th>
                            <th class="w-200px max-w-200px">Tên ngạch lương</th>
                            <th class="w-100px max-w-150px">Bậc 1</th>
                            <th class="w-100px max-w-150px">Bậc 2</th>
                            <th class="w-100px max-w-200px">Bậc 3</th>
                            <th class="min-w-100px max-w-100px">Bậc 4</th>
                            <th class="min-w-125px max-w-250px">Bậc 5</th>
                            <th class="min-w-125px max-w-250px">Bậc 6</th>
                            <th class="min-w-125px max-w-250px">Bậc 7</th>
                            <th class="min-w-125px max-w-250px">Bậc 8</th>
                            <th class="w-auto" colspan="2">Hành động</th>
                        </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody v-for="(item, index) in formSalaryGrade.salary_grades" :key="index">
                        <!-- Row 1: Tên ngạch lương -->
                        <tr>
                            <td rowspan="3" class="text-center align-middle">{{ index + 1 }}</td>
                            <td>  <input type="text"
                                         :class="{
                                    'input-custom-valid': errors['salary_grades.' + index + '.name'],
                                }"
                                         v-model="item.name" style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" />
                                <div class="w-100"></div>
                                <span
                                    v-if="errors['salary_grades.' + index + '.name']"
                                    class="text-danger mt-3"
                                >{{ errors['salary_grades.' + index + '.name'][0] }}</span
                                >
                            </td>
                            <td><input type="text" :value="formatNumber(item.coefficient_one)" @input="onInputMoney($event, 'coefficient_one', index)"
                                      :key="`name-1-${index}`" style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.coefficient_two)" @input="onInputMoney($event, 'coefficient_two', index)"
                                       :key="`name-2-${index}`" style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;"/></td>
                            <td><input type="text"
                                       :value="formatNumber(item.coefficient_three)" @input="onInputMoney($event, 'coefficient_three', index)"
                                       :key="`name-3-${index}`" style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.coefficient_four)" @input="onInputMoney($event, 'coefficient_four', index)"
                                       :key="`name-4-${index}`" style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.coefficient_five)" @input="onInputMoney($event, 'coefficient_five', index)"
                                       :key="`name-5-${index}`" style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.coefficient_six)" @input="onInputMoney($event, 'coefficient_six', index)"
                                       :key="`name-6-${index}`" style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.coefficient_seven)" @input="onInputMoney($event, 'coefficient_seven', index)"
                                       :key="`name-7-${index}`" style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.coefficient_eight)" @input="onInputMoney($event, 'coefficient_eight', index)"
                                       :key="`name-8-${index}`" style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;"/></td>
                            <td rowspan="3" class="text-center align-middle">
                                <a href="#" class="btn btn-icon btn-delete btn-sm" @click="removeItemUserRow(index, item)">
                                    <i class="fa-solid fa-trash fs-4"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Row 2: Mức lương cơ bản -->
                        <tr>
                            <td>
                                <div >  Mức lương cơ bản</div>
                                <input type="text"
                                       :value="formatNumber(item.attributes.salary_basic)"
                                       @input="onInputSalaryBasic($event, 'salary_basic', index)"
                                       style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" />
                            </td>
                            <td ><input type="text"
                                        :value="formatNumber(item.value_one)" disabled @input="onInputMoney($event, 'value_one', index)"
                                        style="width: 100%;border:1px solid #9ca3af;background: #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.value_two)" disabled @input="onInputMoney($event, 'value_two', index)"
                                       style="width: 100%;border:1px solid #9ca3af;background: #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.value_three)" disabled @input="onInputMoney($event, 'value_three', index)"
                                       style="width: 100%;border:1px solid #9ca3af;background: #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.value_four)" disabled @input="onInputMoney($event, 'value_four', index)"
                                       style="width: 100%;border:1px solid #9ca3af;background: #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.value_five)" disabled @input="onInputMoney($event, 'value_five', index)"
                                       style="width: 100%;border:1px solid #9ca3af;background: #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.value_six)" disabled @input="onInputMoney($event, 'value_six', index)"
                                       style="width: 100%;border:1px solid #9ca3af;background: #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.value_seven)" disabled @input="onInputMoney($event, 'value_seven', index)"
                                       style="width: 100%;border:1px solid #9ca3af;background: #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.value_eight)" disabled @input="onInputMoney($event, 'value_eight', index)"
                                       style="width: 100%;border:1px solid #9ca3af;background: #9ca3af;
                                      border-radius: 5px;font-size: 12px;"/></td>
                        </tr>

                        <!-- Row 3: Lương theo năng lực -->
                        <tr>
                            <td>Lương theo năng lực: </td>
                            <td><input type="text"
                                       :value="formatNumber(item.attributes.performance_one)" @input="onInputPerformance($event, 'performance_one', index)"
                                       style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.attributes.performance_two)" @input="onInputPerformance($event, 'performance_two', index)"
                                       style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.attributes.performance_three)" @input="onInputPerformance($event, 'performance_three', index)"
                                       style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.attributes.performance_four)" @input="onInputPerformance($event, 'performance_four', index)"
                                       style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.attributes.performance_five)" @input="onInputPerformance($event, 'performance_five', index)"
                                       style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.attributes.performance_six)" @input="onInputPerformance($event, 'performance_six', index)"
                                       style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.attributes.performance_seven)" @input="onInputPerformance($event, 'performance_seven', index)"
                                       style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                            <td><input type="text"
                                       :value="formatNumber(item.attributes.performance_eight)" @input="onInputPerformance($event, 'performance_eight', index)"
                                       style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;" /></td>
                        </tr>
                        </tbody>
                        <tbody v-if="Object.keys(formSalaryGrade.salary_grades).length == 0">
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
    const formSalaryGrade = reactive({
        salary_grades: [],
        remove_salary_grade_ids: [],
    });

    const addSalaryGradeRow = () => {
        formSalaryGrade.salary_grades.push({
            id: 0,
            idSave: 0,
            name: null,
            coefficient_one: 0,
            value_one: 0,
            coefficient_two: 0,
            value_two: 0,
            coefficient_three: 0,
            value_three: 0,
            coefficient_four: 0,
            value_four: 0,
            coefficient_five: 0,
            value_five: 0,
            coefficient_six: 0,
            value_six: 0,
            coefficient_seven: 0,
            value_seven: 0,
            coefficient_eight: 0,
            value_eight: 0,
            attributes: {
                salary_basic : 0,
                performance_one: 0,
                performance_two: 0,
                performance_three: 0,
                performance_four: 0,
                performance_five: 0,
                performance_six: 0,
                performance_seven: 0,
                performance_eight: 0,
            }
        });
    };

    const removeItemUserRow =(key, item)=> {
        formSalaryGrade.salary_grades.splice(key,1);
        if(item.id > 0) {
            formSalaryGrade.remove_salary_grade_ids.push(item.id)
        }
    }

    const getInfoSalaryGrades = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/salary-grades/get-info",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                formSalaryGrade.salary_grades = data;
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    onMounted(() => {
        getInfoSalaryGrades();
    });

    const errors = ref([]);

    const updateSalaryGrade = () => {
        KTApp.showPageLoading();
        axios
            .put("/salary-grades/update",  formSalaryGrade)
            .then((res) => {
                errors.value = [];
                useToast.successToast(res.data.message);
                getInfoSalaryGrades();
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
        formSalaryGrade.salary_grades[index][fieldName] = unformatted;

        // Tự động cập nhật value tương ứng nếu là hệ số
        const salaryBasic = parseFloat(formSalaryGrade.salary_grades[index].attributes.salary_basic || 0);

        // Nếu trường đang thay đổi là coefficient_x, cập nhật value_x
        if (fieldName.startsWith('coefficient_')) {
            const suffix = fieldName.replace('coefficient_', ''); // vd: 'one'
            const valueField = `value_${suffix}`;
            formSalaryGrade.salary_grades[index][valueField] = parseFloat((unformatted * salaryBasic).toFixed(2));
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
            const coef = parseFloat(formSalaryGrade.salary_grades[index][`coefficient_${suffix}`] || 0);

            formSalaryGrade.salary_grades[index][`value_${suffix}`] = coef * unformatted;
        }

        // Gán lại salary_basic
        formSalaryGrade.salary_grades[index].attributes.salary_basic = unformatted;

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

        formSalaryGrade.salary_grades[index].attributes[fieldName] = unformatted;

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
