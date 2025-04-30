<template>
    <div class="col-xxl-12 col-xl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch">
            <!--begin::Header-->
            <div class="card-header border-0 mb-2">
                <div class="row g-2 mt-0 align-items-center w-350px">
                    <div class="w-auto">
                        <label for="inputPassword6" class="col-form-label">Tìm kiếm</label>
                    </div>
                    <div class="w-auto">
                        <input type="text" class="required form-control mb-lg-0 p-2" v-model="searchData.search"
                            placeholder="Mã/tên loại hợp đồng..." />
                    </div>
                    <a href="#" class="btn btn-icon btn-icon-sm btn-color-primary btn-active-light-success" @click="getData()">
                        <i class="fa-solid fa-magnifying-glass fs-3"></i></a>
                </div>
                <div class="card-toolbar m-0" >
                    <a href="#" class="btn btn-function" data-bs-toggle="modal" data-bs-target="#modal_contract_type" v-if="btnAdd">
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm</a>
                </div>
            </div>

            <div class="card-body py-0">
                <!--begin::Table container-->
                <div class="table-responsive table-scroll h-78vh text-nowrap">
                    <!--begin::Table-->
                    <table class="table table-row-dashed table-bordered table-hover table-sm table-data" cellspacing="0"
                        cellpadding="0" border="0" width="325" id="tableid">
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
                                <th class="w-150px min-w-150px">Mã loại hợp đồng</th>
                                <th class="min-w-350px">Tên loại hợp đồng</th>
                                <th class="w-550px">Ghi chú</th>
                                <th class="w-150px">Trạng thái</th>
                                <th class="w-80px text-center" colspan="2">Hành động</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="max-h-75 overflow-auto">
                            <tr v-for="(item, index) in contractTypes" :key="index">
                                <!-- <td>
                  <div class="form-check form-check-sm form-check-custom form-check-solid p-0">
                    <input class="form-check-input widget-9-check" type="checkbox" value="1" />
                  </div>
                </td> -->
                                <td>{{ (index += 1) }}</td>
                                <td>{{ item.code }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.note }}</td>
                                <td v-if="item.status == true"><span class="text-primary">Sử dụng</span></td>
                                <td v-else> <span class="text-danger">Ngưng sử dụng</span></td>
                                <td class="w-50px">
                                    <a href="#" class="btn btn-icon btn-edit btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal_contract_type" @click="setDataUpdate(item)" v-if="item.is_edit">
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </td>
                                <td class="w-50px">
                                    <a href="#" class="btn btn-icon btn-delete btn-sm"
                                        v-if="item.is_delete" @click="deleteRow(item.id)">
                                        <i class="fa-solid fa-trash fs-4"></i>
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
                <base-pagination :pagination="pagination" @change-page="changePage" />
                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
        <!--end::Tables Widget 9-->
        <ContractTypeModal :type="dataUpdate" @close-model="getData()"></ContractTypeModal>
    </div>
</template>
<script setup>
import ContractTypeModal from "./CreateOrUpdateModal.vue";

import { reactive, ref, computed, watch, onBeforeMount } from "vue";
import { useContracTypeStore } from "../../../stores/contract";
import axios from "axios";
import { sweetAlertMessage } from '../../../helper/sweetAlert'
import { useToast } from '../../../helper/toastMessage'

const props = defineProps({
    btnAdd: {
        type: Boolean,
        default: false,
    }
})

const store = useContracTypeStore();

const dataUpdate = ref([]);

const searchData = reactive({
    search: ''
})

const contractTypes = computed(() => {
    return store.$state.types.data ? store.$state.types.data : [];
});

const pagination = computed(() => {
    return store.$state.types.meta
        ? store.$state.types.meta.pagination
        : { current_page: 1, total_pages: 1, per_page: 30 };
});

const changePage = (newData) => {
    getData(newData.current_page, newData.per_page);
};

const setDataUpdate = (data) => {
    dataUpdate.value = data;
    console.log(dataUpdate.value);
};

const clickCreate = () => {
    dataUpdate.value = {
        id: 0,
        code: "",
        name: "",
        note: "",
    };
};

const getData = (page = pagination.value.current_page, per_page = pagination.value.per_page, search = searchData) => {
    store.getContracTypeData(page, per_page, search);
    clickCreate();
};

const deleteRow = (id) => {
    sweetAlertMessage.messageWarning("Bạn có chắc chắn muốn xóa không?")
        .then((res) => {
            console.log(res);
            if (res.isConfirmed == true) {
                axios({
                    method: "DELETE",
                    url: "/contracts/types/api/" + id,
                })
                    .then((res) => {
                        console.log(res.data);
                        store.removeData(res.data.data);

                        useToast.successToast("Xóa bản ghi thành công!")
                    })
                    .catch((err) => {
                        console.log(err);
                        getData();
                    });
            }
        })
        .catch((err) => { });
};

onBeforeMount(() => {
    getData();
});
</script>
<style lang="scss"></style>
