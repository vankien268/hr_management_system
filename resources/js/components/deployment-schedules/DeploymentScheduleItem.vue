<template>
  <tr :class="{ active:getIdClick == deploymentScheduleItemNew.id  }">
    <td style="text-align:center">
            <span class="text-dark">{{  (pagination.per_page)*(pagination.current_page - 1) + (deploymentScheduleItemNew.stt + 1)}}</span>
        </td>
        <td :title="deploymentScheduleItemNew.code">
            <span class="text-dark d-block break-text" style="width:100px;">{{  deploymentScheduleItemNew.code }}</span>
        </td>
        <td style="width:250px;" :title="deploymentScheduleItemNew.title">
            <span class="text-dark d-block break-text" style="width:250px;">{{ deploymentScheduleItemNew.title }}</span>
        </td>
        <td>
            <div class="text-dark d-block break-text"
            :title="`${ moment(new Date(deploymentScheduleItemNew.from_date)).format('DD/MM/YYYY')} - ${moment(new Date(deploymentScheduleItemNew.to_date)).format('DD/MM/YYYY')}`"
            style="padding-bottom:5px; padding-top:5px; width:180px;"><i class="fa-solid fa-calendar-days"></i>
            {{ `${ moment(new Date(deploymentScheduleItemNew.from_date)).format('DD/MM/YYYY')}
             - ${moment(new Date(deploymentScheduleItemNew.to_date)).format('DD/MM/YYYY')}` }}
            </div>
        </td>

        <td class="text-dark text-center">
            <span class="text-dark text-hover-primary cursor-pointer d-flex justify-content-end "
               >
                <i  style="margin-right: 12px;" data-bs-target="#actionUpdateUser"
                        data-bs-toggle="modal"  @click="handleEditDeployment(deploymentScheduleItemNew, true)" class="fa-solid fa-book fs-4"
                title="Chi tiết lịch triển khai">
            </i>
            </span>
        </td>
        <td class="text-dark" :title="deploymentScheduleItemNew.note">
            <span class="text-dark d-block break-text" style="width:200px;" >{{ deploymentScheduleItemNew.note }}</span>
        </td>
        <td class="text-dark " :title="deploymentScheduleItemNew.status.data.name">
            <div  class="text-red d-block mb-1 d-block" style="width:120px;"
            >{{ deploymentScheduleItemNew.status.data.name  }}</div>
        </td>
        <td class="w-50px text-center">
            <a href="#" v-if="deploymentScheduleItemNew.is_edit"  data-bs-target="#actionUpdateUser"
                        data-bs-toggle="modal"  @click="handleEditDeployment(deploymentScheduleItemNew, false)" class="btn btn-icon btn-edit btn-sm"
                       >
                <i class="ki-duotone ki-pencil fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </a>
        </td>
        <td class="w-50px">
            <a v-if="deploymentScheduleItemNew.is_delete" href="#" @click="handleDeleteDeployment(deploymentScheduleItemNew.id)" class="btn btn-icon btn-delete btn-sm me-1"
            >
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
import { helperFunc } from '../../helper/heplerFunction'
import moment from 'moment';

const props = defineProps({
    deploymentScheduleItem: {
        type: Object,
        default: {}
    },
    index: Number,
    pagination: {
        type: Object,
        default: {
            current_page: 1,
            per_page: 30
        }
    },
    getIdClick: {
        type: Boolean
    }
})
let deploymentScheduleItemNew = {...props.deploymentScheduleItem};
const {deploymentScheduleItem} = toRefs(props)
watch(deploymentScheduleItem,(newValue, oldValue) => {
    deploymentScheduleItemNew = {...newValue}
})

// watch(props.pagination,(newValue, oldValue) => {
//     props.pagination = newValue

// })
const emit = defineEmits(['handleEditDeployment', 'handleDeleteDeployment'])
const handleEditDeployment = (userItem, isEdit) => {
    console.log(userItem);
    emit('handleEditDeployment', {userItem, isEdit});
}
const errors = ref([]);

const handleDeleteDeployment =(userId) => {
    sweetAlertMessage.messageWarning("Bạn có chắc chắn muốn xóa không?").then((result) => {
        if(result.value) {
            KTApp.showPageLoading();
            axios.delete(`/deployment-schedule/destroy/${userId}`)
            .then((res) => {
                const { message } = res.data;
                useToast.successToast(message);
                emit('handleDeleteDeployment');
            }).catch((error) => {
                errors.value = error.response.data.errors;
            }).finally(() => {
                KTApp.hidePageLoading();
            })
        }
    })
}
</script>

<style>

</style>
