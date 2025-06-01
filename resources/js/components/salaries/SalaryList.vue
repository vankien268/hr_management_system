<template>
    <div class="card">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">{{ title }}</span>
            </h3>

            <div class="card-toolbar">
                <div class="d-flex align-items-center w-auto me-5">
                    <div class="w-100px">
                        <label class="col-form-label"
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
                <!--begin::Menu-->
                <div class="align-items-right">
                    <a
                        href="#"
                        class="btn btn-function me-2"
                        @click="clickCreateRole"
                        data-bs-target="#formCreateRole"
                        data-bs-toggle="modal"
                        v-if="props.btnAdd"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm bảng lương</a
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
                        <th class="w-25px" style="text-align: center">
                            STT
                        </th>
                        <th class="w-200px">Tên bảng lương</th>
                        <th class="w-150px">Phòng ban</th>
                        <th class="w-125px">Kỳ lương</th>
                        <th class="w-50px text-center" colspan="2">Hành động</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    <tr v-for="(item, index) in roles" :key="index">
                        <td style="text-align: center">
                                <span
                                    class="text-dark text-hover-primary fs-6 w-25px break-text d-block"
                                >{{
                                        pagination.per_page *
                                            (pagination.current_page - 1) +
                                        1 +
                                        index
                                    }}</span
                                >
                        </td>
                        <td>
                            <a :href="`/salaries/salary-contacts?salary_id=${item.id}`" target="_blank">
                                <span
                                    class="text-dark text-hover-primary text-content w-200px break-text d-block pb-1 mt-1 cursor-pointer"
                                >
                                    {{ item.name }}
                                </span>
                            </a>
                        </td>
                        <td>
                              <span
                                  class="text-dark text-hover-primary d-block mb-1 text-content"
                              >{{ item.department_names }}</span
                              >

                        </td>
                        <td class="w-125px ">
                          Kỳ lương tháng {{ item.month }}/{{ item.year }}
                        </td>
                        <td class="w-25px text-center">
                            <a
                                href="#"
                                @click="handleUpdate(item)"
                                data-bs-target="#formCreateRole"
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
                        <td class="w-25px text-center">
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
                    <tbody v-if="Object.keys(roles).length == 0">
                    <tr>
                        <td class="text-center" colspan="12">
                            Không có dữ liệu hiển thị
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
        id="formCreateRole"
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
                        isClickRoleUpdate
                        ? "Sửa bảng lương"
                        : "Thêm bảng lương"
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
                                <span class="required">Tên bảng lương</span>
                            </label>
                            <!--end::Label-->
                            <input
                                type="text"
                                class="form-control text-input"
                                :class="{
                                    'input-custom-valid': errors.name,
                                    // 'input-disabled': canDisabledCode,
                                }"
                                v-model="formRole.name"
                                placeholder="Tên bảng lương"
                                name="target_title"
                            />
                            <div class="w-100"></div>
                            <span
                                v-if="errors.name"
                                class="text-danger mt-3"
                            >{{ errors.name[0] }}</span
                            >
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="required">Tháng</span>
                            </label>
                            <!--end::Label-->
                            <select class="form-select" style="height:29px;" v-model="formRole.month" :class="{ 'select-custom-valid' :  errors.month}"  data-placeholder="Chọn tháng" aria-label="Default select example">
                                <option :value="null">Vui lòng chọn</option>
                                <option :value="item.value" v-for="(item,index) in selectMonths" :key="index">{{ item.name }}</option>
                            </select>
                            <div class="w-100"></div>
                            <span
                                v-if="errors.month"
                                class="text-danger mt-3"
                            >{{ errors.month[0] }}</span
                            >
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="required">Năm</span>
                            </label>
                            <!--end::Label-->
                            <input
                                type="text"
                                class="form-control text-input"
                                :class="{
                                    'input-custom-valid': errors.year,
                                    // 'input-disabled': canDisabledCode,
                                }"
                                v-model="formRole.year"
                                placeholder="Nhập năm"
                                name="target_title"
                            />
                            <div class="w-100"></div>
                            <span
                                v-if="errors.year"
                                class="text-danger mt-3"
                            >{{ errors.year[0] }}</span
                            >
                        </div>
                        <!--end::Input group-->
                        <div
                            class="d-flex flex-column mb-8 fv-row"

                        >
                            <label class="required fs-6 fw-semibold mb-2"
                            >Trạng thái</label
                            >

                            <multiselect
                                v-model="formRole.department_ids"
                                :options="departmentListAPI"
                                :custom-label="customUserLabel"
                                track-by="id"
                                placeholder="Chọn phòng ban"
                                :multiple="true"
                                style="padding: 0px;"
                                :class="{ 'select-custom-valid' :  errors?.department_ids }"
                            >
                            </multiselect>

                            <div class="w-100 pt-1"></div>
                            <span
                                v-if="errors?.department_ids"
                                class="text-danger mt-3"
                            >{{ errors?.department_ids[0] }}</span
                            >
                        </div>

                        <div class="modal-footer" style="border-top:none">
                            <button type="button" class="btn btn-function me-4" @click.prevent="
                                    isClickRoleUpdate
                                        ? updateRole()
                                        : storeRole()
                                ">
                                <i class="fa-solid fa-floppy-disk"></i> Lưu
                            </button>
                            <!-- <button type="button" class="btn btn-function me-4" @click.prevent="">
                                <i class="fa-solid fa-gear fs-2"></i> Gán quyền
                            </button> -->
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
    import Multiselect from 'vue-multiselect'

    import axios from "axios";
    const props = defineProps({
        title: String,
        btnAdd: {
            type: Boolean,
            default: false,
        }
    });
    const formRole = reactive({
        name: "",
        department_ids: [],
        month: null,
        year: null,
    });

    const searchTimekeepingUser = ref({
        month: "",
    });

    const handleSearch = () => {
        getRoles(searchTimekeepingUser.value)
    }

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
    const customUserLabel = (option) => {
        return `${option.name}`
    }


    // handle chọn số bản ghi / 1 trang
    let selectTotalRecord = ref(30);
    const handleClickItem = (numberPage) => {
        selectTotalRecord.value = numberPage;
    };
    const roles = ref([]);
    let getMetaPaginate = ref({});
    const getRoles = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/salaries/get-all",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                // console.log(meta);
                roles.value = data;
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
        getRoles(requestPaginate);
    };

    const clickAssignRole = (id) => {
        window.location.href = "/system-functions?role_id=" + id;
    }

    onMounted(() => {
        getRoles();
        getAllDepartments();
    });

    const errors = ref([]);
    const storeRole = () => {
        KTApp.showPageLoading();
        axios
            .post("/salaries/store", formRole)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close');
                btn.click();
                // $("#formCreateRole").modal("hide");
                // $(".modal-backdrop").remove();
                getRoles();
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
                if(error.response?.data?.code == 403) {
                    useToast.errorToast(error.response.data?.errors?.message);
                }
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    let role_id = ref(0);
    let canDisabledCode = ref(false);
    let isClickRoleUpdate = ref(false);

    const handleUpdate = (item) => {
        role_id.value = item.id;
        isClickRoleUpdate.value = true;
        formRole.name = item.name;
        formRole.department_ids = item.department_ids;
        formRole.month = item.month;
        formRole.year = item.year;
        errors.value = [];
        canDisabledCode.value = true;
    };
    const clickCreateRole = () => {
        isClickRoleUpdate.value = false;
        formRole.name = "";
        formRole.department_ids = [];
        formRole.month = null;
        formRole.year = null;
        errors.value = [];
        canDisabledCode.value = false;
    };
    const updateRole = () => {
        KTApp.showPageLoading();
        axios
            .put("/salaries/update/" + `${role_id.value}`, formRole)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close');
                btn.click();
                // $("#formCreateRole").modal("hide");
                // $(".modal-backdrop").remove();
                changePage(getMetaPaginate.value.pagination);
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
                if(error.response?.data?.code == 403) {
                    useToast.errorToast(error.response.data?.errors?.message);
                }
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    const selectMonths = reactive([
        { value: "0                                                         1", name: "Tháng 1" },
        { value: "02", name: "Tháng 2" },
        { value: "03", name: "Tháng 3" },
        { value: "04", name: "Tháng 4" },
        { value: "05", name: "Tháng 5" },
        { value: "06", name: "Tháng 6" },
        { value: "07", name: "Tháng 7" },
        { value: "08", name: "Tháng 8" },
        { value: "09", name: "Tháng 9" },
        { value: "10", name: "Tháng 10" },
        { value: "11", name: "Tháng 11" },
        { value: "12", name: "Tháng 12" },
    ])

    const handleDelete = (id) => {
        sweetAlertMessage
            .messageWarning("Bạn có chắc chắn muốn xóa không?")
            .then(function (result) {
                if (result.value) {
                    KTApp.showPageLoading();
                    axios
                        .delete("/salaries/destroy/" + id)
                        .then((res) => {
                            useToast.successToast(res.data.message);
                            const totalRecordOnPage =
                                getMetaPaginate.value.pagination.count;
                            if (totalRecordOnPage - 1 === 0) {
                                getMetaPaginate.value.pagination.current_page -= 1;
                            }
                            if (getMetaPaginate.value.pagination.total - 1 === 0) {
                                getRoles();
                            }
                            changePage(getMetaPaginate.value.pagination);
                        })
                        .catch((error) => {
                            console.log(error);
                            if(error.response?.data?.code == 403) {
                                useToast.errorToast(error.response.data?.errors?.message);
                            }
                        }).finally(()=>{
                        KTApp.hidePageLoading();
                    });
                }
            });
    };

    const closeModal = () => {
        // $("#formCreateRole").modal("hide");
        // $(".modal-backdrop").remove();
    };
    const time = ref('');

    const getTime = () => {
        var currentTimeDate = new Date();
        var dates = currentTimeDate.getDate();
        var months = currentTimeDate.getMonth();
        var years = currentTimeDate.getFullYear();
        var hours   =  currentTimeDate.getHours();
        var minutes = currentTimeDate.getMinutes();
        var seconds = currentTimeDate.getSeconds();

        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        dates = dates < 10 ? '0' + dates : dates;
        months = months < 10 ? '0' + months : months;


        time.value = dates + '/' + months + '/' + years + ' ' + hours + ':' + minutes + ':' + seconds;
    }
    onMounted(() => {
        getTime();
        setInterval(getTime, 500);
    })
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
    .icon-roles:hover {
        color: black;
    }
</style>
