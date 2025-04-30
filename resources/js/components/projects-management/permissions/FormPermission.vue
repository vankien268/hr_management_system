<template>
  <div
            class="modal fade"
            id="permission"
            data-bs-keyboard="true"
            data-bs-backdrop="static"
            tabindex="-1"
            aria-hidden="true"
        >
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-fullscreen" style="padding-top:20px;overflow:hidden !important">
                <!--begin::Modal content-->
                <div class="modal-content rounded" style="height:650px;">
                    <!--begin::Modal header-->
                    <div class="modal-header border-0 pb-0">
                        <!--begin::Close-->
                        <h4 class="modal-title">Phân quyền khai báo dự án</h4>
                        <div id="close-modal-permission"
                        @click="closeModalPermission"
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
                                     <div
                                            class="d-flex align-items-center flex-wrap mb-3"
                                        >
                                            <div >
                                                <input
                                                    type="text"
                                                    class="form-control mb-lg-0 p-2"
                                                    placeholder="Nhập tên người dùng hoặc tài khoản"
                                                    style="width:300px;height: 35px;"
                                                    v-model="searchUser"
                                                    @keydown.enter="handleClickSearchUser()"
                                                />
                                            </div>
                                                <div>
                                            <a
                                                    tabindex="0"
                                                    href="#"
                                                    @click="handleClickSearchUser()"
                                                    class="btn btn-function"
                                                >
                                                    <i class="fa-solid fa-search"></i>Tìm kiếm</a
                                                >
                                        </div>
                                    </div>


                                    <span class="card-label fw-bold fs-4 m-0"></span>
                                    <div class="align-items-center d-flex">
                                        <div @click="addUserRow()">
                                            <a href="#" class="btn btn-function">
                                            <i class="ki-duotone ki-plus fs-2 "></i>Thêm</a>
                                        </div>
                                        <div>
                                            <!-- :class="{ 'disabled': getAllFunctionOfProject.length < 1 }" -->
                                            <a @click="saveUsers()"  href="#" class="btn btn-function">
                                            <i class="fa-regular fa-pen-to-square"></i>Lưu</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-3">
                                    <div class="table-responsive table-scroll-sm h-55vh text-nowrap">
                                        <table class="table table-row-dashed table-bordered table-data">
                                            <thead>
                                                <tr class="fs-6 text-gray-400">
                                                    <th style="width:200px;">Chọn người dùng</th>
                                                    <th class="w-60px ">Tất cả</th>
                                                    <th style="width: 250px; white-space: pre-wrap;" v-for="(item,index) in projectPermission.functions"
                                                    :key="index">
                                                    <!-- :style="{'margin-left:8px': item.id == 24}" -->
                                                        <!-- {{ item.children.length }} -->
                                                        <div style="text-align: center; padding-bottom: 5px;">{{ item.name }}</div>
                                                        <span v-if="item.children.length > 0"

                                                        v-for="(item2, index2) in item.children" :key="index2"
                                                       :style=" [ item2.id == 26 ? {  'margin-left': '48px' } : '',  item2.id == 25 ? {  'margin-left': '29px' } : '']"
                                                        style="padding:0px 19px;">{{ item2.name }}</span>
                                                    </th>
                                                    <th class="text-center" style="min-width:150px" colspan="2">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody class="max-h-25 overflow-auto cursor-pointer"
                                                >
                                                <tr v-for="(item,index) in getAllFunctionOfProject" :key="index"
                                                   >

                                                 <td :class="{ 'is-invalid-td' :   errors['permissions.' +index + '.user_id']}" style="width: 200px;"
                                                 :title="errors['permissions.' +index + '.user_id']"
                                                 >
                                                       <SelectSearchDiffUser :disabled="idEdit != index && item.idSave !=0"
                                                                    @changeUser="changeUser"
                                                            :list-data="getUsersData"
                                                                        style="
                                                                            height: 29px;
                                                                            border: 0px;
                                                                            background-color: white;border-radius:6px;
                                                                        "
                                                                        :idSave="item.idSave"
                                                                        v-model="item.user_id"
                                                            placeholder="Chọn"
                                                            key-value="id"
                                                            :indexKey="index"
                                                            key-display="name"
                                                        />
                                                    </td>
                                                    <td >
                                                        <input
                                                              type="checkbox"
                                                              :disabled="idEdit != index && item.idSave !=0"
                                                               @click="checkedAll(index)" :checked="item.function_ids.length == 14" :id="'checkbox-all-'+index"
                                                         />
                                                    </td>
                                                    <td style="width: 250px;"  v-for="(item2,index2) in projectPermission.functions"
                                                    :key="index2">
                                                        <div class="d-flex">
                                                            <input v-if="item2.children.length < 1" :disabled="idEdit != index && item.idSave !=0"
                                                            @change="checkCheckboxRelated(index, item2.related_array_id, item2.isParent, item2.id)"
                                                            type="checkbox" :value="item2.id" v-model="item.function_ids"/>

                                                                    <input v-if="item2.children.length > 0"
                                                                v-for="(item3, index3) in item2.children"
                                                                :value="item3.id"
                                                                :key="index3" :disabled="idEdit != index && item.idSave !=0"
                                                                :style=" item3.id == 26? '':''"
                                                                @change="checkCheckboxRelated(index, item3.related_array_id, item3.isParent, item3.id)"
                                                                    type="checkbox" v-model="item.function_ids"
                                                                />
                                                        </div>

                                                    </td>
                                                    <td :title="projectPermission.canUserCreateProject
                                                            && item.user_id == projectPermission.userIdCreator? 'Không thể sửa quyền người tạo dự án.': ''">
                                                        <a href="#" class="btn btn-icon btn-edit btn-sm"
                                                        :class="{'disable': projectPermission.canUserCreateProject
                                                            && item.user_id == projectPermission.userIdCreator}"
                                                            v-if="idEdit==index && item.idSave !=0" @click="resetIdRowEdit()">
                                                            <i class="fa-solid fa-check fs-5"></i>
                                                        </a>
                                                        <a :class="{'disabled': projectPermission.canUserCreateProject
                                                            && item.user_id == projectPermission.userIdCreator}"

                                                        v-if="index < totalRecordUserRoot && idEdit != index"
                                                         @click="setIdRowEdit(index)" href="#"
                                                         class="btn btn-icon btn-edit btn-sm"

                                                         >
                                                                <i :class="{'disabled disaled-edit-permission': projectPermission.canUserCreateProject
                                                            && item.user_id == projectPermission.userIdCreator}" class="fa-solid fa-pen"></i>
                                                        </a>
                                                    </td>
                                                    <td style="width: 150px;" class="text-center" :title="projectPermission.canUserCreateProject
                                                            && item.user_id == projectPermission.userIdCreator? 'Không thể xóa quyền người tạo dự án.': ''">
                                                            <a

                                                             @click="removeItemUserRow(index, item)" href="#"
                                                             class="btn btn-icon btn-delete btn-sm"
                                                             :class="{'disable' :projectPermission.canUserCreateProject
                                                            && item.user_id == projectPermission.userIdCreator}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                            </tbody>
                                            <tbody v-if="Object.keys(getAllFunctionOfProject).length == 0">
                                                <tr>
                                                    <td class="text-center" colspan="13">
                                                        Không có dữ liệu hiển thị
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
import SelectSearchDiffUser from '../../input/SelectSearchDiff2.vue'

const props = defineProps({
    functionProjects: {
        type: Object
    },
    projectIdClickPermission: Number,
    generateFunction: Array,
    projectPermission: Object
})
// phân quyền
const checkboxAll = ref([])

const getAllFunctionOfProject = ref([])
const storeUser = useUsers();
onMounted(() => {
  storeUser.getUsersData({getAll:true});
})


const getUsersData = computed(()=> {
    return storeUser.getUserNotBlock;
})

const projectID = ref(null)

const addUserRow = () => {
    getAllFunctionOfProject.value.push({
        user_id: 0,
        idSave: 0, // id thêm mới chưa lưu vì khi chọn user thì id !=0
        function_ids: [],
        project_id:   props.functionProjects.projectId,
        isActive: false
    })
}

const { projectPermission } = toRefs(props)
const resetData = (data) => {
    getAllFunctionOfProject.value = [];
    checkboxAll.value = [];
    if(data && data.length > 0) {
            data.forEach((item) => {
                projectID.value =  item.project_id;
                    getAllFunctionOfProject.value.push({
                    user_id: item.user_id,
                    idSave: item.user_id, // id thêm mới chưa lưu vì khi chọn user thì id !=0
                    function_ids: item.functionIds,
                    project_id: item.project_id,
                    isActive: item.isActive
                })
                if(item.isActive) {
                    checkboxAll.value.push({
                        isCheck: true,
                        index: getAllFunctionOfProject.value.length - 1
                    })
                }
        });
    }
}
const totalRecordUserRoot = ref(0);
watch(projectPermission, (newValue) => {
    console.log(newValue);
    totalRecordUserRoot.value = newValue.projectFunctionUsers?.length;
    resetData( newValue.projectFunctionUsers)
})

const destroyUserId = ref([])
const removeItemUserRow =(key,item)=> {
    getAllFunctionOfProject.value.splice(key,1);
    if(item.idSave) {
        destroyUserId.value.push(item.user_id)
    }

}

const idEdit = ref(-1);
const setIdRowEdit =(index) => {
    idEdit.value = index;
}
const resetIdRowEdit=() => {
    idEdit.value = -1;
}

const { getUserById } = storeToRefs(storeUser)
const idSave = ref(0);
const changeUser =(userNew, userIdRoot, index , idSaveOfUser) => {
    idEdit.value = index;
    // id chưa save
    let user = getUserById.value(userIdRoot);
    if(user && user.idSave != 0 && idSaveOfUser != 0) {
        // console.log(userRoot,userNew, 'idsave')
        idSave.value = user.idSave;
    }
    // console.log(optionId)
    if(userNew == null) {
        getAllFunctionOfProject.value[index].user_id = userIdRoot
        getAllFunctionOfProject.value[index].idSave = 0
    }else {
        getAllFunctionOfProject.value[index].user_id =  userNew.id
        getAllFunctionOfProject.value[index].idSave =  idSave.value
    }
}
const emits = defineEmits(['updateUsers', 'searchPermissionUser']);
const errors =  ref([]);
const isBtnClickSave = ref(false);
const saveUsers = () => {
    isBtnClickSave.value = true;
    KTApp.showPageLoading();
    let formDataRequest = {
        permissions: getAllFunctionOfProject.value,
        destroyUserId: destroyUserId.value,
        project_id:  props.functionProjects.projectId
    }
     axios.post('/projects/store-permission-project', formDataRequest)
    .then((res) => {
        const { message, project } = res.data;
        useToast.successToast(message);
         errors.value = [];
         const btnClick = document.getElementById('close-modal-permission');
         btnClick.click();
        idEdit.value = -1;
        console.log(project.projectFunctionUsers, 'aa')
        resetData(project.projectFunctionUsers)
        emits('updateUsers');
        isBtnClickSave.value = false;
    }).catch((error) => {
          isBtnClickSave.value = false;
        let code = error.response?.status;
          if(code == 422) {
             errors.value = error.response.data.errors;
             useToast.errorToast("Vui lòng kiểm tra lại dữ liệu !");
             return;
        }
        if(code == 400) {
            // errors.value= []
             useToast.errorToast(error.response.data.errors.message);
             return;
        }
    }).finally(() => {
        KTApp.hidePageLoading();
    })
}

const checkedAll = (index) => {

        const keyBox =  checkboxAll.value.findIndex((item) => (item.index == index))
        let isValue = false;
        if(keyBox != -1) {
            checkboxAll.value.splice(keyBox, 1)
        }else {
             isValue = true;
             checkboxAll.value.push({
                isCheck: true,
                index: index
            })
        }

    getAllFunctionOfProject.value[index].function_ids = [];
    if(isValue){
        getAllFunctionOfProject.value[index].function_ids = [...props.generateFunction]
        return;
    }
}
// related ids

const checkCheckboxRelated = (index, relatedString, isParent, selfId) => {

     if(relatedString) {
        let ids = JSON.parse(relatedString);

        getAllFunctionOfProject.value[index].function_ids.push(...ids)

        getAllFunctionOfProject.value[index].function_ids
        = [...Array.from(new Set(getAllFunctionOfProject.value[index].function_ids))];
    }

    let checkExists = getAllFunctionOfProject.value[index].function_ids.includes(selfId)

    if(selfId == 25 && !checkExists) {
      const keyBox =  checkboxAll.value.findIndex((item) => (item.index == index))
        if(keyBox != -1) {
            checkboxAll.value.splice(keyBox, 1)
        }
          getAllFunctionOfProject.value[index].function_ids = [];
    }
    if(isParent && !checkExists) {
        if(selfId == 30) {

              getAllFunctionOfProject.value[index].function_ids =
               getAllFunctionOfProject.value[index].function_ids.filter((item) => {
                return (item < 30 || (item > 34 && item < 105) )
             });
        }
        if(selfId == 96) {
              getAllFunctionOfProject.value[index].function_ids =
               getAllFunctionOfProject.value[index].function_ids.filter((item) => {
                return item < 96 || item ==105
             });
        }
        // else {
        //     getAllFunctionOfProject.value[index].function_ids = [];
        // }
    }
    if(selfId == 27 || selfId == 28) {
            getAllFunctionOfProject.value[index].function_ids =
               getAllFunctionOfProject.value[index].function_ids.filter((item) => {
                return item != 26
             });
        }

        getAllFunctionOfProject.value[index].function_ids
        = [...Array.from(new Set(getAllFunctionOfProject.value[index].function_ids))];

              getAllFunctionOfProject.value[index].function_ids = getAllFunctionOfProject.value[index].function_ids.filter((value) => {
                if(![24,29,95].includes(value)) {
                    return value;
                }
            })
    let lengthForm = getAllFunctionOfProject.value[index].function_ids.length;
    if(lengthForm == 14) {
        $('#checkbox-all-' + index).prop('checked', true)
    }else {
        $('#checkbox-all-' + index).prop('checked', false)
    }

}
const searchUser = ref(null);
const handleClickSearchUser= () => {
    KTApp.showPageLoading();
     axios({
        url: '/projects/get-all',
        method: "GET",
        params: {searchPermissionUser:searchUser.value}
    })
    .then(res => {
        const { data } = res.data;
        console.log( data, 'ok')
        let permissions = data.find((item) => (item.id ==  projectID.value))
        if(permissions) {
            resetData(permissions.projectFunctionUsers)
            return;
        }
        resetData(projectPermission.value.projectFunctionUsers)
    }).catch(error => {
        console.log(error)
    }).finally(()=>{
         KTApp.hidePageLoading();
    })
}
const closeModalPermission = () => {
    errors.value = [];
    idEdit.value = -1;
    checkboxAll.value = []
    searchUser.value = null;
    resetData(projectPermission.value.projectFunctionUsers)
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

.disaled-edit-permission {
    color:gray;
}
@media screen and (min-width: 1280px) {
      .set-screen {
         width: 100%;
         overflow: hidden;
      }
   }
</style>
