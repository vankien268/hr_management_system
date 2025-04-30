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
                        class="d-flex align-items-center flex-wrap w-auto me-4"
                    >
                        <div class="w-auto me-20">
                            <label for="customerCode" class="col-form-label"
                                >Dự án</label
                            >
                        </div>
                        <div class="w-275px contract-pro-set ms-20">
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
                        <div class="w-auto me-12">
                            <label for="customerCode" class="col-form-label"
                                >Hợp đồng</label
                            >
                        </div>
                        <div class="w-275px contract-con-set ms-20">
                            <SelectSearch
                                :list-data="contracts"
                                v-model="contract_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="code"
                            />
                        </div>
                    </div>
                    <a
                        style="margin-left: 16px !important"
                        href="#"
                        class="btn btn-sm btn-icon-bg-primary btn-color-light ms-7"
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
                <div class="d-flex align-items-center flex-wrap ms-3 mb-4">
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-6"
                    >
                        <div class="w-auto">
                            <label class="col-form-label" for="checkCreate"
                                >Ngày thanh toán dự kiến</label
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
                        <div class="w-125px ms-3">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2 ms-2"
                                id="toDate"
                                v-model="expected_payment_to_date"
                                :min="expected_payment_from_date"
                            />
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center flex-wrap w-auto me-5"
                    >
                        <div class="w-auto">
                            <label class="col-form-label" for="checkCreate"
                                >Ngày thanh toán thực tế</label
                            >
                        </div>
                        <div class="w-125px ms-5 me-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2"
                                id="fromDate"
                                placeholder=""
                                v-model="payment_date_from_date"
                                :max="payment_date_to_date"
                            />
                        </div>
                        <div class="w-125px ms-2">
                            <input
                                type="date"
                                class="form-control mb-lg-0 p-2 ms-3"
                                id="toDate"
                                v-model="payment_date_to_date"
                                :min="payment_date_from_date"
                            />
                        </div>
                    </div>
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
                    <div class="col-5 pay-con-set">
                        <p
                            style="margin-right: 115px !important"
                            class="text-title"
                        >
                            BÁO CÁO TIẾN ĐỘ THANH TOÁN HỢP ĐỒNG
                        </p>
                        <p
                            v-if="
                                payment_date_from_date == '' &&
                                payment_date_to_date == ''
                            "
                            class="text-date"
                        ></p>
                        <p
                            v-else-if="payment_date_from_date == ''"
                            class="text-date"
                        >
                            Ngày:
                            {{
                                moment(new Date(payment_date_to_date)).format(
                                    "DD/MM/YYYY"
                                )
                            }}
                        </p>
                        <p
                            v-else-if="payment_date_to_date == ''"
                            class="text-date"
                        >
                            Ngày:
                            {{
                                moment(new Date(payment_date_from_date)).format(
                                    "DD/MM/YYYY"
                                )
                            }}
                        </p>
                        <p
                            v-else-if="
                                payment_date_from_date != '' &&
                                payment_date_to_date != ''
                            "
                            class="text-date"
                        >
                            Ngày:
                            {{
                                moment(new Date(payment_date_from_date)).format(
                                    "DD/MM/YYYY"
                                )
                            }}
                            -
                            {{
                                moment(new Date(payment_date_to_date)).format(
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
                                <th class="w-35px">LẦN</th>
                                <th class="w-100px">NGÀY THANH TOÁN DỰ KIẾN</th>
                                <th class="w-100px">
                                    SỐ TIỀN THANH TOÁN DỰ KIẾN
                                </th>
                                <th class="w-100px">NGÀY THANH TOÁN THỰC TẾ</th>
                                <th class="w-150px">
                                    SỐ TIỀN THANH TOÁN THỰC TẾ
                                </th>
                                <th class="w-100px">CHƯA THANH TOÁN</th>
                                <th class="w-25px">GHI CHÚ</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody
                            v-for="(
                                dispatchReport, key
                            ) in paymentDetailContractReports"
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
                                    colspan="9"
                                >
                                    <p
                                        :title="
                                            dispatchReport.code +
                                            ' - ' +
                                            dispatchReport.name
                                        "
                                        class="pt-1 pb-1 d-block break-text w-300px"
                                    >
                                        {{ dispatchReport.code }} -
                                        {{ dispatchReport.name }}
                                    </p>
                                    <p
                                        class="pb-1"
                                        :title="
                                            dispatchReport.customer.data.code +
                                            ' - ' +
                                            dispatchReport.customer.data.name
                                        "
                                    >
                                        {{ dispatchReport.customer.data.code }}
                                        -
                                        {{ dispatchReport.customer.data.name }}
                                    </p>
                                </td>
                            </tr>
                            <template
                                v-for="(
                                    val_contracts, key_contracts
                                ) in dispatchReport.contracts.data"
                                :key="key_contracts"
                            >
                                <tr
                                    class="max-h-75 overflow-auto cursor-pointer"
                                >
                                    <td>
                                        {{ key_contracts + 1 }}
                                    </td>
                                    <td
                                        class="h-40px fw-medium pointer-events-none"
                                        style="
                                            font-size: 14px;
                                            padding-left: 3rem;
                                        "
                                        colspan="9"
                                    >
                                        <p class="pt-1 pb-1">
                                            Ngày kí:
                                            {{ moment(new Date(val_contracts.signing_date)).format(
                                            "DD/MM/YYYY"
                                        ) }}
                                        </p>
                                        <p
                                            :title="val_contracts.code"
                                            class="pb-1 w-250px d-block break-text"
                                        >
                                            Số hợp đồng:
                                            {{ val_contracts.code }}
                                        </p>
                                    </td>
                                </tr>
                                <template
                                    v-for="(
                                        val_payment_details, key_payment_details
                                    ) in val_contracts.payment_details.data"
                                    :key="key_payment_details"
                                >
                                    <tr>
                                        <td>
                                            <span
                                                class="text-dark d-block text-hover-primary w-15px fs-6"
                                            >
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark text-hover-primary d-block text-content w-35px break-text"
                                                :title="
                                                    val_payment_details.payment_times
                                                "
                                                >Lần
                                                {{
                                                    val_payment_details.payment_times
                                                }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark text-hover-primary d-block text-content w-100px break-text pb-1 mt-1"
                                                >
                                                {{ moment(new Date( val_payment_details.expected_payment_date)).format(
                                            "DD/MM/YYYY"
                                        ) }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <span
                                                class="text-dark text-hover-primary d-block text-content w-160px break-text pb-1 mt-1"
                                                :title="
                                                    val_payment_details.amount
                                                "
                                            >
                                                {{
                                                    displayPrice(
                                                        val_payment_details.amount
                                                    )
                                                }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                >
                                                {{ moment(new Date( val_payment_details.payment_date)).format(
                                            "DD/MM/YYYY"
                                        ) }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <span
                                                class="text-dark text-hover-primary d-block text-content break-text pb-1 mt-1"
                                                :title="
                                                    val_payment_details.actual_amount
                                                "
                                                >{{
                                                    displayPrice(
                                                        val_payment_details.actual_amount
                                                    )
                                                }}</span
                                            >
                                        </td>
                                        <td class="text-right">
                                            <span
                                                class="text-dark text-hover-primary d-block text-content break-text pb-1 mt-1"
                                                :title="
                                                    val_payment_details.actual_amount
                                                "
                                            >
                                                {{
                                                    displayPrice(
                                                        val_payment_details.amount -
                                                            val_payment_details.actual_amount
                                                    )
                                                }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark text-hover-primary d-block text-content w-75px break-text pb-1 mt-1"
                                                :title="
                                                    val_payment_details.note
                                                "
                                                >{{
                                                    val_payment_details.note
                                                }}</span
                                            >
                                        </td>
                                    </tr>
                                </template>
                                <tr>
                                    <td></td>
                                    <td
                                        colspan="2"
                                        style="
                                            text-align: center;
                                            font-weight: bold;
                                        "
                                    >
                                        <span
                                            class="text-dark text-hover-primary d-block text-content w-250px break-text pb-1 mt-1"
                                        >
                                            Tổng doanh thu hợp đồng
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <span
                                            class="text-dark text-hover-primary d-block text-content w-160px break-text pb-1 mt-1"
                                        >
                                            {{
                                                displayPrice(
                                                    total_amount_contract(
                                                        val_contracts
                                                            .payment_details
                                                            .data
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
                                    <td class="text-right">
                                        <span
                                            class="text-dark text-hover-primary d-block text-content break-text pb-1 mt-1"
                                        >
                                            {{
                                                displayPrice(
                                                    total_actual_amount_contract(
                                                        val_contracts
                                                            .payment_details
                                                            .data
                                                    )
                                                )
                                            }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <span
                                            class="text-dark text-hover-primary d-block text-content break-text pb-1 mt-1"
                                        >
                                            {{
                                                displayPrice(
                                                    total_amount_contract(
                                                        val_contracts
                                                            .payment_details
                                                            .data
                                                    ) -
                                                        total_actual_amount_contract(
                                                            val_contracts
                                                                .payment_details
                                                                .data
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
                            </template>
                            <tr>
                                <td colspan="3">
                                    <span
                                        style="font-weight: bold"
                                        class="text-center text-dark text-hover-primary d-block text-content w-250px break-text pb-1 mt-1"
                                    >
                                        Tổng doanh thu dự án
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span
                                        class="text-dark text-hover-primary d-block text-content break-text pb-1 mt-1"
                                    >
                                        {{
                                            displayPrice(
                                                total_amount_project(
                                                    dispatchReport
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
                                <td class="text-right">
                                    <span
                                        class="text-dark text-hover-primary d-block text-content break-text pb-1 mt-1"
                                    >
                                        {{
                                            displayPrice(
                                                total_actual_amount_project(
                                                    dispatchReport
                                                )
                                            )
                                        }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span
                                        class="text-dark text-hover-primary d-block text-content break-text pb-1 mt-1"
                                    >
                                        {{
                                            displayPrice(
                                                total_amount_project(
                                                    dispatchReport
                                                ) -
                                                    total_actual_amount_project(
                                                        dispatchReport
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
                        <tbody
                            v-if="
                                Object.keys(paymentDetailContractReports)
                                    .length == 0
                            "
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
                            <td colspan="2" class="name-company" width="25%">
                                <span
                                    >Công ty cổ phần giải pháp công nghệ
                                    Newway</span
                                >
                                <br />
                                <span>74 Hồ Đền Lừ, Hoàng Mai, Hà Nội</span>
                            </td>
                            <td
                                width="40%"
                                class="title-header"
                                style="text-align: center:  !important; "
                                colspan="4"
                            >
                                <p class="title-print-pay">
                                    BÁO CÁO TIẾN ĐỘ THANH TOÁN HỢP ĐỒNG
                                </p>
                                <p
                                    v-if="
                                        payment_date_from_date == '' &&
                                        payment_date_to_date == ''
                                    "
                                    class="text-date time-title-pay"
                                ></p>
                                <p
                                    v-else-if="payment_date_from_date == ''"
                                    class="text-date time-title-pay"
                                >
                                    Ngày:
                                    {{
                                        moment(
                                            new Date(payment_date_to_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                </p>
                                <p
                                    v-else-if="payment_date_to_date == ''"
                                    class="text-date time-title-pay"
                                >
                                    Ngày:
                                    {{
                                        moment(
                                            new Date(payment_date_from_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                </p>
                                <p
                                    v-else-if="
                                        payment_date_from_date != '' &&
                                        payment_date_to_date != ''
                                    "
                                    class="text-date time-title-pay"
                                >
                                    Ngày:
                                    {{
                                        moment(
                                            new Date(payment_date_from_date)
                                        ).format("DD/MM/YYYY")
                                    }}
                                    -
                                    {{
                                        moment(
                                            new Date(payment_date_to_date)
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
                    </table>
                    <tr>
                        <td colspan="9" class="n-header-payment"></td>
                    </tr>
                    <table>
                        <tr
                            class="n-body text-title-body"
                            style="font-weight: bold; height: 50px"
                        >
                            <th style="width: 20px">STT</th>
                            <th
                                style="
                                    width: 75px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Lần
                            </th>
                            <th
                                style="
                                    width: 150px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Ngày thanh toán dự kiến
                            </th>
                            <th
                                style="
                                    width: 300px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Số tiền thanh toán dự kiến
                            </th>
                            <th
                                style="
                                    width: 275px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Ngày thanh toán thực tế
                            </th>
                            <th
                                style="
                                    width: 275px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Số tiền thanh toán thực tế
                            </th>
                            <th
                                style="
                                    width: 275px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Chưa thanh toán
                            </th>
                            <th
                                style="
                                    width: 400px;
                                    text-align: left;
                                    padding: 0 2px 0 5px;
                                "
                            >
                                Ghi chú
                            </th>
                        </tr>
                        <tbody
                            v-for="(
                                dispatchReport, key
                            ) in paymentDetailContractReports"
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
                                    "
                                    colspan="9"
                                >
                                    <p style="font-weight: bold">
                                        {{ dispatchReport.code }} -
                                        {{ dispatchReport.name }}
                                    </p>
                                    <p style="font-weight: bold">
                                        {{ dispatchReport.customer.data.code }}
                                        -
                                        {{ dispatchReport.customer.data.name }}
                                    </p>
                                </td>
                            </tr>
                            <template
                                v-for="(
                                    val_contracts, key_contracts
                                ) in dispatchReport.contracts.data"
                                :key="key_contracts"
                            >
                                <tr
                                    class="max-h-75 overflow-auto cursor-pointer"
                                >
                                    <td>
                                        {{ key_contracts + 1 }}
                                    </td>
                                    <td
                                        class="h-40px fw-medium pointer-events-none"
                                        style="
                                            /* font-size: 14px; */
                                            color: black;
                                            padding-left: 3rem;
                                            font-weight: bold;
                                        "
                                        colspan="9"
                                    >
                                        <p
                                            style="
                                                color: black;
                                                font-weight: bold;
                                            "
                                        >
                                            Ngày kí:
                                            {{
                                                moment(
                                                    new Date(
                                                        val_contracts.signing_date
                                                    )
                                                ).format("DD/MM/YYYY")
                                            }}
                                        </p>
                                        <p
                                            style="
                                                color: black;
                                                font-weight: bold;
                                            "
                                        >
                                            Số hợp đồng:
                                            {{ val_contracts.code }}
                                        </p>
                                    </td>
                                </tr>
                                <template
                                    v-for="(
                                        val_payment_details, key_payment_details
                                    ) in val_contracts.payment_details.data"
                                    :key="key_payment_details"
                                >
                                    <tr>
                                        <td></td>
                                        <td style="text-align: left">
                                            Lần
                                            {{
                                                val_payment_details.payment_times
                                            }}
                                        </td>
                                        <td style="text-align: left">
                                            {{
                                                moment(
                                                    new Date(
                                                        val_payment_details.expected_payment_date
                                                    )
                                                ).format("DD/MM/YYYY")
                                            }}
                                        </td>
                                        <td style="text-align: right">
                                            {{
                                                displayPrice(
                                                    val_payment_details.amount
                                                )
                                            }}
                                        </td>
                                        <td style="text-align: left">
                                            {{
                                                moment(
                                                    new Date(
                                                        val_payment_details.payment_date
                                                    )
                                                ).format("DD/MM/YYYY")
                                            }}
                                        </td>
                                        <td style="text-align: right">
                                            {{
                                                displayPrice(
                                                    val_payment_details.actual_amount
                                                )
                                            }}
                                        </td>
                                        <td style="text-align: right">
                                            {{
                                                displayPrice(
                                                    val_payment_details.amount -
                                                        val_payment_details.actual_amount
                                                )
                                            }}
                                        </td>
                                        <td style="text-align: left">
                                            {{ val_payment_details.note }}
                                        </td>
                                    </tr>
                                </template>
                                <tr>
                                    <td></td>
                                    <td colspan="2">
                                        <span
                                            style="
                                                color: black;
                                                font-weight: bold;
                                            "
                                        >
                                            Tổng doanh thu hợp đồng
                                        </span>
                                    </td>
                                    <td style="text-align: right">
                                        <span>
                                            {{
                                                displayPrice(
                                                    total_amount_contract(
                                                        val_contracts
                                                            .payment_details
                                                            .data
                                                    )
                                                )
                                            }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <span> </span>
                                    </td>
                                    <td style="text-align: right">
                                        <span>
                                            {{
                                                displayPrice(
                                                    total_actual_amount_contract(
                                                        val_contracts
                                                            .payment_details
                                                            .data
                                                    )
                                                )
                                            }}
                                        </span>
                                    </td>
                                    <td style="text-align: right">
                                        <span>
                                            {{
                                                displayPrice(
                                                    total_amount_contract(
                                                        val_contracts
                                                            .payment_details
                                                            .data
                                                    ) -
                                                        total_actual_amount_contract(
                                                            val_contracts
                                                                .payment_details
                                                                .data
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
                            </template>
                            <tr>
                                <td colspan="3">
                                    <span
                                        style="color: black; font-weight: bold"
                                    >
                                        Tổng doanh thu dự án
                                    </span>
                                </td>
                                <td style="text-align: right">
                                    <span>
                                        {{
                                            displayPrice(
                                                total_amount_project(
                                                    dispatchReport
                                                )
                                            )
                                        }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span> </span>
                                </td>
                                <td style="text-align: right">
                                    <span>
                                        {{
                                            displayPrice(
                                                total_actual_amount_project(
                                                    dispatchReport
                                                )
                                            )
                                        }}
                                    </span>
                                </td>
                                <td style="text-align: right">
                                    <span>
                                        {{
                                            displayPrice(
                                                total_amount_project(
                                                    dispatchReport
                                                ) -
                                                    total_actual_amount_project(
                                                        dispatchReport
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
                        <tr class="n-footer">
                            <td colspan="9" style="height: 20px"></td>
                        </tr>
                        <tr style="height: 50px" class="n-footer">
                            <td colspan="2"></td>
                            <td colspan="2">Người lập biểu</td>
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
import { displayPrice } from "../../../../services/utils";
import { helperFunc } from "../../../helper/heplerFunction";
import moment from "moment";
import SelectSearch from "../../input/SelectSearch.vue";
const props = defineProps({
    title: String,
    name: {
        type: String,
        default: "user",
    },
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

const expected_payment_from_date = ref("");
const expected_payment_to_date = ref("");
const payment_date_from_date = ref(moment().format("YYYY-MM-DD"));
const payment_date_to_date = ref(moment().format("YYYY-MM-DD"));
const project_id = ref("");
const contract_id = ref("");
const status_id = ref("");

const searchData = reactive({
    expected_payment_from_date: "",
    expected_payment_to_date: "",
    payment_date_from_date: "",
    payment_date_to_date: "",
    project_id: "",
    contract_id: "",
    status_id: "",
});

const clickSearch = () => {
    searchData.expected_payment_from_date = expected_payment_from_date.value;
    searchData.expected_payment_to_date = expected_payment_to_date.value;
    searchData.payment_date_from_date = payment_date_from_date.value;
    searchData.payment_date_to_date = payment_date_to_date.value;
    searchData.project_id = project_id.value;
    searchData.contract_id = contract_id.value;
    ``;
    searchData.status_id = status_id.value;
    pagination.value.current_page = 1;
    getPaymentDetailContractReports(searchData);
};

// handle chọn số bản ghi / 1 trang

const currentIndex = ref(-1);

let selectTotalRecord = ref(30);
const handleClickItem = (numberPage) => {
    selectTotalRecord.value = numberPage;
};
const paymentDetailContractReports = ref([]);
let getMetaPaginate = ref({});
const urlExportExcel = ref(null);
const getPaymentDetailContractReports = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/reports/payment-details-contracts/get-all",
        method: "GET",
        params: {
            ...params,
            per_page: selectTotalRecord.value,
            page: pagination.value.current_page,
        },
    })
        .then((res) => {
            const { data, meta, url_export } = res.data;
            paymentDetailContractReports.value = data;
            paymentDetailContractReports.value = paymentDetailContractReports.value.filter(item => {
                if(item.contracts.data.length > 0) {
                    return item;
                }

            })
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
const contracts = ref([]);
const systemStatus = ref([]);
const getOther = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/reports/payment-details-contracts/getOther",
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
    getPaymentDetailContractReports(searchData);
};

onMounted(() => {
    getPaymentDetailContractReports({
        payment_date_from_date: payment_date_from_date.value,
        payment_date_to_date: payment_date_to_date.value,
    });
    getOther();
    getTime();
    setInterval(getTime, 500);
});
//tổng số tiền thanh toán dự kiến hợp đồng
const total_amount_contract = (data) => {
    return data.reduce((total, item) => {
        total += item.amount;
        return total;
    }, 0);
};
//tổng số tiền thanh toán thực tế hợp đồng
const total_actual_amount_contract = (data) => {
    return data.reduce((total, item) => {
        total += item.actual_amount;
        return total;
    }, 0);
};
//tổng số tiền thanh toán dự kiến dự án
const total_amount_project = (project) => {
    let total = 0;
    project.contracts.data.forEach((contract) => {
        contract.paymentDetails.data.forEach((item) => {
            total += item.amount;
            return item;
        });
        return contract;
    });
    return total;
};
//tổng số tiền thanh toán dự kiến thực tế
const total_actual_amount_project = (project) => {
    let total = 0;
    project.contracts.data.forEach((contract) => {
        contract.paymentDetails.data.forEach((item) => {
            total += item.actual_amount;
            return item;
        });
        return contract;
    });
    return total;
};
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
.pay-con-set .text-title {
    font-weight: 700;
    font-size: 17px;
    color: black !important;
    padding-bottom: 5px;
    text-align: center;
    margin-right: 120px;
}
.pay-con-set .text-date {
    text-align: center;
    margin-right: 120px;
}
.contract-pro-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.contract-pro-set .select-box .options-container {
    width: 273px;
}
/* .contract-pro-set .options-container {
    top: 57px ;
} */
.contract-con-set .selected {
    padding: 13px 24px 13px 8px !important;
}
.contract-con-set .select-box .options-container {
    width: 273px;
}
/* .contract-con-set .options-container {
    top: 57px !important;
} */
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
        color: black !important;
    }

    .time-title-pay {
        font-size: 12px;
        margin-left: 110px !important;
    }

    .title-print-pay {
        font-size: 18px;
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

    .n-header-payment{
        height: 20px !important;
    }
}
</style>
