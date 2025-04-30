<template>
    <div
              class="modal fade"
              id="modalListTask"
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
                          <h4 class="modal-title">Nhật ký dự án</h4>
                          <div @click="closeModaltasks" id="close-tasks"
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
                             <div class="row col-lg-12 pe-1 ms-1" style="border-bottom: 1px solid rgb(192, 192, 192);">
                              <div class="col-lg-12">
                                  <div class="card-header border-0 d-flex justify-content-between align-items-center">
                                      <span class="card-label fw-bold fs-4 m-0"></span>
                                      <div class="align-items-center d-flex">
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
                                  <div class="card-body py-3">
                                      <div class="table-responsive table-scroll-sm h-55vh text-nowrap">
                                          <table class="table table-row-dashed table-bordered table-data">
                                              <thead>
                                                  <tr class="fs-6 text-gray-400">
                                                      <th class="w-50px max-w-50px">STT</th>
                                                      <th class="w-125px max-w-150px">Ngày cập nhật
                                                      </th>
                                                      <th class="w-200px max-w-125px">Diễn giải</th>
                                                      <th class="w-130px max-w-100px" >
                                                          Ngày thực hiện
                                                      </th>
                                                      <th class="min-w-125px max-w-250px">
                                                         Trạng thái
                                                      </th>
                                                          <th class="min-w-125px max-w-250px">
                                                          Người thực hiện
                                                      </th>
                                                          <th class="min-w-125px max-w-250px">
                                                          Ghi chú
                                                      </th>
                                                      <th class="w-auto"  colspan="2">Hành động </th>
                                                  </tr>
                                              </thead>
                                              <tbody v-if="totalRecordTaskRoot > 0 ||  formTask.tasks.length > 0" class="max-h-25 overflow-auto cursor-pointer"
                                                  >
                                                  <tr v-for="(item,index) in formTask.tasks" :key="index"
                                                     >
                                                     <!-- style="border-right:1px solid red !important" -->
                                                      <td class="text-center text-content">
                                                          {{ index + 1 }}
                                                      </td>
                                                      <td style="background:#e4e4e4;"  :class="{ 'is-invalid-border-right' : errors['tasks.' + index + '.description']}">
                                                          <input style="background:#e4e4e4 !important" class="text-content" :title="moment().format('DD/MM/YYYY')"
                                                           :disabled="true" type="text" :value="moment().format('DD/MM/YYYY')"
                                                          />
                                                      </td>
                                                      <td :class="{ 'is-invalid-td': errors['tasks.' + index + '.description'] }"
                                                      >
                                                          <input class="text-content" :class="{'is-invalid' : errors['tasks.' + index + '.description']}" :title="errors['tasks.' + index + '.description'] ?? item.description"
                                                           :disabled="idEdit!==item.id && item.id !==0" ref="nameFocus" type="text" v-model="item.description"
                                                           />
                                                      </td>
                                                      <td :class="{ 'is-invalid-td': errors['tasks.' + index + '.date'] }">
                                                        <input class="text-content"
                                                         :title="errors['tasks.' + index + '.date'] ?? item.date"
                                                           :disabled="idEdit!==item.id && item.id !==0" type="date"
                                                            v-model="item.date"
                                                            :max="moment().format('YYYY-MM-DD')"
                                                        />
                                                      </td>
                                                      <td :class="{ 'is-invalid-td': errors['tasks.' + index + '.status_id'] }">
                                                          <select :title="errors['tasks.' + index + '.status_id'] ?? item.status_id"
                                                          :disabled="idEdit!==item.id && item.id !==0" v-model="item.status_id"
                                                           style="border:0px;background-color: white;width:150px;" class="form-select">
                                                            <option :value="null">Chọn trạng thái</option>
                                                              <option :selected="item2.id == item.status_id" v-for="(item2,index) in getStatusesByTask"
                                                             :key="index"
                                                              :value="item2.id">{{ item2.name }}</option>
                                                          </select>
                                                      </td>
                                                      <td style="background:#e4e4e4;"  >
                                                          <input :title="item.user_name" style="background:#e4e4e4 !important"
                                                          :disabled="true" type="text" v-model="item.user_name" />

                                                      </td>

                                                      <td :class="{ 'is-invalid-td': errors['tasks.' + index + '.note'] }">
                                                          <input class="text-content" :class="{'is-invalid' : errors['tasks.' + index + '.note']}"
                                                           :title="errors['tasks.' + index + '.note'] ?? item.note"
                                                          :disabled="idEdit!==item.id && item.id !==0" type="text" v-model="item.note"/>
                                                      </td>
                                                      <td>
                                                          <a href="#" class="btn btn-icon btn-edit btn-sm"
                                                              v-if="idEdit==item.id" @click="resetIdRowEdit()">
                                                              <i class="fa-solid fa-check fs-5"></i>
                                                          </a>
                                                          <a v-if="item.id !==0 && idEdit != item.id" @click="setIdRowEdit(item.id, index)" href="#" class="btn btn-icon btn-edit btn-sm">
                                                                  <i class="fa-solid fa-pen"></i>
                                                          </a>
                                                      </td>
                                                      <td class="text-center">
                                                              <a @click="removeItemTaskRow(index, item)" href="#" class="btn btn-icon btn-delete btn-sm">
                                                              <i class="fa-solid fa-trash"></i>
                                                          </a>
                                                      </td>
                                                  </tr>
                                              </tbody>
                                             <tbody v-else>
                                                    <tr>
                                                        <td class="text-center" colspan="8">
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
  import moment from 'moment';
  import { computed, defineProps, onBeforeMount, onMounted, reactive, ref, toRefs, watch } from 'vue'
  import { useToast } from "../../../helper/toastMessage.js";
  import { useSystemStatusStore } from '../../../stores/status'

  const props = defineProps({
    taskList: {
          type: Array,
          default: function() {
              return [{
                  id: 0,
                  description: "",
                  date: "",
                  user_name: null,
                  status_id: null,
                  user_id : null,
                  note: ""
              }]
          }
      },
      projectId:{
        type:Number,
        default: 0
      },
      nameUser: String,
      userIdCurrent: Number
  })

  const formTask = reactive({
      project_id: 0,
      tasks: [],
      destroyTaskIds: []
  })
const totalRecordTaskRoot = ref(0);
  const addTaskRow = () => {
    formTask.tasks.push({
            id: 0,
            description: "",
            date: "",
             user_name: props.nameUser,
            status_id: null,
            user_id: props.userIdCurrent,
            note: ""
      })
  }
  formTask.tasks = [...props.taskList];
  formTask.project_id = props.projectId;
    totalRecordTaskRoot.value = props.taskList.length;

  const { taskList, projectId } = toRefs(props)
  watch(taskList, (newValue) => {
        console.log(newValue, 'watch')
       totalRecordTaskRoot.value = newValue.length;
      formTask.tasks = [...newValue];

  })
  watch(projectId, (newValue) => {
      formTask.project_id = newValue;
  })

  const removeItemTaskRow =(key, item)=> {
    formTask.tasks.splice(key,1);
    formTask.destroyTaskIds.push(item.id)
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

const storeSystemStatus = useSystemStatusStore();
onBeforeMount(() => {
    storeSystemStatus.getSystemStatusData();
})
const getStatusesByTask = computed(() => {
    return storeSystemStatus.getStatusesByTask;
})
  const emits = defineEmits(['updateTasks']);
  const errors =  ref([]);
  const isBtnClickSave = ref(false);
  const saveTasks = () => {
      isBtnClickSave.value = true;
       KTApp.showPageLoading();
       axios.post('/projects/store-task-by-project', formTask)
      .then((res) => {
          const { message, tasks } = res.data;
          useToast.successToast(message);
           errors.value = [];
             idEdit.value = -1;
            formTask.destroyTaskIds = [];
            formTask.tasks = [];
           formTask.tasks = [...tasks.data]
          emits('updateTasks',  {project_id:formTask.project_id, tasks:tasks.data});
          totalRecordTaskRoot.value = tasks.length
          isBtnClickSave.value = false;
      }).catch((error) => {
          errors.value = error.response.data.errors;
          useToast.errorToast("Vui lòng kiểm tra lại dữ liệu !");
          isBtnClickSave.value = false;
      }).finally(() => {
        KTApp.hidePageLoading();
    })
  }

  const closeModaltasks = () => {
      errors.value = [];
      idEdit.value = -1;
      formTask.destroyTaskIds = [];
     formTask.tasks = [...props.taskList];
      console.log( formTask.tasks, props.taskList)
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

      .form-control {
          border:0px;
      }
  }

  </style>
        <!-- .is-invalid {
          border :0px;
          background: no-repeat;
          background-position: right calc(0.375em + 0.3875rem) center;
          background-size: calc(0.75em + 0.775rem) calc(0.75em + 0.775rem);
          background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23e61c1c'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23e61c1c' stroke='none'/%3e%3c/svg%3e")
      } -->
