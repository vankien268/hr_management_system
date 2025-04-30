<template>
    <div class="card">
        <!--begin::Header-->
        <div class="d-flex align-items-center justify-content-between flex-wrap ms-7 pt-6">
            <div class="d-flex align-items-center flex-wrap col-xl-12 mb-1 justify-content-between">
                <div class="d-flex align-items-center me-1 flex-wrap w-auto mb-2" style="padding-left:2px;">
                    <div class="w-120px mx-1">
                        <label class="col-form-label" for="checkCreate" style="font-size:12px;">TG gửi cảnh báo</label>
                    </div>
                    <div class="me-1 w-125px">
                        <input type="date" :max="searchData.to_date_create" v-model="searchData.from_date_create"
                            class="form-control mb-lg-0 p-2 fs-6" id="fromDate"
                            placeholder="" />
                            <div v-if="errorsNotification['from_date_create']" :title="errorsNotification['from_date_create'] ? errorsNotification['from_date_create'][0] : ''"
                                style="width:150px;" class="text-danger pt-2">
                                {{ helperFunc.shortString(errorsNotification['from_date_create'][0], 17) }}
                            </div>
                    </div>
                    <div>
                        <label class="col-form-label">-</label>
                    </div>
                    <div class="ms-1 w-125px">
                        <input type="date" :min="searchData.from_date_create" v-model="searchData.to_date_create"
                            class="form-control mb-lg-0 p-2 fs-6" id="toDate" />
                             <div v-if="errorsNotification['to_date_create']" :title="errorsNotification['to_date_create'] ? errorsNotification['to_date_create'][0] : ''"
                                style="width:150px;" class="text-danger pt-2">
                                {{ helperFunc.shortString(errorsNotification['to_date_create'][0], 17) }}
                            </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto me-4 mb-2">
                        <div class="w-50px">
                            <label for="customerCode" class="col-form-label" style="font-size:12px;">Dự án</label>
                        </div>
                        <div class="w-120px">
                            <SelectSearch
                                style="width: 170px;"
                                :list-data="getProjects"
                                v-model="searchData.project_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto me-4 mb-2">
                        <div class="w-85px">
                            <label for="customerCode" class="col-form-label" style="font-size:12px;">Khách hàng</label>
                        </div>
                        <div class="w-120px">
                            <SelectSearch
                                style="width: 170px;"
                                :list-data="getCustomers"
                                v-model="searchData.customer_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto me-4 mb-2">
                        <div class="w-120px">
                            <label for="customerCode" class="col-form-label" style="font-size:12px;">Công văn/thông báo</label>
                        </div>
                        <div class="w-120px">
                            <SelectSearch
                                style="width: 170px;"
                                :list-data="dispatches"
                                v-model="searchData.dispatch_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center me-1 flex-wrap w-auto" >
                    <div class="w-100px mx-1 me-2">
                        <label class="col-form-label" for="checkCreate" style="font-size:12px;">Ngày đến hạn</label>
                    </div>
                    <div class="me-1 w-125px">
                        <input type="date" :max="searchData.to_date_expiration" v-model="searchData.from_date_expiration"
                            class="form-control mb-lg-0 p-2 fs-6" id="fromDate"
                            placeholder="" />

                             <div v-if="errorsNotification['from_date_expiration']" :title="errorsNotification['from_date_expiration'] ? errorsNotification['from_date_expiration'][0] : ''"
                                style="width:150px;" class="text-danger pt-2">
                                {{ helperFunc.shortString(errorsNotification['from_date_expiration'][0], 17) }}
                            </div>

                    </div>
                    <div>
                        <label class="col-form-label">-</label>
                    </div>
                    <div class="ms-1 w-125px">
                        <input type="date" :min="searchData.from_date_expiration" v-model="searchData.to_date_expiration"
                            class="form-control mb-lg-0 p-2 fs-6" id="toDate" />
                        <div v-if="errorsNotification['to_date_expiration']" :title="errorsNotification['to_date_expiration'] ? errorsNotification['to_date_expiration'][0] : ''"
                                style="width:150px;" class="text-danger pt-2">
                                {{ helperFunc.shortString(errorsNotification['to_date_expiration'][0], 17) }}
                            </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto me-4 mb-2">
                        <div class="w-50px">
                            <label for="customerCode" class="col-form-label" style="font-size:12px;">Hợp đồng</label>
                        </div>
                        <div class="w-120px">
                            <!-- {{ getContracts }} -->
                            <SelectSearch
                                style="width: 170px;"
                                :list-data="getContracts"
                                v-model="searchData.contract_code"
                                placeholder="Tất cả"
                                key-value="code"
                                key-display="code"
                            />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto me-4 mb-2">
                        <div class="w-85px">
                            <label for="customerCode" class="col-form-label" style="font-size:12px;">Trạng thái</label>
                        </div>
                        <div class="w-100px">
                            <select
                                    style="height: 29px"
                                    class="form-select"
                                    placeholder="Tất cả"
                                    v-model="searchData.status_read"
                                    aria-label="Default select example"
                                >
                                <option :value="null">Tất cả</option>
                                    <option :value="true">Đã đọc</option>
                                    <option :value="false">Chưa đọc</option>
                                </select>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto me-4 mb-2">
                        <div class="w-100px">
                            <label for="customerCode" class="col-form-label" style="font-size:12px;">BB nghiệm thu</label>
                        </div>
                        <div class="w-120px">
                            <SelectSearch
                                style="width: 170px;"
                                :list-data="acceptances"
                                v-model="searchData.acceptance_record_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="title"
                            />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto me-4 mb-2">
                        <a @click="handleSearch" tabindex="0" href="#" class="btn btn-function">
                            <i class="fa-solid fa-search"></i>Tìm kiếm</a>
                    </div>
                </div>

        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3 text-nowrap">
            <!--begin::Table container-->
            <div class="table-responsive table-scroll tableFixHead">
                <!--begin::Table-->
                <table class="table table-row-dashed table-bordered table-sm table-data" cellspacing="0"
                        cellpadding="0" border="0" width="325" id="tableid">
                    <!--begin::Table head-->
                    <thead class="fs-6 text-gray-400">
                    <tr class="fw-bold text-muted">
                        <th style="width:10px;text-align:center" >STT</th>

                        <th style="width:50px;">Thời gian gửi cảnh báo </th>
                        <th style="width:80px;">Ngày đến hạn</th>
                        <th style="width:400px;">Nội dung cảnh báo</th>
                        <th style="width:50px;" class="text-center">Chi tiết</th>
                        <th style="width:80px;">Trạng thái</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody v-for="(item, index) in notifications"  :key="index">

                            <!-- Biên bản nghiệm thu -->
                            <tr v-if="item.data.acceptance_records" >
                                <td style="text-align:center;width:10px;">
                                    <span class="text-dark  break-text d-block">{{ (pagination.per_page)*(pagination.current_page - 1) + (item.stt + 1) }}</span>
                                </td>
                                <td style="width:50px;" class="break-text">
                                    {{ moment(new Date(item.created_at)).format('HH:mm DD/MM/YYYY') }}
                                </td>
                                <td >
                                    <span class="text-dark d-block mb-1 break-text text-content"
                                    >{{ moment(item.data.acceptance_records.acceptance_date).add(item.data.acceptance_records.warranty_period, 'months').format('DD/MM/YYYY') }}
                                    </span>
                                </td>

                                <td >
                                    <span class="text-dark d-block break-text text-wrap"
                                    ><b>{{ `${item.data.acceptance_records.title}(${item.data.acceptance_records.code})` }}</b>
                                     thuộc dự án <b>{{ `${item.data.acceptance_records.project.name}(${item.data.acceptance_records.project.code})` }}</b>
                                        sẽ hết hạn vào ngày <b>{{ moment(item.data.acceptance_records.acceptance_date).add(item.data.acceptance_records.warranty_period, 'months').format('DD/MM/YYYY') }}</b>
                                    </span>
                                </td>
                                <td >
                                    <div  class="text-red d-block mb-3 break-text d-block text-center"

                                    >
                                        <!-- <a
                                         class="btn btn-icon btn-edit btn-color-primary btn-sm"
                                        :href="`${'/acceptance-records?id='+item.data.acceptance_records.id+'&notification_id='+item.id}`">


                                        </a> -->
                                         <a href="" class="btn btn-icon btn-edit btn-color-primary btn-sm"
                                         @click="handleAcceptanceRecord(item.data.acceptance_records.id, item.id)"
                                        data-bs-target="#notificationAcceptanceRecordInList"
                                        data-bs-toggle="modal"><i
                                            class="fa-solid fa-circle-info mt-3 fs-2"
                                        ></i></a>
                                    </div>
                                </td>

                                <td class="w-50px text-content">
                                    <span>{{ item.read_at!= null ? 'Đã đọc' :'Chưa đọc'  }}</span>
                                </td>
                            </tr>

                            <!-- Công văn, thông báo -->
                             <tr v-if="item.data.dispatches" >
                                <td style="text-align:center;width:20px;" >
                                    <span class="text-dark break-text d-block">{{ (pagination.per_page)*(pagination.current_page - 1) + (item.stt + 1) }}</span>
                                </td>
                                <td style="width:50px;" class="break-text">
                                    {{ moment(new Date(item.created_at)).format('HH:mm DD/MM/YYYY') }}
                                </td>
                                <td >
                                    <span v-if="item.data.dispatches.isTodate == true" class="text-dark d-block mb-1 break-text text-content"
                                    >{{ moment(new Date(item.data.dispatches.to_date)).format('DD/MM/YYYY') }}</span>

                                    <span v-else class="text-dark d-block mb-1 break-text text-content"
                                    >{{ moment(new Date(item.data.dispatches.from_date)).format('DD/MM/YYYY') }}</span>
                                </td>

                                <td  >
                                    <span class="text-dark d-block break-text text-wrap"
                                    ><b>Công văn, thông báo: {{ `${item.data.dispatches.name}(${item.data.dispatches.code})` }}</b> thuộc dự án <b>
                                        {{ `${item.data.dispatches.project.name}(${item.data.dispatches.project.code})` }}</b>
                                    </span>
                                    <span v-if="item.data.dispatches.isTodate == true">
                                        sẽ hết hạn vào ngày <b>{{ moment(new Date(item.data.dispatches.to_date)).format('DD/MM/YYYY') }}</b>
                                    </span>

                                     <span v-else class="text-dark d-block mb-1 break-text text-content"
                                    >bắt đầu có hiệu lực vào ngày <b>{{ moment(new Date(item.data.dispatches.from_date)).format('DD/MM/YYYY') }}</b></span>
                                </td>
                                <td >
                                      <!-- :href="`${'/dispatches?id='+item.data.dispatches.id+'&notification_id='+item.id+'&code='+item.data.dispatches.project.code}`" -->
                                    <div  class="text-red text-hover-primary d-block mb-3 break-text d-block text-center"
                                        >
                                        <a @click="handleNotificationDispatch(item.data.dispatches.id, item.id)" data-bs-target="#notificationDispatchInList"
                                        data-bs-toggle="modal"
                                         class="btn btn-icon btn-edit btn-color-primary btn-sm"
                                       >
                                            <i
                                                class="fa-solid fa-circle-info mt-3 fs-2"
                                            ></i>

                                            </a>

                                        </div>
                                </td>

                                <td class="w-50px text-content">
                                    <span>{{ item.read_at !=null? 'Đã đọc' : 'Chưa đọc' }}</span>
                                </td>
                            </tr>

                            <!-- Hết hạn hợp đồng -->
                             <tr v-if="item.data.contracts">
                                <td style="text-align:center; width:20px;">
                                    <span class="text-dark break-text d-block">{{ (pagination.per_page)*(pagination.current_page - 1) + (item.stt + 1) }}</span>
                                </td>
                                <td style="width:50px;" class="break-text">
                                    {{ moment(new Date(item.created_at)).format('HH:mm DD/MM/YYYY') }}
                                </td>
                                <td >
                                    <span class="text-dark  d-block mb-1 break-text text-content"
                                    >{{ moment(new Date(item.data.contracts.expiration_date)).format('DD/MM/YYYY') }}</span>
                                </td>

                                <td  >
                                    <span class="text-dark d-block break-text text-wrap "

                                    >Hợp đồng <b>{{ `${item.data.contracts.code}` }}</b> thuộc dự án <b>{{ `${item.data.contracts.project.name}
                                        (${item.data.contracts.project.code})` }}</b>
                                    của khách hàng <b>{{ item.data.contracts.customer.name + '(' +  item.data.contracts.customer.code + ')' }}</b>
                                        sẽ hết hạn vào ngày <b>{{ moment(item.data.contracts.expiration_date).format('DD/MM/YYYY') }}</b>
                                    </span>
                                </td>
                                <td >
                                    <div  class="text-red text-hover-primary d-block mb-3 break-text d-block text-center"
                                        >
                                        <!-- <a
                                         class="btn btn-icon btn-edit btn-color-primary btn-sm"
                                        :href="`${'/contracts?code='+item.data.contracts.code+'&notification_id='+item.id}`">
                                            <i
                                                class="fa-solid fa-circle-info mt-3 fs-2"
                                            ></i>

                                            </a> -->
                                              <a href="#" class="btn btn-icon btn-edit btn-color-primary btn-sm"  @click="()=>{
                                                    clickCreate(item.data.contracts.id, item.id);
                                                    setAction('view');
                                                }"><i
                                            class="fa-solid fa-circle-info mt-3 fs-2"
                                        ></i></a>
                                        </div>
                                </td>

                                <td class="w-50px text-content">
                                    <span>{{ item.read_at !=null? 'Đã đọc' : 'Chưa đọc' }}</span>
                                </td>
                            </tr>

                            <!-- Thời gian dự kiến thanh toán hợp đồng -->
                             <tr v-if="item.data.payment_details">
                                <td style="text-align:center; width:20px;">
                                    <span class="text-dark break-text d-block">{{ (pagination.per_page)*(pagination.current_page - 1) + (item.stt + 1) }}</span>
                                </td>
                                <td style="width:50px;" class="break-text">
                                    {{ moment(new Date(item.created_at)).format('HH:mm DD/MM/YYYY') }}
                                </td>
                                <td >
                                    <span class="text-dark   d-block mb-1 break-text text-content"
                                    >{{ moment(item.data.payment_details.expected_payment_date).format('DD/MM/YYYY') }}</span>
                                </td>

                                <td >
                                    <span class="text-dark d-block break-text text-wrap"

                                    > Lần thanh toán thứ  <b>{{ item.data.payment_details.payment_times }}</b>
                                       hợp đồng <b>{{ `${item.data.payment_details.contract.code}` }}</b> thuộc dự án <b>

                                        {{ `${item.data.payment_details.contract.project.name}(${item.data.payment_details.contract.project.code})` }}</b>
                                    của khách hàng <b>{{ item.data.payment_details.contract.customer.name + '(' +  item.data.payment_details.contract.customer.code + ')' }}</b>
                                        sẽ hết hạn vào ngày <b>{{ moment(item.data.payment_details.expected_payment_date).format('DD/MM/YYYY') }}</b>
                                    </span>
                                </td>
                                <td >
                                    <div  class="text-red text-hover-primary  d-block mb-3 break-text d-block text-center"
                                        >
                                        <!-- <a  class="btn btn-icon btn-edit btn-color-primary btn-sm"
                                         :href="`${'/contracts?code='+item.data.payment_details.contract.code+'&notification_id='+item.id}`">
                                            <i
                                                class="fa-solid fa-circle-info mt-3 fs-2"
                                            ></i>

                                            </a> -->
                                               <a href="#" class="btn btn-icon btn-edit btn-color-primary btn-sm"  @click="()=>{
                                                    clickCreate(item.data.payment_details.contract.id, item.id);
                                                    setAction('view');
                                                }"><i
                                            class="fa-solid fa-circle-info mt-3 fs-2"
                                        ></i></a>
                                        </div>
                                </td>

                                <td class="w-50px text-content">
                                    <span>{{ item.read_at !=null? 'Đã đọc' : 'Chưa đọc' }}</span>
                                </td>
                            </tr>

                    </tbody>
                    <tbody v-if="notifications.length == 0">
                                                <tr>
                                                    <td class="text-center" colspan="6">
                                                        Không có dữ liệu hiển thị
                                                    </td>
                                                </tr>
                                            </tbody>
                </table>
                <!--end::Table-->
            </div>
               <base-pagination
                :pagination="pagination"
                @change-page="changePage"
            />
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
    <contractForm
    :contractId="getContractId"
    :disabledEditContractFromNotification="disabledEditContractFromNotification"
            :contract="dataUpdateContract"
             :statuses="getStatuses"
            :types="getContractTypes"
            :action="modalAction"
            @close-model="closeModalContract"
            v-if="showModal"
    >
    </contractForm>
    <FormDispatch :idModal="'notificationDispatchInList'"
     :disabledEditDispatchFromNotification="disabledEditDispatchFromNotification"
    :dispatch-id="dispatchId">
    </FormDispatch>

    <FormAcceptance :idModal="'notificationAcceptanceRecordInList'"
    @updateAcceptanceId="updateAcceptanceId"
     :disabledEditAcceptanceFromNotification="disabledEditAcceptanceFromNotification"
    :acceptanceId="acceptanceId"
    ></FormAcceptance>
</template>
<script setup>
import {defineProps, ref, onMounted, watch, reactive, computed } from 'vue'
import { helperFunc } from '../../helper/heplerFunction.js'
import axios from "axios";
import moment from 'moment';
import { useCustomerStore } from "../../stores/customer";
import { useContractStore } from "../../stores/contract";
import { useStoreProjects } from "../../stores/project";
import SelectSearch from "../input/SelectSearch.vue";
import contractForm from '../contract/CreateOrUpdateModal.vue'
import FormDispatch from '../../components/dispatches/FormCreateOrUpdate.vue'
import FormAcceptance from '../acceptance-records/FormCreateOrUpdate.vue'

const props = defineProps({
    title: String,
    btnAdd: {
        type: Boolean,
        default: false,
    },
     statuses: {
        type: Array,
        default: [],
    },
    types: {
        type: Array,
        default: []
    }
})

// Xem chi tiết công văn, thông báo
const dispatchId = ref(null);
const disabledEditDispatchFromNotification = ref(false);
const handleNotificationDispatch =(getDispatchId, notificationId) => {
    dispatchId.value = getDispatchId;
    disabledEditDispatchFromNotification.value = true;
    updateSetReadNotification(notificationId)
}
const acceptanceId = ref(null)
// Xem chi tiết biên bản nghiệm thu
const disabledEditAcceptanceFromNotification = ref(false);
const demoShow= ref(false)
const handleAcceptanceRecord = (getAcceptanceId, notificationId) => {
    acceptanceId.value = getAcceptanceId;
    disabledEditAcceptanceFromNotification.value = true;
    demoShow.value = true
    updateSetReadNotification(notificationId)
}
const updateAcceptanceId=() => {
    acceptanceId.value = null;
    console.log( acceptanceId.value )
}

const disabledEditContractFromNotification = ref(false);
// const showModal = computed(() => {
//     disabledEditContractFromNotification.value = true
//     return contractStore.$state.showModal ?? false;;
// });
const showModal = ref(false)

const modalAction= ref('create')
const dataUpdate = ref({
    id: 0,
    code: "",
    contract_type_id: null,
    contract_value: "",
    customer_contractor: "",
    customer_id: null,
    expiration_date: null,
    hand_over_date: null,
    note: "",
    number_payment: 1,
    project_id: null,
    signing_date: null,
    start_date: null,
    status_id: null,
    user_contractor_id: null,
    user_charge_id: null,
    warranty_time: null,
    annex_contracts: {
        data: [],
    },
    contract_modules: {
        data: [],
    },
    payment_details: {
        data: [],
    },
});

const setAction = (action) => {
    console.log(action, 'view action')
    modalAction.value = action;
};
const getContractTypes = ref([]);
const getStatuses = ref([]);
const showContract = (contractId) => {
  return new Promise((resolve, reject) => {
    KTApp.showPageLoading();
    axios({
      url: "/contracts/api/" + contractId,
      method: "GET",
    })
      .then((res) => {
        const { data, meta, contractTypes, statuses } = res.data;
        dataUpdate.value = data;
           getContractTypes.value = contractTypes;
             getStatuses.value = statuses
        resolve(data); // Gọi resolve khi axios thành công
      })
      .catch((error) => {
        console.log('error')
        errorsNotification.value = error.response.data?.errors;
        reject(error); // Gọi reject khi axios gặp lỗi
      })
      .finally(() => {
        KTApp.hidePageLoading();
      });
  });
};
const getContractId = ref(null)
const clickCreate = (contractId, notificationId) => {
    if(contractId) {
         showModal.value = true
         disabledEditContractFromNotification.value = true
        getContractId.value = contractId
        showContract(contractId).then(() => {
        contractStore.toggleShowModal(true);
     });
     updateSetReadNotification(notificationId)
    }

};

const dataUpdateContract = computed(() => {
    return dataUpdate.value;
})
const closeModalContract = () => {
    // clickCreate(false);
     showModal.value = false;
    // contractStore.toggleShowModal(false);
};
const updateSetReadNotification = (notificationId) => {
    axios({
      url: "/notification/read-notification/" + notificationId,
      method: "POST",
    })
      .then((res) => {
        const { notification } = res.data;
        //  getAllNotifications();
        const index = notifications.value.findIndex((item) => item.id == notification.id);
        if(index != -1) {
            notifications.value[index] = notification;
        }
        
      })
      .catch((error) => {
        console.log(error)
      })
};
const storeCustomer = useCustomerStore();
const projectStore = useStoreProjects();
const contractStore = useContractStore();
const errorsNotification = ref([]);
const notifications = ref([]);
const getMetaPaginate = ref({});

const getAllNotifications = (params = null) => {
    KTApp.showPageLoading();
    axios({
                'url': '/notification/get-all',
                'method' : "GET",
                 params: params
            })
        .then((res) => {
            const { data, meta } = res.data;
            notifications.value = data;
            let stt = 0;
             notifications.value.forEach(item => {
                item.stt = stt;
                stt++;
                return item;
             })
             errorsNotification.value = []
            getMetaPaginate.value = meta

    }).catch((error) => {
        errorsNotification.value = error.response.data?.errors;;
    }).finally(()=> {
          KTApp.hidePageLoading();
    });
}
// Biên bản nghiệm thu
const acceptances = ref([])
const getAcceptances = (params = {getAll: true}) => {
    axios({
        url: "/acceptance-records/get-all",
        method: "GET",
        params: {
            ...params,
        }
    })
        .then((res) => {
            const { data, meta } = res.data;
            acceptances.value = data;
        })
        .catch((error) => {
            console.log(error);
        });

};
// Công văn, thông báo
const dispatches = ref([])
const getDispatches = (params = {getAll: true}) => {
    axios({
        url: "/dispatches/get-all",
        method: "GET",
        params: {
            ...params,
        }
    })
        .then((res) => {
            const { data, meta } = res.data;
            dispatches.value = data;
            console.log(dispatches.value, 'aaa')
        })
        .catch((error) => {
            console.log(error);
        });

};

const pagination = computed(() => {
    return getMetaPaginate.value?.pagination
        ? getMetaPaginate.value.pagination
        : { current_page: 1, total_pages: 1, per_page: 30 };
});

const searchData = reactive({
    from_date_create: null,
    to_date_create: null,
    project_id: null,
    customer_id: null,
    dispatch_id: null,
    from_date_expiration: null,
    to_date_expiration: null,
    contract_code: null,
    status_read: null,
    acceptance_record_id: null
});

const changePage = (newDataPagination) => {
    let requestPaginate = {
        page: newDataPagination.current_page,
        per_page: newDataPagination.per_page,
    };
    requestPaginate = { ...requestPaginate, ...searchData };
    getAllNotifications(requestPaginate);
};

onMounted(() => {
    getAllNotifications(),
    storeCustomer.getData(1, 30, { getAll: true });
    projectStore.getAllProjectsData({getAll:true})
    contractStore.getContractData(1, 30, {getAll:true})
    getAcceptances();
    getDispatches();
})

const getCustomers = computed(() => {
    return storeCustomer.customers?.data;
});

const getProjects = computed(() => {
    if (projectStore.$state.projects.data) {

    } else {
        return projectStore.$state.projects;
    }
});


const getContracts = computed(() => {
    return contractStore.contracts?.data;
});
const handleSearch = () => {
    getAllNotifications(searchData)
}
</script>

<style scoped>
.tableFixHead{
    overflow: auto; height: 590px;
}
.tableFixHead thead th {
    position: sticky; top: 0; z-index: 1;
}

table  { border-collapse: collapse; width: 100%; }
</style>
