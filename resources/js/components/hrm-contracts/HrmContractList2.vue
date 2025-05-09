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
                        <div class="w-75px">
                            <label for="customerCode" class="col-form-label"
                            >Mã hợp đồng</label
                            ><base-validation />
                        </div>
                        <div class="w-175px ms-1">
                            <input
                                type="text"
                                class="form-control mb-lg-0 p-2"
                                id="customerCode"
                                placeholder="EPLxxx"
                                v-model="code"
                            /><base-validation />
                            <!-- <SelectSearch class="w-100px" :list-data="props.customers" key-value="id" key-display="name"/> -->
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-85px">
                            <label for="customerCode" class="col-form-label"
                            >Tên hợp đồng</label
                            ><base-validation />
                        </div>
                        <div class="w-150px">
                            <input
                                type="text"
                                class="form-control mb-lg-0 p-2"
                                placeholder="000xxx000"
                                v-model="fullname"
                            /><base-validation />
                        </div>
                    </div>
                    <div class="d-flex align-items-center me-5 w-auto">
                        <div class="w-70px me-1">
                            <label class="col-form-label" for="checkCreate"
                            >Ngày sinh</label
                            ><base-validation />
                        </div>
                        <div class="w-auto">
                            <input
                                type="checkbox"
                                class="form-check-sm mb-lg-0 p-2"
                                placeholder=""
                                v-model="is_birthday"
                            /><base-validation />
                        </div>
                        <div class="ms-1 me-1 w-125px">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                :disabled="!is_birthday"
                                :max="birthday_to"
                                placeholder=""
                                v-model="birthday_from"
                            />
                            <base-validation :message="errors.birthday_from" />
                        </div>
                        <div class="ms-1 w-125px">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                :disabled="!is_birthday"
                                :min="birthday_from"
                                v-model="birthday_to"
                            />
                            <base-validation :message="errors.birthday_to" />
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-85px me-1">
                            <label for="customerCode" class="col-form-label"
                            >Số điện thoại</label
                            ><base-validation />
                        </div>
                        <div class="w-125px">
                            <input
                                type="text"
                                class="form-control mb-lg-0 p-2"
                                v-model="contact_phone"
                            />
                            <base-validation />
                        </div>
                    </div>

                </div>
                <div class="d-flex align-items-center col-xl-12">
                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-100px">
                            <label for="customerCode" class="col-form-label"
                            >Số CMTND/CCCD</label
                            ><base-validation />
                        </div>
                        <div class="w-150px">
                            <input
                                type="text"
                                class="form-control mb-lg-0 p-2"
                                v-model="contact_identify"
                            />
                        </div>
                    </div>

                    <div class="d-flex align-items-center w-auto me-5">
                        <div class="w-85px me-1">
                            <label for="customerCode" class="col-form-label"
                            >Email</label
                            ><base-validation />
                        </div>
                        <div class="w-150px">
                            <input
                                type="text"
                                class="form-control mb-lg-0 p-2"
                                v-model="contact_email"
                            />
                            <base-validation />
                        </div>
                    </div>

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

                    <div class="d-flex align-items-center w-auto" v-if="editAction">
                        <div class="w-150px">
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
                            <td>

                                <a   data-bs-target="#formCreateRequestTicket"
                                     data-bs-toggle="modal"
                                     href="#"
                                     class="btn btn-icon btn-edit btn-color-primary btn-sm"
                                     @click="
                                           handleDetail()
                                        "
                                ><i
                                    class="fa-solid fa-circle-info fs-2"
                                ></i
                                ></a>
                                {{ item.contact_code }} - {{ item.contract_name }}

                            </td>
                            <td>{{ item.contact_full_name }}</td>
                            <td>{{ item.contract_type_name }}</td>

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
                    <div class="row col-lg-12 ms-1 mb-10 form" style="border-bottom: 1px solid rgb(212, 212, 212);">
                        <div class="col-lg-6">
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="customerCode" class="required col-form-label">Mã hợp đồng</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9 td-background-disabled" >
                                    <!-- :disabled="props.contract.id != 0" -->
                                    <input  :disabled="detailView" type="text" v-model="dataUpdate.contact_code"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.contact_code" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="taxCode" class="required col-form-label">Tên hợp đồng</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input  :disabled="detailView" type="text" v-model="dataUpdate.full_name"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.full_name" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="name" class="required col-form-label">Loại hợp đồng</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input  :disabled="detailView" type="text"  v-model="dataUpdate.contact_email"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.contact_email" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="name" class=" col-form-label">Ngày tạo hợp đồng</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input  :disabled="detailView" type="text"  v-model="dataUpdate.contact_email"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.contact_email" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="name" class="required col-form-label">Thòi hạn hợp đồng</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input  :disabled="detailView" type="date" v-model="dataUpdate.contact_birthday"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.contact_birthday" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="taxCode" class=" col-form-label">Ngày có hiệu lực
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input  :disabled="detailView" type="text" v-model="dataUpdate.contact_national"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.contact_national" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="status" class=" col-form-label">Ngày hết hiệu lực</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input  :disabled="detailView" type="text" v-model="dataUpdate.contact_identify"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.contact_identify" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="status" class=" col-form-label">Chọn phòng ban</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input  :disabled="detailView" type="text"  v-model="dataUpdate.contact_identify_day"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.contact_identify_day" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="status" class=" col-form-label">Tên nhân viên</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input  :disabled="detailView" type="text" v-model="dataUpdate.contact_identify_place"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.contact_identify_place" />
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6">
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="customerCode" class="required col-form-label">Chọn phòng ban</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <select :disabled="detailView" class="form-select" style="height:29px;" v-model="dataUpdate.department_id" :class="{ 'select-custom-valid' :  errors.department_id}"  data-placeholder="Chọn bộ phận" aria-label="Default select example">
                                        <option :value="null">Vui lòng chọn</option>
                                        <option :value="item.id" v-for="(item,index) in departmentListAPI" :key="index">{{ item.name }}</option>
                                    </select>
                                    <div class="w-100"></div>
                                    <span v-if="errors.department_id" class="text-danger mt-2">{{ errors.department_id[0] }}</span>
                                </div>
                            </div>


                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="taxCode" class=" col-form-label">Tên nhân viên
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <select :disabled="detailView" class="form-select" style="height:29px;" v-model="dataUpdate.bank_id" :class="{ 'select-custom-valid' :  errors.bank_id}"  data-placeholder="Chọn ngân hàng" aria-label="Default select example">
                                        <option :value="null">Vui lòng chọn</option>
                                        <option :value="item.id" v-for="(item,index) in banks" :key="index">{{ item.name }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="taxCode" class=" col-form-label">Hình thức làm việc
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input  :disabled="detailView" type="text" v-model="dataUpdate.atm_number"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.atm_number" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="taxCode" class=" col-form-label">Lương cơ bản
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input  :disabled="detailView" type="text" v-model="dataUpdate.contact_tax_code"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.contact_tax_code" />
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-3">
                                    <label for="taxCode" class=" col-form-label">Phụ cấp
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-9">
                                    <input  :disabled="detailView" type="text" v-model="dataUpdate.contact_tax_code_date"
                                            class="form-control mb-lg-0 p-2"
                                    />
                                    <base-validation :message="errors?.contact_tax_code_date" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer" v-if = "! detailView" >

                    <button type="button" class="btn btn-function me-4"
                            @click.prevent="
                                    isClickRequestTicketUpdate
                                        ? handleUpdateHrmContact()
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
    import { useContractStore } from "../../stores/contract";
    import moment from "moment";
    import { useToast } from "../../helper/toastMessage";
    import { sweetAlertMessage } from "../../helper/sweetAlert";
    import { helperFunc } from "../../helper/heplerFunction";
    import axios from "axios";

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
    const code = ref("");
    const fullname = ref("");
    const is_birthday = ref(false);
    const birthday_from = ref(null);
    const birthday_to = ref(null);
    const contact_phone = ref(null);
    const contact_email = ref(null);
    const contact_identify = ref(null);

    const searchData = reactive({
        code: "",
        fullname: "",
        is_birthday: false,
        birthday_from: null,
        birthday_to: null,
        contact_phone: null,
        contact_email: null,
        contact_identify: null,
    });

    const clickSearch = () => {
        searchData.code = code.value;
        searchData.fullname = fullname.value;
        searchData.birthday = is_birthday.value;
        searchData.birthday_from = birthday_from.value;
        searchData.contact_phone = contact_phone.value;
        searchData.contact_email = contact_email.value;
        searchData.contact_identify = contact_identify.value;
        searchData.birthday_to = birthday_to.value;
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
        contact_code: null,
        full_name: null,
        contact_gender: null,
        contact_birthday: null,
        contact_email: null,
        contact_facebook: null,
        contact_zalo: null,
        contact_mobile: null,
        contact_mobile_2: null,
        contact_identify: null,
        contact_identify_day: null,
        contact_identify_place: null,
        contact_marital_status: null,
        contact_national: null,
        contact_status_id: null,
        contact_tax_code: null,
        contact_tax_code_date: null,
        atm_number: null,
        bank_id: null,
        permanent_address: null,
        temporary_address: null,
        contact_home_town: null,
        relative_phone_number: null,
    });

    const isClickContractUpdate = ref(false);
    const errors = ref([]);

    const clickCreateContract = () => {
        isClickContractUpdate.value = false;
        errors.value = [];
        editAction.value = false;
        detailView.value = false;

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
        dataUpdate.value = data;
        modalAction.value = action;
        editAction.value = true;
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
        axios.get('/departments/get-all')
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


    const handleUpdateHrmContact = () => {
        editAction.value = false;

        KTApp.showPageLoading();
        axios.put(`/hrm-contacts/update/` + `${dataUpdate.value.id}`, dataUpdate.value).then((res) => {
            useToast.successToast(res.data.message);
            errors.value = [];
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

    const storeContract = () => {
        KTApp.showPageLoading();
        axios
            .post("/hrm-contracts/store", formRequestTicket)
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

    const detailView = ref(false);
    const handleDetail = () => {
        detailView.value = true;
    }

    const closeModal = () => {
        editAction.value = false;
        errors.value = [];
        detailView.value = false;
    };

    onBeforeMount(() => {
        getData();
        getBanks();
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
<style>
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
</style>
