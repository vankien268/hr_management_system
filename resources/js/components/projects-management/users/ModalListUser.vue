<template>
  <div
            class="modal "
            id="modalUserList"
            data-bs-keyboard="true"
            data-bs-backdrop="static"
            tabindex="-1"
            aria-hidden="true"
        >
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-xl" >
                <!--begin::Modal content-->
                <div class="modal-content rounded" style="height:650px;">
                    <!--begin::Modal header-->
                    <div class="modal-header border-0 pb-0">
                        <!--begin::Close-->
                        <h4 class="modal-title">Danh sách người đại diện công ty</h4>
                        <div @click="closeModalContacts"
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
                        class="modal-body pt-0 px-5 justify-content-center"
                    >
                           <div class="row col-lg-12 ps-1 pe-1 ms-1" style="border-bottom: 1px solid rgb(192, 192, 192);">
                            <div class="col-lg-12">
                                <div class="card-header border-0 d-flex justify-content-between align-items-center">
                                    <span class="card-label fw-bold fs-4 m-0"></span>
                                    <div class="align-items-center d-flex">
                                        <div @click="addUserRow()">
                                            <a href="#" class="btn btn-function">
                                            <i class="ki-duotone ki-plus fs-2 "></i>Thêm</a>
                                        </div>
                                        <div>
                                            <a @click="saveUsers()" :class="{ 'disabled': isBtnClickSave }" href="#" class="btn btn-function">
                                            <i class="fa-regular fa-pen-to-square"></i>Lưu</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-3">
                                    <div class="table-responsive table-scroll-sm h-55vh text-nowrap">
                                        <table class="table table-row-dashed table-bordered table-data">
                                            <thead>
                                                <tr class="fs-6 text-gray-400">
                                                    <th class="w-20px max-w-50px">STT</th>
                                                    <th class="w-50px max-w-100px">Mã người dùng</th>
                                                    <th class="w-250px max-w-150px">Họ và tên</th>
                                                    <th class="w-150px max-w-150px">Số diện thoại</th>
                                                    <th class="w-200px max-w-200px">
                                                        Email
                                                    </th>
                                                    <th class="min-w-100px max-w-100px">
                                                        Trạng thái
                                                    </th>
                                                     <th class="min-w-125px max-w-250px">
                                                       Bộ phận
                                                    </th>
                                                    <th class="min-w-125px max-w-250px">
                                                        Ghi chú
                                                    </th>
                                                    <th class="w-auto"  colspan="2">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody class="max-h-25 overflow-auto cursor-pointer"
                                                >
                                                <tr v-for="(item,index) in formUsers.users" :key="index"
                                                   >
                                                   <!-- style="border-right:1px solid red !important" -->
                                                    <td class="text-center text-content" :class="{ 'is-invalid-border-right' : errors['users.' + index + '.id']}">
                                                        {{ index + 1 }}
                                                    </td>
                                                    <td :class="{ 'is-invalid-td' :   errors['users.' + index + '.id']}">
                                                        <!-- <select  class="w-120px text-content" :disabled="index < totalRecordUserRoot && idEdit != index"
                                                         style="height:29px;border:0px; background-color: white;"
                                                        data-hide-search="true" :title="errors['users.' + index + '.id']"
                                                         data-placeholder="Chọn mã người dùng" name="target_assign"
                                                            @change="changeUser($event.target.value, index, item)"
                                                        >
                                                            <option :value="null">Chọn</option>
                                                            <option :selected="item.id == item2.id"
                                                            :title="item2.code"
                                                            v-for="(item2,index) in getUsersData" :key="index" :value="item2.id">
                                                                {{ `${item2.username} - ${item2.name}` }}
                                                            </option>
                                                    -->
                                                             <SelectSearchUser
                                                                v-model="item.id"
                                                               @changeUser="changeUser"
                                                                style="height: 30px; border-radius:8px;"
                                                                :list-data="getUsersData"
                                                                :disabled="idEdit != index && item.idSave !=0"
                                                                placeholder="Chọn"
                                                                key-value="id"
                                                                  :idSave="item.idSave"
                                                                  :indexKey="index"
                                                                :class="{ 'is-invalid-td' :   errors['users.' + index + '.id']}"
                                                                key-display="name"
                                                            />
                                                    </td>

                                                    <td class="td-background-disabled" >
                                                        <input  :title="item.name"
                                                         :disabled="true" class="text-content" type="text" v-model="formUsers.users[index].name"
                                                         />
                                                    </td>
                                                    <td class="td-background-disabled">
                                                        <input :title="item.phone" class="text-content" :disabled="true" type="text"  v-model="item.phone"
                                                        />
                                                    </td>
                                                    <td class="td-background-disabled" >
                                                        <input :title="item.email" class="text-content"  :disabled="true" type="text" v-model="item.email" />
                                                    </td>
                                                    <td class="td-background-disabled" >
                                                        <input :title="item.statusName" class="text-content" :disabled="true" type="text" v-model="item.statusName"/>
                                                    </td>

                                                     <td class="td-background-disabled" :class="{ 'is-invalid-border-right' : errors['users.' + index + '.pivot.note']}" >
                                                        <input :title="item.department_name" class="text-content" :disabled="true" type="text" v-model="item.department_name"/>
                                                    </td>
                                                    <!-- :class="{'is-invalid-icon' : errors['users.' + index + '.pivot.note']}" -->
                                                    <td :class="{ 'is-invalid-td': errors['users.' + index + '.pivot.note'], 'td-background-disabled':idEdit!=index && index < totalRecordUserRoot }">
                                                        <input class="text-content"
                                                         ref="inputNote" :title="errors['users.' + index + '.pivot.note'] ?? item.pivot.note" type="text"
                                                        v-model="item.pivot.note"
                                                        :disabled="idEdit!=index && index < totalRecordUserRoot"
                                                        />
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btn btn-icon btn-edit btn-sm"
                                                            v-if="idEdit==index && item.idSave !=0" @click="resetIdRowEdit()">
                                                            <i class="fa-solid fa-check fs-5"></i>
                                                        </a>
                                                        <a v-if="index < totalRecordUserRoot && idEdit != index" @click="setIdRowEdit(index)" href="#"
                                                         class="btn btn-icon btn-edit btn-sm">
                                                                <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                            <a :class="totalRecordUserRoot == 1 && KeyDisabled == index || formUsers.users.length == 1 ?
                                                         'disable disabled' : ''"
                                                             @click="removeItemUserRow(index, item)" href="#" class="btn btn-icon btn-delete btn-sm">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
</template>

<script setup>
import axios from 'axios';
import { computed, defineProps, onMounted, reactive, ref, toRefs, watch } from 'vue'
import { storeToRefs } from 'pinia';
import { useToast } from "../../../helper/toastMessage.js";
import { useUsers } from '../../../stores/user';
import SelectSearchDiffUser from "../../input/SelectSearchDiff.vue";
import SelectSearchUser from "../../input/SelectSearchDiff2.vue";

const props = defineProps({
    userList: {
        type: Array,
        default: function() {
            return [{
                id: 0,
                code: "",
                name: "",
                phone: "",
                email: "",
                status: "",
                department_name:"",
                pivot: {
                    note: ""
                }
            }]
        }
    },
    totalUser: {
        type:Number,
        default: 0
    }
})

const storeUser = useUsers();
onMounted(() => {
  storeUser.getUsersData({getAll:true});
})


const getUsersData = computed(()=> {
    return storeUser.getUserNotBlock;
})

const formUsers = reactive({
    project_id: 0,
    users: [],
    destroyUserIds: []
})

const addUserRow = () => {
    formUsers.users.push({
        id: 0,
        idSave: 0, // id thêm mới chưa lưu vì khi chọn user thì id !=0
        code: "",
        name: "",
        phone: "",
        email: "",
        statusName: "",
        department_name:"",
        pivot: {
            note: ""
        }
    })
}

formUsers.users = [...props.userList];
const { userList } = toRefs(props)

watch(userList, (newValue) => {
    console.log(newValue);
    formUsers.users = [...newValue];
    formUsers.project_id = newValue[0].pivot?.project_id;
})


const removeItemUserRow =(key, item)=> {
    formUsers.users.splice(key,1);
    if(item.id > 0) {
         formUsers.destroyUserIds.push(item.id)
    }
}
const KeyDisabled = ref(-1);
// Tính toán những bản ghi đã lưu.
const totalRecordUserRoot = computed(() => {
    let records = formUsers.users.filter((item) => (item.id != 0 && item.idSave != 0));
    if(records.length == 1) {
        KeyDisabled.value = Object.keys(records)[0];
    }
    return records.length;
})
const idEdit = ref(-1);
const inputNote = ref(null);
const setIdRowEdit =(index) => {
    idEdit.value = index;
       setTimeout(() => {
         inputNote.value[index].focus()
    }, 500)
}
const resetIdRowEdit=() => {
    idEdit.value = -1;
}

const { getUserById } = storeToRefs(storeUser)
const idSave = ref(0);

// Change user
const changeUser =(userNew, userIdRoot, index , idSaveOfUser) => {
      idEdit.value = index;
        let rootUser = getUserById.value(userIdRoot);
      // id chưa save
    if(rootUser && rootUser.idSave != 0 && idSaveOfUser != 0) {
        idSave.value = rootUser.idSave;
    }
    let noteUser = formUsers.users[index].pivot.note;
    console.log(rootUser,index)
    if(userNew == null) {
        formUsers.users[index] = {
            id: userIdRoot,
            idSave: 0,
            code: "",
            name: "",
            phone: "",
            email: "",
            statusName: "",
            department_name:"",
            pivot: {
                note: noteUser
            }
          }

    }else {

         formUsers.users[index] = {
            id: userNew.id,
            idSave: idSave.value,
            code: userNew.code,
            name: userNew.name,
            phone: userNew.phone,
            email: userNew.email,
            statusName: userNew.statusName,
            department_name:userNew.department_name,
            pivot: {
                note:  noteUser
            }

        }
    }
}
const emits = defineEmits(['updateUsers']);
const errors =  ref([]);
const isBtnClickSave = ref(false);
const saveUsers = () => {
    isBtnClickSave.value = true;
    KTApp.showPageLoading();
     axios.post('/projects/store-user-by-project', formUsers)
    .then((res) => {
        const { message, users } = res.data;
        useToast.successToast(message);
        formUsers.users = [...users.data];
         errors.value = [];
        idEdit.value = -1;
        formUsers.destroyUserIds = [];
        emits('updateUsers', formUsers.project_id);
        isBtnClickSave.value = false;
    }).catch((error) => {
          isBtnClickSave.value = false;
        let code = error.response?.status;
          if(code == 422) {
             errors.value = error.response.data.errors;
             useToast.errorToast("Vui lòng kiểm tra lại dữ liệu !");
             return;
        }
        if(code == 403) {
             useToast.errorToast(error.response.data.message);
        }
    }).finally(() => {
        KTApp.hidePageLoading();
    })
}

const closeModalContacts = () => {
    errors.value = [];
    idEdit.value = -1;
    formUsers.destroyUserIds = [];
    formUsers.users = [...props.userList];
}
</script>

<style lang="scss" scoped>
.table {
    tr {
        &.active {
            td {
                background-color: rgb(255, 255, 255);
            }

            input {
                background-color: rgb(255, 255, 255);
            }
        }

    }
    td.td-background-disabled {
        background-color: #e0e4ec;
    }
}

table {
    &.disable {
        a {
            visibility: hidden !important;
        }
    }
    .is-invalid-td{
            border: 1px solid red !important;
        }
    .is-invalid-border-right {
        border-right: 1px solid red !important;
    }
    .form-control {
        border:0px;
    }

}
input.is-invalid-icon {
            border :0px !important;
            background: no-repeat !important;
            background-position: right calc(0.375em + 0.3875rem) center !important;
            background-size: calc(0.75em + 0.775rem) calc(0.75em + 0.775rem) !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23e61c1c'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23e61c1c' stroke='none'/%3e%3c/svg%3e") !important
        }
</style>
