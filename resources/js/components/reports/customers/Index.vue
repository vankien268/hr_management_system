<template>
    <div class="col-xxl-12 col-xl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch pt-5">
            <!--begin::Header-->
            <!-- Search -->
            <div
                class="d-flex align-items-center justify-content-between flex-wrap ms-5"
            >
                <div class="d-flex align-items-center flex-wrap ms-3 mb-4">
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-5"
                    >
                        <div class="w-auto">
                            <label class="col-form-label" for="checkCreate"
                                >Ngày khai báo</label
                            >
                        </div>
                        <div class="w-125px me-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                id="fromDate"
                                placeholder=""
                                v-model="from_date"
                                :max="to_date"
                            />
                        </div>
                        <div class="w-125px ms-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2 ms-2"
                                id="toDate"
                                v-model="to_date"
                                :min="from_date"
                            />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto">
                        <div class="w-auto">
                            <label
                                for="customerCode"
                                class="col-form-label ms-2 me-5"
                                >Phân loại</label
                            >
                        </div>
                        <div class="w-150px">
                            <select class="form-select" v-model="customer_type">
                                <option value="">Tất cả</option>
                                <option value="1">Khách VIP</option>
                                <option value="0">Khách thường</option>
                            </select>
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto ms-2 me-2"
                    >
                        <div class="w-auto">
                            <label
                                for="customerCode"
                                class="col-form-label ms-2 me-5"
                                >Trạng thái</label
                            >
                        </div>
                        <div class="w-175px system-status-customer-set">
                            <SelectSearch
                                :list-data="systemStatuses"
                                v-model="status_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div>
                    <a
                        href="#"
                        class="btn btn-sm btn-icon-bg-primary btn-color-light ms-5"
                        @click="clickSearch"
                    >
                        Tìm kiếm
                    </a>
                    <a
                        v-print="'#printMe'"
                        class="btn btn-sm btn-icon-bg-primary btn-color-light ms-5"
                    >
                        In
                    </a>

                    <a
                        :href="urlExportExcel"
                        target="_blank"
                        class="btn btn-sm btn-icon-bg-primary btn-color-light ms-5"
                    >
                        Xuất excel
                    </a>
                </div>
            </div>
            <!-- End search -->
            <div class="card-body py-3 pt-0">
                <!--begin::Table container-->
                <div>
                    <!-- Header -->
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
                        <div class="col-5 cus-set">
                            <p class="text-title">BÁO CÁO KHÁCH HÀNG</p>
                            <p
                                v-if="from_date == '' && to_date == ''"
                                class="text-date"
                            ></p>
                            <p v-else-if="from_date == ''" class="text-date">
                                Ngày:
                                {{
                                    moment(new Date(to_date)).format(
                                        "DD/MM/YYYY"
                                    )
                                }}
                            </p>
                            <p v-else-if="to_date == ''" class="text-date">
                                Ngày:
                                {{
                                    moment(new Date(from_date)).format(
                                        "DD/MM/YYYY"
                                    )
                                }}
                            </p>
                            <p
                                v-else-if="from_date != '' && to_date != ''"
                                class="text-date"
                            >
                                Ngày:
                                {{
                                    moment(new Date(from_date)).format(
                                        "DD/MM/YYYY"
                                    )
                                }}
                                -
                                {{
                                    moment(new Date(to_date)).format(
                                        "DD/MM/YYYY"
                                    )
                                }}
                            </p>
                        </div>
                        <div class="col-2 pt-1 p-0">
                            <p class="float-right">
                                Ngày in: {{ time }}
                                <br />
                                Người in: {{ props.name }}
                            </p>
                        </div>
                    </div>
                    <!-- end header -->
                    <!-- body -->
                    <div
                        class="table-responsive table-scroll h-77vh text-nowrap"
                    >
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
                                    <th class="w-10px" style="width: 35px">
                                        STT
                                    </th>
                                    <th class="w-120px">Ngày khai báo</th>
                                    <th class="w-100px">Mã khách hàng</th>
                                    <th class="w-100px">Mã số thuế</th>
                                    <th class="w-200px">Tên khách hàng</th>
                                    <th class="w-200px">Người đại diện</th>
                                    <th class="w-150px">Trạng thái</th>
                                    <th class="w-150px">Ghi chú</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody
                                class="max-h-75 overflow-auto cursor-pointer"
                            >
                                <tr
                                    v-for="(item, index) in customerReports"
                                    :key="index"
                                    :class="{ active: item.id == currentIndex }"
                                    @click="currentIndex = item.id"
                                >
                                    <td>
                                        <span
                                            class="text-dark d-block text-hover-primary w-10px fs-6"
                                        >
                                            {{ index + 1 }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark text-hover-primary d-block text-content w-120px break-text"
                                            :title="item.created_at"
                                            >
                                            {{ moment(new Date(item.created_at)).format(
                                            "DD/MM/YYYY"
                                        ) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark text-hover-primary d-block text-content w-100px break-text pb-1 mt-1"
                                            :title="item.code"
                                            >{{ item.code }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark text-hover-primary d-block text-content w-100px break-text"
                                            :title="item.tax_code"
                                            >{{ item.tax_code }}
                                        </span>
                                    </td>
                                    <td>
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-200px break-text pb-1 mt-1"
                                        >
                                            {{
                                                item.customer_type === 1
                                                    ? "Khách VIP"
                                                    : "Khách thường"
                                            }}
                                        </p>
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-200px break-text pb-1 mt-1"
                                            :title="item.name"
                                        >
                                            {{ item.name }}
                                        </p>
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-200px break-text pb-1 mt-1"
                                            :title="item.address"
                                        >
                                            Địa chỉ: {{ item.address }}
                                        </p>
                                    </td>
                                    <td>
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-200px break-text pb-1 mt-1"
                                            :title="item.representative_name"
                                        >
                                            {{ item.representative_name }}
                                        </p>
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-200px break-text pb-1 mt-1"
                                            :title="item.representative_phone"
                                        >
                                            SDT: {{ item.representative_phone }}
                                        </p>
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-200px break-text pb-1 mt-1"
                                            :title="item.representative_email"
                                        >
                                            Email:
                                            {{ item.representative_email }}
                                        </p>
                                    </td>
                                    <td>
                                        <span
                                            :key="key"
                                            class="text-red text-hover-primary d-block mb-1 text-content break-text text-left w-150px pb-1 mt-1"
                                        >
                                            {{ item.status.data.name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark text-hover-primary d-block mb-1 fs-6 w-150px break-text pb-1 mt-1"
                                            :title="item.note"
                                            >{{ item.note }}</span
                                        >
                                    </td>
                                </tr>
                            </tbody>
                            <tbody
                                v-if="Object.keys(customerReports).length == 0"
                            >
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
                    <!-- end body -->
                    <!-- footer -->
                    <div class="total-report mt-3">
                        <div class="mb-5">
                            <span>Tổng</span>
                            <span class="ms-17 me-10">{{
                                totalAllCustomers
                            }}</span>
                            <span>Khách hàng</span>
                        </div>
                        <div class="mb-5">
                            <span>Trong đó</span>
                            <span class="ms-10 me-10">{{
                                totalCustomerVips
                            }}</span>
                            <span>Khách hàng VIP</span>
                        </div>
                        <div>
                            <span></span>
                            <span class="me-10" style="margin-left: 88px">{{
                                totalCustomerNormals
                            }}</span>
                            <span>Khách hàng thường</span>
                        </div>
                        <div class="col-12 row mt-2">
                            <span class="text-end"
                                >Trang {{ pagination.current_page }}/{{
                                    pagination.total_pages
                                }}</span
                            >
                        </div>
                        <div class="row col-12 mt-5 mb-10">
                            <div class="col-1"></div>
                            <div class="col-9">Người lập biểu</div>
                            <div class="col-2">Trưởng bộ phận</div>
                        </div>
                    </div>
                    <!-- end footer -->
                </div>

                <!-- Phân trang -->
                <base-pagination
                    :pagination="pagination"
                    @change-page="changePage"
                />
                <!-- end Phân trang -->
                <!-- In báo cáo -->
                <div style="display: none" class="showOnPrint" id="printMe">
                    <table>
                        <!-- <thead> -->
                        <tr class="n-header">
                            <td
                                width="10%"
                                colspan="2"
                                style="
                                    vertical-align: middle;
                                    text-align: center;
                                "
                            >
                                <img
                                    src="https://newwaypms.com/skins/news/images/logo_mobile.png"
                                    alt=""
                                    width="70"
                                />
                            </td>
                            <td colspan="2" class="name-company" width="25%">
                                <span
                                    >Công ty cổ phần giải pháp công nghệ
                                    Newway</span
                                >
                                <br />
                                <span>74 Hồ Đền Lừ, Hoàng Mai, Hà Nội</span>
                            </td>
                            <td
                                class="title-header"
                                style="text-align: center:  !important;"
                                colspan="2"
                                width="37%"
                            >
                                <p class="title-print-cus">BÁO CÁO KHÁCH HÀNG</p>
                                <p
                                    v-if="from_date == '' && to_date == ''"
                                    class="text-date time-title-cus"
                                >

                                </p>
                                <p
                                    v-else-if="from_date == ''"
                                    c class="text-date time-title-cus"
                                >
                                    Ngày:
                                    {{
                                        moment(new Date(to_date)).format(
                                            "DD/MM/YYYY"
                                        )
                                    }}
                                </p>
                                <p
                                    v-else-if="to_date == ''"
                                    class="text-date time-title-cus"
                                >
                                    Ngày:
                                    {{
                                        moment(new Date(from_date)).format(
                                            "DD/MM/YYYY"
                                        )
                                    }}

                                </p>
                                <p
                                    v-else-if="from_date != '' && to_date != ''"
                                    class="text-date time-title-cus"
                                >
                                    Ngày:
                                    {{
                                        moment(new Date(from_date)).format(
                                            "DD/MM/YYYY"
                                        )
                                    }}
                                    -
                                    {{
                                        moment(new Date(to_date)).format(
                                            "DD/MM/YYYY"
                                        )
                                    }}
                                </p>
                            </td>
                            <td colspan="2" class="date-time-print" width="18%">
                                <p>Ngày in: {{ time }}</p>
                                <!-- <br /> -->
                                <p>Người in: {{ props.name }}</p>
                            </td>
                        </tr>
                        <tr class="n-header">
                            <td colspan="8" style="height: 20px"></td>
                        </tr>
                        <!-- </thead> -->
                    </table>
                    <table>
                        <!-- <tbody> -->
                        <tr
                            class="n-body text-title-body"
                            style="font-weight: bold; height: 50px"
                        >
                            <th style="text-align: center; width: 20px">STT</th>
                            <th
                                style="
                                    width: 120px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Ngày khai báo
                            </th>
                            <th
                                style="
                                    width: 150px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Mã khách hàng
                            </th>
                            <th
                                style="
                                    width: 120px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Mã số thuế
                            </th>
                            <th
                                style="
                                    width: 200px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Tên khách hàng
                            </th>
                            <th
                                style="
                                    width: 200px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Người đại diện
                            </th>
                            <th
                                style="
                                    width: 150px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Trạng thái
                            </th>
                            <th
                                style="
                                    width: 170px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Ghi chú
                            </th>
                        </tr>
                        <tr
                            class="n-body text-content-body"
                            v-for="(item, index) in customerReports"
                            :key="index"
                            :class="{ active: item.id == currentIndex }"
                            @click="currentIndex = item.id"
                        >
                            <td style="text-align: center">
                                {{ index + 1 }}
                            </td>
                            <td style="text-align: left">
                                {{ moment(new Date(item.created_at)).format(
                                            "DD/MM/YYYY"
                                        ) }}
                            </td>
                            <td style="text-align: left">
                                {{ item.code }}
                            </td>
                            <td style="text-align: left; width: 50px">
                                {{ item.tax_code }}
                            </td>
                            <td style="text-align: left">
                                <p style="text-align: left;margin-top: 5px">
                                    {{
                                        item.customer_type === 1
                                            ? "Khách VIP"
                                            : "Khách thường"
                                    }}
                                </p>
                                <p style="text-align: left;margin-top: 5px">
                                    {{ item.name }}
                                </p>
                                <p style="text-align: left;margin-top: 5px">
                                    Địa chỉ: {{ item.address }}
                                </p>
                            </td>
                            <td style="text-align: left">
                                <p style="text-align: left;margin-top: 5px">
                                    {{ item.representative_name }}
                                </p>
                                <p style="text-align: left;margin-top: 5px">
                                    SDT: {{ item.representative_phone }}
                                </p>
                                <p style="text-align: left;margin-top: 5px">
                                    Email: {{ item.representative_email }}
                                </p>
                            </td>
                            <td style="text-align: left">
                                {{ item.status.data.name }}
                            </td>
                            <td style="text-align: left">
                                {{ item.note }}
                            </td>
                        </tr>
                        <!-- </tbody> -->
                        <!-- <tfoot> -->
                        <tr class="n-footer">
                            <td colspan="8" style="height: 20px"></td>
                        </tr>
                        <tr class="n-footer" style="height: 30px">
                            <td colspan="2">Tổng:</td>
                            <td>{{ totalAllCustomers }}</td>
                            <!-- <td>000000000000000</td> -->
                            <td colspan="2">Khách hàng</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr class="n-footer" style="height: 30px">
                            <td colspan="2">Trong đó:</td>
                            <td>{{ totalCustomerVips }}</td>
                            <td colspan="2">Khách hàng Vip</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr class="n-footer" style="height: 30px">
                            <td colspan="2"></td>
                            <td>{{ totalCustomerNormals }}</td>
                            <td colspan="2">Khách hàng thường</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr class="n-footer">
                            <td colspan="8" style="height: 20px"></td>
                        </tr>
                        <tr class="n-footer" style="height: 50px">
                            <td colspan="3" style="text-align: center">
                                Người lập biểu
                            </td>
                            <td colspan="3"></td>
                            <td colspan="2">Trưởng bộ phận</td>
                        </tr>
                        <!-- </tfoot> -->
                    </table>
                </div>
                <!-- Kết thúc In báo cáo -->
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
import moment from "moment";
import SelectSearch from "../../input/SelectSearch.vue";
import { useSystemStatusStore } from "../../../stores/status";
const props = defineProps({
    title: String,
    name: {
        type: String,
        default: "user",
    },
});

const systemStatusStore = useSystemStatusStore();

const systemStatuses = computed(() => {
    return systemStatusStore.$state.statuses.data ?? [];
});

const time = ref("");

const today = new Date();
const date =
    today.getDate() +
    "/" +
    ("0" + (today.getMonth() + 1)).slice(-2) +
    "/" +
    today.getFullYear();

const getTime = () => {
    var currentTimeDate = new Date();
    var dates = currentTimeDate.getDate();
    var months = currentTimeDate.getMonth() + 1;
    var years = currentTimeDate.getFullYear();
    var hours = currentTimeDate.getHours();
    var minutes = currentTimeDate.getMinutes();
    var seconds = currentTimeDate.getSeconds();

    hours = hours < 10 ? "0" + hours : hours;
    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;
    dates = dates < 10 ? "0" + dates : dates;
    months = months < 10 ? "0" + months : months;

    time.value =
        dates +
        "/" +
        months +
        "/" +
        years +
        " " +
        hours +
        ":" +
        minutes +
        ":" +
        seconds;
};

const systemStatus = ref([]);
const from_date = ref(moment().format("YYYY-MM-DD"));
const to_date = ref(moment().format("YYYY-MM-DD"));
const customer_type = ref("");
const status_id = ref("");

const searchData = reactive({
    from_date: "",
    to_date: "",
    customer_type: "",
    status_id: "",
});

const clickSearch = () => {
    searchData.from_date = from_date.value;
    searchData.to_date = to_date.value;
    searchData.customer_type = customer_type.value;
    searchData.status_id = status_id.value;
    pagination.value.current_page = 1;
    getCustomerReports(searchData);
};

// handle chọn số bản ghi / 1 trang

const currentIndex = ref(-1);

let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};
const customerReports = ref([]);
const totalCustomerVips = ref([]);
const totalCustomerNormals = ref([]);
const totalAllCustomers = ref([]);
let getMetaPaginate = ref({});
const urlExportExcel = ref(null);
const getCustomerReports = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/reports/customers/get-all",
        method: "GET",
        params: {
            ...params,
            per_page: selectTotalRecord.value,
            page: pagination.value.current_page,
        },
    })
        .then((res) => {
            const {
                data,
                meta,
                totalCustomerVip,
                totalCustomerNormal,
                totalCustomers,
                url_export,
            } = res.data;
            totalCustomerVips.value = totalCustomerVip;
            totalCustomerNormals.value = totalCustomerNormal;
            totalAllCustomers.value = totalCustomers;
            customerReports.value = data;
            getMetaPaginate.value = meta;
            urlExportExcel.value = url_export;
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};

const getSystemStatus = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/reports/customers/getOther",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data } = res;
            // console.log(meta);
            systemStatus.value = data.getSystemStatus;
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
    getCustomerReports(searchData);
};

onMounted(() => {
    getCustomerReports({ from_date: from_date.value, to_date: to_date.value });
    getSystemStatus();
    systemStatusStore.getSystemStatusData(2);
    getTime();
    setInterval(getTime, 500);
});
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
.cus-set .text-title {
    font-weight: 700;
    font-size: 17px;
    color: black !important;
    padding-bottom: 5px;
    text-align: center;
    margin-right: 200px;
}
.cus-set .text-date {
    text-align: center;
    margin-right: 200px;
}
.system-status-customer-set .selected {
    padding: 6px !important;
}
.system-status-customer-set .select-box .options-container {
    width: 173px;
}
/* .system-status-customer-set .options-container {
    top: 333px !important;
} */
.customer-type-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.customer-type-set select {
    padding: 6px !important;
}
@media print {
    .noPrint {
        display: none !important;
    }
    .showOnPrint {
        display: block !important;
        font-family: Helvetica, Arial, sans-serif;
        color: #000000!important;
        margin-top: 40px;
    }
    table {
        border-collapse: collapse;
    }
    /* table .n-header{
        border: none !important;
    } */

    .n-body th {
        border: 1px solid #000000;
        border-collapse: collapse;
    }

    .n-body td {
        border: 1px solid #000000;
        border-collapse: collapse;
    }

    .title-header {
        text-align: left;
        vertical-align: text-top;
        font-size: 12px;
        margin-left: 10px;
        color: black !important;
    }

    .time-title-cus {
        font-size: 12px;
        margin-left: 58px!important;
    }

    .title-print-cus {
        font-size: 23px!important;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .name-company {
        font-size: 12px;
    }

    .date-time-print {
        /* text-align: right; */
        font-size: 12px;
        /* margin-left: 100px; */
    }

    .text-title-body {
        color: black !important;
        font-size: 10px;
        line-height: 13px;
    }

    .text-content-body {
        font-size: 10px;
        line-height: 13px;
    }

    .n-footer {
        font-size: 12px;
    }
}
</style>
