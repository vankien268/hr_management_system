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
                                >Ngày lập</label
                            >
                        </div>
                        <div class="w-125px ms-15 me-2">
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
                    <div
                        class="d-flex align-items-center flex-wrap w-auto ms-2 me-5"
                    >
                        <div class="w-auto me-1">
                            <label for="customerCode" class="col-form-label"
                                >Dự án</label
                            >
                        </div>
                        <div class="w-150px dis-pro-set ms-11">
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
                                >Loại</label
                            >
                        </div>
                        <div class="w-150px dis-type-set ms-16">
                            <select class="form-select" v-model="type">
                                <option value="">Tất cả</option>
                                <option value="1">Gửi đi</option>
                                <option value="0">Tiếp nhận</option>
                            </select>
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto ms-16"
                    >
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label"
                                >Người nhận</label
                            >
                        </div>
                        <div class="w-150px dis-rec-set ms-6">
                            <SelectSearch
                                :list-data="receivers"
                                v-model="receiver"
                                placeholder="Tất cả"
                                key-value="receiver"
                                key-display="receiver"
                            />
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap ms-3 mb-4">
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-7"
                    >
                        <div class="w-auto">
                            <label class="col-form-label" for="checkCreate"
                                >Ngày hiệu lực</label
                            >
                        </div>
                        <div class="w-125px ms-5 me-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                id="fromDate"
                                placeholder=""
                                v-model="effective_from_date"
                                :max="effective_to_date"
                            />
                        </div>
                        <div class="w-125px ms-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2 ms-2"
                                id="toDate"
                                v-model="effective_to_date"
                                :min="effective_from_date"
                            />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto">
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label"
                                >Trạng thái</label
                            >
                        </div>
                        <div class="w-150px dis-sta-set ms-5">
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
                        class="d-flex align-items-center flex-wrap w-auto me-5 ms-5"
                    >
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label"
                                >Người gửi</label
                            >
                        </div>
                        <div v-if="senders.length > 0"
                         class="w-150px dis-sen-set ms-5">
                            <SelectSearch
                                :list-data="senders"
                                v-model="sender"
                                placeholder="Tất cả"
                                key-value="sender"
                                key-display="sender"
                            />
                        </div>
                    </div>

                    <a
                        style="margin-left: 24px !important"
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
                    <div class="col-5 dis-set">
                        <p class="text-title">BÁO CÁO CÔNG VĂN, THÔNG BÁO</p>
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
                                <th class="w-85px">Ngày lập</th>
                                <th class="w-100px">Mã công văn, thông báo</th>
                                <th class="w-100px">Tên công văn, thông báo</th>
                                <th class="w-175px">Loại</th>
                                <th class="w-100px">Số công văn, thông báo</th>
                                <th class="w-85px">Ngày hiệu lực</th>
                                <th class="w-85px">Trạng thái</th>
                                <th class="w-200px">Nội dung</th>
                                <th class="w-200px">Ghi chú</th>
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
                                    colspan="10"
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
                                        class="text-dark text-hover-primary d-block text-content w-85px break-text"
                                        :title="item.date"
                                        >{{ moment(new Date(item.date)).format(
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
                                        class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                        :title="item.name"
                                        >{{ item.name }}
                                    </span>
                                </td>
                                <td>
                                    <p
                                        class="text-dark text-hover-primary d-block text-content w-150px break-text mb-1 pb-1 mt-1"
                                    >
                                        {{
                                            item.type === 1
                                                ? "Gửi đi"
                                                : "Tiếp nhận"
                                        }}
                                    </p>
                                    <div v-if="item.type === 1">
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-175px break-text mb-1 pb-1"
                                            :title="item.sender"
                                        >
                                            Người gửi: {{ item.sender  == 'null' ? '' : item.sender  }}
                                        </p>
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-175px break-text pb-1"
                                            :title="item.receiver"
                                        >
                                            Người nhận: {{ item.receiver  == 'null' ? '' : item.receiver  }}
                                        </p>
                                    </div>
                                    <div v-if="item.type === 0">
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-175px break-text mb-1 pb-1"
                                            :title="item.receiver"
                                        >
                                            Người nhận: {{ item.receiver  == 'null' ? '' : item.receiver  }}
                                        </p>
                                        <p
                                            class="text-dark text-hover-primary d-block text-content w-175px break-text pb-1"
                                            :title="item.sender"
                                        >
                                            Người gửi: {{ item.sender  == 'null' ? '' : item.sender  }}
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-100px break-text pb-1 mt-1"
                                        :title="item.number"
                                        >{{ item.number }}</span
                                    >
                                </td>
                                <td>
                                    <p
                                        class="text-dark text-hover-primary d-block text-content w-150px break-text mb-1 pb-1"
                                    >
                                        Từ ngày: {{ moment(new Date(item.from_date)).format(
                                            "DD/MM/YYYY"
                                        ) }}
                                    </p>
                                    <p
                                        class="text-dark text-hover-primary d-block text-content w-150px break-text pb-1"
                                    >
                                        Đến ngày: {{ moment(new Date(item.to_date)).format(
                                            "DD/MM/YYYY"
                                        ) }}
                                    </p>
                                </td>
                                <td>
                                    <div
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-150px break-text pb-1 mt-1"
                                        :title="item.status.data.name"
                                    >
                                        {{ item.status.data.name }}
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-200px break-text pb-1 mt-1"
                                        :title="item.content"
                                        >{{ item.content }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-200px break-text pb-1 mt-1"
                                        :title="item.note"
                                        >{{ item.note }}</span
                                    >
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
                    <div class="mb-5">
                        <span>Tổng</span>
                        <span class="ms-17 me-10">{{
                            totalAllDispatches
                        }}</span>
                        <span>Công văn, thông báo</span>
                    </div>
                    <div class="mb-5">
                        <span>Trong đó</span>
                        <span class="ms-10 me-10">{{
                            totalAllDispatchSens
                        }}</span>
                        <span>Công văn, thông báo gửi đi</span>
                    </div>
                    <div>
                        <span></span>
                        <span class="me-10" style="margin-left: 88px">{{
                            totalAllDispatchRecs
                        }}</span>
                        <span>Công văn thông báo, tiếp nhận</span>
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
                            <td colspan="2" class="name-company" width="25%">
                                <span
                                    >Công ty cổ phần giải pháp công nghệ
                                    Newway</span
                                >
                                <br />
                                <span>74 Hồ Đền Lừ, Hoàng Mai, Hà Nội</span>
                            </td>
                            <td
                                width="38%"
                                colspan="5"
                                class="title-header"
                                style="text-align: center:  !important; "
                            >
                                <p class="title-print-dis">
                                    BÁO CÁO CÔNG VĂN, THÔNG BÁO
                                </p>
                                <p
                                    v-if="from_date == '' && to_date == ''"
                                    class="text-date time-title-dis"
                                >

                                </p>
                                <p
                                    v-else-if="from_date == ''"
                                    class="text-date time-title-dis"
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
                                    class="text-date time-title-dis"
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
                                    class="text-date time-title-dis"
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
                            <th style="text-align: center; width: 20px">STT</th>
                            <th
                                style="
                                    width: 50px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Ngày lập
                            </th>
                            <th
                                style="
                                    width: 125px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Mã công văn, thông báo
                            </th>
                            <th
                                style="
                                    width: 125px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Tên công văn, thông báo
                            </th>
                            <th
                                style="
                                    min-width: 125px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Loại
                            </th>
                            <th class="scv_title"
                                style="
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Số công văn, thông báo
                            </th>
                            <th

                                style="
                                    width: 130px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Ngày hiệu lực
                            </th>
                            <th
                                style="
                                    min-width: 100px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Trạng thái
                            </th>
                            <th
                                style="
                                    min-width: 100px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Nội dung
                            </th>
                            <th
                                style="
                                    min-width: 100px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Ghi chú
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
                                        font-weight: bold;
                                        padding-left: 3rem;
                                    "
                                    colspan="10"
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
                                    {{  item.date === null
                                        ?
                                        ""
                                        :
                                        moment(new Date(item.date)).format(
                                            "DD/MM/YYYY"
                                        )
                                    }}

                                </td>
                                <td style="text-align: left">
                                    {{ item.code }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.name }}
                                </td>
                                <td style="text-align: left">
                                    <p class="margin-top: 5px">
                                        {{
                                            item.type === 1
                                                ? "Gửi đi"
                                                : "Tiếp nhận"
                                        }}
                                    </p>
                                    <p class="margin-top: 5px" v-if="item.type === 1">
                                        Người gửi: {{ item.sender }}
                                    </p>
                                    <p class="margin-top: 5px" v-if="item.type === 1">
                                        Người nhận: {{ item.receiver }}
                                    </p>
                                    <p class="margin-top: 5px" v-if="item.type === 0">
                                        Người nhận: {{ item.receiver }}
                                    </p>
                                    <p class="margin-top: 5px" v-if="item.type === 0">
                                        Người gửi: {{ item.sender }}
                                    </p>
                                </td>
                                <td class="break" style="text-align: left">
                                    {{ item.number }}
                                </td>
                                <td style="text-align: left">
                                    <p class="margin-top: 5px">Từ ngày: {{ moment(new Date(item.from_date)).format(
                                            "DD/MM/YYYY"
                                        ) }}</p>
                                    <p class="margin-top: 5px">Đến ngày: {{ moment(new Date(item.to_date)).format(
                                            "DD/MM/YYYY"
                                        ) }}</p>
                                </td>
                                <td style="text-align: left">
                                    {{ item.status.data.name }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.content }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.note }}
                                </td>
                            </tr>
                        </tbody>
                        <tr class="n-footer">
                            <td colspan="10" style="height: 20px"></td>
                        </tr>
                        <tr style="height: 30px" class="n-footer">
                            <td colspan="2">Tổng:</td>
                            <td>{{ totalAllDispatches }}</td>
                            <td colspan="2">Công văn, thông báo</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="height: 30px" class="n-footer">
                            <td colspan="2">Trong đó:</td>
                            <td>{{ totalAllDispatchSens }}</td>
                            <td colspan="2">Công văn, thông báo gửi đi</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="height: 30px" class="n-footer">
                            <td colspan="2"></td>
                            <td>{{ totalAllDispatchRecs }}</td>
                            <td colspan="2">Công văn thông báo, tiếp nhận</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="n-footer">
                            <td colspan="10" style="height: 10px"></td>
                        </tr>
                        <tr style="height: 50px" class="n-footer">
                            <td colspan="2"></td>
                            <td colspan="2">Người lập biểu</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
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

const from_date = ref(moment().format("YYYY-MM-DD"));
const to_date = ref(moment().format("YYYY-MM-DD"));
const effective_from_date = ref("");
const effective_to_date = ref("");
const project_id = ref("");
const type = ref("");
const sender = ref("");
const receiver = ref("");
const status_id = ref("");

const searchData = reactive({
    from_date: "",
    to_date: "",
    effective_from_date: "",
    effective_to_date: "",
    project_id: "",
    type: "",
    sender: "",
    receiver: "",
    status_id: "",
});

const clickSearch = () => {
    searchData.from_date = from_date.value;
    searchData.to_date = to_date.value;
    searchData.effective_from_date = effective_from_date.value;
    searchData.effective_to_date = effective_to_date.value;
    searchData.project_id = project_id.value;
    searchData.type = type.value;
    searchData.sender = sender.value;
    searchData.receiver = receiver.value;
    searchData.status_id = status_id.value;
    pagination.value.current_page = 1;
    getDispatchReports(searchData);
};

// handle chọn số bản ghi / 1 trang

const currentIndex = ref(-1);
const senders = ref([]);
const receivers = ref([]);
let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};
const totalAllDispatches = ref([]);
const totalAllDispatchSens = ref([]);
const totalAllDispatchRecs = ref([]);
const dispatchReports = ref([]);
let getMetaPaginate = ref({});
const urlExportExcel = ref(null);
const getDispatchReports = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/reports/dispatches/get-all",
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
                totalDispatches,
                totalDispatchSens,
                totalDispatchRecs,
                url_export,
            } = res.data;
            totalAllDispatches.value = totalDispatches;
            totalAllDispatchSens.value = totalDispatchSens;
            totalAllDispatchRecs.value = totalDispatchRecs;
            dispatchReports.value = helperFunc.groupBy(
                data,
                "project_customer_title"
            );
            // dispatchReports.value = data
            // .reduce((group, arr) => {
            //     const { project_customer_title } = arr;
            //     group[project_customer_title] = group[project_customer_title] ?? [];
            //     group[project_customer_title].push(arr);
            //     return group;
            // }, {})
            // ;
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
        url: "/reports/dispatches/getOther",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data } = res;
            projects.value = data.getProjects;
            senders.value = data.getSenders;
            receivers.value = data.getReceivers;

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
    getDispatchReports({ from_date: from_date.value, to_date: to_date.value });
    getOther();
    systemStatusStore.getSystemStatusData(6);
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
.dis-set .text-title {
    font-weight: 700;
    font-size: 17px;
    color: black !important;
    padding-bottom: 5px;
    text-align: center;
    margin-right: 120px;
}
.dis-set .text-date {
    text-align: center;
    margin-right: 120px;
}
.dis-pro-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.dis-pro-set .select-box .options-container {
    width: 149px;
}
/* .dis-pro-set .options-container {
    top: 54px !important;
} */
.dis-type-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.dis-type-set .select-box .options-container {
    width: 149px;
}
/* .dis-type-set .options-container {
    top: 54px !important;
} */
.dis-rec-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.dis-rec-set .select-box .options-container {
    width: 149px;
}
/* .dis-rec-set .options-container {
    top: 54px !important;
} */
.dis-sta-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.dis-sta-set .select-box .options-container {
    width: 149px;
}
/* .dis-sta-set .options-container {
    top: 99px !important;
} */
.dis-sen-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.dis-sen-set .select-box .options-container {
    width: 149px;
}
/* .dis-sen-set .options-container {
    top: 99px !important;
} */
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

    .time-title-dis {
        font-size: 12px;
        margin-left: 110px!important;
    }

    .title-print-dis {
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
        font-size: 12px;
        line-height: 13px;
    }

    .text-content-body {
        font-size: 10px;
        line-height: 13px;
    }

    .n-footer {
        font-size: 10px;
    }

    .scv_title {
       min-width: 50px !important;
       max-width: 50px !important;
    }

    .break {
        word-break: break-all!important;
    }
}
</style>
