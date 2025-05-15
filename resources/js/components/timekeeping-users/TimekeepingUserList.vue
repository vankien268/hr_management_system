<template>
    <div class="card">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">{{ title }}</span>
            </h3>

            <div class="card-toolbar">
                <!--begin::Menu-->
                <div class="d-flex align-items-center w-auto me-5">
                    <div class="w-75px">
                        <label for="customerCode" class="col-form-label"
                        >Mã/Tên nhân viên</label
                        >
                    </div>
                    <div class="w-175px ms-1">
                        <input
                            @keyup.enter="handleSearch"
                            v-model="searchTimekeepingUser.nameAndCode"
                            type="text"
                            class="form-control mb-lg-0 p-2"
                            id="customerCode"
                            placeholder="EPLxxx"
                        />
                        <!-- <SelectSearch class="w-100px" :list-data="props.customers" key-value="id" key-display="name"/> -->
                    </div>
                </div>

                <div class="d-flex align-items-center w-auto me-5">
                    <div class="w-100px">
                        <label for="customerCode" class="col-form-label"
                        >Thời gian</label>
                    </div>
                    <div class="w-325px" style="">
                        <input
                            @change="handleSearch"
                            v-model="searchTimekeepingUser.month"
                            type="month"
                            class="form-control mb-lg-0 p-2"
                            placeholder="EPLxxx"
                        />
                        <div class="w-100"></div>
                    </div>
                </div>

                <div class="d-flex align-items-center w-auto me-5">
                    <div class="w-100px">
                        <label for="customerCode" class="col-form-label"
                        >Ca chấm công</label>
                    </div>
                    <div class="w-325px" style="">
                        <select @change="selectWorkingShiftSetting($event.target.value)" class="form-select" style="height:29px;" v-model="formTimekeepingUser.shift_id" data-placeholder="Chọn ca chấm công" aria-label="Default select example">
                            <option :value="item.id" v-for="(item,index) in workingShiftSettings" :key="index">{{ item.shift_title }}</option>
                        </select>
                        <div class="w-100"></div>
                        <span v-if="errors?.shift_id" class="text-danger">{{
                                errors.shift_id[0]
                            }}</span>
                    </div>
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
                <table style="width: 5000px;"
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
                        <th class="min-w-150px">Mã nhân viên
                        </th>
                        <th class="min-w-140px">Tên nhân viên</th>
                        <th style="width: 250px; text-align: center;"
                        v-for="(label, index) in date_in_month_label"
                        >{{label}}</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    <tr v-for="(item, index) in user_timekeeping_in_month" :key="index"
                        :class="{ active: item.contact_code == currentIndex }" @click="currentIndex = item.contact_code">
                        <td style="text-align: center">
                          <span class="text-dark text-hover-primary fs-6">
                            {{ pagination.per_page * (pagination.current_page - 1) + 1 + index }}
                          </span>
                                            </td>
                                            <td>
                          <span class="text-dark text-hover-primary text-content">
                            {{ item.contact_code }}
                          </span>
                                            </td>
                                            <td>
                          <span class="text-dark text-hover-primary text-content">
                            {{ item.full_name }}
                          </span>
                        </td>

                         <td
                             v-for="(label, dateKey) in date_in_month_label"  style="text-align: center;" :key="dateKey">
                             <div
                                 @click="!isFutureMonth && handleUpdate(item, dateKey, item['months'][dateKey]?.check_in_time, item['months'][dateKey]?.check_out_time, label)"
                                 :class="{
                                    'text-dark text-hover-primary': !isFutureMonth,
                                    'text-muted': isFutureMonth
                                  }"
                                 class="d-block mb-1 text-content"
                                 :style="{ cursor: isFutureMonth ? 'not-allowed' : 'pointer' }"
                                 :data-bs-toggle="!isFutureMonth ? 'modal' : null"
                                 :data-bs-target="!isFutureMonth ? '#formCreateAllowance' : null"
                             >
                          <span v-if="item['months'][dateKey]">
                            <b>{{ item['months'][dateKey].check_in_time || '--:--' }} | {{ item['months'][dateKey].check_out_time || '--:--' }}</b>
                          </span>
                                 <span v-else>--:--</span>
                             </div>

                         </td>
                         </tr>
                    </tbody>
                </table>

                <!--end::Table-->
            </div>
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
        <div class="modal-dialog modal-dialog-centered mw-450px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-left border-0 pb-0">
                    <!--begin::Close-->
                    <h4 class="modal-title">
                       Cập nhật chấm công: {{ full_name }} -  {{ updateCheckinDate }}
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
                        <div style="display: flex; margin-left: 70px;">
                            <div class="mb-8 fv-row">
                                <!--begin::Label-->
                                <label
                                    class="d-flex align-items-center fs-6 fw-semibold mb-2"
                                >
                                    <span class="required">Thời gian vào</span>
                                </label>
                                <!--end::Label-->
                                <TimePicker
                                    :class="{
                                    'input-custom-valid': errors?.check_in,
                                }"
                                    v-model="formTimekeepingUser.check_in"
                                />
                                <div class="w-100"></div>
                                <span
                                    v-if="errors?.check_in"
                                    class="text-danger mt-3"
                                >{{ errors.check_in[0] }}</span
                                >
                            </div>
                            <div class="mb-8 fv-row" style="margin-left: 50px;">
                                <!--begin::Label-->
                                <label
                                    class="d-flex align-items-center fs-6 fw-semibold mb-2"
                                >
                                    <span class="required">Thời gian ra</span>
                                </label>
                                <!--end::Label-->
                                <TimePicker
                                    :class="{
                                    'input-custom-valid': errors?.check_out,
                                }"
                                    v-model="formTimekeepingUser.check_out"
                                />
                                <div class="w-150px"></div>
                                <span
                                    v-if="errors?.check_out"
                                    class="text-danger mt-3"
                                >{{ errors.check_out[0] }}</span
                                >
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top:none">
                            <button type="button" class="btn btn-function me-4" @click.prevent="
                                   updateTimekeeping()
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
    import TimePicker from '../working-shift-settings/TimePicker.vue';
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
    const user_timekeeping_in_month = ref([]);
    const date_in_month_label = ref([]);

    let getMetaPaginate = ref({});

    const getTimekeepingUsers = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/timekeeping-users/get-all",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                user_timekeeping_in_month.value = res.data.user_timekeeping_in_month;
                date_in_month_label.value = res.data.date_in_month_label;
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    const formTimekeepingUser = reactive({
        user_id: null,
        checkin_date: null,
        check_in: null,
        check_out: null,
        shift_id: null
    });

    const searchTimekeepingUser = ref({
        nameAndCode: "",
        month: "",
    });

    const handleSearch = () => {
        getTimekeepingUsers(searchTimekeepingUser.value)
    }

    const full_name = ref("");
    const updateCheckinDate = ref("");

    const handleUpdate = (item, dateKey, check_in_time, check_out_time, label) => {
        formTimekeepingUser.user_id = item.user_id;
        formTimekeepingUser.checkin_date = dateKey;
        formTimekeepingUser.check_in = check_in_time;
        formTimekeepingUser.check_out = check_out_time;
        full_name.value = item.full_name;
        updateCheckinDate.value = label;
        errors.value = [];
    };
    const errors = ref([]);

    const updateTimekeeping = () => {
        KTApp.showPageLoading();
        axios
            .put("/timekeeping-users/update", formTimekeepingUser)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close');
                btn.click();
                // $("#formCreateBank").modal("hide");
                // $(".modal-backdrop").remove();
                console.log(searchTimekeepingUser.value.month, 'month')
                getTimekeepingUsers(searchTimekeepingUser.value);
            })
            .catch((error) => {
                errors.value = error.response?.data?.errors;
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
        getTimekeepingUsers(requestPaginate);
    };

    const workingShiftSettings = ref([]);

    const getWorkingShiftSettings = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/working-shift-settings/get-all",
            method: "GET",
            params: {...params,
                is_timekeeping: true
            },
        })
            .then((res) => {
                const { data, meta } = res.data;
                // console.log(meta);
                workingShiftSettings.value = data;
                // formWorkflow.users = [...data.users]
                workingShiftSettings.value.forEach((item) => formTimekeepingUser.shift_id = item.id)
                getMetaPaginate.value = meta;
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    onMounted(() => {
        getTimekeepingUsers();
        getWorkingShiftSettings();

        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        searchTimekeepingUser.value.month = `${year}-${month}`;
    });

    const isFutureMonth = computed(() => {
        const today = new Date();
        const current = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}`;
        return searchTimekeepingUser.value.month > current;
    });

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
