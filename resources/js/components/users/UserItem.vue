<template>
  <tr>
    <td style="text-align:center">
            <span class="text-dark">{{  (pagination.per_page)*(pagination.current_page - 1) + (userItemNew.stt + 1)}}</span>
        </td>
        <!-- <td style="max-width:100px;" class="break-text">
            <span class="text-dark">{{ userItemNew.code }}</span>
        </td> -->
        <td class="break-text" style="max-width:120px;" :title="userItemNew.username">
            <span class="text-dark">{{ userItemNew.username }}</span>
        </td>
        <td class="break-text" style="max-width:150px;">
            <div class="text-dark " :title="userItemNew.name" style="padding-bottom:5px; padding-top:5px;"><i class="fa-solid fa-user"></i>
            {{ userItemNew.name }}
            </div>
              <div class="fs-8 w-100" style="padding-bottom:5px;"
                                   >
                                Giới tính : {{ userItemNew.genderName }}
               </div>
        </td>

        <td class="text-dark break-text" style="max-width:200px;" >
            <div class="text-dark pb-2  break-text" :title="userItemNew.email">
               <i class="fa-solid fa-envelope"></i> {{ userItemNew.email }}
                </div>
              <div class="text-dark  break-text" :title="userItemNew.phone">
                <i class="fa-solid fa-phone"></i> {{ userItemNew.phone }}
                </div>
        </td>
        <td class="text-dark ">
            <div  class="text-red d-block mb-1 "
                  :class="userItemNew.status == 0 ? 'status-badge-danger-color' : 'status-badge-active-color'"
            >{{ userItemNew.statusName }}</div>
        </td>
        <td class="text-dark text-center">
            <span class="text-dark">{{ userItemNew.situation }}</span>
        </td>
        <td class="text-dark">
            <!-- style="font-weight:normal" -->
            <div class="badge bg-primary badge text-white cursor-pointer" v-if="userItemNew.changePassword" title="Đổi mật khẩu" @click="changePassword(userItemNew.id, userItemNew.username)">Đổi mật khẩu</div>
        </td>
        <!-- <td class="text-dark text-center">
            <span class="text-dark cursor-pointer"><i class="fa-solid fa-gear fs-4"></i></span>
        </td> -->
        <td class="w-50px text-center">
            <a href="#"  data-bs-target="#actionUpdateUser"
                        data-bs-toggle="modal"  @click="handleEditUser(userItemNew)" v-if="userItemNew.isEdit" class="btn btn-icon btn-edit btn-sm">
                <i class="ki-duotone ki-pencil fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </a>
        </td>
        <td class="w-50px" :title="userItemNew.is_delete_permission && userItemNew.isDelete == false?'Người dùng này đã phát sinh dữ liệu không thể xóa.':''">
            <a href="#" @click="handleDeleteUser(userItemNew.id)" class="btn btn-icon btn-delete btn-sm me-1" v-if="userItemNew.is_delete_permission"
            :class="{'disable' : userItemNew.isDelete == false}">
                <i class="fa-solid fa-trash fs-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </a>
        </td>
    </tr>
</template>

<script setup>
import axios from 'axios';
import { defineProps, ref, toRefs, watch } from 'vue';
import { useToast } from '../../helper/toastMessage'
import { sweetAlertMessage } from '../../helper/sweetAlert'
import moment from 'moment';

const props = defineProps({
    userItem: Object,
    index: Number,
    pagination: {
        type: Object,
        default: {
            current_page: 1,
            per_page: 30
        }
    },
    btnAdd: {
        type: Boolean,
        default: false,
    }
})
let userItemNew = {...props.userItem};
const {userItem} = toRefs(props)
watch(userItem,(newValue, oldValue) => {
    userItemNew = {...newValue}
})

watch(props.pagination,(newValue, oldValue) => {
    props.pagination = newValue

})
const emit = defineEmits(['handleEditUser', 'changeUserPassword','handleDeleteUser'])
const handleEditUser = (userItem) => {
    emit('handleEditUser', userItem);
}
const errors = ref([]);
const changePassword = (userId, username) => {
    emit('changeUserPassword', {userId, username});
}

const handleDeleteUser =(userId) => {
    sweetAlertMessage.messageWarning("Bạn có chắc chắn muốn xóa không?").then((result) => {
        if(result.value) {
            KTApp.showPageLoading();
            axios.delete(`/users/destroy/${userId}`)
            .then((res) => {
                const { message } = res.data;
                useToast.successToast(message);
                emit('handleDeleteUser');
            }).catch((error) => {
                errors.value = error.response.data.errors;
                if(error.response?.data?.errors?.message) {
                    useToast.errorToast(error.response?.data?.errors?.message)
                }
            }).finally(() => {
                KTApp.hidePageLoading();
            })
        }
    })
}
</script>

<style>

</style>
