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
                        @click="clickCreateBank"
                        data-bs-target="#formCreateBank"
                        data-bs-toggle="modal"
                        v-if="props.btnAdd"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm ngân hàng</a
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
                            <th class="min-w-150px">Tên viết tắt</th>
                            <th class="min-w-140px">Tên đầy đủ</th>
                            <th class="min-w-200px">Ghi chú</th>
                            <th class="min-w-100px">Trạng thái</th>
                            <th class="min-w-100px text-center" colspan="2">Hành động</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        <tr v-for="(item, index) in banks" :key="index"
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
                                    class="text-dark text-hover-primary text-content"
                                    >{{ item.def_name }}</span
                                >
                            </td>
                            <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                    >{{ item.name }}</span
                                >
                            </td>

                            <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 fs-6"
                                    :title="item.note"
                                    >{{
                                        helperFunc.shortString(item.note)
                                    }}</span
                                >
                            </td>

                            <td>
                                <div
                                    class="text-red text-hover-primary d-block mb-1 text-content text-center"
                                    :class="item.status == 0 ? 'status-badge-danger-color' : 'status-badge-active-color'"
                                >
                                    {{
                                        item.status === 1
                                            ? "Đang sử dụng"
                                            : "Ngừng sử dụng"
                                    }}
                                </div>
                            </td>

                            <td class="w-50px text-center">
                                <a v-if="item.isEdit"
                                    href="#"
                                    @click="handleUpdate(item)"
                                    data-bs-target="#formCreateBank"
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
        id="formCreateBank"
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
                            isClickBankUpdate
                                ? "Sửa ngân hàng"
                                : "Thêm mới ngân hàng"
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
                                    'input-custom-valid': errors.def_name,
                                    'input-disabled': canDisabledCode,
                                }"
                                v-model="formBank.def_name"
                                @input="
                                    formBank.def_name =
                                        $event.target.value.toUpperCase()
                                "
                                placeholder="Nhập tên viết tắt"
                                name="target_title"
                            />
                            <div class="w-100"></div>
                            <span
                                v-if="errors.def_name"
                                class="text-danger mt-3"
                                >{{ errors.def_name[0] }}</span
                            >
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="required">Tên ngân hàng</span>
                            </label>
                            <!--end::Label-->
                            <input
                                type="text"
                                class=" text-input form-control"
                                :class="{ 'input-custom-valid': errors.name }"
                                v-model="formBank.name"
                                placeholder="Nhập tên ngân hàng"
                                name="target_title"
                            />
                            <div class="w-100"></div>
                            <span v-if="errors.name" class="text-danger mt-3">{{
                                errors.name[0]
                            }}</span>
                        </div>

                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">Ghi chú</label>
                            <textarea
                                style="resize:none"
                                class="form-control text-input"
                                v-model="formBank.note"
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
                        <div
                            class="d-flex flex-column mb-8 fv-row"
                            v-if="isClickBankUpdate === true"
                        >
                            <label class="required fs-6 fw-semibold mb-2"
                                >Trạng thái</label
                            >

                            <select
                                class="form-select"
                                :class="{
                                    'select-custom-valid': errors.status,
                                }"
                                data-placeholder="Chọn trạng thái"
                                v-model="formBank.status"
                                aria-label="Default select example"
                            >
                                <option value="1">Sử dụng</option>
                                <option value="0">Ngừng sử dụng</option>
                            </select>
                            <div class="w-100"></div>
                            <span v-if="errors.status" class="text-danger">{{
                                errors.status[0]
                            }}</span>
                        </div>

                        <div class="modal-footer" style="border-top:none">
                    <button type="button" class="btn btn-function me-4" @click.prevent="
                                    isClickBankUpdate
                                        ? updateBank()
                                        : storeBank()
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
import axios from "axios";
const props = defineProps({
    title: String,
    btnAdd: {
        type: Boolean,
        default: false,
    }
});
const formBank = reactive({
    def_name: "",
    name: "",
    note: "",
});
// handle chọn số bản ghi / 1 trang
const currentIndex = ref(-1);

let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};
const banks = ref([]);
let getMetaPaginate = ref({});
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
    getBanks(requestPaginate);
};

onMounted(() => {
    getBanks();
});

const errors = ref([]);
const storeBank = () => {
     KTApp.showPageLoading();
    axios
        .post("/banks/store", formBank)
        .then((res) => {
            useToast.successToast(res.data.message);
            const btn = document.getElementById('close');
            btn.click();
            // $("#formCreateBank").modal("hide");
            // $(".modal-backdrop").remove();
            getBanks();
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
        }).finally(()=>{
             KTApp.hidePageLoading();
        });
};

let bank_id = ref(0);
let canDisabledCode = ref(false);
let isClickBankUpdate = ref(false);

const handleUpdate = (item) => {
    bank_id.value = item.id;
    isClickBankUpdate.value = true;
    formBank.def_name = item.def_name;
    formBank.name = item.name;
    formBank.status = item.status;
    formBank.note = item.note;
    errors.value = [];
    canDisabledCode.value = true;
};
const clickCreateBank = () => {
    isClickBankUpdate.value = false;
    formBank.def_name = "";
    formBank.name = "";
    formBank.note = "";
    errors.value = [];
    canDisabledCode.value = false;
};
const updateBank = () => {
     KTApp.showPageLoading();
    axios
        .post("/banks/update/" + `${bank_id.value}`, formBank)
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
                    .delete("/banks/destroy/" + id)
                    .then((res) => {
                        useToast.successToast(res.data.message);
                        const totalRecordOnPage =
                            getMetaPaginate.value.pagination.count;
                        if (totalRecordOnPage - 1 === 0) {
                            getMetaPaginate.value.pagination.current_page -= 1;
                        }
                        if (getMetaPaginate.value.pagination.total - 1 === 0) {
                            getBanks();
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
