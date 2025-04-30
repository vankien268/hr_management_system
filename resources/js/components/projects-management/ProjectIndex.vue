<template>
    <div class="card ">
        <!--begin::Header-->
        <!-- <div class="card-header border-0">
        </div> -->

        <div class="d-flex align-items-center justify-content-between flex-wrap ms-7 pt-6">
            <div class="d-flex align-items-center flex-wrap col-xl-12 mb-1 justify-content-between">
                <div class="d-flex justify-content-start">
                    <div class="d-flex align-items-center flex-wrap w-auto me-2 mb-2">
                        <div class="w-120px">
                            <label for="customerCode" class="col-form-label" style="font-size:12px;">Tên dự án/code</label>
                        </div>
                        <div class="w-170px mx-2">
                            <input type="text" @keyup.enter="handleSearch" v-model="searchInfoProject.nameAndCode"
                                style="width: 160px;" class="form-control mb-lg-0 p-2" />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto me-2 mb-2">
                        <div class="w-120px">
                            <label for="customerCode" class="col-form-label" style="font-size:12px;">Người phụ trách</label>
                        </div>
                        <div class="w-170px mx-1">
                            <input type="text" @keyup.enter="handleSearch" v-model="searchInfoProject.user_name"
                                style="width: 150px;" class="form-control mb-lg-0 p-2" />
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap w-auto me-4 mb-2">
                        <div class="w-100px">
                            <label for="customerCode" class="col-form-label" style="font-size:12px;">Khách hàng</label>
                        </div>
                        <div class="w-170px">
                                <SelectSearch
                                style="width: 228px;"
                                :list-data="getAllCustomers"
                                v-model="searchInfoProject.customer_name"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div>
                    <!-- <div class="d-flex align-items-center flex-wrap w-auto me-1 mb-2">
                        <div class="w-100px">
                            <label for="customerCode" class="col-form-label" style="font-size:12px;">Phân loại dự án</label>
                        </div>
                        <div class="w-170px ms-5">
                                <SelectSearch
                                style="width: 150px"
                                :list-data="getAllProjectTypes"
                                v-model="searchInfoProject.project_type"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div> -->
                </div>


                <div class="d-flex justify-content-end mx-8">
                    <div class="align-items-center d-flex" style="margin-top: -5px;">
                        <div>
                            <a @click="handleClickCreateProject" href="#" class="btn btn-function " v-if="props.btnAdd"
                                data-bs-target="#modalCreateProjects" data-bs-toggle="modal">
                                <i class="ki-duotone ki-plus fs-2 "></i>Thêm</a>
                        </div>
                        <!-- getDataUpdate.canPermissionEditProject -->
                        <div>
                            <a href="#" class="btn btn-function" v-if="getDataUpdate.canPermissionEditProject || getDataUpdate.canEditPermissionSystem"
                            :class="
                            {'disabled': getIdClick == 0}"
                                data-bs-target="#modalUpdateProjects" data-bs-toggle="modal">
                                <i class="fa-regular fa-pen-to-square"></i>Sửa</a>
                        </div>
                        <div>
                            <a v-if="getDataUpdate.canDeletePermissionSystem" :class="
                            {'disabled': !getDataUpdate.isDelete}" @click.prevent="handleProjectDestroy" href="#"
                                class="btn btn-function ">
                                <i class="fa-solid fa-trash"></i>Xóa</a>
                        </div>
                    </div>

                </div>

            </div>
            <div class="d-flex align-items-center flex-wrap col-xl-12 mb-4 justify-content-start">
                <div class="d-flex align-items-center flex-wrap w-auto me-1 mb-2">
                    <div class="w-100px mx-1">
                        <label for="customerCode" class="col-form-label" style="font-size:12px;">Khu vực</label>
                    </div>
                    <div class="w-170px">
                        <!-- <select @keyup.enter="handleSearch" v-model="searchInfoProject.city_id" style="width: 160px;"
                            class="form-select form-control" aria-label="Default select example">
                            <option :value="null">Tất cả</option>
                            <option v-for="(item, index) in getCities" :key="index" :value="item.id">{{ item.name }}</option>
                        </select> -->
                          <SelectSearch
                                style="width: 160px"
                                :list-data="getCities"
                                v-model="searchInfoProject.city_id"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                    </div>
                </div>
                <div class="d-flex align-items-center me-1 flex-wrap w-auto mb-2" style="padding-left:2px;">
                    <div class="w-100px mx-2">
                        <label class="col-form-label" for="checkCreate" style="font-size:12px;">Ngày khai báo</label>
                    </div>
                    <div class="me-1 w-125px">

                        <input type="date" :max="searchInfoProject.to_date" @keyup.enter="handleSearch"
                            v-model="searchInfoProject.from_date" class="form-control mb-lg-0 p-2 fs-6" id="fromDate"
                            placeholder="" />
                        <div v-if="errors['from_date']" :title="errors['from_date'] ? errors['from_date'][0] : ''"
                            style="width:150px;" class="text-danger pt-2">
                            {{ helperFunc.shortString(errors['from_date'][0], 17) }}
                        </div>
                    </div>
                    <div>
                        <label class="col-form-label">-</label>
                    </div>
                    <div class="ms-1 w-125px">
                        <input type="date" :min="searchInfoProject.from_date" @keyup.enter="handleSearch"
                            v-model="searchInfoProject.to_date" class="form-control mb-lg-0 p-2 fs-6" id="toDate" />
                        <div v-if="errors['to_date']" :title="errors['to_date'] ? errors['to_date'][0] : ''"
                            class="text-danger pt-2">{{
                                helperFunc.shortString(errors['to_date'][0], 17)
                            }}</div>
                    </div>
                </div>
                <!-- <div class="d-flex align-items-center flex-wrap w-auto me-2 mb-2 ms-5">
                        <div class="w-120px">
                            <label for="customerCode" class="col-form-label" style="font-size:12px;">Người phụ trách</label>
                        </div>
                        <div class="w-170px">
                                <SelectSearchUser
                                style="width: 160px"
                                :list-data="users"
                                v-model="searchInfoProject.user_name"
                                placeholder="Tất cả"
                                key-value="id"
                                key-display="name"
                            />
                        </div>
                    </div> -->
                <div class="align-items-center me-1 flex-wrap w-auto mb-2 justify-content-end mx-10">
                    <a @click="handleSearch" tabindex="0" href="#" class="btn btn-function">
                        <i class="fa-solid fa-search"></i>Tìm kiếm</a>
                </div>
            </div>
        </div>
        <!--begin::Body-->
        <div class="card-body py-3 text-nowrap" style="margin-top:-18px;">
            <!--begin::Table container-->
            <div class="table-responsive table-scroll">
                <!--begin::Table-->
                <table class="table table-row-dashed table-bordered table-sm table-data" cellspacing="0" cellpadding="0"
                    border="0" width="325" id="tableid">
                    <!--begin::Table head-->
                    <thead class="fs-6 text-gray-400">
                        <tr class="fw-bold text-muted">
                            <th class="min-w-60px text-content" style="text-align:center">STT</th>
                            <th class="min-w-80px text-content">Ngày tạo</th>
                            <th style="width:150px;min-width:150px;" class="text-content">Mã dự án</th>
                            <th style="width:200px;min-width:200px;" class=" text-content">Tên dự án</th>
                            <th style="width:150px;min-width:150px" class="text-content">Trạng thái</th>
                            <th style="width:200px;min-width:200px" class="text-content">Người phụ trách</th>
                            <th style="width:100px;" class="min-w-80px text-content">Khu vực</th>
                            <th class="min-w-60px text-content">Khách hàng</th>
                            <th style="width:200px;min-width:200px" class=" text-content">Thông tin liên hệ</th>
                            <th style="width:200px" class=" text-content">Phân loại dự án</th>
                            <th style="width:200px" class="text-content">Mô tả sơ bộ</th>
                            <th class="min-w-100px text-content">Nhật ký dự án</th>
                            <th class="min-w-100px text-content">Phân quyền</th>
                             <th class="min-w-100px text-content">Lịch sử chỉnh sửa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <project-item class="cursor-pointer" v-for="(item, index) in projects" :key="index"
                            :projectItem="item" :index="index" :pagination="pagination" @click="setDataUpdate(item)"
                            :get-data-update="getDataUpdate" :old-user-id="oldUserId" @handle-contacts="handleContacts"
                            @handle-users="handleUsers" @handle-tasks="handleTasks"
                            @permissionProject="permissionProject"
                            @handleClickViewHistories="handleClickViewHistories"
                            ></project-item>
                        <!--end::Table body-->
                    </tbody>
                    <tbody v-if="Object.keys(projects).length == 0">
                        <tr>
                            <td class="text-center" colspan="13">
                                Không có dữ liệu hiển thị
                            </td>
                        </tr>
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>

            <base-pagination :pagination="pagination" @change-page="changePage" />
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
    <!-- modal -->
    <div class="modal" id="modalCreateProjects" data-bs-keyboard="true" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <!--begin::Modal content-->
            <div class="rounded modal-content">
                <!--begin::Modal header-->
                <div class="modal-header border-0 pb-0">
                    <!--begin::Close-->
                    <h4 class="modal-title">
                        Thêm mới dự án
                    </h4>
                    <div @click="closeModalProject($event, true)"
                        class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body p-0 ps-2 pe-2 mb-3">
                    <form-project @resetclickBtnIconClose="resetclickBtnIconClose" :clickBtnIconClose="clickBtnIconClose"
                        :key="1" @storeProject="storeProject" :customers="customers"></form-project>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <!-- sua -->
    <div class="modal" id="modalUpdateProjects" data-bs-keyboard="true" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header border-0 pb-0">
                    <!--begin::Close-->
                    <h4 class="modal-title">
                        Sửa dự án
                    </h4>
                    <div @click="closeModalUpdateProject($event, true)" id="click-close-project"
                        class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body pt-0 px-5">
                    <form-project :key="2" :edit-project-modal="editProjectModal" @update-project="updateProject"
                        :get-data-update="getDataUpdate" :clickUpdateBtnIconClose="clickUpdateBtnIconClose"
                        @resetclickUpdateBtnIconClose="resetclickUpdateBtnIconClose"
                        :customers="customers"
                        ></form-project>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <contact-index :info-contacts="infoContacts" @update-contacts="updateContacts" :get-data-update="getDataUpdate">
    </contact-index>

    <modal-user-list :user-list="userList" @update-users="updateUsers" :total-user="totalUser">

    </modal-user-list>

    <modal-list-task :task-list="taskList" @update-tasks="updateTasks" :project-id="projectId" :nameUser="nameUser" :userIdCurrent="userIdCurrent">

    </modal-list-task>

    <!-- phân quyền dự án -->
    <form-permission :generateFunction="generateFunction" :function-projects="functionProjects"
        :projectIdClickPermission="projectIdClickPermission" :projectPermission="projectPermission"
        @update-users="updateUsers"></form-permission>

    <!-- lịch sử sửa dự án -->
    <!-- <history-update-project :project-id="view_history_project_id"
    :getMetaPaginateHistoryProjects="getMetaPaginateHistoryProjects"
    :getAllHistoryProjects="getAllHistoryProjects"
    :paginationUpdateHistory="paginationUpdateHistory"
    @change-page-history-update="changePageHistoryUpdate"
    >

    </history-update-project> -->
    <div
            class="modal"
            id="historyUpdateProject"
            data-bs-keyboard="true"
            data-bs-backdrop="static"
            tabindex="-1"
            aria-hidden="true"
        >
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered modal-xl" >
                <!--begin::Modal content-->
                <div class="modal-content rounded">
                    <!--begin::Modal header-->
                    <div class="modal-header border-0 pb-0">
                        <!--begin::Close-->
                        <h4 class="modal-title">Danh sách lịch sử chỉnh sửa dự án</h4>
                        <div
                        class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2"
                            data-bs-dismiss="modal"
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
                        class="modal-body pt-0 px-5 justify-content-center"
                    >
                           <div class="row col-lg-12 ps-1 pe-1 ms-1" style="border-bottom: 1px solid rgb(192, 192, 192);">
                            <div class="col-lg-12">

                           <div class="d-flex align-items-center justify-content-between flex-wrap "
                            >
                                <div
                                    class="d-flex align-items-center flex-wrap mb-3"
                                >
                                    <div
                                        class="d-flex align-items-center flex-wrap w-auto me-5"
                                    >
                                        <div class="w-auto">
                                            <label
                                                class="col-form-label"
                                                >Mã dự án</label
                                            >
                                        </div>
                                        <div class="w-200px ms-14">
                                            <input
                                                type="text"
                                                class="form-control mb-lg-0 p-2"
                                                :disabled="true"
                                                :value="getDataUpdate.code"
                                            />
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center flex-wrap w-auto me-4"
                                    >
                                        <div class="w-auto">
                                            <label
                                                class="col-form-label"
                                                >Tên dự án</label
                                            >
                                        </div>
                                        <div class="w-350px ms-5">
                                            <input
                                                type="text"
                                                class="form-control mb-lg-0 p-2"
                                                 :disabled="true"
                                                :value="getDataUpdate.name"
                                            />
                                        </div>
                                    </div>
                                      <div
                                        class="d-flex align-items-center flex-wrap w-auto me-3"
                                    >
                                        <div class="w-auto">
                                            <label
                                                for="customerCode"
                                                class="col-form-label me-3"
                                                >Thông tin</label
                                            >
                                        </div>
                                        <div
                                            class="selected break-text w-125px cus-inf-set"
                                        >
                                            <SelectSearch
                                            :list-data="infoList"
                                                v-model="infoSearch"
                                                placeholder="Tất cả"
                                                key-value="key"
                                                key-display="value"
                                            />
                                        </div>
                                    </div>
                                    <a
                                        href="#"
                                        class="btn btn-icon btn-sm btn-icon-bg-primary btn-color-light"
                                        @click="clickSearchProjectHistory(view_history_project_id)"
                                    >
                                        <i
                                            class="fa-solid fa-magnifying-glass"
                                        ></i
                                    ></a>
                                </div>

                                <div
                                    class="d-flex align-items-center flex-wrap"
                                >
                                    <div
                                        class="d-flex align-items-center me-1 flex-wrap w-auto"
                                    >
                                        <div class="w-auto">
                                            <label
                                                class="col-form-label"
                                                for="checkCreate"
                                                >Thời gian sửa</label
                                            >
                                        </div>
                                        <div class="w-100px ms-6">
                                            <input
                                                type="time"
                                                class="form-control mb-lg-0 p-2"
                                                id="customerCode"
                                                v-model="formSearchProjectHistory.from_hours"
                                            />
                                        </div>
                                        <div class="ms-1 me-1 w-125px ms-3">
                                            <input
                                                type="date"
                                                class="form-control mb-lg-0 p-2"
                                                id="fromDate"
                                                 v-model="formSearchProjectHistory.from_date"
                                            />
                                             <div  v-if="errorsHistory['from_date']"  :title="errorsHistory['from_date']? errorsHistory['from_date'][0]: ''"
                                            style="width:150px;" class="text-danger pt-2">
                                                {{  helperFunc.shortString(errorsHistory['from_date'][0], 17) }}
                                            </div>
                                        </div>
                                        <div class="w-100px ms-4">
                                            <input
                                                type="time"
                                                class="form-control mb-lg-0 p-2"
                                                id="customerCode"
                                                 v-model="formSearchProjectHistory.to_hours"
                                            />
                                        </div>
                                        <div class="ms-1 w-125px ms-3">
                                            <input
                                                type="date"
                                                class="form-control mb-lg-0 p-2"
                                                id="toDate"
                                                 v-model="formSearchProjectHistory.to_date"
                                            />
                                               <div  v-if="errorsHistory['to_date']"  :title="errorsHistory['to_date']? errorsHistory['to_date'][0]: ''"
                                            style="width:150px;" class="text-danger pt-2">
                                                {{  helperFunc.shortString(errorsHistory['to_date'][0], 17) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center flex-wrap w-auto ms-3 me-3"
                                    >
                                        <div class="w-auto">
                                            <label
                                                for="customerCode"
                                                class="col-form-label me-3"
                                                >Người chỉnh sửa</label
                                            >
                                        </div>
                                        <div class="w-125px cus-edi-set">
                                            <SelectSearch
                                                :list-data="getUserHistories"
                                                placeholder="Tất cả"
                                                key-value="id"
                                                key-display="name"
                                                v-model="user_editor_id"
                                            />
                                        </div>
                                    </div>

                                </div>
                            </div>
                                <div class="card-body py-3" >
                                    <div class="table-responsive table-scroll-sm h-55vh text-nowrap">
                                        <table class="table table-row-dashed table-bordered table-sm table-data">
                                            <thead>
                                                <tr class="text-gray-400">
                                                    <th class="w-50px text-center">STT</th>
                                                    <th class="w-150px">Thời gian chỉnh sửa</th>
                                                    <th class="w-120px">Người chỉnh sửa</th>
                                                    <th  class="w-120px" style="width: 130px;">
                                                        Thông tin
                                                    </th>
                                                    <th class="w-300px">
                                                        Nội dung trước khi sửa
                                                    </th>
                                                        <th class="w-300px">
                                                            Nội dung sau khi sửa
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="max-h-25 overflow-auto cursor-pointer"
                                                >

                                                <tr v-for="(item, index) in getAllHistoryProjects" :key="index"

                                                >
                                                    <td class="text-center">{{ index + 1 }}</td>
                                                    <td>
                                                        {{
                                                            moment(
                                                                new Date(
                                                                    item.created_at
                                                                )
                                                            ).format(
                                                                "hh:mm A DD/MM/YYYY"
                                                            )
                                                        }}</td>
                                                    <td>{{ item.user.data.name }}</td>
                                                    <!-- {{Object.entries(item.properties.old.project).length}} -->
                                                    <td>
                                                        <!-- <div v-if="item.properties.old.project">
                                                            <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="d-block text-content w-150px break-text"
                                                            >
                                                                <b>Thông tin dự án</b>
                                                            </span>
                                                        </div> -->
                                                        <div
                                                        v-for="(
                                                            item2, index2
                                                        ) in item.properties
                                                            .attributes"
                                                        :key="index2"
                                                    >
                                                    <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2=='project' && item2.hasOwnProperty('code')"
                                                            >
                                                                Mã dự án
                                                            </span>
                                                     <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2=='project' && item2.hasOwnProperty('name')"
                                                            >
                                                                Tên dự án
                                                            </span>
                                                     <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2 =='city_id'"
                                                            >
                                                                Khu vực
                                                            </span>
                                                     <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2 =='status_id'"
                                                            >
                                                             Trạng thái dự án
                                                            </span>
                                                     <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2=='project' && item2.hasOwnProperty('description')"
                                                            >
                                                            Mô tả sơ bộ
                                                            </span>
                                                     <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2 =='project_type_id'"
                                                            >
                                                                Phân loại dự án
                                                            </span>
                                                     <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2 =='customer_id'"
                                                            >
                                                                Khách hàng
                                                            </span>

                                                        <!-- Đại diện phía khách hàng -->

                                                            <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2 =='contact' && item2.hasOwnProperty('name')"
                                                            >
                                                                Họ và tên
                                                            </span>

                                                              <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2 =='contact' && item2.hasOwnProperty('phone') && getUserPermissions.phone"
                                                            >
                                                                Số điện thoại
                                                            </span>

                                                               <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2 =='contact' && item2.hasOwnProperty('email') && getUserPermissions.email"
                                                            >
                                                                Email
                                                            </span>

                                                               <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2 =='contact' && item2.hasOwnProperty('position')"
                                                            >
                                                                Chức vụ
                                                            </span>

                                                              <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2 =='contact' && item2.hasOwnProperty('status')"
                                                            >
                                                                Trạng thái người liên hệ
                                                            </span>

                                                              <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2 =='contact' && item2.hasOwnProperty('contact_note')"
                                                            >
                                                                Ghi chú người liên hệ
                                                            </span>
                                                            <!-- Người đại diện phía công ty -->

                                                              <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2 =='user' && item2.hasOwnProperty('user_id')"
                                                            >
                                                               Mã người dùng
                                                            </span>

                                                                <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content w-150px break-text"
                                                              v-if="index2 =='user' && item2.hasOwnProperty('user_note')"
                                                            >
                                                               Ghi chú người phụ trách
                                                            </span>
                                                        </div>

                                                    </td>
                                                    <td v-if="item.event == 'updated'" >
                                                        <div
                                                            v-for="(
                                                                item3, key3
                                                            ) in item.properties
                                                                .old"
                                                            :key="key3"
                                                        >

                                                            <span style="
                                                                    padding: 3px 0;
                                                                "
                                                                :title=" item3.name"
                                                                class="text-dark text-hover-primary d-block text-content break-text"
                                                                v-if="
                                                                      key3=='project' && item3.hasOwnProperty('name')

                                                                "
                                                                >
                                                                    {{ item3.name ? item3.name:'---' }}
                                                            </span>
                                                              <span style="
                                                                    padding: 3px 0;
                                                                "
                                                                 :title="item.jsonOldCity[0]?.name"

                                                                class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                                v-if="
                                                                    key3=='city_id'
                                                                "
                                                                >
                                                                    {{ item.jsonOldCity[0]?.name?item.jsonOldCity[0]?.name: '---' }}
                                                            </span>
                                                               <span style="
                                                                    padding: 3px 0;
                                                                "
                                                                 :title="item.jsonOldSystemStatus[0]?.name"
                                                                class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                                v-if="
                                                                    key3=='status_id'

                                                                "
                                                                >
                                                                    {{ item.jsonOldSystemStatus[0]?.name? item.jsonOldSystemStatus[0]?.name: '---' }}
                                                            </span>
                                                               <span style="
                                                                    padding: 3px 0;
                                                                "
                                                                 :title="item.jsonOldCustomer[0]?.name"
                                                                class="text-dark text-hover-primary d-block text-content w-200px break-text"
                                                                v-if="
                                                                    key3=='customer_id'

                                                                "
                                                                >
                                                                  {{ item.jsonOldCustomer[0]?.name?item.jsonOldCustomer[0]?.name: '---' }}
                                                            </span>
                                                               <span style="
                                                                    padding: 3px 0;
                                                                " :title=" item3.description"
                                                                class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                                v-if="  key3=='project' && item3.hasOwnProperty('description')
                                                                "
                                                                >
                                                                    {{ item3.description?item3.description:'---' }}
                                                            </span>
                                                               <span style="
                                                                    padding: 3px 0;
                                                                "
                                                                 :title="item.jsonOldProjectType[0]?.name"
                                                                class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                                v-if="
                                                                    key3=='project_type_id'

                                                                "
                                                                >
                                                                  {{ item.jsonOldProjectType[0]?.name? item.jsonOldProjectType[0]?.name: '---' }}
                                                            </span>
                                                             <!-- Đại diện phía khách hàng -->

                                                            <span style="
                                                                padding: 3px 0;
                                                            "
                                                             :title="item3.name"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='contact' && item3.hasOwnProperty('name')"
                                                            >
                                                                {{ item3.name? item3.name: '---' }}
                                                            </span>

                                                              <span style="
                                                                padding: 3px 0;
                                                            "
                                                              :title="item3.phone"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='contact' && item3.hasOwnProperty('phone') && getUserPermissions.phone"
                                                            >
                                                                {{ item3.phone? item3.phone: '---' }}
                                                            </span>

                                                               <span style="
                                                                padding: 3px 0;
                                                            "
                                                            :title="item3.email"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='contact' && item3.hasOwnProperty('email') && getUserPermissions.email"
                                                            >
                                                                {{ item3.email? item3.email: '---' }}
                                                            </span>

                                                               <span style="
                                                                padding: 3px 0;
                                                            "
                                                             :title="item3.position"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='contact' && item3.hasOwnProperty('position')"
                                                            >
                                                               {{ item3.position?  item3.position: '---' }}
                                                            </span>

                                                              <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='contact' && item3.hasOwnProperty('status')"
                                                            >
                                                                 {{ item3.status == 0 ? 'Ngừng hoạt động' : 'Hoạt động' }}
                                                            </span>

                                                              <span style="
                                                                padding: 3px 0;
                                                            "
                                                             :title="item3.contact_note"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='contact' && item3.hasOwnProperty('contact_note')"
                                                            >
                                                                 {{ item3.contact_note? item3.contact_note: '---' }}
                                                            </span>

                                                            <!-- Người đại diện phía công ty -->

                                                            <span style="
                                                                padding: 3px 0;
                                                            "
                                                            :title="`${item.jsonOldUser[0]?.name}(${item.jsonOldUser[0]?.username})`"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='user' && item3.hasOwnProperty('user_id')"
                                                            >
                                                                 {{ `${item.jsonOldUser[0]?.name}(${item.jsonOldUser[0]?.username})` }}
                                                            </span>

                                                                <span style="
                                                                padding: 3px 0;
                                                            "
                                                             :title="item3.user_note"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='user' && item3.hasOwnProperty('user_note')"
                                                            >
                                                                {{ item3.user_note? item3.user_note:'---' }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td v-else>
                                                        <span>Không dữ liệu để hiển thị.</span>
                                                    </td>
                                                      <td>
                                                        <div
                                                            v-for="(
                                                                item3, key3
                                                            ) in item.properties
                                                                .attributes"
                                                            :key="key3"
                                                        >
                                                        <span style="
                                                                    padding: 3px 0;
                                                                "
                                                                :title="item3.code"
                                                                class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                                v-if="
                                                                    key3=='project' && item3.hasOwnProperty('code')
                                                                "
                                                                >
                                                                    {{ item3.code? item3.code : '---' }}
                                                            </span>
                                                            <span style="
                                                                    padding: 3px 0;
                                                                "
                                                                :title="item3.name"
                                                                class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                                v-if="
                                                                    key3=='project' && item3.hasOwnProperty('name')
                                                                "
                                                                >
                                                                    {{ item3.name? item3.name: '---' }}
                                                            </span>
                                                              <span style="
                                                                    padding: 3px 0;
                                                                "
                                                                :title="item.jsonNewCity[0]?.name"
                                                                class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                                v-if="
                                                                    key3=='city_id'

                                                                "
                                                                >
                                                                    {{ item.jsonNewCity[0]?.name? item.jsonNewCity[0]?.name: '---' }}
                                                            </span>
                                                               <span style="
                                                                    padding: 3px 0;
                                                                "
                                                                 :title="item.jsonNewSystemStatus[0]?.name"
                                                                class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                                v-if="
                                                                    key3=='status_id'

                                                                "
                                                                >
                                                                      {{ item.jsonNewSystemStatus[0]?.name? item.jsonNewSystemStatus[0]?.name: '---' }}
                                                            </span>
                                                               <span style="
                                                                    padding: 3px 0;
                                                                "
                                                                  :title="item.jsonNewCustomer[0]?.name"
                                                                class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                                v-if="
                                                                    key3=='customer_id'

                                                                "
                                                                >
                                                                     {{ item.jsonNewCustomer[0]?.name? item.jsonNewCustomer[0]?.name :'---' }}
                                                            </span>
                                                               <span style="
                                                                    padding: 3px 0;
                                                                "
                                                                 :title="item3.description"
                                                                class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                                v-if=" key3=='project' && item3.hasOwnProperty('description')
                                                                "
                                                                >
                                                                    {{ item3.description? item3.description: '---' }}
                                                            </span>
                                                               <span style="
                                                                    padding: 3px 0;
                                                                "
                                                                 :title="item.jsonNewProjectType[0]?.name"
                                                                class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                                v-if="
                                                                    key3=='project_type_id'

                                                                "
                                                                >

                                                                     {{ item.jsonNewProjectType[0]?.name? item.jsonNewProjectType[0]?.name: '---' }}
                                                            </span>

                                                              <!-- Đại diện phía khách hàng -->

                                                            <span style="
                                                                padding: 3px 0;
                                                            "
                                                             :title=" item3.name"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='contact' && item3.hasOwnProperty('name')"
                                                            >
                                                                {{ item3.name? item3.name: '---' }}
                                                            </span>

                                                              <span style="
                                                                padding: 3px 0;
                                                            "
                                                             :title=" item3.phone"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='contact' && item3.hasOwnProperty('phone') && getUserPermissions.phone"
                                                            >
                                                                {{ item3.phone ?item3.phone:'---' }}
                                                            </span>

                                                               <span style="
                                                                padding: 3px 0;
                                                            "
                                                            :title=" item3.email"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='contact' && item3.hasOwnProperty('email') && getUserPermissions.email"
                                                            >
                                                                {{ item3.email ? item3.email:'---'}}
                                                            </span>

                                                               <span style="
                                                                padding: 3px 0;
                                                            "
                                                             :title=" item3.position"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='contact' && item3.hasOwnProperty('position')"
                                                            >
                                                               {{ item3.position? item3.position: '---' }}
                                                            </span>

                                                              <span style="
                                                                padding: 3px 0;
                                                            "
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='contact' && item3.hasOwnProperty('status')"
                                                            >
                                                                 {{ item3.status == 0 ? 'Ngừng hoạt động' : 'Hoạt động' }}
                                                            </span>

                                                              <span style="
                                                                padding: 3px 0;
                                                            "
                                                              :title=" item3.contact_note"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='contact' && item3.hasOwnProperty('contact_note')"
                                                            >
                                                                 {{ item3.contact_note? item3.contact_note: '---' }}
                                                            </span>
                                                            <!-- Người đại diện phía công ty -->

                                                              <span style="
                                                                padding: 3px 0;
                                                            "
                                                             :title="`${item.jsonNewUser[0]?.name}(${item.jsonNewUser[0]?.username})`"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='user' && item3.hasOwnProperty('user_id')"
                                                            >
                                                                 {{ `${item.jsonNewUser[0]?.name}(${item.jsonNewUser[0]?.username})` }}
                                                            </span>

                                                                <span style="
                                                                padding: 3px 0;
                                                            "
                                                            :title="item3.user_note"
                                                            class="text-dark text-hover-primary d-block text-content max-w-300px break-text"
                                                              v-if="key3 =='user' && item3.hasOwnProperty('user_note')"
                                                            >
                                                                {{ item3.user_note? item3.user_note: '---' }}
                                                            </span>

                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                             <tbody v-if="getAllHistoryProjects.length == 0">
                                                <tr>
                                                    <td class="text-center" colspan="13">
                                                        Không có dữ liệu hiển thị
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                        <base-pagination :pagination="paginationUpdateHistory" @change-page="changePageHistoryUpdate" />

                                </div>
                            </div>
                        </div>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, computed, watch, onBeforeMount, reactive } from 'vue'
import { sweetAlertMessage } from '../../helper/sweetAlert';
import ProjectItem from './ProjectItem.vue';
import FormProject from './FormProject.vue';
import { useToast } from "../../helper/toastMessage.js";
import { useCity } from '../../stores/city';
import ContactIndex from './contacts/ContactIndex.vue';
import modalUserList from './users/ModalListUser.vue'
import ModalListTask from './tasks/ModalListTask.vue';
import { helperFunc } from '../../helper/heplerFunction'
import formPermission from './permissions/FormPermission.vue'
import SelectSearch from "../input/SelectSearch.vue";
import SelectSearchUser from "../input/SelectSearchUser.vue";
import moment from "moment";
// import historyUpdateProject from './history-update-project/HistoryUpdateProject.vue';

const props = defineProps({
    btnAdd: {
        type: Boolean,
        default: false,
    },
    users: {
        type: Array,
        default: []
    },
    customers: {
        type: Array,
        default: []
    }
})
const storeCity = useCity();

onBeforeMount(() => {
    storeCity.getCityData();
})
const getCities = computed(() => {
    return storeCity.cities;
})

const getAllProjects = ref([]);
const getMetaPaginate = ref({})
const errors = ref([]);
const nameUser = ref("");
const userIdCurrent = ref(0);
const getAllProjectsApi = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: '/projects/get-all',
        method: "GET",
        params: params
    })
        .then(res => {
            const { data, meta } = res.data;
            getAllProjects.value = data;
            getMetaPaginate.value = meta;
            nameUser.value = data[0]?.userCurrent;
            userIdCurrent.value = data[0]?.user_id;
            errors.value = [];
            // if(res.data?.message) {
            //     useToast.errorToast(res.data?.message);
            // }
        }).catch(error => {
            errors.value = error?.response?.data?.errors;
        }).finally(() => {
            KTApp.hidePageLoading();
        })
}
const getAllCustomers = ref([]);
const getAllProjectTypes = ref([]);
const getOther = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: '/projects/getOther',
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data } = res;
            getAllCustomers.value = data.getCustomers;
            getAllProjectTypes.value = data.getProjectTypes;

        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};

onMounted(() => {
    getAllProjectsApi();
    getOther();
})
const projects = computed(() => {
    return getAllProjects.value;
})

const pagination = computed(() => {
    return getMetaPaginate.value?.pagination ?
        getMetaPaginate.value.pagination : { current_page: 1, total_pages: 1, per_page: 30 }
});

const changePage = (newDataPagination, searchData = null) => {
    let requestPaginate = {
        page: newDataPagination.current_page,
        per_page: newDataPagination.per_page
    }
    if (searchData) {
        requestPaginate = { ...requestPaginate, ...searchData }
    }
    requestPaginate = { ...requestPaginate }
    getAllProjectsApi(requestPaginate);
}

const storeProject = () => {
    getAllProjectsApi();

}

const getDataUpdate = ref({});
const getIdClick = ref(0);
const editProjectModal = ref(false);
const oldUserId = ref(0);

const setDataUpdate = (item) => {
    getDataUpdate.value = item;
    getIdClick.value = item.id
    editProjectModal.value = true;
    oldUserId.value = item.users?.data[0].id
}


const updateProject = () => {
    changePage(getMetaPaginate.value.pagination)
    const btnClick = document.getElementById('click-close-project')
    btnClick.click();
    getIdClick.value = 0;
    // editProjectModal.value = false;
    oldUserId.value = 0;
    //   getDataUpdate.value = {};
}

let clickBtnIconClose = ref(false);
let clickUpdateBtnIconClose = ref(false);
const closeModalProject = ($event, value) => {
    clickBtnIconClose.value = value;
}

const closeModalUpdateProject = ($event, value) => {
    clickUpdateBtnIconClose.value = value;
}
// reset click icon close về false
const resetclickBtnIconClose = (value) => {
    clickBtnIconClose.value = value
}
const resetclickUpdateBtnIconClose = (value) => {
    clickUpdateBtnIconClose.value = value
}

const handleProjectDestroy = () => {
    sweetAlertMessage.messageWarning('Bạn có chắc chắn muốn xóa không?')
        .then(result => {
            if (result.value) {
                KTApp.showPageLoading();
                axios.delete(`/projects/destroy/${getIdClick.value}`)
                    .then(res => {
                        const { message } = res.data;
                        const totalRecordOnPage = getMetaPaginate.value.pagination.count;
                        if (totalRecordOnPage - 1 === 0) {
                            getMetaPaginate.value.pagination.current_page -= 1;
                        }
                        if (getMetaPaginate.value.pagination.total - 1 === 0) {
                            getAllProjectsApi();
                        }
                        changePage(getMetaPaginate.value.pagination)
                        useToast.successToast(message);
                    }).catch((error) => {
                        if (error.response.data.code == 422 && error.response.data.errors?.message) {
                            useToast.errorToast(error.response.data.errors.message);
                        }
                    }).finally(() => {
                        KTApp.hidePageLoading();
                    })
            }
        })
}

// tìm kiếm
const searchInfoProject = reactive({
    nameAndCode: "",
    user_name: "",
    customer_name: "",
    customer_code: "",
    project_type: null,
    city_id: null,
    from_date: null,
    to_date: null
});

const handleSearch = () => {
    getAllProjectsApi(searchInfoProject)
}
const infoContacts = ref([]);

const handleContacts = (contacts) => {
    infoContacts.value = contacts;
}

const updateContacts = (data) => {
    const index = getAllProjects.value.findIndex((item) => (item.id == data.project_id));
    if (index != -1) {
        getAllProjects.value[index].contacts.data = data.contacts;
    }
    // updateForGetListProject(data.project_id, data.contacts);
    // contactsByProject(data.projectId)
}

// PHẦN ĐẠI DIỆN PHÍA CÔNG TY
const userList = ref([]);
const totalUser = ref(0);
const handleUsers = (data) => {
    userList.value = data.users;
    totalUser.value = data.totalUser
}
const updateUsers = (data) => {
    // const index = getAllProjects.value.findIndex((item) => (item.id == data.project_id));
    // if(index != -1) {
    //     getAllProjects.value[index].users.data = data.users;
    // }
    changePage(getMetaPaginate.value.pagination);
}

// PHẦN NHẬT KÝ DỰ ÁN
const taskList = ref([]);
const projectId = ref(0);
const handleTasks = (data) => {
    taskList.value = data.tasks;
    projectId.value = data.projectId;
}
const updateTasks = (data) => {
    const index = getAllProjects.value.findIndex((item) => (item.id == data.project_id));
    if (index != -1) {
        getAllProjects.value[index].tasks.data = data.tasks;
    }
}

// chức năng dự án
const functionProjects = reactive({
    functions: [],
    projectId: null
})
const generateFunction = ref([]);
const recuirseFunction = (data) => {
    data.forEach(item => {
        let id = item.id;
        generateFunction.value.push(id)
        if (item.children.length > 0) {
            recuirseFunction(item.children)
        }
    });
}
const projectIdClickPermission = ref(null)
const projectPermission = ref({});
const permissionProject = (project) => {
    functionProjects.functions = [...project.functions]
    functionProjects.projectId = project.id
    projectPermission.value = project;
    recuirseFunction(project.functions)
}
// Lịch sử dự án
const getAllHistoryProjects = ref([]);
const getMetaPaginateHistoryProjects  = ref({})
const getUserHistories = ref([]);
const errorsHistory = ref([]);
const getUserPermissions = ref([]);
const getAllHistoryProjectsApi = (params = null, projectId) => {
    console.log( props.getDataCustomers)
    KTApp.showPageLoading();
    axios({
        url: '/projects/get-histories/'+ projectId,
        method: "GET",
        params: params
    })
        .then(res => {
            const { data, meta, userEditors, userPermissions } = res.data;
             getAllHistoryProjects.value =data
            getMetaPaginateHistoryProjects.value = meta;

            Object.keys(userEditors).forEach((key) => {
                 getUserHistories.value.push(
                     userEditors[key]
            )
            });
             errorsHistory.value = [];
            getUserPermissions.value = userPermissions;

            //  getAllHistoryProjects.value =  getAllHistoryProjects.value.filter((item) => {
            //     let contact = item.properties.attributes?.contact;
            //       let lengthProject = Object.entries(contact).length;

            //     if(lengthProject == 4) {
            //             if((contact.hasOwnProperty('email')
            //                  && getUserPermissions.value.email
            //                 )
            //                 || (contact.hasOwnProperty('phone')
            //                  && getUserPermissions.value.phone)
            //                  )
            //             {
            //                 return item;
            //             }
            //     }
            //      if(lengthProject > 4) {
            //         return item;
            //      }
            //  })
        }).catch(error => {
            console.log(error)
            errorsHistory.value = error?.response?.data?.errors;
        }).finally(() => {
            KTApp.hidePageLoading();
        })
}
const view_history_project_id = ref(null);

const handleClickViewHistories=(projectId) => {
    view_history_project_id.value = projectId;
    getAllHistoryProjectsApi(null, projectId)
}
const paginationUpdateHistory = computed(() => {
    return getMetaPaginateHistoryProjects.value?.pagination ?
        getMetaPaginateHistoryProjects.value.pagination : { current_page: 1, total_pages: 1, per_page: 30 }
});
const updateChangePageHistoryUpdate = (newDataPagination, searchData = null, projectId) => {
    let requestPaginate = {
        page: newDataPagination.current_page,
        per_page: newDataPagination.per_page
    }
    if (searchData) {
        requestPaginate = { ...requestPaginate, ...searchData }
    }
    requestPaginate = { ...requestPaginate }
    getAllHistoryProjectsApi(requestPaginate, projectId);
}
const changePageHistoryUpdate=() => {
    updateChangePageHistoryUpdate(paginationUpdateHistory.value,null,view_history_project_id.value )
}

const infoList = ref([
    {
        key: "code",
        value: "Mã dự án",
    },
    {
        key: "project_name",
        value: "Tên dự án",
    },
    {
        key: "customer_id",
        value: "Khách hàng",
    },
    {
        key: "city_id",
        value: "Khu vực",
    },
    {
        key: "project_type_id",
        value: "Phân loại dự án",
    },
    {
        key: "status_id",
        value: "Trạng thái dự án",
    },
    {
        key: "description",
        value: "Mô tả sơ bộ",
    },
    {
        key: "contact_name",
        value: "Họ tên người liên hệ",
    },
    {
        key: "phone",
        value: "SĐT người liên hệ",
    },
    {
        key: "email",
        value: "Email người liên hệ",
    },
    {
        key: "position",
        value: "Chức vụ người liên hệ",
    },
    {
        key: "status",
        value: "Trạng thái người liên hệ",
    },
    {
        key: "contact_note",
        value: "Ghi chú người liên hệ",
    },
    {
        key: "user_id",
        value: "Mã người dùng",
    },
     {
        key: "user_note",
        value: "Ghi chú người phụ trách",
    },
]);
const infoSearch = ref(null);
const user_editor_id = ref(null);
const formSearchProjectHistory = reactive({
    searchInfo: null,
    from_date: null,
    to_date: null,
    from_hours: null,
    to_hours: null,
    editor: null
});
const clickSearchProjectHistory = (projectId) => {
    formSearchProjectHistory.searchInfo = infoSearch.value;
     formSearchProjectHistory.editor = user_editor_id.value;
    getAllHistoryProjectsApi(formSearchProjectHistory, projectId)
}
</script>

<style scoped>
.modal-content {
    margin: auto;
}

.check-permission {
    visibility: hidden;
}
</style>
