<template>
    <div class="card">
        <!--begin::Tables Widget 9-->
        <div class="card-header border-0 pt-5">
            <!--begin::Header-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1" style="margin-left: 30px;">Danh sách thiết lập ca chấm công</span>
            </h3>

            <div class="card-toolbar">
                <!--begin::Menu-->
                <div class="align-items-right" style="margin-right: 30px;">
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
                <!--begin::Menu 2-->
            </div>

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
                        <tr class="fs-6 text-gray-400">
                            <th class="w-50px max-w-50px">STT</th>
                            <th class="w-100px max-w-125px text-center">
                                Tên ca làm việc
                            </th>
                            <th class="min-w-100px max-w-125px">Sử dụng/ Ngừng sử dụng</th>
                            <th class="min-w-200px max-w-350px">
                               Mô tả
                            </th>
                            <th class="min-w-100px text-center" colspan="2">Hành động</th>
                        </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody

                        >
                        <tr  v-for="(item, key) in workingShiftSettings"
                             :key="key"
                             class="max-h-75 overflow-auto">
                            <td class="text-center">
                                {{
                                pagination.per_page *
                                (pagination.current_page - 1) +
                                1 +
                                key
                                }}
                            </td>
                            <td class="break-text">
                                {{ item.shift_title }}
                            </td>

                            <td class="break-text">
                                {{ item.active == 1 ? "Sử dụng" : "Ngừng sử dụng" }}
                            </td>

                            <td class="break-text">
                                {{ item.description }}
                            </td>
                            <td class="w-50px text-center">
                                <a
                                    href="#"
                                    @click="handleUpdate(item)"
                                    data-bs-target="#formCreateRequestTicket"
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
                        <tbody v-if="Object.keys(workingShiftSettings).length == 0">
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
                        {{editAction ? 'Sửa thiết lập ca làm việc' : 'Thêm thiết lập ca làm việc'}}
                    </h4>

                    <div class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2" data-bs-dismiss="modal" @click="closeModal()">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                </div>

                <div class="modal-body">
                    <!-- Tên ca làm việc -->
                    <div class="mb-3">
                        <label for="shift_title" class="form-label">Tên ca làm việc <span class="text-danger">*</span></label>
                        <input type="text"
                               v-model="dataUpdateWorkingShiftSetting.shift_title"
                               :class="{
                                    'input-custom-valid': errors?.shift_title,
                                }"
                               class="form-control" id="shift_title" name="shift_title" >
                        <div class="w-100 pt-1"></div>
                        <span
                            v-if="errors?.shift_title"
                            class="text-danger mt-3"
                        >{{ errors.shift_title[0] }}</span
                        >
                    </div>

                    <!-- Loại ca làm việc -->
                    <div class="mb-3">
                        <label class="form-label">Loại ca làm việc</label>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="shift_type"
                                       v-model="dataUpdateWorkingShiftSetting.shift_type"
                                       id="full_time" :value="1" checked>
                                <label class="form-check-label" for="full_time">Full time</label>
                            </div>
                            <div class="form-check form-check-inline" style="padding-left: 50px;">
                                <input class="form-check-input" type="radio" name="shift_type"
                                       v-model="dataUpdateWorkingShiftSetting.shift_type"
                                       id="part_time" :value="0">
                                <label class="form-check-label" for="part_time">Part time</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 mb-3">
                        <label class="form-label">Thời gian làm việc</label>
                    </div>

                    <!-- Thời gian làm việc trong tuần -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 150px;">Ngày kích hoạt</th>
                                <th>Thứ</th>
                                <th>Giờ bắt đầu ca</th>
                                <th>Giờ kết thúc ca</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Loop T2 -> CN -->

                            <!-- Hoặc render thủ công -->
                            <!-- Ví dụ: -->
                            <tr v-for="(item, index) in days" :index = "index">
                                <td>

                                    <input
                                        type="checkbox" v-model="dataUpdateWorkingShiftSetting.shift_weekdays[item.textEng].is_working"
                                    />
                                </td>
                                <td>{{item.textVi}}
                                </td>
                                <td>
                                    <TimePicker
                                        v-model="dataUpdateWorkingShiftSetting.shift_weekdays[item.textEng].shift_start_time"
                                    />
                                </td>
                                <td>
                                    <TimePicker
                                        v-model="dataUpdateWorkingShiftSetting.shift_weekdays[item.textEng].shift_end_time"
                                    />
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Thông tin thêm -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="work_days" class="form-label ">Số công / ca làm việc <span class="text-danger">*</span></label>
                            <input type="number"
                                   :class="{
                                    'input-custom-valid': errors?.['attributes.work_number']
                                }"
                                   v-model="dataUpdateWorkingShiftSetting.attributes.work_number"
                                   class="form-control" id="work_days" name="work_days" required>

                            <div class="w-100 pt-1"></div>
                            <span
                                v-if="errors?.['attributes.work_number']"
                                class="text-danger mt-3"
                            >{{ errors?.['attributes.work_number'][0] }}</span
                            >
                        </div>
<!--                        <div class="col-md-6">-->
<!--                            <label for="work_salary" class="form-label">Tiền công / ca làm việc <span class="text-danger">*</span></label>-->
<!--                            <input type="number" class="form-control" id="work_salary" name="work_salary" required>-->
<!--                        </div>-->
                        <div class="col-md-6">
                            <label for="description" class="form-label">Nhân viên áp dụng</label>
                            <multiselect
                                v-model="dataUpdateWorkingShiftSetting.working_shift_users"
                                :options="users"
                                :custom-label="customUserLabel"
                                track-by="id"
                                placeholder="Chọn người dùng"
                                :multiple="true"
                                style="padding: 0px;"
                                :class="{ 'select-custom-valid' :  errors?.working_shift_users }"
                            >
                            </multiselect>

                            <div class="w-100 pt-1"></div>
                            <span
                                v-if="errors?.working_shift_users"
                                class="text-danger mt-3"
                            >{{ errors?.working_shift_users[0] }}</span
                            >

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="allow_late" class="form-label">Cho phép đi muộn (Phút)</label>
                            <input type="number"
                                   :class="{
                                    'input-custom-valid': errors?.attributes?.check_in_late,
                                }"
                                   v-model="dataUpdateWorkingShiftSetting.attributes.check_in_late"
                                   class="form-control" id="allow_late" name="allow_late">
                            <div class="w-100 pt-1"></div>
                            <span
                                v-if="errors?.attributes?.check_in_late"
                                class="text-danger mt-3"
                            >{{ errors.attributes.check_in_late[0] }}</span>
                        </div>
                        <div class="col-md-6">
                            <label for="allow_early" class="form-label">Cho phép về sớm (Phút)</label>
                            <input type="number"
                                   :class="{
                                    'input-custom-valid': errors?.attributes?.check_out_early,
                                }"
                                   v-model="dataUpdateWorkingShiftSetting.attributes.check_out_early"
                                   class="form-control" id="allow_early" name="allow_early">
                            <div class="w-100 pt-1"></div>
                            <span
                                v-if="errors?.attributes?.check_out_early"
                                class="text-danger mt-3"
                            >{{ errors.attributes.check_out_early[0] }}</span>
                        </div>
                    </div>

                    <!-- Mô tả -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control"
                                  :class="{
                                    'input-custom-valid': errors?.description,
                                }"
                                  v-model="dataUpdateWorkingShiftSetting.description"
                                  id="description" name="description" rows="3"></textarea>
                        <div class="w-100 pt-1"></div>
                        <span
                            v-if="errors?.description"
                            class="text-danger mt-3"
                        >{{ errors.description[0] }}</span>
                    </div>

                    <!-- Checkboxes -->
                    <div class="mb-3 form-check">
                        <input type="checkbox"
                               v-model="dataUpdateWorkingShiftSetting.attributes.use_strict_timekeeping"
                               class="form-check-input" id="strict_mode" name="strict_mode">
                        <label class="form-check-label" for="strict_mode">Cơ chế chấm công nghiêm ngặt</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox"
                               v-model="dataUpdateWorkingShiftSetting.attributes.use_free_timekeeping"
                               class="form-check-input" id="free_mode" name="free_mode" checked>
                        <label class="form-check-label" for="free_mode">Cơ chế chấm công tự do</label>
                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-function me-4"
                            @click.prevent="
                                    editAction
                                        ? updateWorkingShiftSetting()
                                        : storeWorkingShiftSetting()
                                ">
                        <i class="fa-solid fa-floppy-disk"></i> Lưu
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm btn-active-color-light" id="close-modal" data-bs-dismiss="modal"
                            @click="closeModal()">
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
    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css'
    import Multiselect from 'vue-multiselect'
    import TimePicker from './TimePicker.vue';

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
    import {useUsers} from "../../stores/user";

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
    const options = ref([
        'list', 'of', 'options'
    ])

    const time = ref();

    const days =  ref([
        {
            textVi:"T2",
            textEng: "monday"
        },
        {
            textVi:"T3",
            textEng: "tuesday"
        },
        {
            textVi:"T4",
            textEng: "wednesday"
        },
        {
            textVi:"T5",
            textEng: "thursday"
        },
        {
            textVi:"T6",
            textEng: "friday"
        },
        {
            textVi:"T7",
            textEng: "saturday"
        },
        {
            textVi:"CN",
            textEng: "sunday"
        },
    ]);

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

    const dataUpdateWorkingShiftSetting = reactive({
        id: null,
        shift_type: 1,
        shift_title: null,
        description: null,
        active: 1,
        shift_weekdays: {
            monday:{
                is_working: 0,
                shift_end_time: null,
                shift_start_time: null
            },
            tuesday:{
                is_working: 0,
                shift_end_time: null,
                shift_start_time: null
            },
            wednesday:{
                is_working: 0,
                shift_end_time: null,
                shift_start_time: null
            },
            thursday:{
                is_working: 0,
                shift_end_time: null,
                shift_start_time: null
            },
            friday:{
                is_working: 0,
                shift_end_time: null,
                shift_start_time: null
            },
            saturday:{
                is_working: 0,
                shift_end_time: null,
                shift_start_time: null
            },
            sunday:{
                is_working: 0,
                shift_end_time: null,
                shift_start_time: null
            }
        },
        attributes: {
            work_number: null,
            check_in_late: null,
            check_out_early: null,
            use_strict_timekeeping: null,
            use_free_timekeeping: null,
        },
        working_shift_users: []

    });

    const closeModal = () => {
        editAction.value = false;
        errors.value = [];

        dataUpdateWorkingShiftSetting.id = null;
        dataUpdateWorkingShiftSetting.shift_type = 1;
        dataUpdateWorkingShiftSetting.shift_title = null;
        dataUpdateWorkingShiftSetting.description = null;
        dataUpdateWorkingShiftSetting.active = 1;

        // Reset shift_weekdays
        const defaultDay = {
            is_working: 0,
            shift_start_time: null,
            shift_end_time: null,
        };

        const weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        weekdays.forEach(day => {
            dataUpdateWorkingShiftSetting.shift_weekdays[day] = { ...defaultDay };
        });

        // Reset attributes
        dataUpdateWorkingShiftSetting.attributes = {
            work_number: null,
            check_in_late: null,
            check_out_early: null,
            use_strict_timekeeping: null,
            use_free_timekeeping: null,
        };

        // Reset working_shift_users
        dataUpdateWorkingShiftSetting.working_shift_users = [];
    };

    const handleUpdate = (item) => {
        editAction.value = true;

        dataUpdateWorkingShiftSetting.id = item.id;
        dataUpdateWorkingShiftSetting.shift_type = item.shift_type;
        dataUpdateWorkingShiftSetting.shift_title = item.shift_title;
        dataUpdateWorkingShiftSetting.description = item.description;
        dataUpdateWorkingShiftSetting.active = item.active;

        // Gán shift_weekdays
        const weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        weekdays.forEach(day => {
            const data = item.shift_weekdays?.[day] ?? {
                is_working: 0,
                shift_start_time: null,
                shift_end_time: null
            };

            dataUpdateWorkingShiftSetting.shift_weekdays[day] = {
                is_working: data.is_working ?? 0,
                shift_start_time: data.shift_start_time ?? null,
                shift_end_time: data.shift_end_time ?? null,
            };
        });

        // Gán attributes
        const attrs = item.attributes ?? {};
        dataUpdateWorkingShiftSetting.attributes = {
            work_number: attrs.work_number ?? null,
            check_in_late: attrs.check_in_late ?? null,
            check_out_early: attrs.check_out_early ?? null,
            use_strict_timekeeping: attrs.use_strict_timekeeping ?? null,
            use_free_timekeeping: attrs.use_free_timekeeping ?? null,
        };

        // Gán danh sách người dùng
        dataUpdateWorkingShiftSetting.working_shift_users = item.users ?? [];
    };


    const isClickContractUpdate = ref(false);
    const errors = ref([]);

    const clickCreateContract = () => {
        errors.value = [];
        editAction.value = false;
    };

    const pagination = computed(() => {
        return getMetaPaginate.value?.pagination
            ? getMetaPaginate.value.pagination
            : { current_page: 1, total_pages: 1, per_page: 30 };
    });

    const handleDelete = (id) => {
        sweetAlertMessage
            .messageWarning("Bạn có chắc chắn muốn xóa không?")
            .then(function (result) {
                if (result.value) {
                    KTApp.showPageLoading();
                    axios
                        .delete("/working-shift-settings/destroy/" + id)
                        .then((res) => {
                            useToast.successToast(res.data.message);
                            const totalRecordOnPage =
                                getMetaPaginate.value.pagination.count;
                            if (totalRecordOnPage - 1 === 0) {
                                getMetaPaginate.value.pagination.current_page -= 1;
                            }
                            if (getMetaPaginate.value.pagination.total - 1 === 0) {
                                getWorkingShiftSettings();
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
// ====================WorkingShiftSetting======================
    const workingShiftSettings = ref([]);
    const getWorkingShiftSettings = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/working-shift-settings/get-all",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                // console.log(meta);
                workingShiftSettings.value = data;
                // formWorkflow.users = [...data.users]
                console.log(workingShiftSettings.value, 'danh sách')
                getMetaPaginate.value = meta;
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };


    const storeWorkingShiftSetting = () => {
        KTApp.showPageLoading();
        axios
            .post("/working-shift-settings/store", dataUpdateWorkingShiftSetting)
            .then((res) => {
                errors.value = [];
                useToast.successToast(res.data.message);
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

    const updateWorkingShiftSetting = () => {
        editAction.value = false;

        KTApp.showPageLoading();
        axios.put(`/working-shift-settings/update/` + `${dataUpdateWorkingShiftSetting.id}`, dataUpdateWorkingShiftSetting).then((res) => {
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

    const changePage = (newDataPagination) => {
        const requestPaginate = {
            page: newDataPagination.current_page,
            per_page: newDataPagination.per_page,
        };
        getWorkingShiftSettings(requestPaginate);
    };

    const users = ref([]);

    const getUsers = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/users/get-all",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                users.value = data;
                console.log( users.value)
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    const customUserLabel = (option) => {
        return `${option.name}(${option.username})`
    }

    onMounted(() => {
        getWorkingShiftSettings();
        getUsers()
    })

    // ====================END WorkingShiftSetting======================


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

</script>
<style lang="scss" scoped>

    .time-select {
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    .right-5 {
        right: 50px;
    }

    label {
        &.col-form-label {
            font-size: 13px !important;
            padding: 2px 0 !important;
        }
    }
    * {
        font-size: 13px;
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

    .multiselect {
        font-size: 13px !important;
    }

    :deep(.multiselect) {
        font-size: 13px !important;
    }

    :deep(.multiselect__option),
    :deep(.multiselect__single),
    :deep(.multiselect__tags) {
        font-size: 13px !important;
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
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
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
