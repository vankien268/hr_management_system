<template>
    <div class="card">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">{{ title }}</span>
            </h3>

            <div class="card-toolbar">
                <!--begin::Menu-->
                <div class="align-items-right">
                    <a
                        href="#"
                        class="btn btn-function me-2"
                        @click="clickCreateTaxFeeRate"
                        data-bs-target="#formCreateTaxFeeRate"
                        data-bs-toggle="modal"
                        v-if="props.btnAdd"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm tỷ lệ thuế phí</a
                    >
                </div>
                <!--begin::Menu 2-->
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
                            <th class="w-50px" style="text-align: center">
                                STT
                            </th>
                            <th class="w-75px">Mã</th>
                            <th class="w-175px">Mô tả</th>
                            <th class="w-100px">Tỷ lệ (%)</th>
                            <th class="w-100px">Phân loại</th>
                            <th class="w-300px">Ghi chú</th>
                            <th class="w-100px">Trạng thái</th>
                            <th class="w-100px text-center" colspan="2">Hành động</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        <tr v-for="(item, index) in taxFeeRates" :key="index"
                        :class="{active : item.id == currentIndex}" @click="currentIndex = item.id"
                        >
                            <td style="text-align: center">
                                <span
                                    class="text-dark d-block text-hover-primary fs-6 w-50px"
                                    >{{
                                        pagination.per_page *
                                            (pagination.current_page - 1) +
                                        1 +
                                        index
                                    }}</span
                                >
                            </td>
                            <td>
                                <span
                                    class="text-dark text-hover-primary d-block text-content w-75px break-text"
                                    :title="item.code"
                                    >{{ item.code }}</span
                                >
                            </td>
                            <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content w-175px break-text"
                                    :title="item.description"
                                    >{{ item.description }}</span
                                >
                            </td>

                            <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content w-100px break-text text-right"
                                    :title="item.rate"
                                    >{{ item.rate }}</span
                                >
                            </td>

                            <td>
                                <span
                                    class="text-red text-hover-primary d-block mb-1 text-content text-center w-100px break-text"
                                >
                                    {{
                                        item.type === 1
                                            ? "Phí dịch vụ"
                                            : "Thuế GTGT"
                                    }}
                                </span>
                            </td>

                            <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 fs-6 w-300px break-text"
                                    :title="item.note"
                                    >{{
                                        item.note
                                    }}</span>
                            </td>

                            <td>
                                <span
                                    class="text-red text-hover-primary d-block mb-1 text-content text-center w-100px"
                                    :class="item.status == 0 ? 'status-badge-danger-color' : 'status-badge-active-color'"
                                >
                                    {{
                                        item.status === 1
                                            ? "Sử dụng"
                                            : "Ngừng sử dụng"
                                    }}
                                </span>
                            </td>

                            <td class="w-50px text-center">
                                <a
                                    href="#"
                                    @click="handleUpdate(item)"
                                    data-bs-target="#formCreateTaxFeeRate"
                                    data-bs-toggle="modal"
                                    class="btn btn-icon btn-edit btn-sm"
                                    v-if="item.isEdit"
                                >
                                    <i
                                        class="ki-duotone ki-pencil fs-2"
                                    >
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </a>
                            </td>
                            <td class="w-50px">
                                <a
                                    href="#"
                                    @click.prevent="handleDelete(item.id)"
                                    class="btn btn-icon btn-delete btn-sm me-1"
                                    v-if="item.isDelete"
                                >
                                    <i class="fa-solid fa-trash fs-5"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
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
    <div
        class="modal fade"
        id="formCreateTaxFeeRate"
        style="position: fixed"
        data-bs-keyboard="false"
        data-bs-backdrop="static"
    >
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-left border-0 pb-0">
                    <!--begin::Close-->
                    <h4 class="modal-title">
                        {{
                            isClickTaxFeeRateUpdate
                                ? "Sửa tỷ lệ thuế phí"
                                : "Thêm mới tỷ lệ thuế phí"
                        }}
                    </h4>
                    <div class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2" data-bs-dismiss="modal" @click="closeModalUser" id="close"
                        aria-label="Close">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div
                    class="modal-body pb-2"
                >
                    <!--begin:Form-->
                    <form id="kt_modal_new_target_form" class="form" action="#">
                        <!--begin::Input group-->
                        <div class="row col-12">
                            <div class="col-6">
                                <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                                    <!--begin::Label-->
                                    <div class="col-4">
                                        <label
                                            class="d-flex align-items-center fs-6 fw-semibold"
                                        >
                                            <span class="required">Mã</span>
                                        </label>
                                    </div>
                                    <!--end::Label-->
                                    <div class="col-8">
                                        <input
                                        type="text"
                                        :disabled="canDisabledCode"
                                        class="form-control text-input"
                                        :class="{
                                            'input-custom-valid': errors.code,
                                            'input-disabled': canDisabledCode,
                                        }"
                                        v-model="formTaxFeeRate.code"
                                        @input="formTaxFeeRate.code=textCode($event.target.value)"
                                      @keyup="validateInput($event)"
                                        placeholder="Nhập mã"
                                        name="target_title"
                                    />
                                    <div class="w-100"></div>
                                    <span
                                        v-if="errors.code"
                                        class="text-danger mt-3"
                                        >{{ errors.code[0] }}</span
                                    >
                                    </div>
                                </div>

                                <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                                <!--begin::Label-->
                                    <div class="col-4">
                                        <label class="d-flex align-items-center fs-6 fw-semibold">
                                            <span class="required">Mô tả</span>
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <!--end::Label-->
                                    <input
                                        type="text"
                                        class=" text-input form-control"
                                        :class="{ 'input-custom-valid': errors.description }"
                                        v-model="formTaxFeeRate.description"
                                        placeholder="Nhập mô tả"
                                        name="target_title"
                                    />
                                    <div class="w-100"></div>
                                    <span v-if="errors.description" class="text-danger mt-3">{{
                                        errors.description[0]
                                    }}</span>
                                    </div>
                                </div>

                                <div
                            class="row g-3 align-items-center col-lg-12 padding-bottom"
                        >
                            <div class="col-4">
                                <label class="required fs-6 fw-semibold"
                                >Trạng thái</label
                            >
                            </div>

                            <div class="col-8">
                                <select
                                class="form-select"
                                :class="{
                                    'select-custom-valid': errors.status,
                                }"
                                data-placeholder="Chọn trạng thái"
                                v-model="formTaxFeeRate.status"
                                aria-label="Default select example"
                            >
                                <option :value="1">Sử dụng</option>
                                <option :value="0">Ngừng sử dụng</option>
                            </select>
                            </div>
                            <div class="w-100"></div>
                            <span v-if="errors.status" class="text-danger">{{
                                errors.status[0]
                            }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div
                                    class="row g-3 align-items-center col-lg-12 padding-bottom">
                                    <div class="col-4">
                                        <label class="required fs-6 fw-semibold"
                                        >Phân loại</label
                                    >
                                    </div>

                                    <div class="col-8">
                                        <select
                                        class="form-select"
                                        :class="{
                                            'select-custom-valid': errors.type,
                                        }"
                                        data-placeholder="Chọn phân loại"
                                        v-model="formTaxFeeRate.type"
                                        aria-label="Default select example"
                                    >
                                        <option value="" disabled>Chọn</option>
                                        <option value="1">Phí dịch vụ</option>
                                        <option value="0">Thuế GTGT</option>
                                    </select>
                                    <div class="w-100"></div>
                                    <span v-if="errors.type" class="text-danger">{{
                                        errors.type[0]
                                    }}</span>
                                    </div>
                                </div>

                                <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                            <!--begin::Label-->
                            <div class="col-4">
                                <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="required">Tỷ lệ</span>
                            </label>
                            </div>
                            <!--end::Label-->
                            <div class="col-6">
                                <input
                                type="text"
                                class=" text-input form-control"
                                :class="{ 'input-custom-valid': errors.rate }"
                                v-model="formTaxFeeRate.rate"
                                placeholder="Nhập tỷ lệ"
                                @input="setupRate($event)"
                                @keyup="validateInput($event)"
                                name="target_title"
                                />
                                <div class="w-100"></div>
                                <span v-if="errors.rate" class="text-danger mt-3">{{
                                    errors.rate[0]
                                }}</span>
                            </div>
                            <div class="col-2">
                                <input
                                type="text"
                                class=" text-input form-control"
                                placeholder="%"
                                name="target_title"
                                disabled
                                />
                            </div>
                                </div>
                            </div>
                        </div>



                        <div class="row rol-12">
                            <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">Ghi chú</label>
                            <textarea
                                style="resize:none"
                                class="form-control text-input"
                                v-model="formTaxFeeRate.note"
                                rows="3"
                                name="target_details"
                                placeholder="Nhập nội dung ghi chú"
                            ></textarea>
                            <div class="w-100"></div>
                            <span v-if="errors.note" class="text-danger mt-3">{{
                                errors.note[0]
                            }}</span>
                            </div>
                        </div>


                        <div class="modal-footer" style="border-top:none">
                    <button type="button" class="btn btn-function me-4" @click.prevent="
                                    isClickTaxFeeRateUpdate
                                        ? updateTaxFeeRate()
                                        : storeTaxFeeRate()
                                ">
                        <i class="fa-solid fa-floppy-disk"></i> Lưu
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm btn-active-color-light" id="close-modal" data-bs-dismiss="modal"
                    @click="closeModal()">
                        <i class="fa-solid fa-xmark"></i>Đóng
                    </button>
                </div>
                    </form>

                    <!--end:Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
</template>

<script setup>
import { defineProps, ref, reactive, computed, onMounted } from "vue";
import { helperFunc } from "../../helper/heplerFunction.js";
import { sweetAlertMessage } from "../../helper/sweetAlert";
import { useToast } from "../../helper/toastMessage";
import { textCode, validateInput } from '../../../services/utils';
import axios from "axios";
const props = defineProps({
    title: String,
    btnAdd: {
        type: Boolean,
        default: false
    },
});
const formTaxFeeRate = reactive({
    code: "",
    description: "",
    rate: "",
    type: "",
    note: "",
    status: 1,
});
// handle chọn số bản ghi / 1 trang
const currentIndex = ref(-1);

let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};
const taxFeeRates = ref([]);
let getMetaPaginate = ref({});
const getTaxFeeRates = (params = null) => {
     KTApp.showPageLoading();
    axios({
        url: "/tax-fee-rates/get-all",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data, meta } = res.data;
            // console.log(meta);
            taxFeeRates.value = data;
            getMetaPaginate.value = meta;
        })
        .catch((error) => {
            console.log(error);
        }).finally(()=>{
         KTApp.hidePageLoading();
    });
};

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
    getTaxFeeRates(requestPaginate);
};

onMounted(() => {
    getTaxFeeRates();
});

const errors = ref([]);
const storeTaxFeeRate = () => {
     KTApp.showPageLoading();
    axios
        .post("/tax-fee-rates/store", formTaxFeeRate)
        .then((res) => {
            useToast.successToast(res.data.message);
            const btn = document.getElementById('close');
            btn.click();
            // $("#formCreateBank").modal("hide");
            // $(".modal-backdrop").remove();
            getTaxFeeRates();
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
        }).finally(()=>{
             KTApp.hidePageLoading();
        });
};

let taxFeeRate_id = ref(0);
let canDisabledCode = ref(false);
let isClickTaxFeeRateUpdate = ref(false);

const handleUpdate = (item) => {
    taxFeeRate_id.value = item.id;
    isClickTaxFeeRateUpdate.value = true;
    formTaxFeeRate.code = item.code;
    formTaxFeeRate.description = item.description;
    formTaxFeeRate.rate = item.rate;
    formTaxFeeRate.type = item.type;
    formTaxFeeRate.status = item.status;
    formTaxFeeRate.note = item.note;
    errors.value = [];
    canDisabledCode.value = true;
};
const clickCreateTaxFeeRate = () => {
    isClickTaxFeeRateUpdate.value = false;
    formTaxFeeRate.code = "";
    formTaxFeeRate.description = "";
    formTaxFeeRate.rate = "";
    formTaxFeeRate.type = "";
    formTaxFeeRate.note = "";
    formTaxFeeRate.status = 1;
    errors.value = [];
    canDisabledCode.value = false;
};
const updateTaxFeeRate = () => {
     KTApp.showPageLoading();
    axios
        .post("/tax-fee-rates/update/" + `${taxFeeRate_id.value}`, formTaxFeeRate)
        .then((res) => {
            useToast.successToast(res.data.message);
            const btn = document.getElementById('close');
            btn.click();
            // $("#formCreateBank").modal("hide");
            // $(".modal-backdrop").remove();
            changePage(getMetaPaginate.value.pagination);
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
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
                    .delete("/tax-fee-rates/destroy/" + id)
                    .then((res) => {
                        useToast.successToast(res.data.message);
                        const totalRecordOnPage =
                            getMetaPaginate.value.pagination.count;
                        if (totalRecordOnPage - 1 === 0) {
                            getMetaPaginate.value.pagination.current_page -= 1;
                        }
                        if (getMetaPaginate.value.pagination.total - 1 === 0) {
                            getTaxFeeRates();
                        }
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

const closeModal = () => {
    // $("#formCreateBank").modal("hide");
    // $(".modal-backdrop").remove();
    currentIndex.value = -1;
};
const setupRate = (event) => {
    if(isNaN(event.target.value)) {
        formTaxFeeRate.rate = 0;
        return ;
    }
    formTaxFeeRate.rate=textCode(event.target.value);


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
</style>
