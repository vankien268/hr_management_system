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
                        @click="clickCreateTax"
                        data-bs-target="#formCreateTax"
                        data-bs-toggle="modal"
                        v-if="props.btnAdd"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm thuế</a
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
                        <th class="min-w-150px">
                            Tên thuế</th>
                        <th class="min-w-140px">Số tiền từ</th>
                        <th class="min-w-200px">Số tiền đến</th>
                        <th class="min-w-100px">Thuế suất</th>
                        <th class="min-w-100px">Giá trị tính</th>
                        <th class="min-w-100px text-center" colspan="2">Hành động</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    <tr v-for="(item, index) in taxes" :key="index"
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
                                >{{ item.tax_name }}</span
                                >
                        </td>
                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >{{ item.tax_income_from }}</span
                                >
                        </td>

                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >{{ item.tax_income_to }}</span
                                >
                        </td>

                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >{{ item.tax_rate }}</span
                                >
                        </td>

                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >{{ item.tax_reduction }}</span
                                >
                        </td>

                        <td class="w-50px text-center">
                            <a
                                href="#"
                                @click="handleUpdate(item)"
                                data-bs-target="#formCreateTax"
                                data-bs-toggle="modal"
                                class="btn btn-icon btn-edit btn-sm"
                            >
                                <i
                                    class="ki-duotone ki-pencil fs-2"
                                >
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </a>
                        </td>
                        <td class="w-50px"  >
                            <a
                                href="#"
                                @click.prevent="handleDelete(item.id)"
                                class="btn btn-icon btn-delete btn-sm me-1"
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
        id="formCreateTax"
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
                        isClickTaxUpdate
                        ? "Sửa thuế"
                        : "Thêm mới thuế"
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
                                <span class="required">Tên thuế</span>
                            </label>
                            <!--end::Label-->
                            <input
                                   type="text"
                                   class="form-control text-input"
                                   :class="{
                                    'input-custom-valid': errors.tax_name,
                                }"
                                   v-model="formTax.tax_name"
                                   placeholder="Nhập tên thuế"
                                   name="target_title"
                            />
                            <div class="w-100"></div>
                            <span
                                v-if="errors.tax_name"
                                class="text-danger mt-3"
                            >{{ errors.tax_name[0] }}</span
                            >
                        </div>

                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="">Số tiền từ</span>
                            </label>
                            <!--end::Label-->
                            <input
                                type="text"
                                class="form-control text-input"
                                :class="{
                                    'input-custom-valid': errors.tax_income_from,
                                }"
                                v-model="formTax.tax_income_from"
                                placeholder="Nhập số tiền từ"
                                name="target_title"
                            />
                            <div class="w-100"></div>
                            <span
                                v-if="errors.tax_income_from"
                                class="text-danger mt-3"
                            >{{ errors.tax_income_from[0] }}</span
                            >
                        </div>

                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="">Số tiền đến</span>
                            </label>
                            <!--end::Label-->
                            <input
                                type="text"
                                class="form-control text-input"
                                :class="{
                                    'input-custom-valid': errors.tax_income_to,
                                }"
                                v-model="formTax.tax_income_to"
                                placeholder="Nhập số tiền đến"
                                name="target_title"
                            />
                            <div class="w-100"></div>
                            <span
                                v-if="errors.tax_income_to"
                                class="text-danger mt-3"
                            >{{ errors.tax_income_to[0] }}</span
                            >
                        </div>

                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="">Thuế suất</span>
                            </label>
                            <!--end::Label-->
                            <input
                                type="text"
                                class="form-control text-input"
                                :class="{
                                    'input-custom-valid': errors.tax_rate,
                                }"
                                v-model="formTax.tax_rate"
                                placeholder="Nhập thuế suất"
                                name="target_title"
                            />
                            <div class="w-100"></div>
                            <span
                                v-if="errors.tax_rate"
                                class="text-danger mt-3"
                            >{{ errors.tax_rate[0] }}</span
                            >
                        </div>

                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="">Giá trị tính	</span>
                            </label>
                            <!--end::Label-->
                            <input
                                type="text"
                                class="form-control text-input"
                                :class="{
                                    'input-custom-valid': errors.tax_reduction,
                                }"
                                v-model="formTax.tax_reduction"
                                placeholder="Nhập giá trị tính	"
                                name="target_title"
                            />
                            <div class="w-100"></div>
                            <span
                                v-if="errors.tax_reduction"
                                class="text-danger mt-3"
                            >{{ errors.tax_reduction[0] }}</span
                            >
                        </div>

                        <!--end::Input group-->

                        <div class="modal-footer" style="border-top:none">
                            <button type="button" class="btn btn-function me-4" @click.prevent="
                                    isClickTaxUpdate
                                        ? updateTax()
                                        : storeTax()
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
    const formTax = reactive({
        tax_name: "",
        tax_income_from: 0,
        tax_income_to: 0,
        tax_rate: 0,
        tax_reduction: 0,
    });
    // handle chọn số bản ghi / 1 trang
    const currentIndex = ref(-1);

    let selectTotalRecord = ref(30);
    const handleClickItem = (numberPage) => {
        selectTotalRecord.value = numberPage;
    };
    const taxes = ref([]);
    let getMetaPaginate = ref({});
    const getAllTaxes = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/taxes/get-all",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                taxes.value = [];

                data.forEach((item) => {
                    taxes.value.push( item.values)
                })
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
        getAllTaxes(requestPaginate);
    };

    onMounted(() => {
        getAllTaxes();
    });

    const errors = ref([]);
    const storeTax = () => {
        KTApp.showPageLoading();
        axios
            .post("/taxes/store", formTax)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close');
                btn.click();
                // $("#formCreateBank").modal("hide");
                // $(".modal-backdrop").remove();
                getAllTaxes();
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    let tax_id = ref(0);
    let isClickTaxUpdate = ref(false);

    const handleUpdate = (item) => {
        tax_id.value = item.id;
        isClickTaxUpdate.value = true;
        formTax.tax_name = item.tax_name;
        formTax.tax_income_from = item.tax_income_from;
        formTax.tax_income_to = item.tax_income_to;
        formTax.tax_rate = item.tax_rate;
        formTax.tax_reduction = item.tax_reduction;
        errors.value = [];
    };

    const clickCreateTax = () => {
        isClickTaxUpdate.value = false;
        formTax.tax_name = "";
        formTax.tax_income_from = 0;
        formTax.tax_income_to = 0;
        formTax.tax_rate = 0;
        formTax.tax_reduction = 0;
        errors.value = [];
    };
    const updateTax = () => {
        KTApp.showPageLoading();
        axios
            .post("/taxes/update/" + `${tax_id.value}`, formTax)
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
                        .delete("/taxes/destroy/" + id)
                        .then((res) => {
                            useToast.successToast(res.data.message);
                            const totalRecordOnPage =
                                getMetaPaginate.value.pagination.count;
                            if (totalRecordOnPage - 1 === 0) {
                                getMetaPaginate.value.pagination.current_page -= 1;
                            }
                            if (getMetaPaginate.value.pagination.total - 1 === 0) {
                                getAllTaxes();
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
