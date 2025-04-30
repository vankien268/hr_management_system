<template>
    <div class="card">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5" style=" justify-content: flex-start;padding: 0 1.5rem;">
            <h3 class="card-title align-items-start flex-column">
                <!-- <span class="card-label fw-bold fs-3 mb-1"
                    >Danh sách người dùng</span
                > -->
            </h3>
            <div
                class="d-flex align-items-center flex-wrap mb-3 mt-2 justify-content-start"
            >
                <div class="d-flex align-items-center flex-wrap w-250px justify-content-start">
                    <div class="w-120px">
                        <label for="customerCode" class="col-form-label"
                            >Bộ phận</label
                        >
                    </div>
                    <div class="w-100px">
                        <!-- <input type="text" class="form-control mb-lg-0 p-2"  /> -->
                        <select
                            @change="
                                changePage(pagination, {
                                    department_id: searchInfoUser.department_id,
                                })
                            "
                            v-model="searchInfoUser.department_id"
                            class="form-select form-control mb-lg-0 p-2"
                            style="width: 180px"
                            aria-label="Default select example"
                        >
                            <option :value="null">Tất cả</option>
                            <option
                                :value="item.id"
                                v-for="(item, index) in getDepartmentData"
                                :key="index"
                            >
                                {{
                                    item.prefix
                                        ? item.prefix + " " + item.name
                                        : item.name
                                }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap w-200px px-3">
                    <div class="w-120px">
                        <label for="customerCode" class="col-form-label"
                            >Trạng thái</label
                        >
                    </div>
                    <div class="w-100px">
                        <select
                            @change="
                                changePage(pagination, {
                                    status_id: searchInfoUser.status_id,
                                })
                            "
                            v-model="searchInfoUser.status_id"
                            class="form-select form-control"
                            aria-label="Default select example"
                        >
                            <option :value="null">Tất cả</option>
                            <option :value="1">Kích hoạt</option>
                            <option :value="0">Khóa</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap w-250px px-1">
                    <div class="w-120px">
                        <label for="customerCode" class="col-form-label"
                            >Tên tài khoản</label
                        >
                    </div>
                    <div class="w-100px">
                        <!-- <input
                            type="text"
                            @keyup.enter="
                                changePage(pagination, {
                                    code: searchInfoUser.code,
                                })
                            "
                            v-model="searchInfoUser.code"
                            class="form-control mb-lg-0 p-2"
                            id="customerCode"
                        /> -->
                        <!-- @changeUser="changeUser" -->

                         <SelectSearchUser
                        v-model="searchInfoUser.username_id"
                        style="height: 30px; border-radius:8px;"
                        :list-data="getUsers"
                        placeholder="Chọn"
                        key-value="id"
                        key-display="username"
                    />
                    </div>
                </div>
                <div
                    class="d-flex align-items-center flex-wrap w-180px"
                    style="margin-left: -18px"
                >
                    <div class="w-120px">
                        <label class="col-form-label">Tên người dùng</label>
                    </div>
                    <div style="width: 182px">
                        <!-- <input
                            type="text"
                            @keyup.enter="
                                changePage(pagination, {
                                    name: searchInfoUser.name,
                                })
                            "
                            v-model="searchInfoUser.name"
                            class="form-control mb-lg-0 p-2"
                        /> -->
                         <SelectSearchUser
                            v-model="searchInfoUser.user_id"
                            style="height: 30px; border-radius:8px;"
                            :list-data="getUsers"
                            placeholder="Chọn"
                            key-value="id"
                            key-display="name"
                        />
                    </div>
                </div>
                <div class="align-items-center me-1 flex-wrap mx-10">
                    <a
                        @click="changePage(pagination)"
                        tabindex="0"
                        href="#"
                        class="btn btn-function"
                    >
                        <i class="fa-solid fa-search"></i>Tìm kiếm</a
                    >
                </div>
                <div class="justify-content-end">
                    <a
                        href="#"
                        class="btn btn-function me-2"
                        data-bs-target="#actionCreateUser"
                        data-bs-toggle="modal"
                        v-if="props.btnAdd"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm</a
                    >
                </div>
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
                    <thead class="fs-6 text-gray-400">
                        <tr class="fw-bold text-muted">
                            <th class="w-40px text-content" style="text-align: center">
                                STT
                            </th>
                            <!-- <th class="w-100px text-content">Mã người dùng</th> -->
                            <th class="text-content" style="width:120px;">Tên tài khoản</th>
                            <th style="width: 150px" class="text-content">Tên người dùng</th>
                            <!-- <th class="min-w-80px">Ngày sinh</th> -->
                            <!-- <th class="min-w-60px">Giới tính</th> -->
                            <th class="w-150px text-content">Thông tin liên hệ</th>
                            <!-- <th class="min-w-100px">Số điện thoại</th> -->
                            <th class="w-40px text-content">Trạng thái</th>
                            <th class="w-40px text-content">Tình trạng</th>
                            <th class="w-100px text-content">Mật khẩu</th>
                            <!-- <th class="w-40px w-40px text-content">Phân quyền</th> -->
                            <th class="w-100px text-center text-content" colspan="2">
                                Hành động
                            </th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody
                        v-for="(item, index) in users"
                        :key="index"
                        class="max-h-75 overflow-auto"
                    >
                        <td
                            class="h-40px fw-medium fs-6 table-bordered"
                            style="
                                background-color: rgb(243 237 179);
                                border-left: 1px solid;
                            "
                            colspan="14"
                        >
                            <span class="text-content">{{ index }}</span>
                        </td>
                        <user-item
                            v-for="(item2, index2) in item"
                            :key="index2"
                            :user-item="item2"
                            :index="index2"
                            :pagination="pagination"
                            @handle-edit-user="handleEditUser"
                            @change-user-password="changePassword"
                            @handle-delete-user="handleDeleteUser"
                        >
                        </user-item>
                    </tbody>
                    <tbody v-if="Object.keys(users).length == 0">
                            <tr>
                                <td class="text-center" colspan="14">
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
    <teleport to="#admin">
        <div
            class="modal fade"
            id="actionCreateUser"
            data-bs-keyboard="true"
            data-bs-backdrop="static"
            tabindex="-1"
            aria-hidden="true"
        >
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-xl">
                <!--begin::Modal content-->
                <div class="modal-content rounded">
                    <!--begin::Modal header-->
                    <div class="modal-header border-0 pb-0">
                        <!--begin::Close-->
                        <h4 class="modal-title">Thêm mới người dùng</h4>
                        <div  @click="closeModalUser()"
                        class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2"
                            data-bs-dismiss="modal"
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
                        class="modal-body pt-0 px-5 px-xl-20 justify-content-center"
                    >
                        <user-form
                            :clickBtnIconClose="clickBtnIconClose"
                            @close-modal-user="changePage(pagination)"
                            @resetBtnIconClose="resetBtnIconClose"
                            @storeUser="storeUser"
                        ></user-form>
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!-- sửa -->
        <div
            class="modal fade"
            id="actionUpdateUser"
            data-bs-keyboard="true"
            data-bs-backdrop="static"
            tabindex="-1"
            aria-hidden="true"
        >
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-xl">
                <!--begin::Modal content-->
                <div class="modal-content rounded">
                    <!--begin::Modal header-->
                    <div
                        class="modal-header justify-content-left border-0 pb-0"
                    >
                        <!--begin::Close-->
                        <h4 class="modal-title">Sửa người dùng</h4>
                        <div
                            @click="closeModalEditUser()"
                            id="click-close-modal"
                            class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2"
                            data-bs-dismiss="modal"
                        >
                        <i class="ki-duotone ki-cross fs-1 text-white">
                                <i class="fa-solid fa-xmark fs-3"></i>
                            </i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body pt-0 px-5 px-xl-20">
                        <user-form
                            @close-modal-user="changePage(pagination)"
                            :user-update-item="userUpdateItem"
                            :isModalEditUser="isModalEditUser"
                            @updateUser="updateUser"
                            :isClickBtnIconEditClose="isClickBtnIconEditClose"
                            @resetBtnIconCloseEdit="resetBtnIconCloseEdit"
                        ></user-form>
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    </teleport>
    <div
        class="modal top fade"
        id="modalChangePassword"
        @click="closeModalChangePassword"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
        data-mdb-backdrop="true"
        data-mdb-keyboard="true"
    >
        <div
            class="modal-dialog modal-dialog-centered"
            @click.stop
            style="width: 400px"
        >
            <div class="modal-content text-center">
                <div class="modal-header h5 text-white bg-primary">
                    Đổi mật khẩu
                </div>
                <div class="modal-body" style="margin-top: -5px">
                    <p>
                        Đổi mật khẩu cho tài khoản: <b>{{ username }}</b>
                    </p>

                    <span> Nhập mật khẩu mới.</span>

                    <div class="form-outline mt-5 mb-2">
                  <div class="input-field" style="height:45px;" :class="{'input-custom-valid': errors.password}" >
                    <span class="fas fa-lock p-2"></span>
                    <input v-model="formData.password"  :type="inputTypeText"  placeholder="Mật khẩu" required class="">
                    <button @click="toggleInputType" class="btn bg-white text-muted">
                        <span v-if="inputTypeText == 'password'" class="far fa-eye-slash"></span>
                         <span v-if="inputTypeText == 'text'" class="far fa-eye"></span>
                    </button>
                </div>
                        <!-- <input
                            type="text"
                            v-model="formData.password"
                            id="tyPassword"
                            class="form-control my-2" :class="{'input-custom-valid': errors.password}"
                        /> -->
                        <!-- <label class="form-label" for="tyPassword"></label>
                        <span v-if="errors.password" class="text-danger">{{
                            errors.password[0]
                        }}</span> -->
                    </div>
                    <div style="padding-top:10px;">
                      <p class="font-weight-italic text-danger" > <i>Mật khẩu bao gồm chữ hoa, chữ thường, số, ký tự đặc biệt. Không bao gồm khoảng trống.<br> Độ dài tối thiểu: 6 ký tự.</i></p>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <div>
                            <button
                                style="padding: 0px 0px"
                                href="#"
                                @click="storeChangePassword"
                                class="btn btn-function w-30 btn-sm mx-2"
                            >
                                <i class="fa-solid fa-floppy-disk py-2"></i>Lưu
                            </button>
                        </div>
                        <div class="mx-2" style="margin-top:4px;">
                            <button
                                @click="closeModalChangePassword"
                                class="btn btn-secondary btn-sm btn-active-color-light"
                                style="padding: 11px"
                            >
                                <i class="fa-solid fa-xmark"></i>Đóng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { helperFunc } from "../../helper/heplerFunction.js";
import { computed, onBeforeMount, reactive, ref, watch, onMounted } from "vue";
import { useDepartmentState } from "../../stores/department";
import { useToast } from "../../helper/toastMessage.js";
import UserForm from "./UserForm.vue";
import UserItem from "./UserItem.vue";
import SelectSearchUser from "../input/SelectSearch.vue";
import { useUsers } from "../../stores/user";

const props = defineProps({
    btnAdd: {
        type: Boolean,
        default: false,
    }
})

const storeDepartment = useDepartmentState();
// tìm kiếm
const searchInfoUser = reactive({
    department_id: null,
    username_id: null,
    status_id: null,
    user_id: null,
});
const inputTypeText = ref("text");
const toggleInputType =() => {
    inputTypeText.value = inputTypeText.value ==="text" ? "password" : "text";

}

const getAllUsers = ref([]);
const getMetaPaginate = ref({});
const getAllUserApi = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/users/get-all",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data, meta } = res.data;
            getAllUsers.value = data;
            getMetaPaginate.value = meta;
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};
const storePiniaUser = useUsers();
onMounted(() => {
    getAllUserApi();
     storePiniaUser.getUsersData({ getAll: true });
});

const getUsers = computed(() => {
    return storePiniaUser.users.data;
});

const pagination = computed(() => {
    return getMetaPaginate.value?.pagination
        ? getMetaPaginate.value.pagination
        : { current_page: 1, total_pages: 1, per_page: 30 };
});

const users = computed(() => {
   return getAllUsers.value = helperFunc.groupBy(
        getAllUsers.value,
        "department_name"
    );
});
const changePage = (newDataPagination) => {
    let requestPaginate = {
        page: newDataPagination.current_page,
        per_page: newDataPagination.per_page,
    };
    requestPaginate = { ...requestPaginate, ...searchInfoUser };
    getAllUserApi(requestPaginate);
};
const isModalEditUser = ref(false);
const userUpdateItem = ref({});
const handleEditUser = (userItem) => {
    isModalEditUser.value = true;
    userUpdateItem.value = userItem;
};

const UserIdToChangPassword = ref(0);
const username = ref("");
const changePassword = (user) => {
    username.value = user.username;
    UserIdToChangPassword.value = user.userId;
    $("#modalChangePassword").modal("show");
};

const handleDeleteUser = () => {
    const totalRecordOnPage = getMetaPaginate.value.pagination.count;
    if (totalRecordOnPage - 1 === 0) {
        getMetaPaginate.value.pagination.current_page -= 1;
    }
    if (getMetaPaginate.value.pagination.total - 1 === 0) {
        getAllUserApi();
    }
    changePage(getMetaPaginate.value.pagination);
};

// change password
const formData = reactive({
    password: "",
});
const errors = ref([]);
const storeChangePassword = () => {
    KTApp.showPageLoading();
    axios
        .post(
            `/users/change-password/${UserIdToChangPassword.value}`,
            formData
        )
        .then((res) => {
            const { message } = res.data;
            $("#modalChangePassword").modal("hide");
            errors.value = [];
            formData.password = "";
            useToast.successToast(message);
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};
const closeModalChangePassword = () => {
    errors.value = [];
    formData.password = "";
    $("#modalChangePassword").modal("hide");
};
const clickBtnIconClose= ref(false);
const closeModalUser = () => {
    clickBtnIconClose.value = true;
    // changePage(pagination);
};
const isClickBtnIconEditClose = ref(false);
const closeModalEditUser =() => {
    isClickBtnIconEditClose.value = true;
}
const resetBtnIconClose=() => {
    clickBtnIconClose.value = false;
    isClickBtnIconEditClose.value = false;
}
const resetBtnIconCloseEdit=() => {
    isClickBtnIconEditClose.value = false;
}


// tìm kiếm
const getDepartmentData = computed(() => {
    if (!storeDepartment.departments.length) {
        return [];
    }
    return helperFunc.recursive(false, storeDepartment.departments);
});
const updateUser= () => {
    changePage(getMetaPaginate.value.pagination)
    const btnClickClose = document.getElementById('click-close-modal');
    btnClickClose.click();
}
const storeUser= () => {
    changePage(getMetaPaginate.value.pagination)
}
onBeforeMount(() => {
    storeDepartment.getAllDepartmentData();
});
</script>

<style scoped>
.input-custom-valid {
    border: 1px solid red;
}
.modal-content {
    width: 85%;
}
</style>
