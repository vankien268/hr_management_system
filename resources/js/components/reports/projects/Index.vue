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
                        class="d-flex align-items-center flex-wrap w-auto me-5"
                    >
                        <div class="w-auto">
                            <label class="col-form-label" for="checkCreate"
                                >Ngày khai báo</label
                            >
                        </div>
                        <div class="w-200px ms-7 me-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                id="fromDate"
                                placeholder=""
                                v-model="from_date"
                                :max="to_date"
                            />
                        </div>
                        <div class="w-200px ms-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2 ms-2"
                                id="toDate"
                                v-model="to_date"
                                :min="from_date"
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto ms-2 me-5"
                    >
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label"
                                >Khách hàng</label
                            >
                        </div>
                        <div class="w-200px customer-con-set ms-2">
                            <SelectSearch
                                :list-data="customers"
                                v-model="customer_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto ms-8"
                    >
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label"
                                >Phân loại dự án</label
                            >
                        </div>
                        <div class="w-200px project-id-type-set">
                            <SelectSearch
                                :list-data="projectType"
                                v-model="project_type_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap ms-3 mb-4">
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-2"
                    >
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label"
                                >Trạng thái</label
                            >
                        </div>
                        <div class="w-200px system-status-contract-set ms-15">
                            <SelectSearch
                                :list-data="systemStatuses"
                                v-model="status_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto district-set me-3"
                    >
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label"
                                >Khu vực</label
                            >
                        </div>
                        <div class="w-200px city-id-set ms-9">
                            <SelectSearch
                                :list-data="cities"
                                v-model="city_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div>
                    <a
                        style="margin-left: 73px !important"
                        href="#"
                        class="btn btn-sm btn-icon-bg-primary btn-color-light ms-20"
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
                    <div class="col-5 pro-set">
                        <p class="text-title">BÁO CÁO DỰ ÁN</p>
                        <p
                            v-if="from_date == '' && to_date == ''"
                            class="text-date"
                        ></p>
                        <p v-else-if="from_date == ''" class="text-date">
                            Ngày:
                            {{ moment(new Date(to_date)).format("DD/MM/YYYY") }}
                        </p>
                        <p v-else-if="to_date == ''" class="text-date">
                            Ngày:
                            {{
                                moment(new Date(from_date)).format("DD/MM/YYYY")
                            }}
                        </p>
                        <p
                            v-else-if="from_date != '' && to_date != ''"
                            class="text-date"
                        >
                            Ngày:
                            {{
                                moment(new Date(from_date)).format("DD/MM/YYYY")
                            }}
                            -
                            {{ moment(new Date(to_date)).format("DD/MM/YYYY") }}
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
                                <th class="w-75px">Ngày tạo</th>
                                <th class="w-50px">Mã dự án</th>
                                <th class="w-125px">Tên dự án</th>
                                <th class="w-75px">Khu vực</th>
                                <th class="w-200px">Phân loại dự án</th>
                                <th class="w-100px">Mô tả sơ bộ</th>
                                <th class="w-100px">Đại diện khách hàng</th>
                                <th class="w-100px">Đại diện công ty</th>
                                <th class="w-100px">Trạng thái</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody
                            v-for="(projectReport, key) in projectReports"
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
                                    colspan="10"
                                >
                                    {{ key }}
                                </td>
                            </tr>
                            <tr
                                v-for="(item, index) in projectReport"
                                :key="index"
                            >
                                <td>
                                    <span
                                        class="text-dark d-block text-hover-primary w-15px fs-6"
                                    >
                                        <!-- {{
                                            pagination.per_page *
                                                (pagination.current_page - 1) +
                                            (item.stt + 1)
                                        }} -->
                                        {{ index + 1 }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-75px break-text"
                                        :title="item.created_at"
                                        >{{ item.created_at }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-50px break-text pb-1 mt-1"
                                        :title="item.code"
                                        >{{ item.code }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-125px break-text"
                                        :title="item.name"
                                        >{{ item.name }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        v-for="(
                                            val_city, key_city
                                        ) in item.city"
                                        :key="key_city"
                                        class="text-dark text-hover-primary d-block text-content w-75px break-text pb-1 mt-1"
                                        :title="val_city.name"
                                        >{{ val_city.name }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        v-for="(
                                            val_project_type, key_project_type
                                        ) in item.projectType"
                                        :key="key_project_type"
                                        class="text-dark text-hover-primary d-block text-content w-200px break-text pb-1 mt-1"
                                        :title="val_project_type.name"
                                        >{{ val_project_type.name }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-100px break-text pb-1 mt-1"
                                        :title="item.description"
                                        >{{ item.description }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        v-for="(
                                            val_contacts, key_contacts
                                        ) in item.contacts.data"
                                        :key="key_contacts"
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-100px break-text pb-1 mt-1"
                                        :title="val_contacts.name"
                                        >{{ val_contacts.name }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        v-for="(val_users, key_users) in item
                                            .users.data"
                                        :key="key_users"
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-100px break-text pb-1 mt-1"
                                        :title="val_users.name"
                                        >{{ val_users.name }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-100px break-text pb-1 mt-1"
                                        :title="item.systemStatus.data.name"
                                        >{{ item.systemStatus.data.name }}</span
                                    >
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-if="Object.keys(projectReports).length == 0">
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
                    <div class="mb-5">
                        <span>Tổng</span>
                        <span class="ms-17 me-10">{{ totalAllProjects }}</span>
                        <span>Dự án</span>
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

                <base-pagination
                    :pagination="pagination"
                    @change-page="changePage"
                />
                <!-- In báo cáo -->
                <div style="display: none" class="showOnPrint" id="printMe">
                    <table>
                        <tr class="n-header">
                            <td
                                width="10%"
                                colspan="1"
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
                            <td colspan="4" class="name-company" width="25%">
                                <span
                                    >Công ty cổ phần giải pháp công nghệ
                                    Newway</span
                                >
                                <br />
                                <span>74 Hồ Đền Lừ, Hoàng Mai, Hà Nội</span>
                            </td>
                            <td
                                width="37%"
                                class="title-header"
                                style="text-align: center:  !important; "
                                colspan="3"
                            >
                                <p class="title-print-pro">BÁO CÁO DỰ ÁN</p>
                                <p
                                    v-if="from_date == '' && to_date == ''"
                                    class="text-date time-title-pro"
                                >

                                </p>
                                <p
                                    v-else-if="from_date == ''"
                                    class="text-date time-title-pro"
                                >
                                    Ngày:
                                    {{
                                        moment(new Date(to_date)).format(
                                            "DD/MM/YYYY"
                                        )
                                    }}
                                </p>
                                <p v-else-if="to_date == ''" class="text-date time-title-pro">
                                    Ngày:
                                    {{
                                        moment(new Date(from_date)).format(
                                            "DD/MM/YYYY"
                                        )
                                    }}

                                </p>
                                <p
                                    v-else-if="from_date != '' && to_date != ''"
                                    class="text-date time-title-pro"
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
                            <td width="18%" colspan="2" class="date-time-print">
                                <span>Ngày in: {{ time }}</span>
                                <br />
                                <span>Người in: {{ props.name }}</span>
                            </td>
                        </tr>
                        <tr class="n-header">
                            <td colspan="10" style="height: 20px"></td>
                        </tr>
                    </table>
                    <table>
                        <tr
                            class="n-body text-title-body"
                            style="font-weight: bold; height: 50px"
                        >
                            <th style="text-align: center; width: 50px">STT</th>
                            <th
                                style="
                                    width: 100px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Ngày tạo
                            </th>
                            <th
                                style="
                                    width: 120px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Mã dự án
                            </th>
                            <th
                                style="
                                    width: 120px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Tên dự án
                            </th>
                            <th
                                style="
                                    width: 120px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Khu vực
                            </th>
                            <th
                                style="
                                    width: 200px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Phân loại dự án
                            </th>
                            <th
                                style="
                                    width: 175px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Mô tả sơ bộ
                            </th>
                            <th
                                style="
                                    width: 150px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Đại diện khách hàng
                            </th>
                            <th  v-if="totalAllProjects != 0"
                                style="
                                    width: 150px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Đại diện công ty
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
                        </tr>
                        <tbody
                            v-for="(projectReport, key) in projectReports"
                            :key="key"
                            class="max-h-75 overflow-auto cursor-pointer n-body text-content-body"
                        >
                            <tr>
                                <td
                                    class="h-40px fw-medium pointer-events-none"
                                    style="
                                        color: black;
                                        /* font-size: 14px; */
                                        font-weight: bold;
                                        padding-left: 3rem;
                                    "
                                    colspan="10"
                                >
                                    {{ key }}
                                </td>
                            </tr>
                            <tr
                                v-for="(item, index) in projectReport"
                                :key="index"
                            >
                                <td style="text-align: center">
                                    {{
                                        pagination.per_page *
                                            (pagination.current_page - 1) +
                                        (item.stt + 1)
                                    }}
                                    <!-- {{ index + 1 }} -->
                                </td>
                                <td style="text-align: left">
                                    {{ item.created_at }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.code }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.name }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.city.data.name }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.projectType.data.name }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.description }}
                                </td>
                                <td
                                    style="text-align: left"
                                    v-for="(val_contacts, key_contacts) in item
                                        .contacts.data"
                                    :key="key_contacts"
                                >
                                    {{ val_contacts.name }}
                                </td>
                                <td
                                    style="text-align: left"
                                >
                                    <p  class="margin-top: 5px" v-for="(val_users, key_users) in item.users
                                        .data"
                                    :key="key_users">
                                    {{ val_users.name }}
                                    </p>
                                </td>
                                <td style="text-align: left">
                                    {{ item.systemStatus.data.name }}
                                </td>
                            </tr>
                        </tbody>
                        <tr class="n-footer">
                            <td colspan="10" style="height: 20px"></td>
                        </tr>
                        <tr style="height: 30px" class="n-footer">
                            <td colspan="2">Tổng:</td>
                            <td>{{ totalAllProjects }}</td>
                            <td colspan="2">Dự án</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="n-footer">
                            <td colspan="10" style="height: 10px"></td>
                        </tr>
                        <tr class="n-footer" style="height: 50px">
                            <td colspan="2"></td>
                            <td colspan="2">Người lập biểu</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2">Trưởng bộ phận</td>
                            <td></td>

                        </tr>
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
import { helperFunc } from "../../../helper/heplerFunction";
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

const from_date = ref(moment().format("YYYY-MM-DD"));
const to_date = ref(moment().format("YYYY-MM-DD"));
const customer_type = ref("");
const status_id = ref("");
const customer_id = ref("");
const project_type_id = ref("");
const city_id = ref("");

const searchData = reactive({
    from_date: "",
    to_date: "",
    customer_type: "",
    status_id: "",
    customer_id: "",
    project_type_id: "",
    city_id: "",
});

const clickSearch = () => {
    searchData.from_date = from_date.value;
    searchData.to_date = to_date.value;
    searchData.customer_type = customer_type.value;
    searchData.status_id = status_id.value;
    searchData.customer_id = customer_id.value;
    searchData.project_type_id = project_type_id.value;
    searchData.city_id = city_id.value;
    pagination.value.current_page = 1;
    getProjectReports(searchData);
};

// handle chọn số bản ghi / 1 trang

const currentIndex = ref(-1);

let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};
const totalAllProjects = ref([]);
const projectReports = ref([]);
let getMetaPaginate = ref({});
const urlExportExcel = ref(null);
const getProjectReports = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/reports/projects/get-all",
        method: "GET",
        params: {
            ...params,
            per_page: selectTotalRecord.value,
            page: pagination.value.current_page,
        },
    })
        .then((res) => {
            const { data, meta, totalProjects, url_export } = res.data;
            totalAllProjects.value = totalProjects;
            projectReports.value = helperFunc.groupBy(data, "customer_title");
            urlExportExcel.value = url_export;
            getMetaPaginate.value = meta;
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};

const systemStatus = ref([]);
const customers = ref([]);
const projectType = ref([]);
const cities = ref([]);
const getOther = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/reports/projects/getOther",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data } = res;
            systemStatus.value = data.getSystemStatus;
            customers.value = data.getCustomers;
            projectType.value = data.getProjectTypes;
            cities.value = data.getCities;
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
    getProjectReports(searchData);
};

onMounted(() => {
    getProjectReports({ from_date: from_date.value, to_date: to_date.value }); // + " 00:00:01" +" 23:59:59"
    getOther();
    systemStatusStore.getSystemStatusData(0);
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
.pro-set .text-title {
    font-weight: 700;
    font-size: 17px;
    color: black !important;
    padding-bottom: 5px;
    text-align: center;
    margin-right: 200px;
}
.pro-set .text-date {
    text-align: center;
    margin-right: 200px;
}
.customer-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.customer-set .select-box .options-container {
    width: 198px;
}
/* .customer-set .options-container {
    top: 105px !important;
} */
.system-status-contract-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.system-status-contract-set .select-box .options-container {
    width: 198px;
}
/* .system-status-contract-set .options-container {
    top: 99px !important;
} */
.customer-type-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.customer-type-set select {
    padding: 6px !important;
}
.district-set {
    margin-left: 230px;
}
.project-id-type-set .select-box .options-container {
    width: 198px;
}
/* .project-id-type-set .options-container {
    top: 54px !important;
} */
.project-id-type-sett .selected {
    padding: 13px 24px 13px 8px !important;
}
.city-id-set .select-box .options-container {
    width: 198px;
}
/* .city-id-set .options-container {
    top: 99px !important;
} */
.city-id-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.customer-con-set .select-box .options-container {
    width: 198px;
}
/* .customer-con-set .options-container {
    top: 54px !important;
} */
.customer-con-set .selected {
    padding: 13px 24px 13px 8px !important;
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

    .time-title-pro {
        font-size: 12px;
        margin-left: 58px!important;
    }

    .title-print-pro {
        margin-left: 42px;
        font-size: 23px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .name-company {
        font-size: 12px;
    }

    .date-time-print {
        text-align: right;
        font-size: 12px;
        /* margin-right: 30px; */
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
