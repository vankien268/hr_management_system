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
                        @click="clickCreateAllowance"
                        data-bs-target="#formCreateAllowance"
                        data-bs-toggle="modal"
                        v-if="props.btnAdd"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm phụ cấp</a
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
                        <th class="min-w-150px">Tên phụ cấp</th>
                        <th class="min-w-140px">Loại phụ cấp</th>
                        <th class="min-w-200px">Số tiền phụ cấp (VNĐ)</th>
                        <th class="min-w-100px">Mô tả</th>
                        <th class="min-w-100px">Trạng thái</th>
                        <th class="min-w-100px text-center" colspan="2">Hành động</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    <tr v-for="(item, index) in allowances" :key="index"
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
                                >{{ item.allowance_name }}</span
                                >
                        </td>
                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >{{ getAllowanceTypeName(item.allowance_type) }}</span
                                >
                        </td>

                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >{{ formatNumber(item.allowance_amount) }}</span
                                >
                        </td>

                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >{{ item.description }}</span
                                >
                        </td>

                        <td>
                            <div
                                class="text-red text-hover-primary d-block mb-1 text-content text-center"
                                :class="item.status == 0 ? 'status-badge-danger-color' : 'status-badge-active-color'"
                            >
                                {{
                                item.status == 1
                                ? "Đang sử dụng"
                                : "Ngừng sử dụng"
                                }}
                            </div>
                        </td>

                        <td class="w-50px text-center">
                            <a v-if="item.is_edit"
                               href="#"
                               @click="handleUpdate(item)"
                               data-bs-target="#formCreateAllowance"
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
<!--                        :title="item.is_deleted == true ? 'Không thể xóa phụ cấp mặc định của hệ thống.' : ''-->
                        <td class="w-50px">
                            <a v-if="item.is_deleted"
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
        id="formCreateAllowance"
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
                        isClickAllowanceUpdate
                        ? "Sửa phụ cấp"
                        : "Thêm mới phụ cấp"
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
                                <span class="required">Tên phụ cấp</span>
                            </label>
                            <!--end::Label-->
                            <input :disabled="isClickAllowanceUpdate && formAllowance.default != 0"
                                type="text"
                                class="form-control text-input"
                                :class="{
                                    'input-custom-valid': errors.allowance_name,
                                    'input-disabled': isClickAllowanceUpdate && formAllowance.default != 0,
                                }"
                                v-model="formAllowance.allowance_name"
                                placeholder="Nhập tên phụ cấp"
                                name="target_title"
                            />
                            <div class="w-100"></div>
                            <span
                                v-if="errors.allowance_name"
                                class="text-danger mt-3"
                            >{{ errors.allowance_name[0] }}</span
                            >
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span >Loại phụ cấp</span>
                            </label>
                            <!--end::Label-->
                            <select :disabled="isClickAllowanceUpdate && formAllowance.default != 0"
                                    style="height:29px;" class="form-select"
                                    v-model="formAllowance.allowance_type" :class="{ 'select-custom-valid' :  errors.allowance_type }" data-hide-search="true" data-placeholder="Chọn loại dự án" name="target_assign">
                                <option v-for="(item, index) in allowanceTypes"
                                        :key="index" :value="item.id">
                                    {{  `${item.name}` }}
                                </option>
                            </select>
                            <div class="w-100"></div>
                            <span v-if="errors.allowance_type" class="text-danger mt-3">{{
                                errors.allowance_type[0]
                            }}</span>
                        </div>

                        <div v-if="isClickAllowanceUpdate && formAllowance.default == 4" class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="">Số ngày vi phạm được phép</span>
                            </label>
                            <!--end::Label-->
                            <input
                                   type="text"
                                   class="form-control text-input"
                                   :class="{
                                    'input-custom-valid': errors.allowed_number_days,
                                }"
                                   :value="formatNumber(formAllowance.allowed_number_days)"
                                   @input="onInputMoney($event, 'allowed_number_days')"
                                   placeholder="Nhập số ngày vi phạm được phép"
                                   name="target_title"
                            />
                            <div class="w-100"></div>
                            <span
                                v-if="errors.allowed_number_days"
                                class="text-danger mt-3"
                            >{{ errors.allowed_number_days[0] }}</span
                            >
                        </div>

                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span >Số tiền phụ cấp (VNĐ)</span>
                            </label>
                            <!--end::Label-->
                            <input
                                type="text"
                                class="form-control text-input"
                                :class="{
                                    'input-custom-valid': errors.allowance_amount
                                }"
                                :value="formatNumber(formAllowance.allowance_amount)"
                                @input="onInputMoney($event, 'allowance_amount')"
                                placeholder="Nhập số tiền phụ cấp"
                                name="target_title"
                            />
                            <div class="w-100"></div>
                            <span
                                v-if="errors.allowance_amount"
                                class="text-danger mt-3"
                            >{{ errors.allowance_amount[0] }}</span
                            >
                        </div>

                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">Mô tả</label>
                            <textarea
                                style="resize:none"
                                class="form-control text-input"
                                v-model="formAllowance.description"
                                rows="3"
                                name="target_details"
                                placeholder="Nhập mô tả"
                            ></textarea>
                            <div class="w-100"></div>
                            <span v-if="errors.description" class="text-danger mt-3">{{
                                errors.note[0]
                            }}</span>
                        </div>
                        <!--end::Input group-->
                        <div
                            class="d-flex flex-column mb-8 fv-row"
                            v-if="isClickAllowanceUpdate === true"
                        >
                            <label class="fs-6 fw-semibold mb-2"
                            >Trạng thái</label
                            >

                            <select
                                class="form-select"
                                :class="{
                                    'select-custom-valid': errors.status,
                                }"
                                data-placeholder="Chọn trạng thái"
                                v-model="formAllowance.status"
                                aria-label="Default select example"
                            >
                                <option :value="1">Sử dụng</option>
                                <option :value="0">Ngừng sử dụng</option>
                            </select>
                            <div class="w-100"></div>
                            <span v-if="errors.status" class="text-danger">{{
                                errors.status[0]
                            }}</span>
                        </div>

                        <div class="modal-footer" style="border-top:none">
                            <button type="button" class="btn btn-function me-4" @click.prevent="
                                    isClickAllowanceUpdate
                                        ? updateAllowance()
                                        : storeAllowance()
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
    const formAllowance = reactive({
        allowance_name: "",
        allowance_type: 1,
        allowed_number_days: 0,
        allowance_amount: null,
        description: null,
        status: 1,
        default: 0,
    });
    // handle chọn số bản ghi / 1 trang
    const currentIndex = ref(-1);

    let selectTotalRecord = ref(30);
    const handleClickItem = (numberPage) => {
        selectTotalRecord.value = numberPage;
    };
    const allowances = ref([]);
    let getMetaPaginate = ref({});
    const getAllowances = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/allowances/get-all",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                // console.log(meta);
                allowances.value = data;
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
        getAllowances(requestPaginate);
    };

    onMounted(() => {
        getAllowances();
    });

    const errors = ref([]);
    const storeAllowance = () => {
        KTApp.showPageLoading();
        axios
            .post("/allowances/store", formAllowance)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close');
                btn.click();
                // $("#formCreateBank").modal("hide");
                // $(".modal-backdrop").remove();
                getAllowances();
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    let allowance_id = ref(0);
    let isClickAllowanceUpdate = ref(false);

    const handleUpdate = (item) => {
        allowance_id.value = item.id;
        isClickAllowanceUpdate.value = true;
        formAllowance.allowance_name = item.allowance_name;
        formAllowance.allowance_type = item.allowance_type;
        formAllowance.allowed_number_days = item.allowed_number_days;
        formAllowance.allowance_amount = item.allowance_amount;
        formAllowance.description = item.description;
        formAllowance.status = item.status;
        formAllowance.default = item.default;
        errors.value = [];
    };

    const clickCreateAllowance = () => {
        isClickAllowanceUpdate.value = false;
        formAllowance.allowance_name = "";
        formAllowance.allowance_type = 1;
        formAllowance.allowed_number_days = 0;
        formAllowance.allowance_amount = null;
        formAllowance.description = null;
        formAllowance.status = 1;
        formAllowance.default = 0;
        errors.value = [];
    };
    const updateAllowance = () => {
        KTApp.showPageLoading();
        axios
            .post("/allowances/update/" + `${allowance_id.value}`, formAllowance)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close');
                btn.click();
                // $("#formCreateBank").modal("hide");
                // $(".modal-backdrop").remove();
                changePage(getMetaPaginate.value.pagination);
            })
            .catch((error) => {
                errors.value = error.response?.data?.errors;
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
                        .delete("/allowances/destroy/" + id)
                        .then((res) => {
                            useToast.successToast(res.data.message);
                            const totalRecordOnPage =
                                getMetaPaginate.value.pagination.count;
                            if (totalRecordOnPage - 1 === 0) {
                                getMetaPaginate.value.pagination.current_page -= 1;
                            }
                            if (getMetaPaginate.value.pagination.total - 1 === 0) {
                                getAllowances();
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

    const allowanceTypes = ref([
        { id: 1, name: 'Loại cố định' },
        { id: 2, name: 'Loại tỉ lệ theo ngày công' },
        { id: 3, name: 'Loại nhập tay' }
    ])

    const getAllowanceTypeName = (typeId) => {
        switch (typeId) {
            case 1:
                return 'Loại cố định';
            case 2:
                return 'Loại tỉ lệ theo ngày công';
            case 3:
                return 'Loại nhập tay';
            default:
                return '';
        }
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

        formAllowance[fieldName] = unformatted;

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
