<template>
    <div class="col-xxl-12 col-xl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch pt-5">
            <!--begin::Header-->

            <div
                class="d-flex align-items-center justify-content-between flex-wrap ms-5"
            >
                <div class="d-flex align-items-center col-xl-12">
                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-100px">
                            <label for="customerCode" class="col-form-label"
                            >Mã hợp đồng</label
                            ><base-validation />
                        </div>
                        <div class="w-175px ms-1">
                            <input
                                type="text"
                                class="form-control mb-lg-0 p-2"
                                id="customerCode"
                                placeholder="000xxx000"
                                v-model="contract_code"
                            /><base-validation />
                            <!-- <SelectSearch class="w-100px" :list-data="props.customers" key-value="id" key-display="name"/> -->
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-100px">
                            <label for="customerCode" class="col-form-label"
                            >Tên hợp đồng</label
                            ><base-validation />
                        </div>
                        <div class="w-150px">
                            <input
                                type="text"
                                class="form-control mb-lg-0 p-2"
                                placeholder="000xxx000"
                                v-model="contract_name"
                            /><base-validation />
                        </div>
                    </div>

                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-100px">
                            <label for="customerCode" class="col-form-label"
                            >Tên nhân sự</label
                            ><base-validation />
                        </div>
                        <div class="w-150px">
                            <input
                                type="text"
                                class="form-control mb-lg-0 p-2"
                                placeholder="000xxx000"
                                v-model="full_name"
                            /><base-validation />
                        </div>
                    </div>

                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-100px">
                            <label for="customerCode" class="col-form-label"
                            >Loại hợp đồng</label
                            ><base-validation />
                        </div>
                        <div class="w-150px" style="margin-top: -10px;">
                            <select class="form-select" style="height:29px;" v-model="contract_type_id" data-placeholder="Chọn bộ phận" aria-label="Default select example">
                                <option :value="null">Vui lòng chọn</option>
                                <option :value="item.id" v-for="(item,index) in contractTypes" :key="index">{{ item.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center col-xl-12" style="margin-left: 10px;">
                    <div class="d-flex align-items-center w-auto">
                        <div class="w-150px">
                            <a
                                href="#"
                                class="btn btn-function me-2"
                                @click="clickSearch()"
                            >
                                <i class="fa-solid fa-magnifying-glass fs-2"></i>Tìm
                                kiếm</a
                            >
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <a
                            href="#"
                            class="btn btn-function me-2"
                            @click="clickCreateContract"
                            data-bs-target="#formCreateRequestTicket"
                            data-bs-toggle="modal"
                        >
                            <i class="ki-duotone ki-plus fs-2"></i>Thêm mới</a
                        >
                    </div>

                    <div class="d-flex align-items-center " v-if="editAction">
                        <div >
                            <span
                            >
                        <a   data-bs-target="#formCreateRequestTicket"
                             data-bs-toggle="modal"
                             href="#"
                             class="btn btn-function me-2"
                             @click="
                                () => {
                                    setAction('update');
                                }
                            "
                        >
                            <i class="fa-regular fa-pen-to-square"></i>Sửa</a
                        >
                            </span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center" v-if="editAction">
                        <a
                            href="#"
                            class="btn btn-function"
                            @click="deleteRow(dataUpdate?.id)"
                        >
                            <i class="fa-solid fa-trash"></i>Xóa</a
                        >
                    </div>

                </div>
            </div>

            <div class="card-body py-3">
                <!--begin::Table container-->
                <div class="table-responsive table-scroll h-65vh text-nowrap">
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
                        <tr class="fs-6 text-gray-400">
                            <th class="w-50px max-w-50px">STT</th>
                            <th class="w-100px max-w-125px text-center">
                                Mã hợp đồng - Tên hợp đồng
                            </th>
                            <th class="min-w-100px max-w-125px">Họ tên nhân viên</th>
                            <th class="min-w-200px max-w-350px">
                                Loại hợp đồng
                            </th>
                            <th class="min-w-200px max-w-350px">
                                Thời hạn hợp đồng
                            </th>
                            <th class="min-w-125px max-w-250px">
                                Ngày tạo
                            </th>

                            <th class="min-w-125px max-w-250px">
                                Ngày có hiệu lực
                            </th>

                            <th class="min-w-125px max-w-250px">
                                Ngày hết hạn
                            </th>
                            <!-- <th class="min-w-125px">Phân loại</th> -->
                        </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody
                            v-for="(contract, key) in contracts"
                            :key="key"
                            class="max-h-75 overflow-auto"
                        >
                        <tr>
                            <td
                                class="h-40px fw-medium pointer-events-none"
                                style="
                                        background-color: rgb(243 237 179);
                                        font-size: 14px;
                                        padding-left: 3rem;
                                    "
                                colspan="12"
                            >
                                {{ key }}
                            </td>
                        </tr>
                        <tr
                            class="cursor-pointer "
                            v-for="(item, index) in contract"
                            :key="index"
                            :class="{ active: item.id == dataUpdate.id }"

                            @click="setDataUpdate(item)"
                        >
                            <td class="text-center">
                                {{
                                pagination.per_page *
                                (pagination.current_page - 1) +
                                (item.stt + 1)
                                }}
                            </td>
                            <td class="break-text">
                                {{ item.contract_code }} - {{ item.contract_name }}
                            </td>
                            <td class="break-text">{{ item.contact_full_name }}</td>
                            <td class="break-text">{{ item.contract_type_name }}</td>

                            <td class="break-text">
                                {{ item.time_limited }}
                            </td>
                            <td class="break-text">
                                {{ `${ moment(new Date( item.register_date)).format('DD/MM/YYYY')}` }}
                            </td>

                            <td class="break-text">
                                {{ `${ moment(new Date( item.effective_date)).format('DD/MM/YYYY')}` }}
                            </td>

                            <td class="break-text">
                                {{ `${ moment(new Date( item.expiration_date)).format('DD/MM/YYYY')}` }}
                            </td>
                        </tr>
                        </tbody>
                        <tbody v-if="Object.keys(contracts).length == 0">
                        <tr>
                            <td class="text-center" colspan="12">
                                Không có dữ liệu hiển thị
                            </td>
                        </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <base-pagination
                    :pagination="pagination"
                    @change-page="changePage"
                />
                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
    </div>

    <div
        id="formCreateRequestTicket"
        class="modal fade"
        data-bs-keyboard="true"
        data-bs-backdrop="static"
        tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered max-h-100">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{detaiView ? 'Thông tin hợp đồng' : 'Sửa hợp đồng'}}
                    </h4>

                    <div class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2" data-bs-dismiss="modal" @click="closeModal()">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                </div>

                <div class="modal-body py-2">
                    <div class="row col-lg-12 ms-1 mb-10 form" style="border-bottom: 1px solid rgb(212, 212, 212); padding-bottom: 30px;">
                        <div class="col-lg-6">
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-6">
                                    <label for="customerCode" class=" col-form-label"><b style="font-size: 16px;">THÔNG TIN HỢP ĐỒNG</b></label>
                                    <base-validation />
                                </div>

                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="customerCode" class="required col-form-label">Mã hợp đồng</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9 td-background-disabled" >
                                    <!-- :disabled="props.contract.id != 0" -->
                                    <input
                                        placeholder="Nhập mã hợp đồng"
                                        :class="{'input-custom-valid': errors.contract_code}"
                                        :disabled="detailView" type="text" v-model="dataUpdate.contract_code"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.contract_code"/>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12" style="margin-top: 1px;">
                                <div class="col-lg-3">
                                    <label for="taxCode" class="required col-form-label">Tên hợp đồng</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input   placeholder="Tên mã hợp đồng"
                                        :class="{'input-custom-valid': errors.contract_name}"
                                        :disabled="detailView" type="text" v-model="dataUpdate.contract_name"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.contract_name"  style="padding-top: 2px;"/>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12"  style="margin-top: 1px;">
                                <div class="col-lg-3">
                                    <label for="name" class="required col-form-label">Loại hợp đồng</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <select  :disabled="detailView" class="form-select" style="height:29px;" v-model="dataUpdate.contract_type_id" :class="{ 'select-custom-valid' :  errors.contract_type_id}"  data-placeholder="Chọn bộ phận" aria-label="Default select example">
                                        <option :value="null">Vui lòng chọn</option>
                                        <option :value="item.id" v-for="(item,index) in contractTypes" :key="index">{{ item.name }}</option>
                                    </select>
                                    <div class="w-100"></div>
                                    <span v-if="errors.contract_type_id" class="text-danger mt-2"  style="padding-top: 2px;">{{ errors.contract_type_id[0] }}</span>

                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12"  style="margin-top: 1px;">
                                <div class="col-lg-3">
                                    <label for="name" class="required col-form-label">Ngày tạo hợp đồng</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input
                                        :class="{'input-custom-valid': errors.register_date}"
                                        :disabled="detailView" type="date"  v-model="dataUpdate.register_date"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.register_date"  style="padding-top: 2px;"/>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12"  style="margin-top: 1px;">
                                <div class="col-lg-3">
                                    <label for="name" class=" col-form-label">Thời hạn hợp đồng</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input
                                        :disabled="detailView" type="text" v-model="dataUpdate.time_limited"
                                            class="form-control mb-lg-0 p-2" placeholder="Nhập thời hạn hợp đồng"
                                    />
                                    <base-validation :message="errors?.time_limited" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12"  style="margin-top: 1px;">
                                <div class="col-lg-3">
                                    <label for="taxCode" class="required col-form-label">Ngày có hiệu lực
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input :max="dataUpdate.expiration_date"
                                        :class="{'input-custom-valid': errors.effective_date}"
                                        :disabled="detailView" type="date" v-model="dataUpdate.effective_date"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.effective_date" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12"  style="margin-top: 1px;">
                                <div class="col-lg-3">
                                    <label for="status" class="required col-form-label">Ngày hết hiệu lực</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input :min="dataUpdate.effective_date"
                                        :class="{'input-custom-valid': errors.expiration_date}"
                                        :disabled="detailView" type="date" v-model="dataUpdate.expiration_date"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.expiration_date" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-6">
                                    <label for="customerCode" class=" col-form-label"><b style="font-size: 16px;">THÔNG TIN NGƯỜI LAO ĐỘNG</b></label>
                                    <base-validation />
                                </div>

                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="status" class="required col-form-label">Chọn phòng ban</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <select :disabled="detailView"
                                            class="form-select"
                                            @change="changeContactDepartment(dataUpdate.department_id)"
                                            style="height:29px;" v-model="dataUpdate.department_id" :class="{ 'select-custom-valid' :  errors.department_id}"  data-placeholder="Chọn bộ phận" aria-label="Default select example">
                                        <option :value="null">Vui lòng chọn</option>
                                        <option :value="item.id" v-for="(item,index) in departmentListAPI" :key="index">{{ item.name }}</option>
                                    </select>
                                    <div class="w-100"></div>
                                    <span v-if="errors.department_id" class="text-danger mt-2">{{ errors.department_id[0] }}</span>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12"  style="margin-top: 1px;">
                                <div class="col-lg-3">
                                    <label for="status" class="required col-form-label">Tên nhân viên</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <select :disabled="detailView || ! clickContactDepartment" class="form-select" style="height:29px;" v-model="dataUpdate.contact_id" :class="{ 'select-custom-valid' :  errors.contact_id}"  data-placeholder="Chọn ngân hàng" aria-label="Default select example">
                                        <option :value="null">Vui lòng chọn</option>
                                        <option :value="item.id" v-for="(item,index) in filteredContacts" :key="index">{{ item.full_name }}</option>
                                    </select>
                                    <div class="w-100"></div>
                                    <span v-if="errors.contact_id" class="text-danger mt-2">{{ errors.contact_id[0] }}</span>
                                </div>
                            </div>

                        </div>



                        <div class="col-lg-6">

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-6">
                                    <label for="customerCode" class=" col-form-label"><b style="font-size: 16px;">THÔNG TIN NGƯỜI ĐẠI DIỆN</b></label>
                                    <base-validation />
                                </div>

                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="customerCode" class="required col-form-label">Chọn phòng ban</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <select :disabled="detailView"
                                            @change="changeSignerUserDepartment(dataUpdate.signer_department_id)"
                                            class="form-select" style="height:29px;" v-model="dataUpdate.signer_department_id" :class="{ 'select-custom-valid' :  errors.signer_department_id}"  data-placeholder="Chọn bộ phận" aria-label="Default select example">
                                        <option :value="null">Vui lòng chọn</option>
                                        <option :value="item.id" v-for="(item,index) in departmentListAPI" :key="index">{{ item.name }}</option>
                                    </select>
                                    <div class="w-100"></div>
                                    <span v-if="errors.signer_department_id" class="text-danger mt-2">{{ errors.signer_department_id[0] }}</span>
                                </div>
                            </div>


                            <div class="row g-3 align-items-center col-lg-12"  style="margin-top: 1px;">
                                <div class="col-lg-3">
                                    <label for="taxCode" class="required col-form-label">Tên nhân viên
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <select :disabled="detailView || ! clickSignerUserDepartment"
                                            class="form-select" style="height:29px;"
                                            v-model="dataUpdate.signer_user_id" :class="{ 'select-custom-valid' :  errors.signer_user_id}"
                                            data-placeholder="Chọn ngân hàng" aria-label="Default select example">
                                        <option :value="null">Vui lòng chọn</option>
                                        <option :value="item.id" v-for="(item,index) in filteredUsers" :key="index">{{ item.full_name }}</option>
                                    </select>
                                    <div class="w-100"></div>
                                    <span v-if="errors.signer_user_id" class="text-danger mt-2">{{ errors.signer_user_id[0] }}</span>
                                </div>
                            </div>


                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-6">
                                    <label for="customerCode" class=" col-form-label"><b style="font-size: 16px;">THÔNG TIN LƯƠNG PHỤ CẤP</b></label>
                                    <base-validation />
                                </div>

                            </div>

                            <div class="row g-3 align-items-center col-lg-12" >
                                <div class="col-lg-3">
                                    <label for="taxCode" class=" col-form-label">Hình thức làm việc
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input   placeholder="Hình thức làm việc" :disabled="detailView" type="text" v-model="dataUpdate.work_type"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.work_type" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12"  style="margin-top: 1px;">
                                <div class="col-lg-3">
                                    <label for="taxCode" class="required col-form-label">Lương cơ bản
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input   placeholder="Lương cơ bản"

                                             :value="formatNumber(dataUpdate.basic_salary)"
                                             @input="onInputMoney($event, 'basic_salary')"

                                        :class="{'input-custom-valid': errors.basic_salary}"
                                        :disabled="detailView" type="text"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.basic_salary" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12"  style="margin-top: 1px;">
                                <div class="col-lg-3">
                                    <label for="taxCode" class=" col-form-label">Phụ cấp
                                    </label>
                                </div>
                                <div class="col-lg-9 flex-wrap" style="display: flex; padding:3px;">
                                    <div  class="form-check  " v-for="(allowance, index2) in allowancesList" :key="index2">
                                       <input :disabled="detailView"
                                               type="checkbox"
                                               class="form-check-input"
                                               :id="'allowance-' + allowance.id"
                                               :value="allowance.id"
                                               v-model="dataUpdate.allowances"
                                        />
                                        <label class="form-check-label" :for="'allowance-' + allowance.id">
                                          {{ allowance.allowance_name }}
                                        </label> &ensp;  &ensp;
                                    </div>
                                    <base-validation :message="errors?.allowances" />
                                </div>

                            </div>

                            <div class="row g-3 align-items-center col-lg-12"  style="margin-top: 1px;">
                                <div class="col-lg-3">
                                    <label for="taxCode" class=" col-form-label">Ghi chú
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9" >
                                    <textarea
                                        style="resize:none"
                                        class="form-control text-input"
                                        v-model="dataUpdate.note"
                                        rows="3"
                                        :class="{'input-custom-valid': errors.note}"
                                        name="target_details"
                                        placeholder="Ghi chú"
                                    ></textarea>
                                    <base-validation :message="errors?.note" />
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="modal-footer" v-if = "! detailView"  >

                    <button type="button" class="btn btn-function me-4"
                            @click.prevent="
                                    editAction
                                        ? updateHrmContract()
                                        : storeContract()
                                ">
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
    import SelectSearch from "../input/SelectSearch.vue";
    import InputSearch from "../input/InputSearch.vue";
    import {
        defineProps,
        ref,
        computed,
        watch,
        onBeforeMount,
        reactive, onMounted,
    } from "vue";
    import { useContractStore } from "../../stores/hrmContract";
    import moment from "moment";
    import { useToast } from "../../helper/toastMessage";
    import { sweetAlertMessage } from "../../helper/sweetAlert";
    import { helperFunc } from "../../helper/heplerFunction";
    import axios from "axios";
    import {destroy} from "../../helper/axiosConfig";

    const contractStore = useContractStore();

    const props = defineProps({
        types: {
            type: Array,
            default: [],
        },
        statuses: {
            Array,
            default: [],
        },
        permissionadd: {
            type: Boolean,
            default: false,
        },
        requestparams: {
            type: Object,
            default: {}
        }
    });

    const infoList = ref([
        {
            key: "code",
            value: "Số hợp đồng",
        },
        {
            key: "signing_date",
            value: "Ngày ký",
        }
    ]);

    // console.log(props.permissionadd)
    const contract_code = ref("");
    const contract_name = ref("");
    const contract_type_id = ref(null);
    const full_name = ref(null);
    const effective_date = ref(null);
    const expiration_date = ref(null);


    const searchData = reactive({
        contract_code: "",
        contract_name: "",
        contract_type_id: null,
        full_name: null,
        effective_date: null,
        expiration_date: null
    });

    const clickSearch = () => {
        searchData.contract_code = contract_code.value;
        searchData.contract_name = contract_name.value;
        searchData.contract_type_id = contract_type_id.value;
        searchData.full_name = full_name.value;
        searchData.effective_date = effective_date.value;
        searchData.expiration_date = expiration_date.value;
        getData(1);
    };

    let selectTotalRecord = ref(30);
    const currentIndex = ref(-1);

    const handleClickItem = (numberPage) => {
        selectTotalRecord.value = numberPage;
    };

    let getMetaPaginate = ref({});

    const modalAction = ref("");

    const editAction = ref(false);

    const setAction = (action) => {
        modalAction.value = action;
    };

    const dataUpdate = ref({
        id: null,
        contract_name: null,
        contract_code: null,
        contract_type_id: null,
        department_id: null,
        contact_id: null,
        signer_user_id: null,
        signer_department_id: null,
        register_date: null,
        time_limited: null,
        work_type: null,
        basic_salary: null,
        effective_date: null,
        expiration_date: null,
        allowances: [],
        note: null,
    });

    const isClickContractUpdate = ref(false);
    const errors = ref([]);

    const clickCreateContract = () => {
        isClickContractUpdate.value = false;
        errors.value = [];
        editAction.value = false;
        detailView.value = false;
        clickContactDepartment.value = false;
        clickSignerUserDepartment.value = false;
    };

    const contracts = computed(() => {
        return contractStore.$state.contracts.data
            ? helperFunc.groupBy(
                contractStore.$state.contracts.data,
                "department_name"
            )
            : [];
    });

    const pagination = computed(() => {
        return contractStore.$state.contracts.meta
            ? contractStore.$state.contracts.meta.pagination
            : { current_page: 1, total_pages: 1, per_page: 30 };
    });

    const changePage = (newData) => {
        getData(newData.current_page, newData.per_page);
    };

    const setDataUpdate = (data, action = "view") => {
        dataUpdate.value = {...data};
        modalAction.value = action;
        editAction.value = true;
        if(dataUpdate.value.department_id) {
            clickContactDepartment.value = true;

            filteredContacts.value = users.value.filter(user => user.department_id === dataUpdate.value.department_id);
        }

        if(dataUpdate.value.signer_department_id) {
            clickSignerUserDepartment.value = true;
            filteredUsers.value = users.value.filter(user => user.department_id === dataUpdate.value.signer_department_id);
        }
    };

    const closeModalByRequest = ref(false)
    const getData = (
        page = pagination.value.current_page,
        per_page = pagination.value.per_page,
        search = searchData

    ) => {
        console.log(props.requestparams.code, 'code')
        if(props.requestparams.code && !closeModalByRequest.value) {
            code.value = props.requestparams.code
            search.code = props.requestparams.code;
            // gọi hàm getContractData và sử dụng then() để chờ kết quả
            contractStore.getContractData(page, per_page, search).then(() => {
                // sau khi promise hoàn thành, mở modal và truyền dữ liệu
                contractStore.toggleShowModal(true);
                setDataUpdate(contractStore.$state.contracts.data[0], 'update')
            })

        }else {
            contractStore.getContractData(page, per_page, search);
            console.log(searchData);
        }
    };

    const departmentListAPI = ref([]);

    const getAllDepartments = () => {
        KTApp.showPageLoading();
        axios.get('/departments/get-all?getAll=true')
            .then((res) => {
                const { getAllDepartment } = res.data;
                departmentListAPI.value = getAllDepartment;

            }).catch((error) => {
            console.log(error);
        }).finally(()=> {
            KTApp.hidePageLoading();
        });
    }

    onMounted(() => {
        getAllDepartments()
    })

    const departmentListNew = ref([]);

    watch(departmentListAPI, (newValue, oldValue) => {
        departmentListNew.value = helperFunc.recursive(true, newValue);
    })


    const updateHrmContract = () => {
        editAction.value = false;

        KTApp.showPageLoading();
        axios.put(`/hrm-contracts/update/` + `${dataUpdate.value.id}`, dataUpdate.value).then((res) => {
            useToast.successToast(res.data.message);
            errors.value = [];
            clickSignerUserDepartment.value = false;
            clickContactDepartment.value = false;
            const btn = document.getElementById('close-modal');
            btn.click();
            changePage(getMetaPaginate.value.pagination);
        })
            .catch((error) => {
                errors.value = error.response?.data?.errors;
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    const deleteRow = (id) => {
        sweetAlertMessage
            .messageWarning("Bạn có chắc chắn muốn xóa không?")
            .then(function (result) {
                if (result.value) {
                    KTApp.showPageLoading();
                    axios
                        .delete("/hrm-contracts/destroy/" + id)
                        .then((res) => {
                            useToast.successToast(res.data.message);
                            const totalRecordOnPage =
                                getMetaPaginate.value.pagination.count;
                            if (totalRecordOnPage - 1 === 0) {
                                getMetaPaginate.value.pagination.current_page -= 1;
                            }
                            if (getMetaPaginate.value.pagination.total - 1 === 0) {

                            }
                            getData();
                            changePage(getMetaPaginate.value.pagination);
                        })
                        .catch((error) => {
                            console.log(error);
                        }).finally(()=>{
                        KTApp.hidePageLoading();
                    });
                }
            });
    };

    const storeContract = () => {
        KTApp.showPageLoading();
        axios
            .post("/hrm-contracts/store", dataUpdate.value)
            .then((res) => {
                errors.value = [];
                const btn = document.getElementById('close-modal');
                btn.click();
                changePage(getMetaPaginate.value.pagination);
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    const banks = ref([]);

    const getBanks = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/banks/get-all",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                // console.log(meta);
                banks.value = data;
                getMetaPaginate.value = meta;
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    const contractTypes = ref([]);

    const getContractTypes = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/contracts/types/api",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                // console.log(meta);
                contractTypes.value = data;
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    const users = ref([]);

    const getUsers = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/hrm-contacts/get-all",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                users.value = data;
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };


    const detailView = ref(false);
    const handleDetail = () => {
        detailView.value = true;
    }

    const closeModal = () => {
        editAction.value = false;
        errors.value = [];
        detailView.value = false;
        dataUpdate.value = {};
    };

    const filteredUsers = ref([]);

    const clickSignerUserDepartment = ref(false);

    const changeSignerUserDepartment = (departmentId) => {

        if(departmentId !== null) {
            clickSignerUserDepartment.value = true;
        }

        if (! departmentId) {
            clickSignerUserDepartment.value = false;
            filteredUsers.value = users.value;
            return;
        }

        filteredUsers.value = users.value.filter(user => user.department_id === departmentId);
    };


    const filteredContacts = ref([]);

    const clickContactDepartment = ref(false);

    const changeContactDepartment = (departmentId) => {

        if(departmentId !== null) {
            clickContactDepartment.value = true;
        }

        if (! departmentId) {
            clickContactDepartment.value = false;
            filteredUsers.value = users.value;
            return;
        }

        filteredContacts.value = users.value.filter(user => user.department_id === departmentId);
    };

    const formatNumber = (number = 0) => {
        return Number(number).toLocaleString('vi-VN');
    };

    const onInputMoney = (e, fieldName) => {
        const raw = e.target.value;

        // Loại bỏ mọi ký tự không phải số
        const cleaned = raw.replace(/[^\d]/g, '');

        // Nếu không có số nào, set về 0 (hoặc '', tuỳ bạn)
        let unformatted = cleaned ? parseInt(cleaned) : 0;

        dataUpdate.value[fieldName] = unformatted;

        // Hiển thị lại với format dấu chấm
        e.target.value = formatNumber(unformatted);
    };

    const allowancesList = ref([]);
    const selectedAllowances = ref([]);

    const getAllowances = () => {
        axios.get('/allowances/get-all')
            .then((res) => {
                const { data, meta } = res.data;
                allowancesList.value = data;
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    onBeforeMount(() => {
        getData();
        getBanks();
        getContractTypes();
        getUsers();
        getAllowances();
    });

</script>
<style lang="scss" scoped>
    .right-5 {
        right: 50px;
    }

    label {
        &.col-form-label {
            font-size: 13px !important;
            padding: 2px 0 !important;
        }
    }

    input {
        &.form-control {
            width: 100%;
            min-height: 24px !important;
            height: 24px !important;
            border-radius: 3px;
            font-size: 12px !important;
        }
    }

    select {
        &.form-select {
            width: 100%;
            min-height: 24px !important;
            height: 24px !important;
            border-radius: 3px;
            font-size: 12px !important;
            padding: 3px 10px 3px 6px;
            background-position: right 0.15rem center;
        }
    }

    @media screen and (max-height: 768px) {
        .table-scroll {
            height: 60vh !important;
        }
    }

    @media screen and (max-height: 720px) {
        .table-scroll {
            height: 58vh !important;
        }
    }
    .check-permission {
        visibility: hidden;
    }
</style>
<style scoped>
    .con-his-edi-set .select-box .options-container {
        width: 147px;
    }
    .con-his-edi-set .options-container {
        top: 195px !important;
    }
    .con-his-inf-set .select-box .options-container {
        width: 198px;
    }
    .con-his-inf-set .options-container {
        top: 195px !important;
    }
    .con-his-pro-set .select-box .options-container {
        width: 500px;
    }
    .con-his-pro-set .options-container {
        top: 153px !important;
    }

    .input-custom-valid {
        border: 1px solid red !important;
    }
    .select-custom-valid {
        border: 1px solid red !important;
    }
</style>
