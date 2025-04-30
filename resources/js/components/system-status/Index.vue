<template>
    <div class="col-xxl-12 col-xl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch">
            <!--begin::Header-->
            <div class="d-flex w-100 justify-content-between mt-7 mb-4 ps-7 pe-7">
                <div class="d-flex align-items-center w-325px">
                    <div class="w-125px">
                        <label for="statuses" class="col-form-label">Loại trạng thái</label>
                    </div>
                    <div class="w-200px">
                        <select class="form-select mb-lg-0 p-2" data-placeholder="Select an option" v-model="type"
                            id="statuses">
                            <option selected value="">-- Tất cả --</option>
                            <option v-for="(item, index) in props.statusType" :key="index" :value="item.value">
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="card-toolbar">
                    <a href="#" class="btn btn-function" data-bs-toggle="modal" data-bs-target="#modal_create_status"
                        v-if="props.btnAdd">
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm trạng
                        thái</a>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-3">
                <!--begin::Table container-->
                <div class="table-responsive table-scroll h-78vh">
                    <!--begin::Table-->
                    <table class="table table-row-dashed table-bordered" cellspacing="0" cellpadding="0" border="0"
                        width="325">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800">
                                <!-- <th class="w-20px">
                  <div class="form-check form-check-sm form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                      data-kt-check-target=".widget-9-check" />
                  </div>
                </th> -->
                                <th class="w-50px">STT</th>
                                <th class="w-350px min-w-150px">
                                    Tên Trạng Thái
                                </th>
                                <th class="min-w-250px">Ghi Chú</th>
                                <th class="w-50px text-center">Ẩn</th>
                                <th class="min-w-100px text-center" colspan="2">Hành động</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody v-for="(type, key) in systemStatus" :key="key">
                            <tr>
                                <td class="h-40px fw-medium" style="background-color: rgb(243 237 179); font-size:14px;"
                                    colspan="6">
                                    {{ key }}
                                </td>
                            </tr>
                            <tr v-for="(item, index) in type" :key="index">
                                <!-- <td>
                  <div class="form-check form-check-sm form-check-custom form-check-solid p-0">
                    <input class="form-check-input widget-9-check" type="checkbox" value="1" />
                  </div>
                </td> -->
                                <td>{{ index+= 1 }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.note }}</td>
                                <td v-if="item.status != true" class="text-center">
                                    <i class="fa-solid fa-check text-dark fs-2"></i>
                                </td>
                                <td v-else></td>
                                <td class="w-50px">
                                    <a href="#" class="btn btn-icon btn-edit btn-sm" @click="setDataUpdate(item)"
                                        v-if="item.is_edit" data-bs-toggle="modal"
                                        data-bs-target="#modal_update_status">
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </td>
                                <td class="w-50px">
                                    <a href="#" class="btn btn-icon btn-delete btn-sm" v-if="item.is_delete" @click="deleteRow(item.id)">
                                        <i class="fa-solid fa-trash fs-5"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <!-- <tbody v-else>
              <tr>
                <td>
                  Không có data
                </td>
              </tr>
            </tbody> -->
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
        <!--end::Tables Widget 9-->
        <CreateSystemStatusModal :status-type="props.statusType"></CreateSystemStatusModal>
        <UpdateSystemStatus :status-type="props.statusType" :status="dataUpdate" @unset-data="unsetDataUpdate()" />

    </div>
</template>
<script setup>
import CreateSystemStatusModal from "./CreateStatus.vue";
import UpdateSystemStatus from "./UpdateStatus.vue";

import { ref, computed, watch, onBeforeMount, onMounted } from "vue";
import { useSystemStatusStore } from "../../stores/status";
import axios from "axios";
import { sweetAlertMessage } from '../../helper/sweetAlert'
import { useToast } from '../../helper/toastMessage';

const props = defineProps({
    statusType: {
        type: [Array],
        default: function () {
            return [];
        },
    },
    btnAdd: {
        type: Boolean,
        default: false
    },
    btnEdit: {
        type: Boolean,
        default: false
    },
    btnDelete: {
        type: Boolean,
        default: false
    },
});

const store = useSystemStatusStore();

const type = ref("");

const dataUpdate = ref(null);

const systemStatus = computed(() => {
    return store.$state.statuses.data
        ? store.$state.statuses.data.reduce((group, arr) => {
            const { type_text } = arr;
            group[type_text] = group[type_text] ?? [];
            group[type_text].push(arr);
            return group;
        }, {})
        : [];
});

watch(type, (newValue, oldValue) => {
    console.log(newValue);
    getData();
});

const setDataUpdate = (data) => {
    dataUpdate.value = data;
};

const unsetDataUpdate = () => {
    dataUpdate.value = null;
    getData();
};

const getData = () => {
    store.getSystemStatusData(type.value);
}

const deleteRow = (id) => {
    sweetAlertMessage.messageWarning("Bạn có chắc chắn muốn xóa không?")
        .then((res) => {
            if (res.isConfirmed == true) {
                axios({
                    method: "DELETE",
                    url: "/system-status/api/" + id,
                })
                    .then((res) => {
                        console.log(res.data);
                        store.removeData(res.data.data);
                        useToast.successToast("Xóa bản ghi thành công!")
                    })
                    .catch((err) => {
                        try {
                            useToast.errorToast(err.response.data.errors.id)
                        } catch {
                        }

                    });
            }
        })
        .catch((err) => {
        });


};

onBeforeMount(() => {
    store.getSystemStatusData(type.value);
});
</script>
<style lang="scss">
table td {
    padding: 0.175rem 0.875rem !important;
}
</style>
