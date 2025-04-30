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
                        @click="clickCreateUnit"
                        data-bs-target="#formCreateUnit"
                        data-bs-toggle="modal"
                        v-if="props.btnAdd"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm đơn vị tính</a
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
                            <th class="w-175px">Tên viết tắt</th>
                            <th class="w-300px">Tên đầy đủ</th>
                            <th class="w-300px">Ghi chú</th>
                            <th class="w-125px">Trạng thái</th>
                            <th class="w-100px text-center" colspan="2">Hành động</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        <tr v-for="(item, index) in units" :key="index"
                        :class="{active : item.id == currentIndex}" @click="currentIndex = item.id"
                        >
                            <td style="text-align: center">
                                <span
                                    class="text-dark text-hover-primary fs-6"
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
                                    class="text-dark text-hover-primary d-block text-content w-175px break-text"
                                    :title="item.code"
                                    >{{ item.code }}</span
                                >
                            </td>
                            <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content w-300px break-text"
                                    :title="item.name"
                                    >{{ item.name }}</span
                                >
                            </td>

                            <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 fs-6 w-300px break-text"
                                    :title="item.note"
                                    >{{
                                        item.note
                                    }}</span
                                >
                            </td>

                            <td>
                                <div
                                    class="text-red text-hover-primary d-block mb-1 text-content text-center w-125px break-text"
                                    :class="item.status == 0 ? 'status-badge-danger-color' : 'status-badge-active-color'"
                                >
                                    {{
                                        item.status === 1
                                            ? "Sử dụng"
                                            : "Ngừng sử dụng"
                                    }}
                                </div>
                            </td>

                            <td class="w-50px text-center">
                                <a v-if="item.isEdit"
                                    href="#"
                                    @click="handleUpdate(item)"
                                    data-bs-target="#formCreateUnit"
                                    data-bs-toggle="modal"
                                    class="btn btn-icon btn-edit btn-sm"
                                    :class="{ 'disable': !item.isEdit }"
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
                                    :class="{ 'disable': !item.isDelete }"
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
        id="formCreateUnit"
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
                            isClickUnitUpdate
                                ? "Sửa đơn vị tính"
                                : "Thêm mới đơn vị tính"
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
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="required">Tên viết tắt</span>
                            </label>
                            <!--end::Label-->
                            <input
                                type="text"
                                :disabled="canDisabledCode"
                                class="form-control text-input"
                                :class="{
                                    'input-custom-valid': errors.code,
                                    'input-disabled': canDisabledCode,
                                }"
                                v-model="formUnit.code"
                                @input="formUnit.code=textCode($event.target.value)"
                                      @keyup="validateInput($event)"
                                placeholder="Nhập tên viết tắt"
                                name="target_title"
                            />
                            <div class="w-100"></div>
                            <span
                                v-if="errors.code"
                                class="text-danger mt-3"
                                >{{ errors.code[0] }}</span
                            >
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="required">Tên đầy đủ</span>
                            </label>
                            <!--end::Label-->
                            <input
                                type="text"
                                class=" text-input form-control"
                                :class="{ 'input-custom-valid': errors.name }"
                                v-model="formUnit.name"
                                placeholder="Nhập tên đơn vị tính"
                                name="target_title"
                            />
                            <div class="w-100"></div>
                            <span v-if="errors.name" class="text-danger mt-3">{{
                                errors.name[0]
                            }}</span>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="required">Trạng thái</span>
                            </label>
                            <!--end::Label-->
                            <select
                                class="form-select"
                                :class="{
                                    'select-custom-valid': errors.status,
                                }"
                                data-placeholder="Chọn trạng thái"
                                v-model="formUnit.status"
                                aria-label="Default select example"
                            >
                                <option :value="1">Sử dụng</option>
                                <option :value="0">Ngừng sử dụng</option>
                            </select>
                            <div class="w-100"></div>
                            <span v-if="errors.status" class="text-danger mt-3">{{
                                errors.status[0]
                            }}</span>
                        </div>

                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">Ghi chú</label>
                            <textarea
                                style="resize:none"
                                class="form-control text-input"
                                v-model="formUnit.note"
                                rows="3"
                                name="target_details"
                                placeholder="Nhập nội dung ghi chú"
                            ></textarea>
                            <div class="w-100"></div>
                            <span v-if="errors.note" class="text-danger mt-3">{{
                                errors.note[0]
                            }}</span>
                        </div>
                        <!--end::Input group-->

                        <div class="modal-footer" style="border-top:none">
                    <button type="button" class="btn btn-function me-4" @click.prevent="
                                    isClickUnitUpdate
                                        ? updateUnit()
                                        : storeUnit()
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
        default: false,
    }
});
const formUnit = reactive({
    code: "",
    name: "",
    note: "",
    status: 1,
});
// handle chọn số bản ghi / 1 trang
const currentIndex = ref(-1);

let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};
const units = ref([]);
let getMetaPaginate = ref({});
const getUnits = (params = null) => {
     KTApp.showPageLoading();
    axios({
        url: "/units/get-all",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data, meta } = res.data;
            // console.log(meta);
            units.value = data;
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
    getUnits(requestPaginate);
};

onMounted(() => {
    getUnits();
});

const errors = ref([]);
const storeUnit = () => {
     KTApp.showPageLoading();
    axios
        .post("/units/store", formUnit)
        .then((res) => {
            useToast.successToast(res.data.message);
            const btn = document.getElementById('close');
            btn.click();
            // $("#formCreateBank").modal("hide");
            // $(".modal-backdrop").remove();
            getUnits();
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
        }).finally(()=>{
             KTApp.hidePageLoading();
        });
};

let unit_id = ref(0);
let canDisabledCode = ref(false);
let isClickUnitUpdate = ref(false);

const handleUpdate = (item) => {
    unit_id.value = item.id;
    isClickUnitUpdate.value = true;
    formUnit.code = item.code;
    formUnit.name = item.name;
    formUnit.status = item.status;
    formUnit.note = item.note;
    errors.value = [];
    canDisabledCode.value = true;
};
const clickCreateUnit = () => {
    isClickUnitUpdate.value = false;
    formUnit.code = "";
    formUnit.name = "";
    formUnit.note = "";
    formUnit.status = 1;
    errors.value = [];
    canDisabledCode.value = false;
};
const updateUnit = () => {
     KTApp.showPageLoading();
    axios
        .post("/units/update/" + `${unit_id.value}`, formUnit)
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
                    .delete("/units/destroy/" + id)
                    .then((res) => {
                        useToast.successToast(res.data.message);
                        const totalRecordOnPage =
                            getMetaPaginate.value.pagination.count;
                        if (totalRecordOnPage - 1 === 0) {
                            getMetaPaginate.value.pagination.current_page -= 1;
                        }
                        if (getMetaPaginate.value.pagination.total - 1 === 0) {
                            getUnits();
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
