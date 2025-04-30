<template>
    <tr :class="{ active:getDataUpdate.id == projectItemNew.id  }" >
    <td style="text-align:center">
            <span class="text-dark text-hover-primary">{{  (pagination.per_page)*(pagination.current_page - 1) + (index + 1)}}</span></td>
        <td >
            <span class="text-dark text-hover-primary text-content">{{ projectItemNew.created_at }}</span>
        </td>
        <td style="text-align:left;max-width:150px">
            <span class="text-dark text-hover-primary text-content break-text d-block" style="max-width:150px" :title="projectItemNew.code">{{ projectItemNew.code }}</span>
        </td>
        <td style="max-width:200px">
            <span class="text-dark text-hover-primary text-content  break-text d-block" :title="projectItemNew.name">{{ projectItemNew.name }}</span>
        </td>
        <td class="text-dark text-hover-primary text-content text-left" style="max-width:150px">
            <span class="text-dark text-hover-primary text-content break-text d-block" :title="projectItemNew.systemStatus?.data.name">{{ projectItemNew.systemStatus?.data.name }}</span>
        </td>
        <td class="text-dark text-hover-primary text-content" style="max-width:200px;">
            <span class="text-dark text-hover-primary text-content d-flex justify-content-start me-10  break-text d-block"
                style="padding-top: 10px;"
                :title="projectItemNew.users?.data[0].name">
                {{ projectItemNew.users?.data[0].name }}
            </span>
            <span
                style="margin-top: -15px;padding-bottom: 10px; display:block"
                class="text-dark text-hover-primary cursor-pointer d-flex justify-content-end"
               >
                <i  @click="usersList(projectItemNew.users.data)" data-bs-target="#modalUserList"
                 data-bs-toggle="modal" class="fa-solid fa-book fs-4"
                title="Danh sách đại diện công ty"></i>
            </span>
        </td>
        <td style="max-width:100px">
            <span class="text-dark text-hover-primary text-content break-text d-block" style="width:88px;" :title="projectItemNew.city?.data.name">{{ projectItemNew.city?.data.name}}</span>
        </td>
        <td style="max-width:200px;">
            <span class="text-dark text-hover-primary text-content break-text d-block" style="width:200px;" :title="projectItemNew.customer?.data.name">
                {{ projectItemNew.customer?.data.name}}
            </span>
        </td>
        <td class="text-dark text-hover-primary" style="max-width:150px;">
            <span class="text-dark text-hover-primary text-content break-text d-flex justify-content-start me-9"
                style="padding-top: 10px;" :title="projectItemNew.contacts?.data[0].name"
            >{{ projectItemNew.contacts?.data[0].name }}</span>
            <span  class="text-dark text-hover-primary cursor-pointer d-flex justify-content-end break-text d-block"
            style="margin-top: -15px;padding-bottom: 10px;max-width:200px;"
            id="clickContacts"><i  @click="contacts(projectItemNew.contacts.data)"
             data-bs-target="#modalDemo" title="Danh sách đại diện phía khách hàng" data-bs-toggle="modal" class="fa-solid fa-book fs-4"></i></span>
        </td>
        <td style="max-width:200px">
            <span class="text-dark text-hover-primary text-content break-text d-block" :title="projectItemNew.projectType?.data.name">
                {{ projectItemNew.projectType?.data.name }}
                </span>
        </td>
        <td style="max-width:200px">
            <span class="text-dark text-hover-primary break-text d-block" :title="projectItemNew.description">
                {{ projectItemNew.description }}
                </span>
        </td>

        <td class="text-dark text-hover-primary text-center">
            <span @click="tasks(projectItemNew.tasks.data, projectItemNew.id)" class="text-dark text-hover-primary cursor-pointer"
             data-bs-target="#modalListTask" data-bs-toggle="modal"><i title="Danh sách nhật ký dự án" class="fa-solid fa-book fs-4"></i></span>
        </td>
        <td class="text-dark text-hover-primary text-center">
            <span v-if="projectItem.canUserCreateProject" class="text-dark text-hover-primary fs-12 cursor-pointer"
             data-bs-target="#permission" data-bs-toggle="modal"
             @click="permission(projectItemNew)"
            ><i class="fa-solid fa-gear fs-4"></i></span>
        </td>
        <td class="text-center">
             <i @click="handleClickViewHistories(projectItemNew.id)" class="fa-solid fa-clock-rotate-left text-hover-primary fs-4 text-center"
               data-bs-target="#historyUpdateProject" data-bs-toggle="modal">
        </i>
        </td>
    </tr>
</template>

<script setup>
import axios from 'axios';
import { computed, defineProps, toRefs, watch, defineEmits } from 'vue'
import { useToast } from '../../helper/toastMessage';
import { sweetAlertMessage } from '../../helper/sweetAlert';
import { helperFunc } from '../../helper/heplerFunction.js'

const props = defineProps({
    projectItem: Object,
    index: Number,
    pagination: {
        type: Object,
        default: {
            current_page: 1,
            per_page: 30
        }
    },
    getDataUpdate: Object
})
let projectItemNew = {...props.projectItem};
const { projectItem } = toRefs(props);

watch(projectItem,(newValue) => {
    projectItemNew = {...newValue};
})


const emit = defineEmits(['handle-contacts', 'handle-users', 'handle-tasks', 'permissionProject', 'handleClickViewHistories']);
// const handleProjectEdit=(projectItemNew) => {
//     emit('handleProjectEdit', projectItemNew)
// }
const contacts=(contacts) => {
    emit('handle-contacts', contacts)
}
const usersList =(users) => {
    emit('handle-users', {users, totalUser: users.length})
}
const tasks=(tasks, projectId) => {
    emit('handle-tasks', {tasks, projectId:projectId})
}
const permission = (project) => {
    emit('permissionProject', project)
}
const handleClickViewHistories =(projectId) => {
    emit('handleClickViewHistories', projectId);
}
</script>

<style scoped>
table td {
    padding: 0.6rem !important;
}
.active {
    background-color: #c1f6ff;
}

</style>
