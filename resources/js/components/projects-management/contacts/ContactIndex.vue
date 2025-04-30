<template>
  <div
            class="modal fade"
            id="modalDemo"
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
                        <h4 class="modal-title">Danh sách người đại diện (liên hệ)</h4>
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
                    <!-- {{ getDataUpdate}} -->
                           <div class="row col-lg-12 ps-1 pe-1 ms-1" style="border-bottom: 1px solid rgb(192, 192, 192);">
                            <div class="col-lg-12">
                                <div class="card-header border-0 d-flex justify-content-between align-items-center">
                                    <span class="card-label fw-bold fs-4 m-0"></span>
                                    <div class="align-items-center d-flex" v-if="getDataUpdate.canUserCreateProject || getDataUpdate.canPermissionEditProject">
                                        <div @click="addTaskRow()">
                                            <a href="#" class="btn btn-function">
                                            <i class="ki-duotone ki-plus fs-2 "></i>Thêm</a>
                                        </div>
                                        <div>
                                            <a @click="saveTasks()" :class="{ 'disabled': isBtnClickSave }" href="#" class="btn btn-function">
                                            <i class="fa-regular fa-pen-to-square"></i>Lưu</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-3" >
                                    <div class="table-responsive table-scroll-sm h-55vh text-nowrap">
                                        <table class="table table-row-dashed table-bordered table-sm table-data">
                                            <thead>
                                                <tr class="fs-6 text-gray-400">
                                                    <th class="w-50px max-w-50px">STT</th>
                                                    <th class="w-250px max-w-150px">Họ và tên</th>
                                                    <th v-if="checkPhonePermission" class="w-120px max-w-125px">Số diện thoại</th>
                                                    <th v-if="checkEmailPermission" class="w-120px max-w-125px" style="width: 130px;">
                                                        Email
                                                    </th>
                                                    <th class="min-w-125px max-w-250px">
                                                        Chức vụ
                                                    </th>
                                                        <th class="min-w-125px max-w-250px">
                                                        Trạng thái
                                                    </th>
                                                        <th class="min-w-125px max-w-250px">
                                                        Ghi chú
                                                    </th>
                                                    <th v-if="getDataUpdate.canUserCreateProject || getDataUpdate.canPermissionEditProject" class="w-auto text-center"  :colspan="2">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody class="max-h-25 overflow-auto cursor-pointer"
                                                >
                                                <tr v-for="(item,index) in formContact.contacts" :key="index"
                                                   >
                                                   <!-- style="border-right:1px solid red !important" -->
                                                    <td class="text-center" :class="{ 'is-invalid-border-right' : errors['contacts.' + index + '.name']}">
                                                        {{ index + 1 }}
                                                    </td>
                                                    <td :class="{ 'is-invalid-td': errors['contacts.' + index + '.name'] }">
                                                        <input class="text-content" :class="{'is-invalid' : errors['contacts.' + index + '.name']}" :title="errors['contacts.' + index + '.name'] ?? item.name"
                                                         :disabled="idEdit!==item.id && item.id !==0" ref="nameFocus" type="text" v-model="item.name"
                                                         />
                                                    </td>
                                                    <td v-if="checkPhonePermission" :class="{ 'is-invalid-td': errors['contacts.' + index + '.phone'] }">
                                                        <input class="text-content" :class="{'is-invalid' : errors['contacts.' + index + '.phone']}" :title="errors['contacts.' + index + '.phone'] ?? item.phone" :disabled="idEdit!==item.id && item.id !==0" type="text"  v-model="item.phone"
                                                        />
                                                    </td>
                                                    <td v-if="checkEmailPermission" :class="{ 'is-invalid-td': errors['contacts.' + index + '.email'] }">
                                                        <input class="text-content" :class="{'is-invalid' : errors['contacts.' + index + '.email']}" :title="errors['contacts.' + index + '.email'] ?? item.email" :disabled="idEdit!==item.id && item.id !==0" type="text" v-model="item.email" />
                                                    </td>
                                                    <td :class="{ 'is-invalid-td': errors['contacts.' + index + '.position'] }">
                                                        <input class="text-content" :class="{'is-invalid' : errors['contacts.' + index + '.position']}" :title="errors['contacts.' + index + '.position'] ?? item.position" :disabled="idEdit!==item.id && item.id !==0" type="text" v-model="item.position"/>
                                                    </td>

                                                    <td v-if="getDataUpdate.canUserCreateProject || getDataUpdate.canPermissionEditProject" :class="{ 'is-invalid-td': errors['contacts.' + index + '.pivot.status'] }">
                                                        <select :disabled="idEdit!==item.id && item.id !==0"
                                                        v-model="item.pivot.status"
                                                        style="border:0px;background-color: white;" class="form-select w-150px text-content">
                                                            <option :value="1">Sử dụng</option>
                                                            <option  :value="0">Ngừng sử dụng</option>
                                                        </select>
                                                    </td>
                                                    <td v-else>
                                                        <span>{{ item.pivot.status==1? 'Sử dụng' : 'Ngừng sử dụng' }}</span>
                                                    </td>
                                                     <td :class="{ 'is-invalid-td': errors['contacts.' + index + '.pivot.note'] }">
                                                        <input class="text-content" :title="errors['contacts.' + index + '.pivot.note'] ?? item.pivot.note" :disabled="idEdit!==item.id && item.id !==0"
                                                        type="text" v-model="item.pivot.note"/>
                                                    </td>
                                                    <td v-if="getDataUpdate.canUserCreateProject || getDataUpdate.canPermissionEditProject">
                                                        <a href="#" class="btn btn-icon btn-edit btn-sm"
                                                            v-if="idEdit==item.id" @click="resetIdRowEdit()">
                                                            <i class="fa-solid fa-check fs-5"></i>
                                                        </a>
                                                        <a v-if="item.id !==0 && idEdit != item.id" @click="setIdRowEdit(item.id, index)" href="#" class="btn btn-icon btn-edit btn-sm">
                                                                <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                    </td>
                                                    <td v-if="getDataUpdate.canUserCreateProject || getDataUpdate.canPermissionEditProject" class="text-center">
                                                            <a
                                                             :class="totalRecordUserRoot == 1 && KeyDisabled == index ? 'disable' :''"
                                                             @click="removeItemTaskRow(index, item)" href="#" class="btn btn-icon btn-delete btn-sm">
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
import { computed, defineProps, onBeforeMount, onMounted, reactive, ref, toRefs, watch } from 'vue'
import { useToast } from "../../../helper/toastMessage.js";
const props = defineProps({
    infoContacts: {
        type: Array,
        default: function() {
            return [{
                id: 0,
                name: "",
                email: "",
                phone: "",
                position: "",
                pivot: {
                    note: "",
                    status: 1
                }
            }]
        }
    },
    getDataUpdate: {
        type: Object
    }
})

const formContact = reactive({
    project_id: 0,
    customer_id : 0,
    contacts: [],
    destroyContactIds: []
})

const addTaskRow = () => {
    formContact.contacts.push({
        id: 0,
        name: "",
        email: "",
        phone: "",
        position: "",
        pivot: {
            note: "",
            status: 1
        }
    })
}

formContact.contacts = [...props.infoContacts];
const checkPhonePermission = ref(false)
const checkEmailPermission = ref(false)
const { infoContacts } = toRefs(props)
watch(infoContacts, (newValue) => {
    console.log(newValue);
    formContact.contacts = [...newValue];
    formContact.customer_id = newValue[0].customer_id;
    formContact.project_id = newValue[0].pivot?.project_id;
    checkEmailPermission.value = newValue[0].email ? true: false
    checkPhonePermission.value = newValue[0].phone ? true: false
})
// Tính toán những bản ghi đã lưu.
const KeyDisabled = ref(0);
const totalRecordUserRoot = computed(() => {
    let records = formContact.contacts.filter((item) => (item.id != 0));
    if(records.length == 1) {
        KeyDisabled.value = Object.keys(records)[0];
    }
    return records.length;
})
const removeItemTaskRow =(key, item)=> {
    formContact.contacts.splice(key,1);
    formContact.destroyContactIds.push(item.id)
}
const idEdit = ref(-1);
const nameFocus = ref(null);
const setIdRowEdit =(id, index) => {
    idEdit.value = id;
    setTimeout(() => {
         nameFocus.value[index].focus()
    }, 500)
}
const resetIdRowEdit=() => {
    idEdit.value = -1;
}
const isReset = ref(false);
const emits = defineEmits(['updateContacts']);
const errors =  ref([]);
const isBtnClickSave = ref(false);
const saveTasks = () => {
    isBtnClickSave.value = true;
     KTApp.showPageLoading();
     axios.post('/projects/store-contact-by-project', formContact)
    .then((res) => {
        const { message, contacts } = res.data;
        useToast.successToast(message);
        isBtnClickSave.value = false;
        errors.value = [];
        idEdit.value = -1;
         formContact.destroyContactIds = [];
       formContact.contacts = [...contacts];
       emits('updateContacts', {project_id:formContact.project_id, contacts:contacts});
    }).catch((error) => {
        let code = error.response.status
        console.log(error)
         isBtnClickSave.value = false;
        if(code == 422) {
            errors.value = error.response.data.errors;
             useToast.errorToast("Vui lòng kiểm tra lại dữ liệu !");
             return;
        }
        if(code == 403) {
             useToast.errorToast( error.response.data.message);
             isReset.value = true;
        }
    }).finally(() => {
        KTApp.hidePageLoading();
    })
}
const closeModalContacts = () => {
    errors.value = [];
    idEdit.value = -1;
     formContact.destroyContactIds = [];
     formContact.contacts = [...props.infoContacts];
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
    input {
        &:not(.is-invalid) {
            border: 0 !important;
        }

        width: 100% !important;
        height: 100% !important;
        box-sizing: border-box !important;
        color: #000000;
        background-color: rgb(255, 255, 255) !important;
        border-radius: 0;
        margin: 0 !important;

        &:disabled {
            color: #2a292ee5;
            background-color: #e4e4e4;
        }

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
    .is-invalid {
        border :0px;
        background: no-repeat;
        background-position: right calc(0.375em + 0.3875rem) center;
        background-size: calc(0.75em + 0.775rem) calc(0.75em + 0.775rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23e61c1c'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23e61c1c' stroke='none'/%3e%3c/svg%3e")
    }
    .form-control {
        border:0px;
    }
}
</style>
