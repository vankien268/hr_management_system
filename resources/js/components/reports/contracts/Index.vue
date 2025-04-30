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
                                >Ngày ký</label
                            >
                        </div>
                        <div class="w-125px ms-15 me-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                id="fromDate"
                                placeholder=""
                                v-model="from_date_signing_date"
                                :max="to_date_signing_date"
                            />
                        </div>
                        <div class="w-125px ms-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2 ms-2"
                                id="toDate"
                                v-model="to_date_signing_date"
                                :min="from_date_signing_date"
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
                        <div class="w-125px con-pro-set ms-20">
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
                                >Người phụ trách</label
                            >
                        </div>
                        <div class="w-125px person-con-set ms-6">
                            <SelectSearch
                                :list-data="userCharges"
                                v-model="user_charge_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div>
                    <!-- <a
                        href="#"
                        class="btn btn-sm btn-icon-bg-primary btn-color-light ms-13"
                        @click="clickSearch"
                    >
                        Xuất Excel
                    </a>
                    <a
                        href="#"
                        class="btn btn-sm btn-icon-bg-primary btn-color-light ms-5"
                        @click="clickSearch"
                    >
                        In
                    </a> -->
                </div>
                <div class="d-flex align-items-center flex-wrap ms-3 mb-4">
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-7"
                    >
                        <div class="w-auto">
                            <label class="col-form-label" for="checkCreate"
                                >Ngày hết hạn</label
                            >
                        </div>
                        <div class="w-125px ms-5 me-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                id="fromDate"
                                placeholder=""
                                v-model="from_date_expiration_date"
                                :max="to_date_expiration_date"
                            />
                        </div>
                        <div class="w-125px ms-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2 ms-2"
                                id="toDate"
                                v-model="to_date_expiration_date"
                                :min="from_date_expiration_date"
                            />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto">
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label"
                                >Loại hợp đồng</label
                            >
                        </div>
                        <div class="w-125px con-con-set ms-5">
                            <SelectSearch
                                :list-data="contractTypes"
                                v-model="contract_type_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-3 ms-5"
                    >
                        <div class="w-auto">
                            <label for="customerCode" class="col-form-label"
                                >Trạng thái</label
                            >
                        </div>
                        <div class="w-125px status-con-set ms-18">
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
                        style="margin-left: 15px !important"
                        href="#"
                        class="btn btn-sm btn-icon-bg-primary btn-color-light ms-10"
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
                    <div class="col-5 con-set">
                        <p class="text-title">BÁO CÁO HỢP ĐỒNG</p>
                        <p
                            v-if="
                                from_date_signing_date == '' &&
                                to_date_signing_date == ''
                            "
                            class="text-date"
                        ></p>
                        <p
                            v-else-if="from_date_signing_date == ''"
                            class="text-date"
                        >
                            Ngày:
                            {{
                                moment(new Date(to_date_signing_date)).format(
                                    "DD/MM/YYYY"
                                )
                            }}
                        </p>
                        <p
                            v-else-if="to_date_signing_date == ''"
                            class="text-date"
                        >
                            Ngày:
                            {{
                                moment(new Date(from_date_signing_date)).format(
                                    "DD/MM/YYYY"
                                )
                            }}
                        </p>
                        <p
                            v-else-if="
                                from_date_signing_date != '' &&
                                to_date_signing_date != ''
                            "
                            class="text-date"
                        >
                            Ngày:
                            {{
                                moment(new Date(from_date_signing_date)).format(
                                    "DD/MM/YYYY"
                                )
                            }}
                            -
                            {{
                                moment(new Date(to_date_signing_date)).format(
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
                                <th class="w-15px">STT</th>
                                <th class="w-75px">Số hợp đồng</th>
                                <th class="w-85px">Ngày ký</th>
                                <th class="w-75px">
                                    Đại diện ký
                                    <p>(Phía khách hàng)</p>
                                </th>
                                <th class="w-75px">
                                    Đại diện ký
                                    <p>(Phía công ty)</p>
                                </th>
                                <th class="w-120px">Loại hợp đồng</th>
                                <th class="w-85px">Thời gian thực hiện</th>
                                <th class="w-85px">Thời gian nghiệm thu</th>
                                <th class="w-85px">Ngày hết hạn</th>
                                <th class="w-95px">Trạng thái</th>
                                <th class="w-50px">
                                    TGBH
                                    <p>(Tháng)</p>
                                </th>
                                <th class="w-25px">
                                    SLTT
                                    <p>(Lần)</p>
                                </th>
                                <th class="w-75px">Người phụ trách</th>
                                <th class="w-120px">
                                    GTHĐ
                                    <p>(VNĐ)</p>
                                </th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody
                            v-for="(contractReport, key) in contractReports"
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
                                    colspan="14"
                                >
                                    <p v-html="key"></p>
                                </td>
                            </tr>
                            <tr
                                v-for="(item, index) in contractReport"
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
                                        :title="item.code"
                                        >{{ item.code }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-85px break-text pb-1 mt-1"
                                        :title="item.signing_date"
                                        >{{ moment(new Date(item.signing_date)).format(
                                            "DD/MM/YYYY"
                                        ) }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block text-content w-105px break-text"
                                        :title="item.customer_contractor"
                                        >{{ item.customer_contractor }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        v-for="(
                                            val_user_contracts,
                                            key_user_contracts
                                        ) in item.user_contractor"
                                        :key="key_user_contracts"
                                        class="text-dark text-hover-primary d-block text-content w-75px break-text pb-1 mt-1"
                                        :title="val_user_contracts.name"
                                        >{{ val_user_contracts.name }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        v-for="(
                                            val_contracts_type,
                                            key_contracts_type
                                        ) in item.contract_type"
                                        :key="key_contracts_type"
                                        class="text-dark text-hover-primary d-block text-content w-120px break-text pb-1 mt-1"
                                        :title="val_contracts_type.name"
                                        >{{ val_contracts_type.name }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-85px break-text pb-1 mt-1"
                                        :title="item.start_date"
                                        >
                                        {{ moment(new Date(item.start_date)).format(
                                            "DD/MM/YYYY"
                                        ) }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-85px break-text pb-1 mt-1"
                                        :title="item.hand_over_date"
                                        >{{ moment(new Date(item.hand_over_date)).format(
                                            "DD/MM/YYYY"
                                        ) }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-85px break-text pb-1 mt-1"
                                        :title="item.expiration_date"
                                        >{{ moment(new Date(item.expiration_date)).format(
                                            "DD/MM/YYYY"
                                        ) }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-95px break-text pb-1 mt-1"
                                        :title="item.status.data.name"
                                        >{{ item.status.data.name }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-50px break-text pb-1 mt-1"
                                        :title="item.warranty_time"
                                        >{{ item.warranty_time }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-25px break-text pb-1 mt-1"
                                        :title="item.number_payment"
                                        >{{ item.number_payment }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        v-for="(
                                            val_user_charge, key_user_charge
                                        ) in item.user_charge"
                                        :key="key_user_charge"
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-75px break-text pb-1 mt-1"
                                        :title="val_user_charge.name"
                                        >{{ val_user_charge.name }}</span
                                    >
                                </td>
                                <td>
                                    <span
                                        style="text-align: right;"
                                        class="text-dark text-hover-primary d-block mb-1 fs-6 w-120px break-text pb-1 mt-1"
                                        :title=" displayPrice(item.contract_value)"
                                        >{{ displayPrice(item.contract_value) }}</span
                                    >
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-if="Object.keys(contractReports).length == 0">
                            <tr>
                                <td class="text-center" colspan="14">
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
                        <span class="ms-17 me-10">{{ totalAllContracts }}</span>
                        <span>Hợp đồng</span>
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
                            <td width="10%"
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
                            <td width="33%" class="name-company" style="text-align: left">
                                <span
                                    >Công ty cổ phần giải pháp công nghệ
                                    Newway</span
                                >
                                <br />
                                <span>74 Hồ Đền Lừ, Hoàng Mai, Hà Nội</span>
                            </td>
                            <td width="38%"
                                class="title-header"
                                style="text-align: center:  !important; "
                            >
                                <p class="title-print-con">BÁO CÁO HỢP ĐỒNG</p>
                                <p
                                    v-if="
                                        from_date_signing_date == '' &&
                                        to_date_signing_date == ''
                                    "
                                    class="text-date time-title-con"
                                ></p>
                                <p
                                    v-else-if="from_date_signing_date == ''"
                                    class="text-date time-title-con"
                                >
                                    Ngày:
                                    {{
                                        moment(
                                            new Date(to_date_signing_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                </p>
                                <p
                                    v-else-if="to_date_signing_date == ''"
                                    class="text-date time-title-con"
                                >
                                    Ngày:
                                    {{
                                        moment(
                                            new Date(from_date_signing_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                </p>
                                <p
                                    v-else-if="
                                        from_date_signing_date != '' &&
                                        to_date_signing_date != ''
                                    "
                                    class="text-date time-title-con"
                                >
                                    Ngày:
                                    {{
                                        moment(
                                            new Date(from_date_signing_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                    -
                                    {{
                                        moment(
                                            new Date(to_date_signing_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                </p>
                            </td>
                            <td width="18%"
                                class="date-time-print"
                                style="text-align: right"
                            >
                                <span>Ngày in: {{ time }}</span>
                                <br />
                                <span>Người in: {{ props.name }}</span>
                            </td>
                        </tr>
                        <tr class="n-header">
                            <td colspan="14" style="height: 20px"></td>
                        </tr>
                    </table>
                    <table>
                        <tr
                            class="n-body text-title-body"
                            style="font-weight: bold; height: 50px"
                        >
                            <th
                                style="
                                    text-align: center;
                                    min-width: 10px !important;
                                    max-width: 10px !important;
                                "
                            >
                                STT
                            </th>
                            <th
                                class="shd_title"
                                style="
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Số hợp đồng
                            </th>
                            <th
                                style="
                                    width: 50px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Ngày ký
                            </th>
                            <th
                                style="
                                    min-width: 85px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Đại diện ký
                                <p>(Khách hàng)</p>
                            </th>
                            <th
                                style="
                                    min-width: 85px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Đại diện ký
                                <p>(Công ty)</p>
                            </th>
                            <th
                                style="
                                    min-width: 100px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Loại hợp đồng
                            </th>
                            <th
                                style="
                                    width: 50px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Thời gian thực hiện
                            </th>
                            <th
                                style="
                                    width: 50px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Thời gian nghiệm thu
                            </th>
                            <th
                                style="
                                    width: 75px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Ngày hết hạn
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
                                    width: 150px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                TGBH
                                <p>(Tháng)</p>
                            </th>
                            <th
                                style="
                                    width: 50px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                SLTT
                                <p>(Lần)</p>
                            </th>
                            <th
                                style="
                                    width: 150px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Người phụ trách
                            </th>
                            <th
                                style="
                                    width: 100px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                GTHĐ
                                <p>(VNĐ)</p>
                            </th>
                        </tr>
                        <tbody
                            v-for="(contractReport, key) in contractReports"
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
                                    colspan="14"
                                >
                                    <p v-html="key"></p>
                                </td>
                            </tr>
                            <tr
                                v-for="(item, index) in contractReport"
                                :key="index"
                            >
                                <td style="text-align: center">
                                    {{
                                        pagination.per_page *
                                            (pagination.current_page - 1) +
                                        (item.stt + 1)
                                    }}
                                </td>
                                <td class="break" style="text-align: left">
                                    {{ item.code }}
                                </td>
                                <td style="text-align: left">
                                    {{
                                        moment(
                                            new Date(item.signing_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.customer_contractor }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.user_contractor.data.name }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.contract_type.data.name }}
                                </td>
                                <td style="text-align: left">
                                    {{
                                        moment(
                                            new Date(item.start_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                </td>
                                <td style="text-align: left">
                                    {{
                                        moment(
                                            new Date(item.hand_over_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                </td>
                                <td style="text-align: left">
                                    {{
                                        moment(
                                            new Date(item.expiration_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.status.data.name }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.warranty_time }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.number_payment }}
                                </td>
                                <td style="text-align: left">
                                    {{ item.user_charge.data.name }}
                                </td>
                                <td style="text-align: right">
                                    {{ displayPrice(item.contract_value) }}
                                </td>
                            </tr>
                        </tbody>
                        <tr class="n-footer">
                            <td colspan="14" style="height: 20px"></td>
                        </tr>
                        <tr class="n-footer" style="height: 30px">
                            <td colspan="2">Tổng:</td>
                            <td>{{ totalAllContracts }}</td>
                            <td colspan="2">Hợp đồng</td>
                            <td colspan="9"></td>
                        </tr>
                        <tr class="n-footer" style="height: 50px">
                            <td colspan="2"></td>
                            <td colspan="2">Người lập biểu</td>
                            <td colspan="7"></td>
                            <td colspan="3">Trưởng bộ phận</td>
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
import { displayPrice } from "../../../../services/utils";
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

const from_date_signing_date = ref(moment().format("YYYY-MM-DD"));
const to_date_signing_date = ref(moment().format("YYYY-MM-DD"));
const from_date_expiration_date = ref("");
const to_date_expiration_date = ref("");
const project_id = ref("");
const user_charge_id = ref("");
const contract_type_id = ref("");
const status_id = ref("");

const searchData = reactive({
    from_date_signing_date: "",
    to_date_signing_date: "",
    from_date_expiration_date: "",
    to_date_expiration_date: "",
    project_id: "",
    user_charge_id: "",
    contract_type_id: "",
    status_id: "",
});

const clickSearch = () => {
    searchData.from_date_signing_date = from_date_signing_date.value;
    searchData.to_date_signing_date = to_date_signing_date.value;
    searchData.from_date_expiration_date = from_date_expiration_date.value;
    searchData.to_date_expiration_date = to_date_expiration_date.value;
    searchData.project_id = project_id.value;
    searchData.user_charge_id = user_charge_id.value;
    searchData.contract_type_id = contract_type_id.value;
    searchData.status_id = status_id.value;
    pagination.value.current_page = 1;
    getContractReports(searchData);
};

// handle chọn số bản ghi / 1 trang

const currentIndex = ref(-1);

let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};
const totalAllContracts = ref([]);
const contractReports = ref([]);
let getMetaPaginate = ref({});
const urlExportExcel = ref(null);
const getContractReports = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/reports/contracts/get-all",
        method: "GET",
        params: {
            ...params,
            per_page: selectTotalRecord.value,
            page: pagination.value.current_page,
        },
    })
        .then((res) => {
            const { data, meta, totalContracts, url_export } = res.data;
            totalAllContracts.value = totalContracts;
            contractReports.value = helperFunc.groupBy(
                data,
                "project_customer_title"
            );
            // contractReports.value = data
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
const userCharges = ref([]);
const contractTypes = ref([]);
const systemStatus = ref([]);
const getOther = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/reports/contracts/getOther",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data } = res;
            projects.value = data.getProjects;
            userCharges.value = data.getUserCharges;
            contractTypes.value = data.getContractTypes;
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
    getContractReports(searchData);
};

onMounted(() => {
    getContractReports({
        from_date_signing_date: from_date_signing_date.value,
        to_date_signing_date: to_date_signing_date.value,
    });
    getOther();
    systemStatusStore.getSystemStatusData(1);
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
.con-set .text-title {
    font-weight: 700;
    font-size: 17px;
    color: black !important;
    padding-bottom: 5px;
    text-align: center;
    margin-right: 200px;
}
.con-set .text-date {
    text-align: center;
    margin-right: 200px;
}
.con-pro-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.con-pro-set .select-box .options-container {
    width: 122px;
}
/* .con-pro-set .options-container {
    top: 54px !important;
} */
.con-con-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.con-con-set .select-box .options-container {
    width: 122px;
}
/* .con-con-set .options-container {
    top: 99px !important;
} */
.person-con-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.person-con-set select {
    padding: 6px !important;
}
.person-con-set .select-box .options-container {
    width: 122px;
}
/* .person-con-set .options-container {
    top: 54px !important;
} */
.status-con-set .select-box .options-container {
    width: 122px;
}
/* .status-con-set .options-container {
    top: 100px !important;
} */
.status-con-set .selected {
    padding: 13px 24px 13px 8px !important;
}
@media print {
    .noPrint {
        display: none !important;
    }
    .showOnPrint {
        display: block !important;
        font-family: Helvetica, Arial, sans-serif;
        color: #000000 !important;
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
        color: 000000 !important;
    }

    .time-title-con {
        font-size: 12px;
        margin-left: 35px !important;
    }

    .title-print-con {
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
        color: #000000 !important;
        font-size: 10px;
        line-height: 13px;
    }

    .text-content-body {
        font-size: 10px;
        color: #000000 !important;
        line-height: 13px;
    }

    .n-footer {
        font-size: 12px;
        color: #000000 !important;
    }

    .shd_title {
       min-width: 100px !important;
       max-width: 100px !important;
    }

    .break {
        word-break: break-all!important;
    }
}
</style>
