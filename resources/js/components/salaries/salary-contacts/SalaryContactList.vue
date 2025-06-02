<template>
    <div class="card">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">{{ title }}</span>
            </h3>

            <div class="card-toolbar">
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3 text-nowrap">
            <!--begin::Table container-->
            <div class="table-responsive table-responsive table-scroll">
                <!--begin::Table-->
                <table
                    class="table table-row-dashed table-bordered table-sm table-data"
                    cellspacing="0"
                    cellpadding="0"
                    border="0"
                    width="325"
                    id="tableid"
                >
                    <!--begin::Table head-->
                    <thead>
                    <tr class="fw-bold text-muted">
                        <th class="w-25px" style="text-align: center">
                            STT
                        </th>
                        <th class="w-200px">Mã nhân viên</th>
                        <th class="w-150px">Tên nhân viên</th>
                        <th class="w-125px">Phòng ban</th>
                        <th class="w-125px">Kỳ lương</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    <tr v-for="(item, index) in roles" :key="index">
                        <td style="text-align: center">
                                <span
                                    class="text-dark text-hover-primary fs-6 w-25px break-text d-block"
                                >{{

                                        item.stt
                                    }}</span
                                >
                        </td>
                        <td>
                            <a @click="handleDetailSalaryContact(item)" data-bs-target="#formCreateRole"
                                data-bs-toggle="modal">
                                <span
                                    class="text-dark text-hover-primary text-content w-200px break-text d-block pb-1 mt-1 cursor-pointer"
                                >
                                    {{ item.contact_code }}
                                </span>
                            </a>
                        </td>
                        <td>
                              <span
                                  class="text-dark text-hover-primary d-block mb-1 text-content"
                              >{{ item.full_name }}</span
                              >

                        </td>
                        <td>
                              <span
                                  class="text-dark text-hover-primary d-block mb-1 text-content"
                              >{{ item.department_name }}</span
                              >

                        </td>
                        <td class="w-125px ">
                            Kỳ lương tháng {{ item.salary_month }}/{{ item.salary_year }}
                        </td>
                    </tr>
                    </tbody>
                    <tbody v-if="Object.keys(roles).length == 0"></tbody>
                </table>

                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
    <div
        id="formCreateRole"
        class="modal fade"
        data-bs-keyboard="true"
        data-bs-backdrop="static"
        tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered max-h-100">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Chi tiết tiền lương nhân sự
                    </h4>

                    <div class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2" data-bs-dismiss="modal" @click="closeModal()">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                </div>

                <div class="modal-body py-2">
                    <div class="row col-lg-12 ms-1 mb-10 form" style="border-bottom: 1px solid rgb(212, 212, 212);">
                        <div class="col-lg-6">

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-6">
                                    <label for="customerCode" class=" col-form-label"><b style="font-size: 16px;">Thông tin nhân viên</b></label>
                                    <base-validation />
                                </div>

                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="customerCode" class=" col-form-label">Mã nhân viên:</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7 td-background-disabled" >
                                    <!-- :disabled="props.contract.id != 0" -->
                                   <b>{{dataDetailSalaryContact.contact_code}}</b>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="taxCode" class=" col-form-label">Họ tên nhân viên:</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{dataDetailSalaryContact.full_name}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="name" class=" col-form-label">Phòng ban</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{dataDetailSalaryContact.department_name}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="name" class=" col-form-label">Kỳ lương tháng: </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>Tháng {{ dataDetailSalaryContact.salary_month }}/{{ dataDetailSalaryContact.salary_year }}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="name" class="col-form-label">Công chuẩn: </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b> {{ dataDetailSalaryContact?.attributes?.statistic_number_of_standard_working_days }} công</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-6">
                                    <label for="customerCode" class=" col-form-label"><b style="font-size: 16px;">Thử việc / Học việc</b></label>
                                    <base-validation />
                                </div>

                            </div>

                            <div class="row g-3 align-items-center col-lg-12" v-if="dataDetailSalaryContact.attributes">
                                <div class="col-lg-5">
                                    <label for="taxCode" class=" col-form-label">Công
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input  type="number"
                                            :min="0"
                                            class="form-control mb-lg-0 p-2"
                                            v-model="dataDetailSalaryContact.attributes.statistic_number_of_probationary_working_days"
                                    />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="taxCode" class=" col-form-label">Lương
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b> {{ formatNumber(dataDetailSalaryContact?.attributes?.statistic_probationary_salary) }} </b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12" >
                                <div class="col-lg-6">
                                    <label for="customerCode" class=" col-form-label"><b style="font-size: 16px;">Chính thức</b></label>
                                    <base-validation />
                                </div>

                            </div>

                            <div class="row g-3 align-items-center col-lg-12" v-if="dataDetailSalaryContact.attributes">
                                <div class="col-lg-5">
                                    <label for="taxCode" class=" col-form-label">Công
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input  type="number"
                                            :min="0"
                                            class="form-control mb-lg-0 p-2"
                                            v-model="dataDetailSalaryContact.attributes.statistic_number_of_official_working_days"
                                    />

                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="taxCode" class=" col-form-label">Lương
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b> {{ formatNumber(dataDetailSalaryContact?.attributes?.statistic_official_salary) }} </b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-6">
                                    <label for="customerCode" class=" col-form-label"><b style="font-size: 16px;">Làm ngày nghỉ hàng tuần</b></label>
                                    <base-validation />
                                </div>

                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="taxCode" class=" col-form-label">Thử việc
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7" v-if="dataDetailSalaryContact.attributes">
                                    <input  type="number"
                                            :min="0"
                                            class="form-control mb-lg-0 p-2"
                                            v-model="dataDetailSalaryContact.attributes.statistic_number_of_probationary_working_days_on_weekly"
                                    />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12" v-if="dataDetailSalaryContact.attributes">
                                <div class="col-lg-5">
                                    <label for="taxCode" class=" col-form-label">Chính thức
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input  type="number"
                                            :min="0"
                                            class="form-control mb-lg-0 p-2"
                                            v-model="dataDetailSalaryContact.attributes.statistic_number_of_official_working_days_on_weekly"
                                    />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-6">
                                    <label for="customerCode" class=" col-form-label"><b style="font-size: 16px;">Làm ngày nghỉ lễ tết</b></label>
                                    <base-validation />
                                </div>

                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="taxCode" class=" col-form-label">Thử việc
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7" v-if="dataDetailSalaryContact.attributes">
                                    <input  type="number"
                                            :min="0"
                                            class="form-control mb-lg-0 p-2"
                                            v-model="dataDetailSalaryContact.attributes.statistic_number_of_probationary_working_days_on_holidays"
                                    />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12" v-if="dataDetailSalaryContact.attributes">
                                <div class="col-lg-5">
                                    <label for="taxCode" class=" col-form-label">Chính thức
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input  type="number"
                                            :min="0"
                                            class="form-control mb-lg-0 p-2"
                                            v-model="dataDetailSalaryContact.attributes.statistic_number_of_official_working_days_on_holidays"
                                    />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-6">
                                    <label for="customerCode" class=" col-form-label"><b style="font-size: 16px;">Thông tin lương</b></label>
                                    <base-validation />
                                </div>

                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Tổng ngày công: </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_total_working_days)}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Lương tính theo ngày công: </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_salary_by_working_day)}}</b>
                                </div>
                            </div>




                        </div>

                        <div class="col-lg-6">

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-6">
                                    <label for="customerCode" class=" col-form-label"><b style="font-size: 16px;">Phụ cấp & thu nhập</b></label>
                                    <base-validation />
                                </div>

                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Xăng xe: </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_gas) }}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Ăn trưa: </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_lunch_allowance)}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Tổng phụ cấp: </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_total_allowance)}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Tổng thu nhập trước thuế: </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_total_income_before_tax)}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-6">
                                    <label for="customerCode" class=" col-form-label"><b style="font-size: 16px;">Bảo hiểm xã hội bắt buộc</b></label>
                                    <base-validation />
                                </div>

                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="taxCode" class=" col-form-label">Mức lương cơ bản
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7" v-if="dataDetailSalaryContact.attributes">
                                  <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_basic_salary)}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12" v-if="dataDetailSalaryContact.attributes">
                                <div class="col-lg-5">
                                    <label for="taxCode" class=" col-form-label">Doanh nghiệp đóng
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                   <b> {{formatNumber(dataDetailSalaryContact.attributes.statistic_enterprise_insurance_paid)}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">NLĐ đóng </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_worker_insurance_paid)}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Tổng các khoản được giảm trừ </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_total_deductions)}}</b>
                                </div>
                            </div>


                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Thu nhập chịu thuế tạm tính </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_provisional_taxable_income)}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Thuế thu nhập cá nhân </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_personal_income_tax)}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Thu nhập sau thuế TNCN</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_income_after_personal_income_tax)}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12" v-if="dataDetailSalaryContact.attributes">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Hoàn tiền</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input  type="text"
                                            :value="formatNumber(dataDetailSalaryContact.attributes.statistic_refund)"
                                            @input="onInputMoney($event, 'statistic_refund')"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12" v-if="dataDetailSalaryContact.attributes">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Khen Thưởng</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input  type="text"
                                            :value="formatNumber(dataDetailSalaryContact.attributes.statistic_bonus)"
                                            @input="onInputMoney($event, 'statistic_bonus')"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12" v-if="dataDetailSalaryContact.attributes">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Tiền phạt</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input  type="text"
                                            :value="formatNumber(dataDetailSalaryContact.attributes.statistic_paying_the_contract_fines_withdrawn_beginning_year)"
                                            @input="onInputMoney($event, 'statistic_paying_the_contract_fines_withdrawn_beginning_year')"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Quỹ nội bộ</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_internal_fund)}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Tổng thu nhập</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_total_income)}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12" v-if="dataDetailSalaryContact.attributes">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Phạt vi phạm quy tắc chấm công</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input  type="text"
                                            class="form-control mb-lg-0 p-2"
                                            :value="formatNumber(dataDetailSalaryContact.attributes.statistic_fines_for_breaking_the_rules)"
                                            @input="onInputMoney($event, 'statistic_fines_for_breaking_the_rules')"
                                    />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12"  v-if="dataDetailSalaryContact.attributes">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Khoản trừ</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input  type="text"
                                            class="form-control mb-lg-0 p-2"
                                            :value="formatNumber(dataDetailSalaryContact.attributes.statistic_deduction)"
                                            @input="onInputMoney($event, 'statistic_deduction')"
                                    />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Tổng tiền thanh toán</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <b>{{formatNumber(dataDetailSalaryContact.attributes?.statistic_total_payment)}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12" v-if="dataDetailSalaryContact.attributes">
                                <div class="col-lg-5">
                                    <label for="status" class=" col-form-label">Ghi chú</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <textarea   class="form-control mb-lg-0 p-2"
                                                v-model="dataDetailSalaryContact.attributes.statistic_note">

                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer"  >

                    <button type="button" class="btn btn-function me-4"  @click.prevent="handleSalaryContact()">
                        <i class="fa-solid fa-floppy-disk"></i> Lưu
                    </button>
                    <button type="button"
                            :class="'btn btn-function me-4'"
                            id="close-modal"
                            data-bs-dismiss="modal" @click="closeModal()">
                        <i class="fa-solid fa-xmark"></i>Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { defineProps, ref, reactive, computed, onMounted } from "vue";
    import { helperFunc } from "../../../helper/heplerFunction.js";
    import { sweetAlertMessage } from "../../../helper/sweetAlert";
    import { useToast } from "../../../helper/toastMessage";
    import axios from "axios";
    const props = defineProps({
        title: String,
        btnAdd: {
            type: Boolean,
            default: false,
        }
    });
    const formRole = reactive({
        name: "",
        status: 1,
    });
    // handle chọn số bản ghi / 1 trang
    let selectTotalRecord = ref(30);
    const handleClickItem = (numberPage) => {
        selectTotalRecord.value = numberPage;
    };
    const roles = ref([]);
    let getMetaPaginate = ref({});
    const getRoles = (params = null) => {

        const urlParams = new URLSearchParams(window.location.search);
        const salaryId = urlParams.get('salary_id');

        KTApp.showPageLoading();
        axios({
            url: "/salaries/get-salary-contacts",
            method: "GET",
            params: {params,  salary_id: salaryId},
        })
            .then((res) => {
                roles.value = res.data;
                console.log( roles.value )
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    const dataDetailSalaryContact = ref({});

    const handleDetailSalaryContact = (item) => {
        dataDetailSalaryContact.value = item;
    }

    const pagination = computed(() => {
        return getMetaPaginate.value?.pagination
            ? getMetaPaginate.value.pagination
            : { current_page: 1, total_pages: 1, per_page: 30 };
    });

    const changePage = (newDataPagination) => {
        const requestPaginate = {
            page: newDataPagination.current_page,
            per_page: newDataPagination.per_page,
        };
        getRoles(requestPaginate);
    };

    const clickAssignRole = (id) => {
        window.location.href = "/system-functions?role_id=" + id;
    }

    onMounted(() => {
        getRoles();
    });

    const errors = ref([]);
    const storeRole = () => {
        KTApp.showPageLoading();
        axios
            .post("/roles/store", formRole)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close');
                btn.click();
                // $("#formCreateRole").modal("hide");
                // $(".modal-backdrop").remove();
                getRoles();
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
                if(error.response?.data?.code == 403) {
                    useToast.errorToast(error.response.data?.errors?.message);
                }
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    let role_id = ref(0);
    let canDisabledCode = ref(false);
    let isClickRoleUpdate = ref(false);

    const handleUpdate = (item) => {
        role_id.value = item.id;
        isClickRoleUpdate.value = true;
        formRole.name = item.name;
        formRole.status = item.status;
        errors.value = [];
        canDisabledCode.value = true;
    };
    const clickCreateRole = () => {
        isClickRoleUpdate.value = false;
        formRole.name = "";
        formRole.status = 1;
        errors.value = [];
        canDisabledCode.value = false;
    };
    const updateRole = () => {
        KTApp.showPageLoading();
        axios
            .post("/roles/update/" + `${role_id.value}`, formRole)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close');
                btn.click();
                // $("#formCreateRole").modal("hide");
                // $(".modal-backdrop").remove();
                changePage(getMetaPaginate.value.pagination);
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
                if(error.response?.data?.code == 403) {
                    useToast.errorToast(error.response.data?.errors?.message);
                }
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };
    const handleDelete = (id) => {
        sweetAlertMessage
            .messageWarning("Bạn có chắc chắn muốn xóa không?")
            .then(function (result) {
                if (result.value) {
                    KTApp.showPageLoading();
                    axios
                        .delete("/roles/destroy/" + id)
                        .then((res) => {
                            useToast.successToast(res.data.message);
                            const totalRecordOnPage =
                                getMetaPaginate.value.pagination.count;
                            if (totalRecordOnPage - 1 === 0) {
                                getMetaPaginate.value.pagination.current_page -= 1;
                            }
                            if (getMetaPaginate.value.pagination.total - 1 === 0) {
                                getRoles();
                            }
                            changePage(getMetaPaginate.value.pagination);
                        })
                        .catch((error) => {
                            console.log(error);
                            if(error.response?.data?.code == 403) {
                                useToast.errorToast(error.response.data?.errors?.message);
                            }
                        }).finally(()=>{
                        KTApp.hidePageLoading();
                    });
                }
            });
    };

    const formatNumber = (number = 0) => {
        return Number(number).toLocaleString('vi-VN');
    };


    const closeModal = () => {
        // $("#formCreateRole").modal("hide");
        // $(".modal-backdrop").remove();
    };
    const time = ref('');

    const getTime = () => {
        var currentTimeDate = new Date();
        var dates = currentTimeDate.getDate();
        var months = currentTimeDate.getMonth();
        var years = currentTimeDate.getFullYear();
        var hours   =  currentTimeDate.getHours();
        var minutes = currentTimeDate.getMinutes();
        var seconds = currentTimeDate.getSeconds();

        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        dates = dates < 10 ? '0' + dates : dates;
        months = months < 10 ? '0' + months : months;


        time.value = dates + '/' + months + '/' + years + ' ' + hours + ':' + minutes + ':' + seconds;
    }
    onMounted(() => {
        getTime();
        setInterval(getTime, 500);
    })

    const onInputMoney = (e, fieldName, index) => {
        let raw = e.target.value;

        // Cho phép số và dấu phẩy (,) - giữ nguyên để người dùng nhập số thực
        const cleaned = raw.replace(/[^0-9,]/g, '');
        console.log(cleaned);
        // Chuyển dấu phẩy sang dấu chấm để parseFloat xử lý đúng
        const numberWithDot = cleaned.replace(',', '.');

        // Parse thành số thực
        let value = parseFloat(numberWithDot);

        // Nếu không hợp lệ thì gán về 0
        if (isNaN(value)) value = 0;

        // Gán vào object
        dataDetailSalaryContact.value.attributes[fieldName] = value;

        // Gán lại value format vào input
        e.target.value = formatNumber(value);
    };

    const handleSalaryContact = () => {

    }
</script>

<style scoped>
    .input-custom-valid {
        border: 1px solid red;
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
    .icon-roles:hover {
        color: black;
    }
</style>
