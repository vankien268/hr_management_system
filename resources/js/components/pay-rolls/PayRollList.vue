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
                        @click="clickCreatePayRoll"
                        data-bs-target="#formCreateAllowance"
                        data-bs-toggle="modal"
                        v-if="props.btnAdd"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm bậc lương vị trí</a
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
                        <th class="min-w-150px">Bậc lương vị trí</th>
                        <th class="min-w-140px">Ngày có hiệu lực</th>
                        <th class="min-w-200px">Ngày hết hiệu lực</th>
                        <th class="min-w-200px">Trạng thái</th>
                        <th class="min-w-100px text-center" colspan="2">Hành động</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    <tr v-for="(item, index) in payRolls" :key="index"
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
                                >{{ item.pay_roll_name }}</span
                                >
                        </td>
                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >   {{ `${ moment(new Date( item.start_date)).format('DD/MM/YYYY')}` }}</span
                                >
                        </td>

                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >  {{ `${ moment(new Date( item.end_date)).format('DD/MM/YYYY')}` }}</span
                                >
                        </td>

                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                > {{ item.status ? 'Đã hết hạn': 'Đang áp dụng' }}</span
                                >
                        </td>

                        <td class="w-50px text-center">
                            <a
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
        id="formCreateAllowance"
        class="modal fade"
        data-bs-keyboard="true"
        data-bs-backdrop="static"
        tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered max-h-100">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                       {{isClickPayRollUpdate ? 'Cập nhật bậc lương vị trí': 'Thêm mới bậc lương vị trí' }}
                    </h4>

                    <div class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2" data-bs-dismiss="modal" @click="closeModal()">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                </div>

                <div class="modal-body py-2">
                    <div class="row col-lg-12 ms-1 mb-10 form" style="border-bottom: 1px solid rgb(212, 212, 212); padding-bottom: 30px;">
                        <div class="col-lg-6">
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="customerCode" class="required col-form-label">Bậc lương vị trí</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7" >
                                    <!-- :disabled="props.contract.id != 0" -->
                                    <input
                                        placeholder="Nhập tên bậc lương vị trí"
                                        :class="{'input-custom-valid': errors.pay_roll_name}"
                                        class="form-control mb-lg-0 p-2"
                                        v-model="formPayRoll.pay_roll_name"
                                    />
                                    <base-validation :message="errors?.pay_roll_name"/>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12"  style="margin-top: 1px;">
                                <div class="col-lg-5">
                                    <label for="taxCode" class=" col-form-label">Mô tả
                                    </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7" >
                                    <textarea
                                        style="resize:none"
                                        class="form-control text-input"
                                        v-model="formPayRoll.description"
                                        rows="5"
                                        :class="{'input-custom-valid': errors.description}"
                                        name="target_details"
                                        placeholder="Mô tả"
                                    ></textarea>
                                    <base-validation :message="errors?.description" />
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row g-3 align-items-center col-lg-12">
                                <div class="col-lg-5">
                                    <label for="taxCode" class="required col-form-label">Ngày có hiệu lực</label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input type="date"  placeholder="Ngày có hiệu lực"
                                             :class="{'input-custom-valid': errors.start_date}"
                                             class="form-control mb-lg-0 p-2"
                                           :max="formPayRoll.end_date"
                                           v-model="formPayRoll.start_date"
                                    />
                                    <base-validation :message="errors?.start_date"  style="padding-top: 2px;"/>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12"   style="margin-top: 1px;">
                                <div class="col-lg-5">
                                    <label for="taxCode" class="required col-form-label">Ngày hết hiệu lực </label>
                                    <base-validation />
                                </div>
                                <div class="col-lg-7">
                                    <input type="date"  placeholder="Ngày hết hiệu lực "
                                           :class="{'input-custom-valid': errors.end_date}"
                                           class="form-control mb-lg-0 p-2"
                                           v-model="formPayRoll.end_date"
                                           :min="formPayRoll.start_date"
                                    />
                                    <base-validation :message="errors?.end_date"  style="padding-top: 2px;"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row col-lg-12 ms-1 mb-10 form" style="border-bottom: 1px solid rgb(212, 212, 212); padding-bottom: 30px;">
                        <div
                            class="card-header border-0 d-flex justify-content-between align-items-center"
                        >
                                <span class="card-label fw-bold text-content">
                                   </span
                                >
                            <div class="align-items-center d-flex">
                                <div @click="addPayRollRow()">
                                    <a href="#" class="btn btn-function">
                                        <i class="ki-duotone ki-plus fs-2"></i>Thêm bậc lương</a
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive table-scroll-sm text-nowrap"  style="min-height: 26vh !important; height:26px;">
                                <table class="table table-row-dashed table-bordered table-data">
                                    <thead>
                                    <tr class="fs-6 text-gray-400">
                                        <th class="w-100px text-center">Bậc lương</th>
                                        <th class="w-200px max-w-180px text-center">P1</th>
                                        <th class="w-200px max-w-200px text-center">P2</th>
                                        <th class="w-200px max-w-200px">Lương theo hiệu suất</th>
                                        <th class="w-200px max-w-200px">Tổng thu nhập dự kiến</th>
                                        <th class="w-100px text-center" colspan="2">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody class="max-h-10 overflow-auto" v-if="formPayRoll.pay_ranges.length > 0">
                                    <tr
                                        v-for="(item, index) in formPayRoll.pay_ranges"
                                        :key="index"
                                    >
                                        <td class="text-center">
                                           {{item.level}}
                                        </td>

                                        <td >
                                            <input
                                                class="text-content"
                                                type="text"
                                                :value="formatNumber(formPayRoll.pay_ranges[index].position_based_pay)"
                                                @input="onInputMoney($event, 'position_based_pay', index)"
                                                style="width: 100%; border: 1px solid #9ca3af; border-radius: 5px; font-size: 12px;"
                                            />

                                        </td>

                                        <td >
                                            <input
                                                class="text-content"
                                                type="text"
                                                :value="formatNumber(formPayRoll.pay_ranges[index].person_based_pay)"
                                                @input="onInputMoney($event, 'person_based_pay', index)"
                                                style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;"
                                            />
                                        </td>

                                        <td >
                                            <input
                                                class="text-content"
                                                type="text"
                                                style="width: 100%;border:1px solid #9ca3af;
                                      border-radius: 5px;font-size: 12px;"
                                                :value="formatNumber(formPayRoll.pay_ranges[index].performance_based_pay)"
                                                @input="onInputMoney($event, 'performance_based_pay', index)"
                                            />
                                        </td>

                                        <td >
                                            {{formatNumber(item.position_based_pay + item.person_based_pay + item.performance_based_pay)}}
                                        </td>
                                        <td class="text-center w-100px">
                                            <a
                                                @click="removeItemPayRollRow(index, item)"
                                                href="#"
                                                class="btn btn-icon btn-delete btn-sm"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody class="max-h-25 overflow-auto cursor-pointer" v-else>
                                    <tr>
                                        <td class="text-center" colspan="8">Không có dữ liệu
                                        </td>
                                    </tr>
                                    <tr >
                                        <td class="text-center" style="border: 1px solid red;" v-if="errors.approver_ids" colspan="8">
                                            <span class="text-danger" >Vui lòng thêm người duyệt.</span>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-function me-4"
                            @click.prevent="
                                    isClickPayRollUpdate
                                        ? updatePayRoll()
                                        : storePayRoll()
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
    import { defineProps, ref, reactive, computed, onMounted } from "vue";
    import { helperFunc } from "../../helper/heplerFunction.js";
    import { sweetAlertMessage } from "../../helper/sweetAlert";
    import moment from "moment";
    import { useToast } from "../../helper/toastMessage";
    import axios from "axios";
    const props = defineProps({
        title: String,
        btnAdd: {
            type: Boolean,
            default: false,
        }
    });
    const formPayRoll = reactive({
        pay_roll_name: "",
        start_date: null,
        end_date: null,
        description: null,
        pay_ranges: [],
    });

    const addPayRollRow = () => {
        formPayRoll.pay_ranges.push({
            id: null,
            level: formPayRoll.pay_ranges.length + 1,
            position_based_pay: 0,
            person_based_pay: 0,
            performance_based_pay: 0,
        });
    };

    const removeItemPayRollRow = (key, item) => {
        formPayRoll.pay_ranges.splice(key, 1);
    };

    // handle chọn số bản ghi / 1 trang
    const currentIndex = ref(-1);

    let selectTotalRecord = ref(30);
    const handleClickItem = (numberPage) => {
        selectTotalRecord.value = numberPage;
    };
    const payRolls = ref([]);
    let getMetaPaginate = ref({});
    const getPayRolls = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/pay-rolls/get-all",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                // console.log(meta);
                payRolls.value = data;
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
        getPayRolls(requestPaginate);
    };

    onMounted(() => {
        getPayRolls();
    })

    const errors = ref([]);
    const storePayRoll = () => {
        KTApp.showPageLoading();
        axios
            .post("/pay-rolls/store", formPayRoll)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close-modal');
                btn.click();
                // $("#formCreateBank").modal("hide");
                // $(".modal-backdrop").remove();
                getPayRolls();
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    let payroll_id = ref(0);
    let isClickPayRollUpdate = ref(false);

    const handleUpdate = (item) => {
        isClickPayRollUpdate.value = true;
        payroll_id.value = item.id;
        formPayRoll.pay_roll_name = item.pay_roll_name;
        formPayRoll.start_date = item.start_date;
        formPayRoll.end_date = item.end_date;
        formPayRoll.description = item.description;
        formPayRoll.pay_ranges = item.pay_ranges;
        console.log( formPayRoll.pay_ranges);
        errors.value = [];
    };

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
        formPayRoll.pay_ranges[index][fieldName] = unformatted;

        // Hiển thị lại với định dạng dấu chấm ngăn cách hàng nghìn
        e.target.value = formatNumber(unformatted);
    };

    const clickCreatePayRoll = () => {
        isClickPayRollUpdate.value = false;
        formPayRoll.pay_roll_name = "";
        formPayRoll.start_date = null;
        formPayRoll.end_date = null;
        formPayRoll.description = null;
        formPayRoll.pay_ranges = [];
        errors.value = [];
    };
    const updatePayRoll = () => {
        KTApp.showPageLoading();
        axios
            .put("/pay-rolls/update/" + `${payroll_id.value}`, formPayRoll)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close-modal');
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
                        .delete("/pay-rolls/destroy/" + id)
                        .then((res) => {
                            useToast.successToast(res.data.message);
                            const totalRecordOnPage =
                                getMetaPaginate.value.pagination.count;
                            if (totalRecordOnPage - 1 === 0) {
                                getMetaPaginate.value.pagination.current_page -= 1;
                            }
                            if (getMetaPaginate.value.pagination.total - 1 === 0) {
                                getPayRolls();
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
