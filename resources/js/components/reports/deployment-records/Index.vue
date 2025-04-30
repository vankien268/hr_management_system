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
                        class="d-flex align-items-center flex-wrap w-auto me-7"
                    >
                        <div class="w-auto">
                            <label class="col-form-label" for="checkCreate"
                                >Thời gian thực hiện</label
                            >
                        </div>
                        <div class="w-125px ms-5 me-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                id="fromDate"
                                placeholder=""
                                v-model="handover_date_from_date"
                                :max="handover_date_to_date"
                            />
                        </div>
                        <div class="w-125px ms-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2 ms-2"
                                id="toDate"
                                v-model="handover_date_to_date"
                                :min="handover_date_from_date"
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-5"
                    >
                        <div class="w-auto me-1">
                            <label for="customerCode" class="col-form-label"
                                >Dự án</label
                            >
                        </div>
                        <div class="w-150px dep-pro-set ms-5">
                            <SelectSearch
                                :list-data="projects"
                                v-model="project_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto">
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label"
                                >Trạng thái</label
                            >
                        </div>
                        <div class="w-150px dep-sta-set ms-5">
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
                        style="margin-left: 35px !important"
                        href="#"
                        class="btn btn-sm btn-icon-bg-primary btn-color-light ms-11"
                        @click="clickSearch"
                    >
                        Tìm kiếm
                    </a>
                    <a
                        v-print="'#printMe'"
                        class="btn btn-sm btn-icon-bg-primary btn-color-light ms-3"
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
                    <div class="col-5 dep-set">
                        <p class="text-title">BÁO CÁO TIẾN ĐỘ TRIỂN KHAI</p>
                        <p
                            v-if="
                                handover_date_from_date == '' &&
                                handover_date_to_date == ''
                            "
                            class="text-date"
                        ></p>
                        <p
                            v-else-if="handover_date_from_date == ''"
                            class="text-date"
                        >
                            Ngày:
                            {{
                                moment(new Date(handover_date_to_date)).format(
                                    "DD/MM/YYYY"
                                )
                            }}
                        </p>
                        <p
                            v-else-if="handover_date_to_date == ''"
                            class="text-date"
                        >
                            Ngày:
                            {{
                                moment(
                                    new Date(handover_date_from_date)
                                ).format("DD/MM/YYYY")
                            }}
                        </p>
                        <p
                            v-else-if="
                                handover_date_from_date != '' &&
                                handover_date_to_date != ''
                            "
                            class="text-date"
                        >
                            Ngày:
                            {{
                                moment(
                                    new Date(handover_date_from_date)
                                ).format("DD/MM/YYYY")
                            }}
                            -
                            {{
                                moment(new Date(handover_date_to_date)).format(
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
                                <th class="w-10px">STT</th>
                                <th class="w-125px">Mã lịch triển khai</th>
                                <th class="w-150px">Tiêu đề lịch triển khai</th>
                                <th class="w-175px">
                                    Thời gian thực hiện
                                    <p>Từ ngày - Tới ngày</p>
                                </th>
                                <th class="w-100px">Trạng thái</th>
                                <th class="w-100px">Ghi chú quan trọng</th>
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
                                    colspan="6"
                                >
                                    <p v-html="key"></p>
                                </td>
                            </tr>
                            <tr
                                v-for="(item, index) in dispatchReport"
                                :key="index"
                            >
                                <td>
                                    <span
                                        class="text-dark d-block text-hover-primary w-10px fs-6"
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
                                        class="text-dark text-hover-primary d-block text-content w-125px break-text"
                                        :title="item.code"
                                    >
                                        {{ item.code }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-160px break-text pb-1 mt-1"
                                        :title="item.title"
                                        >{{ item.title }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-175px break-text"
                                        :title="item.handover_date"
                                    >
                                        <!-- {{ item.from_date}} - {{ item.to_date }} -->
                                        {{
                                            moment(
                                                new Date(item.from_date)
                                            ).format("DD/MM/YYYY")
                                        }}
                                        -
                                        {{
                                            moment(
                                                new Date(item.to_date)
                                            ).format("DD/MM/YYYY")
                                        }}
                                    </span>
                                </td>
                                <td>
                                    <div
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-150px break-text pb-1 mt-1"
                                        :title="item.status.data.name"
                                    >
                                        {{ item.status.data.name }}
                                    </div>
                                </td>
                                <td class="">
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-125px break-text"
                                        :title="item.note"
                                        >{{ item.note }}
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
                            <td colspan="1" class="name-company" width="25%">
                                <span
                                    >Công ty cổ phần giải pháp công nghệ
                                    Newway</span
                                >
                                <br />
                                <span>74 Hồ Đền Lừ, Hoàng Mai, Hà Nội</span>
                            </td>
                            <td
                                colspan="3"
                                width="42%"
                                class="title-header"
                                style="text-align: center:  !important; "
                            >
                                <p class="title-print-dep">
                                    BÁO CÁO TIẾN ĐỘ TRIỂN KHAI
                                </p>
                                <p
                                    v-if="
                                        handover_date_from_date == '' &&
                                        handover_date_to_date == ''
                                    "
                                    class="text-date time-title-dep"
                                >

                                </p>
                                <p
                                    v-else-if="handover_date_from_date == ''"
                                    class="text-date time-title-dep"
                                >
                                    Ngày:
                                    {{
                                        moment(
                                            new Date(handover_date_to_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                </p>
                                <p
                                    v-else-if="handover_date_to_date == ''"
                                    class="text-date time-title-dep"
                                >
                                    Ngày:
                                    {{
                                        moment(
                                            new Date(handover_date_from_date)
                                        ).format("DD/MM/YYYY")
                                    }}

                                </p>
                                <p
                                    v-else-if="
                                        handover_date_from_date != '' &&
                                        handover_date_to_date != ''
                                    "
                                    class="text-date time-title-dep"
                                >
                                    Ngày:
                                    {{
                                        moment(
                                            new Date(handover_date_from_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                    -
                                    {{
                                        moment(
                                            new Date(handover_date_to_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                </p>
                            </td>
                            <td width="18%" colspan="1" class="date-time-print">
                                <span>Ngày in: {{ time }}</span>
                                <br />
                                <span>Người in: {{ props.name }}</span>
                            </td>
                        </tr>
                        <tr class="n-header">
                            <td colspan="6" style="height: 20px"></td>
                        </tr>
                    </table>
                    <table>
                        <tr
                            class="n-body text-title-body"
                            style="font-weight: bold; height: 50px"
                        >
                            <th style="text-align: center; width: 10px">STT</th>
                            <th
                                style="
                                    width: 250px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Mã lịch triển khai
                            </th>
                            <th
                                style="
                                    width: 200px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Tiêu đề lịch triển khai
                            </th>
                            <th
                                style="
                                    width: 200px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Thời gian thực hiện
                                <p>Từ ngày - Tới ngày</p>
                            </th>
                            <th
                                style="
                                    width: 200px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Trạng thái
                            </th>
                            <th
                                style="
                                    width: 250px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Ghi chú quan trọng
                            </th>
                        </tr>
                        <tbody
                            v-for="(dispatchReport, key) in dispatchReports"
                            :key="key"
                            class="max-h-75 overflow-auto cursor-pointer n-body text-content-body"
                        >
                            <tr>
                                <td
                                    class="h-40px fw-medium pointer-events-none"
                                    style="
                                        color: black;
                                        /* font-size: 14px; */
                                        padding-left: 3rem;
                                        font-weight: bold;
                                    "
                                    colspan="6"
                                >
                                    <p v-html="key"></p>
                                </td>
                            </tr>
                            <tr
                                v-for="(item, index) in dispatchReport"
                                :key="index"
                            >
                                <td style="text-align: center">
                                    {{
                                        pagination.per_page *
                                            (pagination.current_page - 1) +
                                        (item.stt + 1)
                                    }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.code }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.title }}
                                </td>
                                <td style="text-align: left">
                                    {{
                                        moment(new Date(item.from_date)).format(
                                            "DD/MM/YYYY"
                                        )
                                    }}
                                    -
                                    {{
                                        moment(new Date(item.to_date)).format(
                                            "DD/MM/YYYY"
                                        )
                                    }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.status.data.name }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.note }}
                                </td>
                            </tr>
                        </tbody>
                        <tr class="n-footer">
                            <td colspan="6" style="height: 20px"></td>
                        </tr>
                        <tr class="n-footer" style="height: 50px">
                            <td colspan="2" style="text-align: right">
                                Người lập biểu
                            </td>
                            <td colspan="2"></td>
                            <td colspan="2">Trưởng bộ phận</td>
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
import { helperFunc } from "../../../helper/heplerFunction.js";
// import { useCustomerStore } from "../../stores/customer";
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

const handover_date_from_date = ref(moment().format("YYYY-MM-DD"));
const handover_date_to_date = ref(moment().format("YYYY-MM-DD"));
const project_id = ref("");
const status_id = ref("");

const searchData = reactive({
    handover_date_from_date: "",
    handover_date_to_date: "",
    project_id: "",
    status_id: "",
});

const clickSearch = () => {
    searchData.handover_date_from_date = handover_date_from_date.value;
    searchData.handover_date_to_date = handover_date_to_date.value;
    searchData.project_id = project_id.value;
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
const urlExportExcel = ref(null);
const getDispatchReports = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/reports/deployment-records/get-all",
        method: "GET",
        params: {
            ...params,
            per_page: selectTotalRecord.value,
            page: pagination.value.current_page,
        },
    })
        .then((res) => {
            const { data, meta, url_export } = res.data;
            dispatchReports.value = helperFunc.groupBy(data, "project_title");
            // dispatchReports.value = data.reduce((group, arr) => {
            //     const { project_title } = arr;
            //     group[project_title] = group[project_title] ?? [];
            //     group[project_title].push(arr);
            //     return group;
            // }, {});
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
const projects = ref([]);
const systemStatus = ref([]);
const getOther = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/reports/deployment-records/getOther",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data } = res;
            projects.value = data.getProjectManagement;
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
    getDispatchReports(searchData);
};

onMounted(() => {
    getDispatchReports({
        handover_date_from_date: handover_date_from_date.value,
        handover_date_to_date: handover_date_to_date.value,
    });
    getOther();
    systemStatusStore.getSystemStatusData(7);
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
.dep-set .text-title {
    font-weight: 700;
    font-size: 17px;
    color: black !important;
    padding-bottom: 5px;
    text-align: center;
    margin-right: 200px;
}
.dep-set .text-date {
    text-align: center;
    margin-right: 200px;
}

.dep-pro-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.dep-pro-set .select-box .options-container {
    width: 148px;
}
/* .dep-pro-set .options-container {
    top: 57px !important;
} */

.dep-sta-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.dep-sta-set .select-box .options-container {
    width: 148px;
}
/* .dep-sta-set .options-container {
    top: 57px !important;
} */

.total-report {
    padding-bottom: 50px;
    border-bottom: 3px solid rgb(182, 182, 182);
    margin-bottom: 20px;
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

    .time-title-dep {
        font-size: 12px;
        margin-left: 90px!important;
    }

    .title-print-dep {
        color: black;
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
