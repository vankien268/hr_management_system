<template>
    <tr>
        <td style="text-align:center" class="w-40px">
            <span class="text-dark  text-hover-primary w-40px break-text d-block">{{ keyItem + 1}}</span>
        </td>
        <td style="max-width:200px;" class="break-text">
            <span class="text-dark text-hover-primary" :title="departmentItem.code">
                <span style="color:black;font-size:13px;">{{ `${departmentItem.prefix? departmentItem.prefix : ''}` }}
                    </span> {{ ' '+ departmentItem.code }}</span>
        </td>
        <td style="max-width:250px;">
            <span class="text-dark  text-hover-primary d-block mb-1 break-text text-content" :title=" departmentItem.name"
            >{{ departmentItem.name }}</span>
        </td>

        <td  style="max-width:250px;">
            <span class="text-dark d-block break-text text-hover-primary text-content"
             :title="departmentItem.note"  >{{ departmentItem.note }}</span>
        </td>
        <td >
            <div  class="text-red text-hover-primary d-block mb-1 break-text d-block"
                  :class="departmentItem.status == 0 ? 'status-badge-danger-color' : 'status-badge-active-color'"
            >{{ departmentItem.convertStatus }}</div>
        </td>

        <td class="w-50px text-center">
            <a href="#" v-if="departmentItem.isEdit" @click="handleUpdate(departmentItem)" class="btn btn-icon btn-edit btn-sm" data-bs-target="#formUpdateDepartment" data-bs-toggle="modal" >
                <i class="ki-duotone ki-pencil fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </a>
        </td>
        <td class="w-50px">
            <a href="#" v-if="departmentItem.is_delete_permission" :class="{ 'disable': !departmentItem.isDelete }"  @click.prevent="handleDelete(departmentItem.id)" class="btn btn-icon btn-delete btn-sm me-1">
                <i class="fa-solid fa-trash fs-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                </i>
            </a>
        </td>
    </tr>
</template>

<script setup>
import axios from 'axios';
import { defineProps, ref, defineEmits, watch } from 'vue';
import { helperFunc } from '../../helper/heplerFunction.js'
import { sweetAlertMessage } from '../../helper/sweetAlert';
import { useToast } from '../../helper/toastMessage';
const props = defineProps({
    departmentItem: {
        type: Object
    },
    keyItem: Number
})
const emit = defineEmits(['deleteDepartment', 'showDepartmentInModal']);

let dataDepartmentInfo = ref({});
const handleUpdate = (item) => {
    emit('showDepartmentInModal', item);
    dataDepartmentInfo.value = props.departmentItem;
}
watch(dataDepartmentInfo,(newValue, oldValue) => {
    dataDepartmentInfo.value = newValue;
    // console.log(newValue, "watch");
})

const handleDelete = (id) => {
    sweetAlertMessage.messageWarning("Bạn có chắc chắn muốn xóa không?")
     .then(function(result) {
        if(result.value) {
             KTApp.showPageLoading();
            axios.delete('/departments/destroy/'+ id)
            .then(res => {
                useToast.successToast(res.data.message)
                    emit('deleteDepartment')
            }).catch((error) => {
                const message = error.response.data.errors.message
                if(message) {
                    sweetAlertMessage.errorAlert(message);
                }
            }).finally(()=> {
                KTApp.hidePageLoading();
            });
        }
    })
}
</script>

<style>

</style>
