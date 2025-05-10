<template>
    <div class="card">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">{{ title }}</span>
            </h3>

            <div class="card-toolbar">
                <!--begin::Menu-->
                <div class="align-items-right">
                    <a
                        href="#"
                        class="btn btn-function me-2"
                        @click="clickCreateRequestTicket"
                        data-bs-target="#formCreateRequestTicket"
                        data-bs-toggle="modal"
                        v-if="props.btnAdd"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm phiếu yêu cầu</a
                    >
                </div>
                <!--begin::Menu 2-->
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3 text-nowrap">
            <!--begin::Table container-->
            <div class="table-responsive table-responsive table-scroll">
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
                    <tr class="fw-bold text-muted">
                        <th class="w-50px" style="text-align: center">
                            STT
                        </th>
                        <th class="min-w-150px">Tiêu đề phiếu yêu cầu</th>
                        <th class="min-w-140px">Thời gian</th>
                        <th class="min-w-100px">Người yêu cầu</th>
                        <th class="min-w-100px">Trạng thái</th>
                        <th class="min-w-180px">Người duyệt	</th>
                        <th class="min-w-100px">Ngày tạo</th>
                        <th class="min-w-100px text-center" colspan="2">Hành động</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    <tr v-for="(item, index) in requestTickets" :key="index"
                        :class="{active : item.id == currentIndex}" @click="currentIndex = item.id"
                    >
                        <td style="text-align: center">
                                <span
                                    class="text-dark text-hover-primary fs-6"
                                >{{
                                        pagination.per_page *
                                            (pagination.current_page - 1) +
                                        1 +
                                        index
                                    }}</span
                                >
                        </td>
                        <td >
                            <a href="#" @click="handleDetailRequestTicket(item)"  :data-bs-target="item.request_status === 0 ? '#detailApprover' : null"
                               data-bs-toggle="modal">
                                <span
                                    class="text-dark text-hover-primary text-content"
                                >{{ item.request_title }}</span
                                >

                            </a>
                        </td>
                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                > Từ {{ `${ moment(new Date(item.start_date)).format('DD/MM/YYYY HH:mm')}
             - ${moment(new Date(item.end_date)).format('DD/MM/YYYY HH:mm')}` }}</span
                                >
                        </td>

                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >{{ item.creator_name }}</span
                                >
                        </td>

                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >{{ item.request_status_name }}</span
                                >
                        </td>

                        <td style="white-space: normal; word-break: break-word;">
                            <b style="padding: 2px;padding-top:100px;">{{ item.user_approvers }}</b>
                        </td>

                        <td>
                                <span
                                    class="text-dark text-hover-primary d-block mb-1 text-content"
                                >{{ item.created_at }}</span
                                >
                        </td>

                        <td class="w-50px text-center">
                            <a v-if="item.is_edit"
                                href="#"
                                @click="handleUpdate(item)"
                                data-bs-target="#formCreateRequestTicket"
                                data-bs-toggle="modal"
                                class="btn btn-icon btn-edit btn-sm"
                            >
                                <i
                                    class="ki-duotone ki-pencil fs-2"
                                >
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </a>
                        </td>
                        <td class="w-50px">
                            <a v-if="item.is_deleted"
                                href="#"
                                @click.prevent="handleDelete(item.id)"
                                class="btn btn-icon btn-delete btn-sm me-1"
                            >
                                <i class="fa-solid fa-trash fs-5"></i>
                            </a>
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
    <div
        class="modal fade"
        id="formCreateRequestTicket"
        style="position: fixed"
        data-bs-keyboard="false"
        data-bs-backdrop="static"
    >
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header justify-content-left border-0 pb-0">
                    <!--begin::Close-->
                    <h4 class="modal-title">
                        {{
                        isClickRequestTicketUpdate
                        ? "Sửa phiếu yêu cầu"
                        : "Thêm mới phiếu yêu cầu"
                        }}
                    </h4>
                    <div class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2" data-bs-dismiss="modal" @click="closeModalUser" id="close"
                         aria-label="Close">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div
                    class="modal-body pb-2"
                >
                    <!--begin:Form-->
                    <form id="kt_modal_new_target_form" class="form" action="#">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="required">Tên phiếu yêu cầu</span>
                            </label>
                            <!--end::Label-->
                            <input
                                   type="text"
                                   class="form-control text-input"
                                   :class="{
                                    'input-custom-valid': errors.request_title,
                                }"
                                   v-model="formRequestTicket.request_title"
                                   placeholder="Nhập tiêu đề phiếu yêu cầu"
                                   name="target_title"
                            />
                            <div class="w-100"></div>
                            <span
                                v-if="errors.request_title"
                                class="text-danger mt-3"
                            >{{ errors.request_title[0] }}</span
                            >
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-2"
                            >
                                <span class="required">Loại phiếu yêu cầu</span>
                            </label>
                            <!--end::Label-->
                            <select
                                    style="height:29px;" class="form-select"
                                    v-model="formRequestTicket.workflow_id" :class="{ 'select-custom-valid' :  errors.workflow_id }" data-hide-search="true" data-placeholder="Chọn loại dự án" name="target_assign">
                                <option v-for="(item, index) in workflows"
                                        :key="index" :value="item.id">
                                    {{  `${item.workflow_name}` }}
                                </option>
                            </select>
                            <div class="w-100"></div>
                            <span v-if="errors.workflow_id" class="text-danger mt-3">{{
                                errors.workflow_id[0]
                            }}</span>
                        </div>

                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 required fw-semibold mb-2">Nội dung / Lý do </label>
                            <textarea
                                style="resize:none"
                                class="form-control text-input"
                                v-model="formRequestTicket.request_description"
                                rows="3"
                                :class="{'input-custom-valid': errors.request_description}"
                                name="target_details"
                                placeholder="Nội dung / Lý do"
                            ></textarea>
                            <div class="w-100"></div>
                            <span v-if="errors.request_description" class="text-danger mt-3">{{
                                errors.request_description[0]
                            }}</span>
                        </div>

                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">Thời gian xin nghỉ phép</label>

                            <div class="d-flex flex-column mb-8">
                                <label class="required fs-6 fw-semibold mb-2">Từ ngày</label>
                                <input :max="formRequestTicket.end_date"
                                    type="datetime-local"
                                    class="form-control text-input"
                                    :class="{
                                    'input-custom-valid': errors.start_date
                                }"
                                    v-model="formRequestTicket.start_date"
                                    placeholder="Chọn từ ngày"
                                    name="target_title"
                                />
                                <div class="w-100"></div>
                                <span v-if="errors.start_date" class="text-danger mt-3">{{
                                errors.start_date[0]
                            }}</span>
                            </div>

                            <div class="d-flex flex-column mb-8">
                                <label class="required fs-6 fw-semibold mb-2">Đến ngày</label>
                                <input
                                    :min="formRequestTicket.start_date"
                                    type="datetime-local"
                                    class="form-control text-input"
                                    :class="{
                                    'input-custom-valid': errors.end_date
                                }"
                                    v-model="formRequestTicket.end_date"
                                    placeholder="Chọn đến ngày"
                                    name="target_title"
                                />
                                <div class="w-100"></div>
                                <span v-if="errors.end_date" class="text-danger mt-3">{{
                                errors.end_date[0]
                            }}</span>
                            </div>

                        </div>

                        <div class="modal-footer" style="border-top:none">
                            <button type="button" class="btn btn-function me-4" @click.prevent="
                                    isClickRequestTicketUpdate
                                        ? updateRequestTicket()
                                        : storeRequestTicket()
                                ">
                                <i class="fa-solid fa-floppy-disk"></i> Lưu
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm btn-active-color-light" id="close-modal" data-bs-dismiss="modal"
                                    @click="closeModal()">
                                <i class="fa-solid fa-xmark"></i>Đóng
                            </button>
                        </div>
                    </form>

                    <!--end:Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <!--    ================================  CHI TIẾT QUY TRÌNH DUYỆT =====================-->
    <div
        class="modal fade"
        id="detailApprover"
        data-bs-keyboard="true"
        data-bs-backdrop="static"
        tabindex="-1"
        aria-hidden="true"
    >
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered mw-800px max-h-60" >
            <!--begin::Modal content-->
            <div class="modal-content rounded" >
                <!--begin::Modal header-->
                <div class="modal-header border-0 pb-0">
                    <!--begin::Close-->
                    <h4 class="modal-title">
                       Chi tiết phiếu yêu cầu
                    </h4>
                    <div id="close-modal-deployment-schedule-by-title close"
                         class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2"
                         data-bs-dismiss="modal"   aria-label="Close"
                    >
                        <i class="ki-duotone ki-cross fs-1 text-white">
                            <i class="fa-solid fa-xmark fs-3"></i>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div
                    class="modal-body pt-5 justify-content-center justify-content-center"
                >
                    <div class="row col-lg-12 ms-2" >
                        <div class="col-lg-12">

                            <div class="row g-3 align-items-center col-lg-12" style="padding-bottom:17px;">
                                <div class="col-lg-4">
                                    <label
                                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                    >
                                        <span class="text-content">Tên phiếu yêu cầu: </span>
                                    </label>
                                </div>

                                <div class="col-lg-7">
                                    <b>{{requestTicketDetail.request_title}}</b>
                                </div>
                            </div>

                            <div class="row align-items-center g-3 col-lg-12" style="padding-bottom:17px;">
                                <div class="col-lg-4">
                                    <label class="fs-6 fw-semibold">
                                            <span class="text-content text-content"
                                            >Người tạo phiếu yêu cầu: </span
                                            >
                                    </label>
                                </div>
                                <div class="col-lg-7">
                                    <b>{{requestTicketDetail.creator_name}}</b>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12" style="padding-bottom:17px;">
                                <div class="col-lg-4">
                                    <label
                                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                    >
                                            <span class=" text-content"
                                            >Nội dung / Lý do:</span
                                            >
                                    </label>

                                </div>

                                <div class="col-lg-7">
                                    <b>{{requestTicketDetail.request_description}}</b>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center col-lg-12" style="padding-bottom:17px;">
                                <div class="col-lg-4">
                                    <label
                                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                    >
                                        <span class="text-content">Loại quy trình:</span>
                                    </label>
                                </div>
                                <div class="col-lg-7">
                                    <b>{{requestTicketDetail.workflow_name}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12" style="padding-bottom:17px;">
                                <div class="col-lg-4">
                                    <label
                                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                    >
                                        <span class="text-content">Trạng thái: </span>
                                    </label>
                                </div>

                                <div class="col-lg-7">
                                  <b>{{requestTicketDetail.request_status_name}}</b>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center col-lg-12" style="padding-bottom:17px;">
                                <div class="col-lg-4">
                                    <label
                                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                    >
                                        <span class="text-content">Thời gian: </span>
                                    </label>
                                </div>

                                <div class="col-lg-7">
                                    <b>  <span
                                        class="text-dark text-hover-primary d-block mb-1 text-content"
                                    > Từ {{ `${ moment(new Date(requestTicketDetail.start_date)).format('DD/MM/YYYY HH:mm')}
             - ${moment(new Date(requestTicketDetail.end_date)).format('DD/MM/YYYY HH:mm')}` }}</span
                                    ></b>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
                <div class="modal-footer" style="border-top:none">

                    <button type="button" class="btn btn-function me-4"   data-bs-target="#formInputNumberDay"
                            data-bs-toggle="modal">
                       Duyệt phiếu
                    </button>
                    <button
                        style="height: 33px; width: 100px;"
                        type="button"
                        class="btn btn-danger me-4"
                        @click="handleClickApprove(2, requestTicketDetail.id)"
                    >
                      <div style="margin-top: -4px;"> Từ chối</div>
                    </button>

                    <button type="button" class="btn btn-secondary btn-sm btn-active-color-light" id="close-modal-detail" data-bs-dismiss="modal"
                            @click="closeModalDetail()">
                        <i class="fa-solid fa-xmark"></i>Đóng
                    </button>
                </div>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
<!--    ================================ END CHI TIẾT QUY TRÌNH DUYỆT =====================-->


<!--    ================================================= Số ngày công =====================-->

    <div
        class="modal fade"
        id="formInputNumberDay"
        data-bs-keyboard="true"
        data-bs-backdrop="static"
        tabindex="-1"
        aria-hidden="true"
    >
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered mw-850px max-h-60" >
            <!--begin::Modal content-->
            <div class="modal-content rounded" >
                <!--begin::Modal header-->
                <div class="modal-header border-0 pb-0">
                    <!--begin::Close-->
                    <h4 class="modal-title">
                      Nhập số ngày công
                    </h4>
                    <div id=" close"
                         class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2"
                         data-bs-dismiss="modal"   aria-label="Close"
                    >
                        <i class="ki-duotone ki-cross fs-1 text-white">
                            <i class="fa-solid fa-xmark fs-3"></i>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div
                    class="modal-body pt-5 justify-content-center justify-content-center"
                >
                    <div class="row col-lg-12 ms-2" >
                        <div class="col-lg-12">
                            <div class="row g-3 align-items-center col-lg-12" style="padding-bottom:17px;">
                                <div class="col-lg-4">
                                    <label
                                        class="d-flex align-items-center fs-6 fw-semibold mb-3"
                                    >
                                        <span class="text-content">Vui lòng nhập số ngày công: </span>
                                    </label>
                                </div>

                                <div class="col-lg-7">
                                    <input
                                        type="number"
                                        class="form-control"
                                        placeholder="Nhập số ngày công"
                                        :class="{
                                    'input-custom-valid': errors?.number_leave_day,
                                }"
                                        v-model="number_leave_day"
                                    />
                                    <div class="w-100 pt-1"></div>
                                    <span
                                        v-if="errors?.number_leave_day"
                                        class="text-danger mt-3"
                                    >{{ errors.number_leave_day[0] }}</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
                <div class="modal-footer" style="border-top:none">
                    <button type="button" class="btn btn-function me-4
                                                " @click="handleClickApprove(1, requestTicketDetail.id)">
                        <i class="fa-solid fa-floppy-disk"></i> Lưu
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm btn-active-color-light" id="close-modal-number_day" data-bs-dismiss="modal"
                         >
                        <i class="fa-solid fa-xmark"></i>Đóng
                    </button>
                </div>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
</template>

<script setup>
    import { defineProps, ref, reactive, computed, onMounted } from "vue";
    import { helperFunc } from "../../helper/heplerFunction.js";
    import { sweetAlertMessage } from "../../helper/sweetAlert";
    import { useToast } from "../../helper/toastMessage";
    import axios from "axios";
    import moment from 'moment';

    const props = defineProps({
        title: String,
        btnAdd: {
            type: Boolean,
            default: false,
        }
    });
    const formRequestTicket = reactive({
        request_title: null,
        workflow_id: null,
        start_date: null,
        end_date: null,
        request_description: null,
        // number_leave_day: null,
    });
    // handle chọn số bản ghi / 1 trang
    const currentIndex = ref(-1);

    let selectTotalRecord = ref(30);
    const handleClickItem = (numberPage) => {
        selectTotalRecord.value = numberPage;
    };
    const requestTickets = ref([]);
    let getMetaPaginate = ref({});
    const getrequestTickets = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/request-tickets/get-all",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                // console.log(meta);
                requestTickets.value = data;
                getMetaPaginate.value = meta;
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
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
        getrequestTickets(requestPaginate);
    };

    const errors = ref([]);
    const storeRequestTicket = () => {
        KTApp.showPageLoading();
        axios
            .post("/request-tickets/store", formRequestTicket)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close');
                btn.click();
                // $("#formCreateBank").modal("hide");
                // $(".modal-backdrop").remove();
                getrequestTickets();
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    let request_ticket = ref(0);
    let isClickRequestTicketUpdate = ref(false);

    const handleUpdate = (item) => {
        request_ticket.value = item.id;
        isClickRequestTicketUpdate.value = true;
        formRequestTicket.request_title = item.request_title;
        formRequestTicket.workflow_id = item.workflow_id;
        formRequestTicket.request_description = item.request_description;
        formRequestTicket.start_date = item.start_date;
        formRequestTicket.end_date = item.end_date;
        errors.value = [];
    };

    const clickCreateRequestTicket = () => {
        isClickRequestTicketUpdate.value = false;
        formRequestTicket.request_title = null;
        formRequestTicket.workflow_id = null;
        formRequestTicket.request_description = null;
        formRequestTicket.start_date = null;
        formRequestTicket.end_date = null;
        errors.value = [];
    };
    const updateRequestTicket = () => {
        KTApp.showPageLoading();
        axios
            .post("/request-tickets/update/" + `${request_ticket.value}`, formRequestTicket)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close');
                btn.click();
                // $("#formCreateBank").modal("hide");
                // $(".modal-backdrop").remove();
                changePage(getMetaPaginate.value.pagination);
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };
    const handleDelete = (id) => {
        sweetAlertMessage
            .messageWarning("Bạn có chắc chắn muốn xóa không?")
            .then(function (result) {
                if (result.value) {
                    KTApp.showPageLoading();
                    axios
                        .delete("/request-tickets/destroy/" + id)
                        .then((res) => {
                            useToast.successToast(res.data.message);
                            const totalRecordOnPage =
                                getMetaPaginate.value.pagination.count;
                            if (totalRecordOnPage - 1 === 0) {
                                getMetaPaginate.value.pagination.current_page -= 1;
                            }
                            if (getMetaPaginate.value.pagination.total - 1 === 0) {
                                getrequestTickets();
                            }
                            changePage(getMetaPaginate.value.pagination);
                        })
                        .catch((error) => {
                            console.log(error);
                        }).finally(()=>{
                        KTApp.hidePageLoading();
                    });
                }
            });
    };

    const workflows = ref([]);
    const getWorkflow = (params = null) => {
        KTApp.showPageLoading();
        axios({
            url: "/workflow/get-all",
            method: "GET",
            params: params,
        })
            .then((res) => {
                const { data, meta } = res.data;
                // console.log(meta);
                workflows.value = data;
                // formWorkflow.users = [...data.users]
            })
            .catch((error) => {
                console.log(error);
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };


    onMounted(() => {
        getrequestTickets();
        getWorkflow({
            "check_permission_dept" : 1
        });
    });

    const closeModal = () => {
        // $("#formCreateBank").modal("hide");
        // $(".modal-backdrop").remove();
        currentIndex.value = -1;
    };

    const requestTicketDetail = reactive({
        "request_title" : null,
        "request_description" : null,
        "start_date" : null,
        "end_date" : null,
        "request_status" : null,
        "request_status_name" : null,
        "workflow_name" : null,
        "creator_name" : null,
        "id": null
    });

    const handleDetailRequestTicket = (requestTicket) => {
        requestTicketDetail.request_title =  requestTicket.request_title;
        requestTicketDetail.request_description =  requestTicket.request_description;
        requestTicketDetail.start_date =  requestTicket.start_date;
        requestTicketDetail.end_date =  requestTicket.end_date;
        requestTicketDetail.request_status_name =  requestTicket.request_status_name;
        requestTicketDetail.workflow_name =  requestTicket.workflow_name;
        requestTicketDetail.creator_name =  requestTicket.creator_name;
        requestTicketDetail.id =  requestTicket.id;
    }
    const requestApprove = reactive({
        "request_status" : 0,
        "number_leave_day" : null
    })
    const number_leave_day = ref(null);

    const handleClickApprove = (status, id) => {
        requestApprove.request_status = status;
        requestApprove.number_leave_day = number_leave_day.value;

        KTApp.showPageLoading();
        axios
            .put("/request-tickets/approve/" + id, requestApprove)
            .then((res) => {
                useToast.successToast(res.data.message);
                const btn = document.getElementById('close-modal-detail');
                btn.click();

                const btn2 = document.getElementById('close-modal-number_day');
                btn2.click();

                // $("#formCreateBank").modal("hide");
                // $(".modal-backdrop").remove();
                getrequestTickets();
            })
            .catch((error) => {
                errors.value = error.response.data.errors;
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };
</script>

<style scoped>
    .input-custom-valid {
        border: 1px solid red !important;
    }
    .select-custom-valid {
        border: 1px solid red !important;
    }
    .input-disabled {
        background-color: lightgray;
    }
    .set-with-modal {
        height: 58vh !important;
    }

    .text-input {
        font-size: 13px;
    }

    /*.is-invalid {*/
    /*    border: 1px !important;*/
    /*    border-bottom: 1px solid !important;*/
    /*    border-color: #ff0000ea !important;*/
    /*    border-radius: 2px !important;*/
    /*}*/
</style>
