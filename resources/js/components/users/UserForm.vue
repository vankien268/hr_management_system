<template>
    <div class="d-flex flex-column">
        <!--begin::Row-->
        <div class="row mt-3">
            <!--begin::Col-->
            <div class="col-lg-6 mb-lg-0">
                <!--begin::Tabs-->
                <div class="nav flex-column">
                    <div class="modal-body px-10 px-lg-15 pt-0 pd-15" style="margin-top:0px;">
                        <form id="" class="form" action="#">
                            <fieldset>
                                <legend style="margin-bottom: 25px">
                                    <b>Thông tin cá nhân</b>
                                </legend>
                                <div class="d-flex flex-column mb-3 fv-row">
                                    <label
                                        class="d-flex align-items-center fw-semibold mb-3"
                                    >
                                        <span class="required"
                                            >Tên tài khoản</span
                                        >
                                    </label>
                                    <!--end::Label-->
                                    <input
                                        type="text"
                                        :style="[{
                                             isModalEditUser
                                                : 'background-color: lightgray'
                                        }]
                                        "
                                        :class="{ 'input-custom-valid' :  errors.username}"
                                        :disabled="isModalEditUser"
                                        v-model="formUser.username"
                                        class="form-control"
                                        placeholder="Nhập tên tài khoản"
                                        name="target_title"
                                    />
                                    <div class="w-100"></div>
                                    <span
                                        v-if="errors.username"
                                        class="text-danger mt-2"
                                        >{{ errors.username[0] }}</span
                                    >
                                </div>
                                <div class="d-flex flex-column mb-4 fv-row">
                                    <!--begin::Label-->
                                    <label
                                        class="d-flex align-items-center fw-semibold mb-3"
                                    >
                                        <span :class="! formUser? 'required': ''">Mật khẩu</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="input-group mb-2">
                                        <input type="password"   @click="eventInputUser" :class="{ 'input-custom-valid' : errors.password}"
                                         style="border-right:0px;height:28px;" class="form-control inputPassword" v-model="formUser.password"/>

                                        <div @click="resetEyes()" style=";height:28px;" :class="{ 'input-custom-valid' :  errors.password}" class="input-group-text cursor-pointer toggleShowPassword">
                                            <i
                                                class="fa-solid fa-eye-slash"
                                            ></i></div>
                                    </div>
                                    <div class="w-100"></div>
                                    <span
                                        v-if="errors.password"
                                        class="text-danger"
                                        >{{ errors.password[0] }}</span
                                    >
                                </div>
                                <div class="d-flex flex-column mb-4 fv-row">
                                    <!--begin::Label-->
                                    <label
                                        class="d-flex align-items-center fw-semibold mb-3"
                                    >
                                        <span :class="! formUser? 'required': ''">Nhập lại mật khẩu</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="input-group mb-2">
                                        <input type="password"   @click="eventInputUser" :class="{ 'input-custom-valid' : errors.confirm_password}"
                                               style="border-right:0px;height:28px;" class="form-control inputPassword" v-model="formUser.confirm_password"/>

                                        <div @click="resetEyes()" style=";height:28px;" :class="{ 'input-custom-valid' :  errors.confirm_password}" class="input-group-text cursor-pointer toggleShowPassword">
                                            <i
                                                class="fa-solid fa-eye-slash"
                                            ></i></div>
                                    </div>
                                    <div class="w-100"></div>
                                    <span
                                        v-if="errors.confirm_password"
                                        class="text-danger"
                                    >{{ errors.confirm_password[0] }}</span
                                    >
                                </div>
                                <div class="d-flex fv-row mb-5">
                                    <div
                                        class="d-flex align-items-center fw-semibold mb-2 mt-2"
                                    >
                                        <span>Trạng thái</span>
                                    </div>
                                    <div
                                        class="form-check form-check-inline mt-2 mx-4"
                                    >
                                        <input
                                            class="form-check-input"
                                            v-model="formUser.status"
                                            type="radio"
                                            name="status"
                                            value="1"

                                        />
                                        <label style="margin-top:-5px;"  for="inlineRadio1"
                                            >Kích họat</label
                                        >
                                        <div
                                            class="form-check form-check-inline mx-10"
                                        >
                                            <input
                                                class="form-check-input"
                                                v-model="formUser.status"
                                                type="radio"
                                                name="status"
                                                value="0"
                                            />
                                            <label style="margin-top:0px;" for="inlineRadio2"
                                                >Khóa</label
                                            >
                                            <span
                                                v-if="errors.status"
                                                class="text-danger mt-2"
                                                >{{ errors.status[0] }}</span
                                            >
                                        </div>
                                    </div>
                                </div>

                                  <div class="d-flex flex-column mb-4 " >
                                    <div class="d-flex">
                                         <label class="fw-semibold mb-2 required">Nhóm quyền

                                        </label>
                                            <div style="margin-top: -1px;">
                                                <i @click="addRoleRows()" class="ki-duotone ki-plus fs-2 mx-3 text-danger cursor-pointer"></i>
                                            </div>

                                    </div>
                                    <div style="max-height:15rem; overflow:auto" class="pe-1 my-2 ">
                                        <div v-for="(item,index) in formUser.roles" :key="index"  class="d-flex">
                                                <select class="form-select mb-3 " v-model="item.role_id"
                                                :title="errors && errors['roles.'+index+'.role_id'] ?errors['roles.'+index+'.role_id'][0]: '' "
                                                :class="{ 'select-custom-valid' :  errors && errors['roles.'+index+'.role_id']}"  data-placeholder="Chọn bộ phận" aria-label="Default select example">
                                                    <option :value="null">Chọn</option>
                                                    <option :value="item.id"
                                                    v-for="(item,index) in roles"
                                                    :disabled="item.status == 0"
                                                    :key="index">{{ item.name }}</option>
                                                </select>
                                                <div> <a href="#" @click="removeRoleRows(index, item)"><i
                                                :class="{'text-danger':formUser.roles.length >1}" class="fa-solid fa-trash cursor-pointer py-2 px-3"

                                                ></i></a></div>
                                             <!-- <div v-if="errors && errors['roles.'+index+'.role_id']"
                                             class="text-danger mt-2">{{ errors['roles.'+index+'.role_id'][0] }}</div> -->
                                        </div>
                                    </div>
                            </div>



                            </fieldset>

                        </form>

                    </div>

                </div>
                <!--end::Tabs-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-lg-6 mb-10">
                <!--begin::Tab content-->
                <div class="tab-content rounded">
                    <form class="form" action="#">
                        <fieldset>
                            <legend style="margin-bottom: 25px">
                                <b>Thông tin tài khoản</b>
                            </legend>
                            <!-- <div class="d-flex flex-column mb-4 fv-row">
                                <label
                                    class="d-flex align-items-center fw-semibold mb-3"
                                >
                                    <span class="required">Mã người dùng</span>
                                </label>
                                <input
                                    type="text"
                                    :style="
                                        {
                                             isModalEditUser
                                                : 'background-color: lightgray'
                                        }
                                    "
                                    :class="{ 'input-custom-valid' :  errors.code}"
                                    :disabled="isModalEditUser"
                                    v-model="formUser.code"
                                    @input="
                                        formUser.code =
                                            $event.target.value.toUpperCase()
                                    "
                                    class="form-control"
                                    placeholder="Nhập mã gười dùng"
                                    name="target_title"
                                />
                                <div class="w-100"></div>
                                <span v-if="errors.code" class="text-danger mt-2">{{
                                    errors.code[0]
                                }}</span>
                            </div> -->
                            <div class="d-flex flex-column mb-4 fv-row" >
                                <!--begin::Label-->
                                <label
                                    class="d-flex align-items-center fw-semibold mb-3"
                                >
                                    <span class="required">Tên người dùng</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    type="text"
                                    v-model="formUser.name"
                                    class="form-control"
                                    placeholder="Nhập tên người dùng"
                                      :class="{ 'input-custom-valid' :  errors.name}"
                                    name="target_title"
                                />
                                <div class="w-100"></div>
                                <span v-if="errors.name" class="text-danger mt-2">{{
                                    errors.name[0]
                                }}</span>
                            </div>

                            <div class="d-flex flex-column mb-4 fv-row">
                                <!--begin::Label-->
                                <label
                                    class="d-flex align-items-center fw-semibold mb-3"
                                >
                                    <span class="required">Ngày sinh</span>
                                </label>
                                <!--end::Label-->
                                <!-- <flat-pickr
                                    :config="configDate"
                                    v-model="formUser.birthday"
                                    class="form-control"
                                    name="birthday"
                                     :class="{ 'input-custom-valid' :  errors.birthday}"
                                    placeholder="Chọn ngày sinh"
                                /> -->
                                  <input :class="{ 'input-custom-valid' :  errors.birthday}"
                                   placeholder="Chọn ngày sinh"
                                     class="form-control"
                                     type="date"
                                         v-model="formUser.birthday"
                                    />
                                <!-- <i class="fa-solid fa-calendar-days" style="cursor: pointer; position: absolute; top:47.2%; z-index: 1;right: 7%;"></i> -->
                                <div class="w-100"></div>
                                <span
                                    v-if="errors.birthday"
                                    class="text-danger mt-3"
                                    >{{ errors.birthday[0] }}</span
                                >
                            </div>
                             <div class="d-flex flex-column mb-4 fv-row">
                                <label class="fw-semibold mb-2 required">Bộ phận</label>
                                <select class="form-select" style="height:29px;" v-model="formUser.department_id" :class="{ 'select-custom-valid' :  errors.department_id}"  data-placeholder="Chọn bộ phận" aria-label="Default select example">
                                    <option :value="null">Vui lòng chọn</option>
                                    <option :value="item.id" v-for="(item,index) in departmentListAPI" :key="index">{{ item.name }}</option>
                                </select>
                                <div class="w-100"></div>
                                <span v-if="errors.department_id" class="text-danger mt-2">{{ errors.department_id[0] }}</span>
                            </div>
                            <div class="d-flex mb-4 fv-row">
                                <div
                                    class="d-flex align-items-center fw-semibold mb-2 mt-2"
                                >
                                    <span>Giới tính</span>
                                </div>
                                <div
                                    class="form-check form-check-inline mt-2 mx-4"
                                >
                                    <input
                                        class="form-check-input"
                                        v-model="formUser.gender"
                                        type="radio"
                                        name="gender"
                                        :value="1"
                                    />
                                    <label for="gender1" style="margin-top:0px;">Nam</label>
                                </div>
                                <div
                                    class="form-check form-check-inline mx-10 mt-2"
                                >
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        v-model="formUser.gender"
                                        name="gender"
                                        :value="2"
                                    />
                                    <label for="gender2" style="margin-top:0px;">Nữ</label>
                                </div>
                                <span
                                    v-if="errors.gender"
                                    class="text-danger mt-3"
                                    >{{ errors.gender[0] }}</span
                                >
                            </div>

                            <div class="d-flex flex-column mb-4 fv-row">
                                <!--begin::Label-->
                                <label
                                    class="d-flex align-items-center fw-semibold mb-3"
                                >
                                    <span class="required">Email</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    type="text"
                                    :class="{ 'input-custom-valid' :  errors.email}"
                                    v-model="formUser.email"
                                    class="form-control"
                                    placeholder="Nhập email"
                                    name="target_title"
                                />
                                <div class="w-100"></div>
                                <span v-if="errors.email" class="text-danger mt-2">{{
                                    errors.email[0]
                                }}</span>
                            </div>
                            <div class="d-flex flex-column mb-4 fv-row">
                                <!--begin::Label-->
                                <label
                                    class="d-flex align-items-center fw-semibold mb-3"
                                >
                                    <span class="required">Số điện thoại</span>
                                </label>
                                <!--end::Label-->
                                <input
                                    type="text"
                                    v-model="formUser.phone"
                                    class="form-control"
                                    placeholder="Nhập số điện thoại"
                                    name="target_title"
                                     :class="{ 'input-custom-valid' :  errors.phone}"
                                />
                                <div class="w-100"></div>
                                <span v-if="errors.phone" class="text-danger mt-2">{{
                                    errors.phone[0]
                                }}</span>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <!--end::Tab content-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>

    <div class="modal-footer">
          <button type="button" @click="!isModalEditUser ? storeUser() : updateUser()" class="btn btn-function me-4">
            <i class="fa-solid fa-floppy-disk"></i> Lưu
          </button>
          <button @click="closeModalUser()"
            type="button"
           class="btn btn-secondary btn-sm btn-active-color-light"
            id="close-modal-user-test"
            data-bs-dismiss="modal"
          >
          <i class="fa-solid fa-xmark"></i>Đóng
          </button>
        </div>
    <!--end::Actions-->
</template>
<script setup>
import axios from "axios";
import { helperFunc } from '../../helper/heplerFunction.js'
import {
    defineProps,
    reactive,
    ref,
    defineEmits,
    computed,
    toRefs,
    watch,
    onMounted,
    onBeforeMount
} from "vue";
import { useToast } from "../../helper/toastMessage.js";
import { Vietnamese } from "flatpickr/dist/l10n/vn.js";
import { useDepartmentState } from '../../stores/department'

const props = defineProps({
    isModalEditUser: Boolean,
    userUpdateItem: {
        type: Object
    },
    clickBtnIconClose: Boolean,
    isClickBtnIconEditClose: Boolean
});


const storeDepartment = useDepartmentState();
let formUser = reactive({
    username: "",
    password: "",
    confirm_password: "",
    status: 1,
    name: "",
    birthday: "",
    gender: 1,
    email: "",
    phone: "",
    department_id: null,
    skype: null,
    roles: [
        {
            role_id: null
        }
    ]
});
const { userUpdateItem } = toRefs(props);

const roleUsers = ref([]);
const resetData = (roles = [], item = {}) => {
    console.log("đã reset")
    formUser.status = 1;
    formUser.password = "";
    formUser.name = "";
    formUser.birthday = "";
    formUser.gender = 1;
    formUser.email = "";
    formUser.phone = "";
    formUser.department_id = null;
    formUser.confirm_password = null;

    if (!props.isModalEditUser) {
        formUser.roles = [{
            role_id:null
        }]
        formUser.username = "";
    }
    if(props.isModalEditUser) {
        let user = userUpdateItem.value;
        formUser.roles = [];
        formUser.status = user.status;
        formUser.password = "";
        formUser.name = user.name;
        formUser.birthday = user.birthday;
        formUser.gender = user.gender;
        formUser.email = user.email;
        formUser.phone = user.phone;
        formUser.department_id = user.department_id;
        roles.forEach(item => {
            formUser.roles.push({
                role_id:item.id
            })
        })
    }
};
const roles = ref([]);
const getRoles = (params) => {
    KTApp.showPageLoading();
         axios({
                'url': '/roles/get-all',
                'method' : "GET",
                 params: params
            })
        .then((res) => {
           roles.value = res.data.roles
        })
        .catch((error) => {
            console.log(error)
        }).finally(()=> {
          KTApp.hidePageLoading();
    });
};
const addRoleRows = () => {
    formUser.roles.push({
        role_id: null
    })
}
const removeRoleRows =(key,item)=> {
    if(formUser.roles.length == 1) {
        return ;
    }
   formUser.roles.splice(key,1);
}
onBeforeMount(() => {
    getRoles({getAll:true})
})
const errors = ref([]);

watch(userUpdateItem, (newValue) => {
    // formUser = {...newValue};
    formUser.id = newValue.id
    formUser.username = newValue.username;
    // formUser.code = newValue.code;
    formUser.status = newValue.status;
    formUser.name =newValue.name;
    formUser.birthday = newValue.birthday;
    formUser.gender = newValue.gender;
    formUser.email = newValue.email;
    formUser.phone = newValue.phone;
    formUser.department_id = newValue.department_id;
    formUser.skype = newValue.skype;
    errors.value = [];
     formUser.roles = []
    newValue.roles.data.forEach(item => {
        formUser.roles.push({
            role_id:item.id
        })
    });
     roleUsers.value =  newValue.roles.data
});
const emit = defineEmits(["closeModalUser","resetBtnIconClose", "updateUser", "resetBtnIconCloseEdit", "storeUser"]);

const storeUser = () => {
    KTApp.showPageLoading();
    axios
        .post("/users/store", formUser)
        .then((res) => {
            const { message } = res.data;
            useToast.successToast(message);
            const btnClose = document.getElementById('close-modal-user-test');
            btnClose.click();
            emit('storeUser');
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
            if(error.response?.data?.code == 403) {
                useToast.errorToast(error.response.data?.errors?.message);
            }
        }).finally(()=> {
          KTApp.hidePageLoading();
    });
};

const updateUser = () => {
    KTApp.showPageLoading();
    axios
        .post(`/users/update/${formUser.id}`, formUser)
        .then((res) => {
            const { message } = res.data;
            useToast.successToast(message);
            const btnClose = document.getElementById('close-modal-user-test');
            btnClose.click();
            emit('updateUser');
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
            if(error.response?.data?.code == 403) {
                useToast.errorToast(error.response.data?.errors?.message);
            }
        }).finally(()=> {
          KTApp.hidePageLoading();
    });
};
const configDate = ref({
    dateFormat: "d/m/Y",
    locale: Vietnamese,
});
// show password
let isShow = false;
const resetEyes=(isBoolean = undefined) => {
    const self = $(".toggleShowPassword");
    isShow = isBoolean != undefined? isBoolean : !isShow;
    if(isShow) {
        self.children().attr("class", "fa fa-eye");
         $(".inputPassword").attr("type", "text");
    }else {
        self.children().attr("class", "fa-solid fa-eye-slash");
        $(".inputPassword").attr("type", "password");
    }

}
const { clickBtnIconClose, isClickBtnIconEditClose } = toRefs(props);
watch(clickBtnIconClose,(newValue) => {
    errors.value = [];
    resetEyes(false);
    resetData();
    emit("resetBtnIconClose")
})
watch(isClickBtnIconEditClose,(newValue) => {
    console.log(roleUsers.value)
    errors.value = [];
    resetEyes(false);
    resetData(roleUsers.value);
    emit("resetBtnIconCloseEdit")
})
const closeModalUser=() => {
    console.log("đã chạy")
    errors.value = [];
    resetEyes(false);
    resetData(roleUsers.value);
    // emit("close-modal-user", true);
}
// get all bộ phận
const departmentListAPI = computed(()=> {
     if(!storeDepartment.departments.length) {
        return [];
    }
    return helperFunc.recursiveGetList(storeDepartment.departments);
})

</script>
<script>


</script>
<style scoped>
.flatpickr-current-month {
    text-align: left !important;
    width: 100px !important;
    font-size: 10px !important;
}
.flatpickr-current-month .flatpickr-monthDropdown-months{
    width: 100px !important;
    display: flex;
    font-size: 14px !important;
}
.flatpickr-current-month .numInputWrapper {
    margin-left: 100px !important;
    margin-top: 5px;
    position: absolute;
    width: 60px !important;
    left: 15px;
}
.flatpickr-current-month {
    display: flex !important;
}
.input-custom-valid {
    border: 1px solid red !important;
}
.select-custom-valid {
    border: 1px solid red !important;
}
</style>
