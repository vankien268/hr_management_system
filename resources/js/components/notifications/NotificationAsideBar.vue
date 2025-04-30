<template>

  <div v-for="(item, index) in notifications"  :key="index">

                                        <!-- Hạn hợp đồng -->
                                        <div v-if="item.data.contracts" class="d-flex flex-stack py-4  mt-2"
                                            :style="!item.read_at ? 'background: #e1f3fd' : ''">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-35px me-4">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i
                                                            class="fa-solid fa-file-signature ki-abstract-28 fs-2 text-primary"></i>
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <div class="mb-0 me-2">
                                                    <span href="#" class="text-content text-gray-800 ">
                                                        Hợp đồng <b>{{ item.data.contracts.code }}</b>
                                                        thuộc dự án
                                                        <b>{{ item.data.contracts.project.name + '(' + item.data.contracts.project.code + ')' }}</b>
                                                        của khách hàng
                                                        <b>{{ item.data.contracts.customer.name + '(' +  item.data.contracts.customer.code + ')' }}</b>
                                                        sẽ hết hạn vào ngày
                                                        <b>{{ moment(item.data.contracts.expiration_date).format('DD/MM/YYYY')}}</b>
                                                    </span>
                                                    <br>
                                                    <div class="badge badge-light fs-8 my-2"
                                                       :style="!item.read_at ? 'background: #e1f3fd' : ''">
                                                        {{ moment(new Date(item.created_at)).format('HH:mm DD/MM/YYYY') }}</div>
                                                </div>
                                                <div class="badge badge-light fs-8 my-2"
                                                    :style="!item.read_at ? 'background: #e1f3fd' : ''"> <a
                                                        href="#" @click="()=>{
                                                    clickCreate(item.data.contracts.id, item.id);
                                                    setAction('view');
                                                }">Chi
                                                        tiết</a>
                                                </div>
                                            </div>

                                        </div>
                                    <!-- Thời gian dự kiến thanh toán hợp đồng -->

                                        <div v-if="item.data.payment_details"  class="  py-4 mt-2"
                                            :style="!item.read_at ? 'background: #e1f3fd' : ''">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-35px me-4">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i
                                                            class="fa-solid fa-file-signature ki-abstract-28 fs-2 text-primary"></i>
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <div class="mb-0 me-2">
                                                    <span href="#" class="text-content text-gray-800 ">
                                                        Lần thanh toán thứ
                                                        <b>{{ item.data.payment_details.payment_times }}</b>
                                                        hợp đồng <b>{{ item.data.payment_details.contract.code }}</b>
                                                        thuộc dự án
                                                        <b>{{ `${item.data.payment_details.contract.project.name}(${item.data.payment_details.contract.project.code})`  }}</b>
                                                        của khách hàng
                                                        <b>{{ item.data.payment_details.contract.customer.name + '(' +  item.data.payment_details.contract.customer.code + ')' }}</b>
                                                        sẽ hết hạn vào ngày
                                                        <b>{{ moment(item.data.payment_details.expected_payment_date).format('DD/MM/YYYY') }}</b>
                                                    </span>
                                                    <br>
                                                    <div class="badge badge-light fs-8 my-2"
                                                        :style="!item.read_at ? 'background: #e1f3fd' : ''">
                                                        {{ moment(new Date(item.created_at)).format('HH:mm DD/MM/YYYY') }}</div>

                                                </div>
                                                <div class="badge badge-light fs-8 my-2"
                                                  :style="!item.read_at ? 'background: #e1f3fd' : ''"> <a @click="()=>{
                                                    clickCreate(item.data.payment_details.contract.id, item.id);
                                                    setAction('view');
                                                }"
                                                        href="#">Chi
                                                        tiết</a>
                                                </div>
                                            </div>

                                        </div>

                                    <!-- Thời hạn biên bản nghiệm thu -->

                                        <div v-if="item.data.acceptance_records" class="d-flex flex-stack py-4 mt-2"
                                            :style="!item.read_at ? 'background: #e1f3fd' : ''">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-35px me-4">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i class="fa-solid fa-file-waveform fs-2 text-primary"></i>
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <div class="mb-0 me-2">
                                                    <span href="#" class="text-content text-gray-800 ">
                                                        <b>{{ `${item.data.acceptance_records.title}(${item.data.acceptance_records.code})` }}</b>
                                                        thuộc dự án
                                                        <b>{{ `${item.data.acceptance_records.project.name}(${item.data.acceptance_records.project.code})` }}</b>
                                                        sẽ hết hạn vào ngày
                                                        <b>{{ moment(item.data.acceptance_records.acceptance_date).add(item.data.acceptance_records.warranty_period, 'months').format('DD/MM/YYYY') }}</b>
                                                    </span>
                                                    <br>
                                                    <div class="badge badge-light fs-8 my-2"
                                                       :style="!item.read_at ? 'background: #e1f3fd' : ''">
                                                        {{ moment(new Date(item.created_at)).format('HH:mm DD/MM/YYYY') }}</div>
                                                </div>
                                                <div class="badge badge-light fs-8 my-2"
                                                   :style="!item.read_at ? 'background: #e1f3fd' : ''">
                                                    <a   @click="handleAcceptanceRecord(item.data.acceptance_records.id, item.id)"
                                        data-bs-target="#notificationAcceptanceRecordSideBar"
                                        data-bs-toggle="modal"
                                                        href="#">Chi
                                                        tiết</a>
                                                </div>
                                            </div>
                                        </div>

                                    <!-- Công văn, thông báo -->

                                        <div v-if="item.data.dispatches" class="flex-stack py-4 mt-2"
                                           :style="!item.read_at ? 'background: #e1f3fd' : ''">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-35px me-4">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i
                                                            class="fa-sharp fa-solid fa-file-invoice fs-2 text-primary"></i>
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <div class="mb-0 me-2">
                                                        <span v-if="item.data.dispatches.isTodate == true" href="#" class="text-content text-gray-800 ">
                                                            Công văn, thông báo:
                                                            <b>{{ `${item.data.dispatches.name}(${item.data.dispatches.code})` }}</b>
                                                            thuộc dự án
                                                            <b>{{ `${item.data.dispatches.project.name}(${item.data.dispatches.project.code})` }}</b>
                                                            của khách hàng
                                                            <b>{{ item.data.dispatches.customer.name + '(' + item.data.dispatches.customer.code + ')' }}</b>
                                                            sẽ hết hạn vào ngày
                                                            <b>{{ moment(new Date(item.data.dispatches.to_date)).format('DD/MM/YYYY') }}</b>
                                                        </span>
                                                        <span v-else href="#" class="text-content text-gray-800 ">
                                                            Công văn, thông báo:
                                                             <b>{{ `${item.data.dispatches.name}(${item.data.dispatches.code})` }}</b>
                                                            thuộc dự án
                                                            <b>{{ `${item.data.dispatches.project.name}(${item.data.dispatches.project.code})` }}</b>
                                                            của khách hàng
                                                            <b>{{ item.data.dispatches.customer.name + '(' + item.data.dispatches.customer.code + ')' }}</b>
                                                            bắt đầu có hiệu lực vào ngày
                                                            <b>{{ moment(new Date(item.data.dispatches.from_date)).format('DD/MM/YYYY')  }}</b>
                                                        </span>
                                                    <br>
                                                    <div class="badge badge-light fs-8 my-2"
                                                        :style="!item.read_at ? 'background: #e1f3fd' : ''">
                                                        {{ moment(new Date(item.created_at)).format('HH:mm DD/MM/YYYY') }}</div>

                                                </div>
                                                <div class="badge badge-light fs-8 my-2 "
                                                   :style="!item.read_at ? 'background: #e1f3fd' : ''"> <a
                                                        @click="handleNotificationDispatch(item.data.dispatches.id, item.id)" data-bs-target="#notificationDispatchSideBar"
                                        data-bs-toggle="modal"
                                                        href="#"  >

                                                        Chi tiết</a>

                                                </div>

                                            </div>
                                        </div>
  </div>

   <Teleport to="body">
    <contractForm
    :contractId="getContractId"
    :disabledEditContractFromNotification="disabledEditContractFromNotification"
            :contract="dataUpdate"
            :statuses="getStatuses"
            :types="getContractTypes"
            :action="modalAction"
              @close-model="closeModalContract"
            v-if="showModal"
    >
    </contractForm>
    <FormDispatch :idModal="'notificationDispatchSideBar'"
    :disabledEditDispatchFromNotification="disabledEditDispatchFromNotification"
     :dispatch-id="dispatchId">
    </FormDispatch>

    <FormAcceptance :idModal="'notificationAcceptanceRecordSideBar'"
    :disabledEditAcceptanceFromNotification="disabledEditAcceptanceFromNotification"
    :acceptanceId="acceptanceId"
    ></FormAcceptance>
   </Teleport>
</template>

<script setup>
import {defineProps, ref, onMounted, watch, reactive, computed } from 'vue'
import contractForm from '../contract/CreateOrUpdateModal.vue'
import FormDispatch from '../../components/dispatches/FormCreateOrUpdate.vue'
import FormAcceptance from '../acceptance-records/FormCreateOrUpdate.vue'
import axios from "axios";
import moment from 'moment';
import { useContractStore } from "../../stores/contract";

const contractStore = useContractStore();
const errorsNotification = ref([]);
const notifications = ref([]);
const getContractTypes = ref([]);
const getStatuses = ref([]);

const getAllNotifications = (params = null) => {
    KTApp.showPageLoading();
    axios({
                'url': '/notification/get-all',
                'method' : "GET",
                 params: params
            })
        .then((res) => {
            const { data, meta, contractTypes, statuses } = res.data;
            notifications.value = data;
            let stt = 0;
             notifications.value.forEach(item => {
                item.stt = stt;
                stt++;
                return item;
             })
             getContractTypes.value = contractTypes;
             getStatuses.value = statuses

    }).catch((error) => {
        errorsNotification.value = error.response.data?.errors;;
    }).finally(()=> {
          KTApp.hidePageLoading();
    });
}

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
const demoShow= ref(false)
const disabledEditAcceptanceFromNotification = ref(false);
const handleAcceptanceRecord = (getAcceptanceId, notificationId) => {
    acceptanceId.value = getAcceptanceId;
    disabledEditAcceptanceFromNotification.value = true;
    demoShow.value = true;
    updateSetReadNotification(notificationId)
}

const disabledEditContractFromNotification = ref(false);
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
const getContractId = ref(null)
const clickCreate = (contractId, notificationId) => {
    if(contractId !=null) {
         disabledEditContractFromNotification.value = true
         showModal.value = true
        getContractId.value = contractId;
          showContract(contractId).then(() => {
              contractStore.toggleShowModal(true);
         });
         updateSetReadNotification(notificationId)
    }
};

const setAction = (action) => {
    modalAction.value = action;
};
const showContract = (contractId) => {
  return new Promise((resolve, reject) => {
    KTApp.showPageLoading();
    axios({
      url: "/contracts/api/" + contractId,
      method: "GET",
    })
      .then((res) => {
        const { data } = res.data;
        dataUpdate.value = data;
        resolve(data); // Gọi resolve khi axios thành công
      })
      .catch((error) => {
        errorsNotification.value = error.response.data?.errors;
        reject(error); // Gọi reject khi axios gặp lỗi
      })
      .finally(() => {
        KTApp.hidePageLoading();
      });
  });
};
const updateSetReadNotification = (notificationId) => {
    axios({
      url: "/notification/read-notification/" + notificationId,
      method: "POST",
    })
      .then((res) => {
        const { data } = res.data;
         getAllNotifications();
      })
      .catch((error) => {
        console.log(error)
      })
};
const closeModalContract = () => {
     showModal.value = false
    // contractStore.toggleShowModal(false);
};
const dataDemo = computed(() => {
    return dataUpdate.value;
})
onMounted(() => {
    getAllNotifications()
})
</script>

<style>

</style>
