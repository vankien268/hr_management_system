<template>
    <div class="col-xxl-12 col-xl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch pt-5">
            <!--begin::Header-->
            <div
                class="d-flex align-items-center justify-content-between flex-wrap ms-5"
            >
                <div class="d-flex align-items-center flex-wrap ms-3 mb-4">
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-2"
                    >
                        <div
                            class="d-flex align-items-center flex-wrap w-auto me-6"
                        >
                            <div class="w-auto">
                                <label class="col-form-label" for="checkCreate"
                                    >Ngày thanh toán</label
                                >
                            </div>
                            <div class="w-125px ms-5 me-2">
                                <input
                                    type="date"
                                    class="form-control mb-lg-0 p-2"
                                    id="fromDate"
                                    placeholder=""
                                    v-model="expected_payment_from_date"
                                    :max="expected_payment_to_date"
                                />
                            </div>
                            <div class="w-125px ms-5">
                                <input
                                    type="date"
                                    class="form-control mb-lg-0 p-2 ms-2"
                                    id="toDate"
                                    v-model="expected_payment_to_date"
                                    :min="expected_payment_from_date"
                                />
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-6"
                    >
                        <div class="d-flex align-items-center flex-wrap w-auto">
                            <div class="w-auto me-3">
                            <label for="customerCode" class="col-form-label"
                                >Dự án</label
                            >
                        </div>
                        <div class="w-150px pro-pro-set">
                            <SelectSearch
                                :list-data="projects"
                                v-model="project_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto">
                        <div class="w-auto me-3">
                            <label for="customerCode" class="col-form-label"
                                >Hợp đồng</label
                            >
                        </div>
                        <div class="w-150px pro-con-set">
                            <SelectSearch
                                :list-data="contracts"
                                v-model="contract_id"
                                placeholder="Tất cả"
                                key-value="code"
                                key-display="code"
                            />
                        </div>
                    </div>
                    <a
                    style="margin-left: 220px!important;"
                        href="#"
                        class="btn btn-sm btn-icon-bg-primary btn-color-light ms-16"
                        @click="clickSearch"
                    >
                        Tìm kiếm
                    </a>
                    <!-- <a
                        href="#"
                        class="btn btn-sm btn-icon-bg-primary btn-color-light ms-4"
                        @click="clickSearch"
                    >
                        In
                    </a>
                    <a
                        href="#"
                        class="btn btn-sm btn-icon-bg-primary btn-color-light ms-4"
                        @click="clickSearch"
                    >
                        Xuất Excel
                    </a> -->
                </div>
            </div>

            <div class="card-body py-3 pt-0">
                <!--begin::Table container-->
                <div class="header-record mb-10 row col-12">
                    <div class="border-report"></div>
                    <div class="col-5 row pt-1">
                        <div
                            class="col-2"
                            style="padding-right: 0px !important"
                        >
                            <img
                                src="https://newwaypms.com/skins/news/images/logo_mobile.png"
                                alt=""
                                width="100%"
                            />
                        </div>
                        <div class="col-10">
                            <p class="pb-1 text-header">
                                Công ty cổ phần giải pháp công nghệ Newway
                            </p>
                            <p class="text-header">
                                74 Hồ Đền Lừ, Hoàng Mai, Hà Nội
                            </p>
                        </div>
                    </div>
                    <div class="col-5 pay-pro-set">
                        <p
                            style="margin-right: 115px !important"
                            class="text-title"
                        >
                            BÁO CÁO CHI TIẾT DOANH THU DỰ ÁN
                        </p>
                        <p v-if="expected_payment_from_date == '' && expected_payment_to_date == ''"  class="text-date"></p>
                        <p v-else-if="expected_payment_from_date == ''"  class="text-date">Ngày: {{moment(new Date(expected_payment_to_date)).format('DD/MM/YYYY')}}</p>
                        <p v-else-if="expected_payment_to_date == ''"  class="text-date">Ngày: {{moment(new Date(expected_payment_from_date)).format('DD/MM/YYYY')}}</p>
                        <p v-else-if="expected_payment_from_date != '' && expected_payment_to_date != ''" class="text-date">Ngày: {{moment(new Date(expected_payment_from_date)).format('DD/MM/YYYY')}} - {{moment(new Date(expected_payment_to_date)).format('DD/MM/YYYY')}}</p>
                    </div>
                    <div class="col-2 pt-1 p-0">
                        <p class="float-right">
                             Ngày in: {{time}}
                            <br />
                            Người in: {{ props.name}}
                        </p>
                    </div>
                </div>
                <div class="table-responsive table-scroll h-77vh text-nowrap">
                    <!--begin::Table-->
                    <table
                        class="table table-row-dashed table-bordered table-sm table-data"
                        cellspacing="0"
                        cellpadding="0"
                        border="0"
                        width="325"
                        id="tableid"
                    >
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fs-6 text-gray-400">
                                <th class="w-15px">STT</th>
                                <th class="w-200px">NGÀY THANH TOÁN</th>
                                <th class="w-200px">DOANH THU THUẦN</th>
                                <th class="w-150px">THUẾ SUẤT</th>
                                <th class="w-150px">PHÍ DỊCH VỤ</th>
                                <th class="w-150px">
                                    DOANH THU
                                </th>
                                <th class="w-150px">GHI CHÚ</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody
                            v-for="(dispatchReport, key) in dispatchReports"
                            :key="key"
                            class="max-h-75 overflow-auto cursor-pointer"
                        >
                            <tr class="max-h-75 overflow-auto cursor-pointer">
                                <td
                                    class="h-40px fw-medium pointer-events-none"
                                    style="
                                        background-color: rgb(243, 237, 179);
                                        font-size: 14px;
                                        padding-left: 3rem;
                                    "
                                    colspan="7"
                                >
                                    <p class="pt-1 pb-1">
                                        {{ dispatchReport.project.data.code }} -
                                        {{ dispatchReport.project.data.name }}
                                    </p>
                                    <p class="pb-1">
                                        {{
                                            dispatchReport.customer.data.code
                                        }}
                                        -
                                        {{ dispatchReport.customer.data.name }}
                                    </p>
                                </td>
                            </tr>
                            <tr class="max-h-75 overflow-auto cursor-pointer">
                                <td>
                                    {{ key + 1 }}
                                </td>
                                <td
                                    class="h-40px fw-medium pointer-events-none"
                                    style="
                                        font-size: 14px;
                                        padding-left: 3rem;
                                    "
                                    colspan="6"
                                >
                                    <p class="pt-1 pb-1">
                                        Ngày kí:
                                        {{ dispatchReport.signing_date }}
                                    </p>
                                    <p class="pb-1">
                                        Số hợp đồng: {{ dispatchReport.code }}
                                    </p>
                                </td>
                            </tr>
                            <tr
                                v-for="(
                                    val_payment_details, key_payment_details
                                ) in dispatchReport.payment_details.data"
                                :key="key_payment_details"
                            >
                                <td>
                                    <span
                                        class="text-dark d-block text-hover-primary w-15px fs-6"
                                    >
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                        :title="
                                            val_payment_details.payment_date
                                        "
                                        >{{ val_payment_details.payment_date }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-200px break-text pb-1 mt-1"
                                        :title="
                                            val_payment_details.actual_amount
                                        "
                                        >{{
                                            displayPrice(val_payment_details.actual_amount)
                                        }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-150px break-text pb-1 mt-1"

                                    >
                                        0
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-150px break-text"

                                        >0
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-150px break-text pb-1 mt-1"
                                        :title="
                                            val_payment_details.actual_amount
                                        "
                                        >{{
                                            displayPrice(val_payment_details.actual_amount)
                                        }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-150px break-text pb-1 mt-1"
                                        :title="val_payment_details.note"
                                        >{{ val_payment_details.note }}</span
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-200px break-text pb-1 mt-1"
                                    >
                                        Tổng doanh thu hợp đồng
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-200px break-text pb-1 mt-1"
                                    >
                                    {{ displayPrice( total_actual_amount(dispatchReport.payment_details.data)) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span
                                        class="text-dark text-hover-primary d-block text-content break-text pb-1 mt-1"
                                    >
                                    0
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span
                                        class="text-dark text-hover-primary d-block text-content break-text pb-1 mt-1"
                                    >
                                        0
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span
                                        class="text-dark text-hover-primary d-block text-content break-text pb-1 mt-1"
                                    >
                                    {{
                                            displayPrice(
                                                total_actual_amount(
                                                    dispatchReport
                                                        .payment_details.data
                                                )
                                            )
                                        }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span
                                        class="text-dark text-hover-primary d-block text-content break-text pb-1 mt-1"
                                    >

                                    </span>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-if="Object.keys(dispatchReports).length == 0">
                            <tr>
                                <td class="text-center" colspan="12">
                                    Không có dữ liệu hiển thị
                                </td>
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <div class="total-report mt-3">
                    <div class="col-12 row mt-2">
                        <span class="text-end">Trang {{ pagination.current_page}}/{{ pagination.total_pages }}</span>
                    </div>
                    <div class="row col-12 mt-5 mb-10">
                        <div class="col-1"></div>
                        <div class="col-9">Người lập biểu</div>
                        <div class="col-2">Trưởng bộ phận</div>
                    </div>
                </div>

                <base-pagination
                    :pagination="pagination"
                    @change-page="changePage"
                />

                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
    </div>
</template>
<script setup>
import {
    defineProps,
    ref,
    toRef,
    computed,
    watch,
    onBeforeMount,
    reactive,
    onMounted,
} from "vue";
import { displayPrice } from "../../../../services/utils";
import { helperFunc } from "../../../helper/heplerFunction";
// import { useCustomerStore } from "../../stores/customer";
// import { destroy } from "../../helper/axiosConfig";
import moment from "moment";
// import { useToast } from "../../helper/toastMessage";
// import { sweetAlertMessage } from "../../helper/sweetAlert";
// import { textCode, validateInput } from "../../../services/utils";
import SelectSearch from "../../input/SelectSearch.vue";
const props = defineProps({
    title: String,
    name: {
        type: String,
        default: 'user'
    }
});

const time = ref('');
const today = new Date();
const date = today.getDate()+'/'+('0' + (today.getMonth()+1)).slice(-2)+'/'+today.getFullYear();
const getTime = () => {
    var currentTimeDate = new Date();
    var dates = currentTimeDate.getDate();
    var months = currentTimeDate.getMonth()+1;
    var years = currentTimeDate.getFullYear();
    var hours   =  currentTimeDate.getHours();
    var minutes = currentTimeDate.getMinutes();
    var seconds = currentTimeDate.getSeconds();

    hours = hours < 10 ? '0' + hours : hours;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;
    dates = dates < 10 ? '0' + dates : dates;
    months = months < 10 ? '0' + months : months;


    time.value = dates + '/' + months + '/' + years + ' ' + hours + ':' + minutes + ':' + seconds;
}

const expected_payment_from_date = ref(moment().format('YYYY-MM-DD'));
const expected_payment_to_date = ref(moment().format('YYYY-MM-DD'));
const project_id = ref("");
const contract_id = ref("");
const status_id = ref("");

const searchData = reactive({
    expected_payment_from_date: "",
    expected_payment_to_date: "",
    project_id: "",
    contract_id: "",
    status_id: "",
});

const clickSearch = () => {
    searchData.expected_payment_from_date = expected_payment_from_date.value;
    searchData.expected_payment_to_date = expected_payment_to_date.value;
    searchData.project_id = project_id.value;
    searchData.contract_id = contract_id.value;
    searchData.status_id = status_id.value;
    pagination.value.current_page = 1;
    getDispatchReports(searchData);
};

// handle chọn số bản ghi / 1 trang

const currentIndex = ref(-1);

let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};
const dispatchReports = ref([]);
let getMetaPaginate = ref({});

const getDispatchReports = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/reports/payment-detail-projects/get-all",
        method: "GET",
        params: {
            ...params,
            per_page: selectTotalRecord.value,
            page: pagination.value.current_page,
        },
    })
        .then((res) => {
            const { data, meta } = res.data;
            if(searchData.expected_payment_from_date == "" || searchData.expected_payment_to_date == "") {
                dispatchReports.value = data;
            }
            else {
                dispatchReports.value = data.filter(item => {
                return item.payment_details.data.length > 0;
            })};
            getMetaPaginate.value = meta;
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};
const projects = ref([]);
const contracts = ref([]);
const systemStatus = ref([]);
const getOther = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/reports/payment-detail-projects/getOther",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data } = res;
            projects.value = data.getProjects;
            contracts.value = data.getContracts;
            systemStatus.value = data.getSystemStatuses;
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};

const pagination = computed(() => {
    return getMetaPaginate.value?.pagination
        ? getMetaPaginate.value.pagination
        : { current_page: 1, total_pages: 1, per_page: 30 };
});

const changePage = (newDataPagination) => {
    const requestPaginate = {
        page: newDataPagination.current_page,
        per_page: newDataPagination.per_page,
    };
    selectTotalRecord.value = newDataPagination.per_page;
    pagination.value.current_page = newDataPagination.current_page;
    getDispatchReports(searchData);
};

onMounted(() => {
    getDispatchReports({expected_payment_from_date:expected_payment_from_date.value,expected_payment_to_date:expected_payment_to_date.value});
    getOther();
    getTime();
    setInterval(getTime, 500);
});
const total_actual_amount = (data) => {
    return data.reduce((total, item) => {
        total += item.actual_amount;
        return total;
    }, 0);
};
// const total_actual_amount = (data) => {
//     return data.reduce((total, item) => {
//         total += item.actual_amount;
//         return total;
//     }, 0);
// };
</script>
<style lang="scss" scoped>
.right-5 {
    right: 50px;
}
</style>

<style lang="scss" scoped>
.input-width,
.va-date-input,
.va-time-input {
    margin: 8px auto;
    width: 100%;
}
</style>
<style>
.border-report {
    padding-top: 20px;
    margin-left: 2px;
    border-top: 3px solid rgb(182, 182, 182);
    width: 99%;
    margin-left: 10px;
}
.text-header {
    font-weight: 500;
}
.pay-pro-set .text-title {
    font-weight: 700;
    font-size: 17px;
    color: black !important;
    padding-bottom: 5px;
    text-align: center;
    margin-right: 120px;
}
.pay-pro-set .text-date {
    text-align: center;
    margin-right: 120px;
}

.pro-pro-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.pro-pro-set .select-box .options-container {
    width: 148px;
}
.pro-pro-set .options-container {
    top: 57px !important;
}

.pro-con-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.pro-con-set .select-box .options-container {
    width: 148px;
}
.pro-con-set .options-container {
    top: 57px !important;
}

</style>
