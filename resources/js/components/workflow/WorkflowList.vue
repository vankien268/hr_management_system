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
                        @click="clickCreateRequestTicket"
                        data-bs-target="#formCreateRequestTicket"
                        data-bs-toggle="modal"
                        v-if="props.btnAdd"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm phiếu yêu cầu</a
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
                        <th class="min-w-150px">Tên quy trình</th>
                        <th class="min-w-140px">Loại quy trình	</th>
                        <th class="min-w-100px">Người tạo	</th>
                        <th class="min-w-100px">Phòng ban áp dụng	</th>
                        <th class="min-w-100px text-center" colspan="2">Hành động</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    <tr v-for="(item, index) in workflows" :key="index"
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
                                >{{ item.workflow_name }}</span
                                >
                        </td>
                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                > {{ item.workflow_type_name }}</span
                                >
                        </td>

                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >{{ item.creator_name }}</span
                                >
                        </td>

                        <td  style="white-space: normal; word-break: break-word;">
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >{{ item.department_names }}</span
                                >
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
<!--    ======================================================= FORM ===================================   -->
    <div
        class="modal fade"
        id="formCreateRequestTicket"
        data-bs-keyboard="true"
        data-bs-backdrop="static"
        tabindex="-1"
        aria-hidden="true"
    >
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered mw-850px max-h-60" >
            <!--begin::Modal content-->
            <div class="modal-content rounded" >
                <!--begin::Modal header-->
                <div class="modal-header border-0 pb-0">
                    <!--begin::Close-->
                    <h4 class="modal-title">
                        {{
                        isClickWorkflowUpdate
                        ? "Sửa quy trình duyệt"
                        : "Thêm mới quy trình duyệt"
                        }}
                    </h4>
                    <div id="close-modal-deployment-schedule-by-title close"
                          class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2"
                          data-bs-dismiss="modal"   aria-label="Close"
                    >
                        <i class="ki-duotone ki-cross fs-1 text-white">
                            <i class="fa-solid fa-xmark fs-3"></i>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div
                    class="modal-body pt-5 justify-content-center justify-content-center"
                >
                    <div class="row col-lg-12 ms-2" >
                        <div class="col-lg-12">
                            <div class="row align-items-center g-3 col-lg-12" style="padding-bottom:17px;">
                                <div class="col-lg-4">
                                    <label class="fs-6 fw-semibold">
                                            <span class="required text-content text-content"
                                            >Tên quy trình</span
                                            >
                                    </label>
                                </div>
                                <div class="col-lg-7">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nhập tên quy trình"
                                        :class="{
                                    'input-custom-valid': errors?.workflow_name,
                                }"
                                        v-model="formWorkflow.workflow_name"
                                    />
                                    <div class="w-100 pt-1"></div>
                                    <span
                                        v-if="errors?.workflow_name"
                                        class="text-danger mt-3"
                                    >{{ errors.workflow_name[0] }}</span
                                    >
                                </div>

                            </div>
                            <div class="row g-3 align-items-center col-lg-12" style="padding-bottom:17px;">
                                <div class="col-lg-4">
                                    <label
                                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                    >
                                            <span class=" text-content"
                                            >Mô tả</span
                                            >
                                    </label>

                                </div>

                                <div class="col-lg-7">
                                    <textarea v-model="formWorkflow.description"
                                        class="form-control"
                                        placeholder="Nhập mô tả"
                                        name="target_title"
                                    />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12" style="padding-bottom:17px;">
                                <div class="col-lg-4">
                                    <label
                                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                    >
                                        <span class="text-content">Phòng ban áp dụng</span>
                                    </label>
                                </div>
                                <div class="col-lg-7">
                                    <select multiple style="height:120px;" class="form-select"
                                            placeholder="Chọn phòng ban áp dụng"
                                            v-model="formWorkflow.dept_ids"
                                            :class="{ 'select-custom-valid' :errors?.dept_ids}">
                                        <option :value="null">Áp dụng tất cả phòng ban</option>
                                        <option v-for="(item, index) in departmentListNew"
                                                :key="index" :value="item.id">
                                            {{  `${item.name}` }}
                                        </option>
                                    </select>
                                    <div v-if="errors?.dept_ids" class="text-danger pt-2">{{
                                        errors.dept_ids[0]
                                        }}</div>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12" style="padding-bottom:17px;">
                                <div class="col-lg-4">
                                    <label
                                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                    >
                                        <span class="text-content">Loại quy trình</span>
                                    </label>
                                </div>

                                <div class="col-lg-7">
                                    <select style="height:29px;" class="form-select"
                                            placeholder="Chọn loại quy trình"
                                            v-model="formWorkflow.workflow_type"
                                            :class="{ 'select-custom-valid' :errors?.workflow_type}">
                                        <option :value="null">Chọn</option>
                                        <option v-for="(item, index) in workflowTypes"
                                                :key="index" :value="item.workflow_type">
                                            {{  `${item.name}` }}
                                        </option>
                                    </select>
                                    <div v-if="errors?.workflow_type" class="text-danger pt-2">{{
                                        errors.workflow_type[0]
                                        }}</div>
                                </div>

                                <!-- Người duyệt -->
                                <div class="row g-3 align-items-center col-lg-12" >
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-3">
                                            <span class="required text-content">Người duyệt</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-7" >
                                        <div class="d-flex gap-4 mb-2">
                                            <label><input type="radio" name="nguoi_duyet" value="dept" class="me-1" v-model="formWorkflow.approver_type"/> Phòng ban</label>
                                            <label><input type="radio" name="nguoi_duyet" value="user" class="me-1" v-model="formWorkflow.approver_type" /> Cá nhân</label>
                                        </div>

                                        <div v-if="formWorkflow.approver_type == 'dept'">
                                            <select
                                                v-model="formWorkflow.approver_ids"
                                                multiple class="form-select" style="margin-top:20px;height: 100px;">
                                                <option v-for="(item, index) in departmentListNew"
                                                        :key="index" :value="item.id">
                                                    {{  `${item.name}` }}
                                                </option>
                                            </select>
                                            <div  v-if="errors.approver_ids && formWorkflow.approver_type == 'dept'"  class="text-danger pt-2">
                                                <span class="text-danger" >Vui lòng chọn người duyệt.</span>
                                           </div>

                                        </div>

                                        <div class="text-danger pt-2"></div>
                                    </div>

                                    <div v-if="formWorkflow.approver_type == 'user'" class="col-lg-12">
                                        <div
                                            class="card-header border-0 d-flex justify-content-between align-items-center"
                                        >
                                <span class="card-label fw-bold text-content">
                                    Danh sách người duyệt</span
                                >
                                            <div class="align-items-center d-flex">
                                                <div @click="addUserRow()">
                                                    <a href="#" class="btn btn-function">
                                                        <i class="ki-duotone ki-plus fs-2"></i>Thêm</a
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body py-3">
                                            <div class="table-responsive table-scroll-sm text-nowrap"  style="min-height: 26vh !important; height:26px;">
                                                <table class="table table-row-dashed table-bordered table-data">
                                                    <thead>
                                                    <tr class="fs-6 text-gray-400">
                                                        <th class="w-20px max-w-50px">STT</th>
                                                        <th class="w-200px max-w-200px">Tên người dùng</th>
                                                        <th class="w-200px max-w-180px">Số điện thoại</th>
                                                        <th class="w-200px max-w-200px">Email</th>
                                                        <th class="w-100px text-center" colspan="2">Hành động</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="max-h-10 overflow-auto cursor-pointer" v-if="formWorkflow.users.length > 0">
                                                    <tr
                                                        v-for="(item, index) in formWorkflow
                                                    .users"
                                                        :key="index"
                                                    >
                                                        <td :class="{ 'is-invalid-border-right' : errors['users.' + index + '.id']}"
                                                            class="text-center text-content">
                                                            {{ index + 1 }}
                                                        </td>
                                                        <td :title="errors['users.' + index + '.id']"
                                                            :class="{ 'is-invalid-border' : errors['users.' + index + '.id']}">

                                                            <SelectSearchDiffUser
                                                                @changeUser="changeUser"
                                                                :list-data="getUsers"
                                                                :disabled="idEdit != index && item.idSave !=0"

                                                                :idSave="item.idSave"
                                                                v-model="item.id"
                                                                placeholder="Chọn"
                                                                key-value="id"
                                                                :indexKey="index"
                                                                key-display="name"
                                                            />
                                                            <!-- :class="{ 'select-custom-valid' :errors?  errors['deploymentSchedule.data.0.project_id']: false}"-->

                                                        </td>
                                                        <td class="td-background-disabled">
                                                            <input
                                                                :disabled="true"
                                                                class="text-content"
                                                                type="text"
                                                                :value="item.phone"
                                                            />
                                                        </td>
                                                        <td   class="td-background-disabled">
                                                            <input
                                                                :disabled="true"
                                                                class="text-content"
                                                                type="text"
                                                                :value="item.email"
                                                            />
                                                        </td>
                                                        <td class="text-center w-100px">
                                                            <a href="#" class="btn btn-icon btn-edit btn-sm"
                                                               v-if="idEdit==index && item.idSave !=0" @click="resetIdRowEdit()">
                                                                <i class="fa-solid fa-check fs-5"></i>
                                                            </a>
                                                            <a v-if="idEdit != index && item.idSave !=0" @click="setIdRowEdit(index)" href="#"
                                                               class="btn btn-icon btn-edit btn-sm">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </a>
                                                        </td>
                                                        <td class="text-center w-100px">
                                                            <a
                                                                @click="removeItemUserRow(index, item)"
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
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
                <div class="modal-footer" style="border-top:none">
                    <button type="button" class="btn btn-function me-4" @click.prevent="
                                    isClickWorkflowUpdate
                                        ? updateWorkflow()
                                        : createWorkflow()
                                ">
                        <i class="fa-solid fa-floppy-disk"></i> Lưu
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm btn-active-color-light" id="close-modal" data-bs-dismiss="modal"
                            @click="closeModal()">
                        <i class="fa-solid fa-xmark"></i>Đóng
                    </button>
                </div>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
</template>

<script setup>
    import {defineProps, ref, reactive, computed, onMounted, watch, onBeforeMount} from "vue";
    import { helperFunc } from "../../helper/heplerFunction.js";
    import { sweetAlertMessage } from "../../helper/sweetAlert";
    import { useToast } from "../../helper/toastMessage";
    import axios from "axios";
    import { useUsers } from "../../stores/user";
    import SelectSearchDiffUser from '../input/SelectSearchDiff2.vue'
    import moment from 'moment';
    import {storeToRefs} from "pinia";

    const props = defineProps({
        title: String,
        btnAdd: {
            type: Boolean,
            default: false,
        }
    });

    const formWorkflow = reactive({
        workflow_type: null,
        workflow_name: null,
        description: null,
        dept_ids: [],
        users: [],
        approver_type: "dept",
        approver_ids: [],
    });

    // handle chọn số bản ghi / 1 trang
    const currentIndex = ref(-1);

    let selectTotalRecord = ref(30);
    const handleClickItem = (numberPage) => {
        selectTotalRecord.value = numberPage;
    };
    const workflows = ref([]);
    let getMetaPaginate = ref({});
    const getWorkflow = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/workflow/get-all",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                // console.log(meta);
                workflows.value = data;
                // formWorkflow.users = [...data.users]
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
        getWorkflow(requestPaginate);
    };

    const errors = ref([]);
    const createWorkflow = () => {

        if(formWorkflow.users.length > 0 && formWorkflow.approver_type === "user") {
            formWorkflow.approver_ids = [];
            formWorkflow.users.forEach(function (item) {
                formWorkflow.approver_ids.push(item.id);
            });
        }

        KTApp.showPageLoading();
        axios
            .post("/workflow/store", formWorkflow)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close-modal');
                btn.click();
                // $("#formCreateBank").modal("hide");
                // $(".modal-backdrop").remove();
                getWorkflow();
            })
            .catch((error) => {
                errors.value = error.response?.data?.errors;
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    let workflow_id = ref(0);
    let isClickWorkflowUpdate = ref(false);

    const handleUpdate = (item) => {
        workflow_id.value = item.id;
        isClickWorkflowUpdate.value = true;
        formWorkflow.workflow_type = item.workflow_type;
        formWorkflow.workflow_name = item.workflow_name;
        formWorkflow.description = item.description;
        formWorkflow.dept_ids = item.dept_ids;
        formWorkflow.approver_ids = item.approver_ids;
        formWorkflow.approver_type = item.approver_type;
        errors.value = [];
        formWorkflow.users = item.users;
    };

    const clickCreateRequestTicket = () => {
        isClickWorkflowUpdate.value = false;
        formWorkflow.workflow_type = null;
        formWorkflow.workflow_name = null;
        formWorkflow.description = null;
        formWorkflow.dept_ids = [];
        formWorkflow.approver_ids = [];
        formWorkflow.approver_type = "dept";
        formWorkflow.users = [];
        errors.value = [];
    };
    const updateWorkflow = () => {

        if(formWorkflow.users.length > 0 && formWorkflow.approver_type === "user") {
            formWorkflow.approver_ids = [];
            formWorkflow.users.forEach(function (item) {
                formWorkflow.approver_ids.push(item.id);
            });
        }

        KTApp.showPageLoading();
        axios
            .post("/workflow/update/" + `${workflow_id.value}`, formWorkflow)
            .then((res) => {
                useToast.successToast(res.data.message);
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
    const handleDelete = (id) => {
        sweetAlertMessage
            .messageWarning("Bạn có chắc chắn muốn xóa không?")
            .then(function (result) {
                if (result.value) {
                    KTApp.showPageLoading();
                    axios
                        .delete("/request-tickets/destroy/" + id)
                        .then((res) => {
                            useToast.successToast(res.data.message);
                            const totalRecordOnPage =
                                getMetaPaginate.value.pagination.count;
                            if (totalRecordOnPage - 1 === 0) {
                                getMetaPaginate.value.pagination.current_page -= 1;
                            }
                            if (getMetaPaginate.value.pagination.total - 1 === 0) {
                                getWorkflow();
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
        clickCreateRequestTicket();
        resetIdRowEdit();
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

    // sẽ call api trước khi component được tạo ra
    onMounted(() => {
        getAllDepartments(),
            getWorkflow();
    })

    const departmentListNew = ref([]);

    watch(departmentListAPI, (newValue, oldValue) => {
        departmentListNew.value = helperFunc.recursive(true, newValue);
    })

    //=================================== USERS =========================
    const storeUser = useUsers();

    onBeforeMount(() => {
        storeUser.getUsersData({ getAll: true });
    });

    const getUsers = computed(() => {
        return storeUser.users.data;
    });


    const addUserRow = () => {
        formWorkflow.users.push({
            id: null,
            idSave: 0, // id thêm mới chưa lưu vì khi chọn user thì id !=0
            name: "",
            username: "",
            phone: "",
            email: "",
        });
    };

    const removeItemUserRow = (key, item) => {
        formWorkflow.users.splice(key, 1);
    };

    const { getUserById } = storeToRefs(storeUser);
    const idEdit = ref(-1);
    const idSave = ref(0);
    const changeUser =(userNew, userIdRoot, index , idSaveOfUser) => {
        idEdit.value = index;
        // id chưa save
        let user = getUserById.value(userIdRoot);
        console.log(userNew, userIdRoot, index , idSaveOfUser, 'a122333');
        if(user && user.idSave != 0 && idSaveOfUser != 0) {
            // console.log(userRoot,userNew, 'idsave')
            idSave.value = user.idSave;
        }
        // console.log(optionId)
        if(userNew == null) {
            console.log(userNew, userIdRoot, index , idSaveOfUser, 'absbbs')
            formWorkflow.users[index] = {
                id: userIdRoot,
                idSave: 0,
                phone: "",
                email: "",
            }
        }else {
            console.log(userNew, userIdRoot, index , idSaveOfUser, 'absbbs222')
            formWorkflow.users[index] = {
                id: userNew.id,
                idSave: userNew.id !== userIdRoot ? 0 : userNew.id,
                phone: userNew.phone,
                email: userNew.email,
            }

            // if (userNew.id !== userIdRoot) {
            //     console.log(  formWorkflow.approver_ids, 't');
            //     formWorkflow.approver_ids = formWorkflow.approver_ids.filter(value => value !== userIdRoot);
            //     console.log(  formWorkflow.approver_ids, 's');
            // }
        }
    }

    const setIdRowEdit =(index) => {
        idEdit.value = index;
    }
    const resetIdRowEdit=() => {
        idEdit.value = -1;
    }

    const workflowTypes = ref([
        { id: 1, name: 'Nghỉ phép năm', workflow_type: "annual_leave" },
        { id: 2, name: 'Nghỉ chế độ',  workflow_type: "regime_leave" },
        { id: 3, name: 'Đi công tác',  workflow_type: "business_travel" },
        { id: 4, name: 'Làm việc ngoài văn phòng',  workflow_type: "working_out_of_the_office" },
        { id: 5, name: 'Nghỉ không lương',  workflow_type: "unpaid_leave" },
        { id: 6, name: 'Xin đi muộn',  workflow_type: "arriving_late" },
        { id: 7, name: 'Xin về sớm',  workflow_type: "leave_early" },
        { id: 8, name: 'Quên chấm công',  workflow_type: "forgot_timekeeping" },
    ])

    const approvalMethods = ref([
        { id: 1, name: 'Duyệt tuần tự', approval_method: "sequential" },
        { id: 2, name: 'Duyệt đồng thời',  approval_method: "simultaneously" },
        { id: 3, name: 'Một người duyệt',  approval_method: "one_person" },
    ])
</script>

<style scoped>
    .input-custom-valid {
        border: 1px solid red !important;
    }
    .select-custom-valid {
        border: 1px solid red !important;
    }

    tr td.td-background-disabled {
        background-color: #e0e4ec;
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
