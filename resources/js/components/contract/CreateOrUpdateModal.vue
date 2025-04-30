<template>
    <Modal :title="props.contract.id != 0
        ? 'Thông tin hợp đồng'
        : 'Thêm mới hợp đồng'" @close-modal="closeModal(props.contract.id)">
        <template #body>
            <div class="row col-lg-12 ms-1 mb-10 form" style="border-bottom: 1px solid rgb(212, 212, 212);">
                <div class="col-lg-6">
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="customerCode" class="required col-form-label">Số hợp đồng</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-5">
                            <!-- :disabled="props.contract.id != 0" -->
                            <input type="text" :disabled="disabledEditContractFromNotification || (props.contract.id != 0 && props.action == 'view')" id="customerCode"
                                @keypress="filterCodeInputNumber($event)"

                                 @input="props.contract.code=validateInputCode(null, true, $event.target.value)"
                                 class="form-control mb-lg-0 p-2"
                                :class="{ 'is-invalid': errors.code }" v-model="props.contract.code" />
                            <base-validation :message="errors.code" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="taxCode" class="required col-form-label">Ngày ký</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <input type="date" class="form-control form-control-datetime w-50 mb-lg-0 p-2"
                                :disabled="props.contract.id != 0 && props.action == 'view'"
                                :class="{ 'is-invalid': errors.signing_date }" id="taxCode"
                                v-model="props.contract.signing_date" />
                            <base-validation :message="errors.signing_date" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="customer_name" class="required col-form-label">Đại diện ký</label>
                            <label for="customer_name" class="col-form-label">(Phía khách hàng)</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <input type="text" class="required form-control mb-lg-0 p-2"
                                :disabled="props.contract.id != 0 && props.action == 'view'"
                                :class="{ 'is-invalid': errors.customer_contractor }"
                                v-model="props.contract.customer_contractor" />
                            <base-validation :message="errors.customer_contractor" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="name" class="required col-form-label">Đại diện ký</label>
                            <label for="name" class="col-form-label">(Phía công ty)</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <SelectSearch :list-data="users" v-model="props.contract.user_contractor_id" key-value="id"
                                :disabled="props.contract.id != 0 && props.action == 'view'"
                                placeholder="--Chọn--" :key-display="['name']"
                                key-show="name"/>

                            <!-- <select class="form-select" :class="{ 'is-invalid': errors.user_contractor_id }"
                                :disabled="props.contract.id != 0 && props.action == 'view'"
                                v-model="props.contract.user_contractor_id">
                                <option :value="null">--Chọn--</option>
                                <option v-for="(item, index) in props.users" :key="index" :value="item.id">{{
                                    item.name }}</option>
                            </select> -->
                            <base-validation :message="errors.user_contractor_id" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="status" class="required col-form-label">Người phụ trách</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <SelectSearch :list-data="users" v-model="props.contract.user_charge_id" key-value="id"
                                :disabled="props.contract.id != 0 && props.action == 'view'"
                                placeholder="--Chọn--" :key-display="['name']"
                                key-show="name"/>
                            <!-- <select class="form-select w-75" :class="{ 'is-invalid': errors.user_charge_id }"
                                :disabled="props.contract.id != 0 && props.action == 'view'"
                                v-model="props.contract.user_charge_id">
                                <option :value="null">--Chọn--</option>
                                <option v-for="(item, index) in props.users" :key="index" :value="item.id">{{
                                    item.name }}</option>
                            </select> -->
                            <base-validation :message="errors.user_charge_id" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="customerType" class="required col-form-label">Thuộc dự án</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <SelectSearch  :class="{
                            'select-custom-valid':
                                errors.project_id
                        }" :list-data="permissionProjects?.length >0? projects.filter((item) => (permissionProjects.includes(item.id))) : projects" v-model="props.contract.project_id" key-value="id"
                                :disabled="props.contract.id != 0 && props.action == 'view'"
                                placeholder="--Chọn--" :key-display="['name']"
                                key-show="name"/>
                            <!-- <select class="form-select w-75" :class="{ 'is-invalid': errors.project_id }"
                                :disabled="props.contract.id != 0 && props.action == 'view'"
                                v-model="props.contract.project_id">
                                <option :value="null">--Chọn--</option>
                                <option v-for="(item, index) in props.projects" :key="index"
                                :disabled="!item.canPermissionAddContract"
                                :value="item.id">
                                    {{ item.name }}</option>
                            </select> -->
                            <base-validation :message="errors.project_id" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="customer_name" class="required col-form-label">Khách hàng</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <span :style="disabledEditContractFromNotification? 'background-color: #e0e4ec' :''" class="form-control" style="height: 28px;">{{ customer ? customer.name : '' }}</span>
                            <base-validation :message="errors.customer_id" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-3">
                            <label for="inputPassword6" class="required col-form-label">Loại hợp đồng</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-9">
                            <select class="form-select" :class="{ 'is-invalid': errors.contract_type_id }"
                                :disabled="props.contract.id != 0 && props.action == 'view'"
                                v-model="props.contract.contract_type_id">
                                <option :value="null">--Chọn--</option>
                                <option v-for="(item, index) in props.types" :key="index" :value="item.id">
                                    {{ item.name }}</option>
                            </select>
                            <base-validation :message="errors.contract_type_id" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3 align-items-center align-content-center col-lg-12" v-if="props.contract.permission_contract_value || props.contract.id == 0 || props.contract.userCreateContract">
                        <div class="col-lg-4">
                            <label for="contract_value" class="required col-form-label">Giá trị hợp đồng</label>
                            <base-validation />
                        </div>
                        <div class="d-flex align-items-center flex-wrap col-lg-8">
                            <div class="col-lg-6">
                                <input type="text" id="contract_value" maxlength="19"  v-model="props.contract.contract_value"
                                    :disabled="props.contract.id != 0 && props.action == 'view'"
                                    @keypress="filterNumberInput($event)" class="form-control p-2" style="text-align:right"
                                    :class="{ 'is-invalid': errors.contract_value }" />
                            </div>
                            <div class="col-lg-3 ms-5">
                                <label for="contract_value" class="col-form-label">VND</label>
                            </div>
                            <base-validation :message="errors.contract_value" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="representative" class="required col-form-label">Thời gian thực hiện</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-8">
                            <input type="date" class="form-control form-control-datetime mb-lg-0 p-2 w-50"
                                :class="{ 'is-invalid': errors.start_date }"
                                :disabled="props.contract.id != 0 && props.action == 'view'"
                                v-model="props.contract.start_date" />
                            <base-validation :message="errors.start_date" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="inputPassword6" class="required col-form-label">Thời gian nghiệm thu</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-8">
                            <input type="date" class="form-control form-control-datetime mb-lg-0 p-2 w-50"
                                :class="{ 'is-invalid': errors.hand_over_date }"
                                :disabled="props.contract.id != 0 && props.action == 'view'"
                                v-model="props.contract.hand_over_date" />
                            <base-validation :message="errors.hand_over_date" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="email" class="required col-form-label">Số lần thanh toán</label>
                            <base-validation />
                        </div>
                        <div class="d-flex align-items-center flex-wrap col-lg-8">
                            <div class="col-lg-4">
                                <select class="form-select" :class="{ 'is-invalid': errors.number_payment }"
                                    :disabled="props.contract.id != 0 && props.action == 'view'"
                                    v-model="props.contract.number_payment" id="customer_name">
                                    <option :value="null">--Chọn--</option>
                                    <option v-for="index in 10" :key="index" :value="index"
                                        :disabled="index < props.contract.payment_details.data.length">{{
                                            index }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-5 ms-5">
                                <label for="created_at" class="col-form-label">Lần </label>
                            </div>
                            <base-validation class="col-lg-12" :message="errors.number_payment" />
                        </div>
                    </div>
                    <div class="row g-3 col-lg-12">
                        <div class="col-lg-4">
                            <label for="inputPassword6" class="col-form-label">Lưu ý quan trọng</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-8">
                            <textarea type="text" id="created_at" v-model="props.contract.note_contract"
                                :disabled="props.contract.id != 0 && props.action == 'view'" class="form-control p-2"
                                :class="{ 'is-invalid': errors.note_contract }" rows="2"></textarea>
                            <base-validation :message="errors.note_contract" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="email" class="required col-form-label">Thời gian bảo hành</label>
                            <base-validation />
                        </div>
                        <div class="d-flex align-items-center flex-wrap col-lg-8">
                            <div class="col-lg-4">
                                <input type="text" id="created_at" v-model="props.contract.warranty_time"
                                    :disabled="props.contract.id != 0 && props.action == 'view'"
                                    @keypress="filterNumberInput($event)" class="form-control p-2"
                                    placeholder="3 - 36 tháng" :class="{ 'is-invalid': errors.warranty_time }" />
                            </div>
                            <div class="col-lg-5 ms-5">
                                <label for="created_at" class="col-form-label">Tháng</label>
                            </div>
                            <base-validation class="col-lg-12" :message="errors.warranty_time" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="inputPassword6" class="required col-form-label">Ngày hết hạn</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-8">
                            <input type="date" class="form-control form-control-datetime mb-lg-0 p-2 w-50"
                                :disabled="props.contract.id != 0 && props.action == 'view'"
                                :class="{ 'is-invalid': errors.expiration_date }"
                                v-model="props.contract.expiration_date" />
                            <base-validation :message="errors.expiration_date" />
                        </div>
                    </div>
                    <div class="row g-3 align-items-center col-lg-12">
                        <div class="col-lg-4">
                            <label for="inputPassword6" class="required col-form-label">Trạng thái</label>
                            <base-validation />
                        </div>
                        <div class="col-lg-8">
                            <select class="form-select w-50" :class="{ 'is-invalid': errors.status_id }"
                                :disabled="props.contract.id != 0 && props.action == 'view'"
                                v-model="props.contract.status_id">
                                <option :value="null">--Chọn--</option>
                                <option v-for="(item, index) in props.statuses" :key="index" :value="item.id">{{
                                    item.name }}</option>
                            </select>
                            <base-validation :message="errors.status_id" />
                        </div>
                    </div>
                </div>
            </div>
 <!-- v-if="contract.canPermisisonViewPaymentContract" -->
            <div v-if="contract.canPermisisonViewPaymentContract || props.contract.id == 0 || contract.userCreateContract"

            class="row col-lg-12 ps-5 mb-10" style="border-bottom: 1px solid rgb(212, 212, 212);">
                <div class="card-header border-0 d-flex justify-content-between align-items-center">
                    <span class="card-label fw-bold fs-4 m-0">Chi tiết số lần thanh toán</span>
                    <div class="card-toolbar m-0">
                        <a href="#" class="btn btn-function" @click="addItemPaymentDetail()"
                            v-if="props.action != 'view' && props.contract.payment_details.data.length < props.contract.number_payment">
                            <i class="ki-duotone ki-plus fs-2"></i>Thêm</a>
                    </div>
                </div>
                <div class="card-body py-3">
                    <div class="table-responsive table-scroll-sm h-30vh text-nowrap">
                        <table class="table table-row-dashed table-bordered table-sm table-data"
                            :class="{ 'disable': props.action == 'view' }">
                            <thead>
                                <tr class="fs-6 text-gray-400">
                                    <th class="w-50px max-w-75px">Lần TT </th>
                                    <th class="required w-175px">Số tiền TT dự kiến(VND)</th>
                                    <th class="required w-150px">
                                        Ngày TT dự kiến
                                    </th>
                                    <th class=" w-150px">
                                        Ngày TT thực tế
                                    </th>
                                    <th class=" w-150px">
                                        Số tiền TT thực tế
                                    </th>
                                    <th class="min-w-325px">
                                        Ghi chú
                                    </th>
                                    <th class="w-75px" colspan="2">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="max-h-25 overflow-auto cursor-pointer"
                                v-if="props.contract.payment_details.data.length > 0">
                                <tr v-for="(item, index) in props.contract.payment_details.data" :key="index"
                                    :class="{ 'active': index == indexPayment || props.contract.id == 0 }">
                                    <td class="text-center">
                                        <!-- <input type="text" :disabled="index != indexPayment" class="form-control"
                                                    @keypress="filterNumberInput($event)"
                                                    :class="{ 'is-invalid': errors['payment_details.data.' + index + '.payment_times'] }"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    :title="errors['payment_details.data.' + index + '.payment_times']"
                                                    v-model="item.payment_times" /> -->
                                        {{ index + 1 }}
                                    </td>
                                    <td><input type="text" maxlength="19" :disabled="index != indexPayment && props.contract.id != 0"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['payment_details.data.' + index + '.amount'] }"
                                            @keypress="filterNumberInput($event)" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom"
                                            :title="errors['payment_details.data.' + index + '.amount']"
                                            style="text-align:right" v-model="item.amount" />
                                    </td>
                                    <td><input type="date" :disabled="index != indexPayment && props.contract.id != 0"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['payment_details.data.' + index + '.expected_payment_date'] }"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            :title="errors['payment_details.data.' + index + '.expected_payment_date']"
                                            v-model="item.expected_payment_date" />
                                    </td>
                                    <td><input type="date" :disabled="index != indexPayment && props.contract.id != 0"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['payment_details.data.' + index + '.payment_date'] }"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            :title="errors['payment_details.data.' + index + '.payment_date']"
                                            v-model="item.payment_date" />
                                    </td>
                                    <td><input type="text" maxlength="19" :disabled="index != indexPayment && props.contract.id != 0"
                                            class="form-control" @keypress="filterNumberInput($event)"
                                            :class="{ 'is-invalid': errors['payment_details.data.' + index + '.actual_amount'] }"
                                            :title="errors['payment_details.data.' + index + '.actual_amount']"
                                            style="text-align:right" v-model="item.actual_amount" />
                                    </td>
                                    <td><input type="text" :disabled="index != indexPayment && props.contract.id != 0"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['payment_details.data.' + index + '.note'] }"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            :title="errors['payment_details.data.' + index + '.note']"
                                            v-model="item.note" />
                                    </td>
                                    <td class="text-center" v-if="props.contract.id != 0">
                                        <a href="#" class="btn btn-icon btn-edit btn-sm" v-if="index == indexPayment"
                                            @click="unsetIndexPayment()">
                                            <i class="fa-solid fa-check"></i>
                                        </a>
                                        <a href="#" class="btn btn-icon btn-edit btn-sm" v-else
                                            @click="setIndexPayment(index)">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-icon btn-delete btn-sm"
                                            :class="{ 'invisible': indexPayment != -1 && indexPayment == index }"
                                            @click="removeItemPaymentDetail(index)">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody class="max-h-25 overflow-auto cursor-pointer" v-else>
                                <tr>
                                    <td class="text-center" colspan="8">Không có dữ liệu
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row col-lg-12 ps-1 pe-1 ms-2">
                <div class="col-lg-6">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <span class="card-label fw-bold fs-4 m-0">Hạng mục thực hiện</span>
                        <div class="card-toolbar m-0">
                            <a href="#" class="btn btn-function" @click="addItemContractModule()"
                                v-if="props.action != 'view'">
                                <i class="ki-duotone ki-plus fs-2"></i>Thêm</a>
                        </div>
                    </div>
                    <div class="card-body py-3">
                        <div class="table-responsive table-scroll-sm h-20vh text-nowrap">
                            <table class="table table-row-dashed table-bordered table-sm table-data"
                                :class="{ 'disable': props.action == 'view' }">
                                <thead>
                                    <tr class="fs-6 text-gray-400">
                                        <th class="w-50px">STT</th>
                                        <th class="required w-125px text-center">Nhóm chức năng</th>
                                        <th class="required w-125px">
                                            Giá trị
                                        </th>
                                        <th class="min-w-150px">
                                            Ghi chú
                                        </th>
                                        <th class="w-50px" colspan="2">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody class="max-h-25 overflow-auto cursor-pointer"
                                    v-if="props.contract.contract_modules?.data?.length > 0">
                                    <tr v-for="(item, index) in props.contract.contract_modules.data" :key="index"
                                        :class="{ 'active': index == indexModule || props.contract.id == 0 }">
                                        <td class="text-center">
                                            {{
                                                (index + 1)
                                            }}
                                        </td>
                                        <td><input type="text" :disabled="index != indexModule && props.contract.id != 0"
                                                class="form-control"
                                                :class="{ 'is-invalid': errors['contract_modules.data.' + index + '.module'] }"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                :title="errors['contract_modules.data.' + index + '.module']"
                                                v-model="item.module" />
                                        </td>
                                        <td><input type="text" maxlength="19" :disabled="index != indexModule && props.contract.id != 0"
                                                class="form-control"
                                                :class="{ 'is-invalid': errors['contract_modules.data.' + index + '.value'] }"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                :title="errors['contract_modules.data.' + index + '.value']"
                                                style="text-align:right" @keypress="filterNumberInput($event)"
                                                v-model="item.value" />
                                        </td>
                                        <td>
                                            <input type="text" :disabled="index != indexModule && props.contract.id != 0"
                                                class="form-control"
                                                :class="{ 'is-invalid': errors['contract_modules.data.' + index + '.note_module'] }"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                :title="errors['contract_modules.data.' + index + '.note_module']"
                                                v-model="item.note_module" />
                                        </td>
                                        <td class="text-center" v-if="props.contract.id != 0">
                                            <a href="#" class="btn btn-icon btn-edit btn-sm" v-if="index == indexModule"
                                                @click="unsetIndexModule()">
                                                <i class="fa-solid fa-check"></i>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-edit btn-sm" v-else
                                                @click="setIndexModule(index)">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-icon btn-delete btn-sm"
                                                :class="{ 'invisible': indexModule != -1 && indexModule == index }"
                                                @click="removeItemContractModule(index)">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td class="text-center" colspan="6">Không có dữ liệu hiển thị</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <span class="card-label fw-bold fs-4 m-0">Danh sách phụ lục hợp đồng</span>
                        <div class="card-toolbar m-0">
                            <a href="#" class="btn btn-function" @click="addItemAnnexContract()"
                                v-if="props.action != 'view'">
                                <i class="ki-duotone ki-plus fs-2"></i>Thêm</a>
                        </div>
                    </div>
                    <div class="card-body py-3">
                        <div class="table-responsive table-scroll-sm h-20vh text-nowrap">
                            <table class="table table-row-dashed table-bordered table-sm table-data"
                                :class="{ 'disable': props.action == 'view' }">
                                <thead>
                                    <tr class="fs-6 text-gray-400">
                                        <th class="w-50px">STT</th>
                                        <th class="required w-125px text-center">Số phụ lục</th>
                                        <th class="required w-125px">
                                            Ngày ký
                                        </th>
                                        <th class="required w-150px">
                                            Diễn giải
                                        </th>
                                        <th class="w-75px" colspan="2">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody class="max-h-25 overflow-auto cursor-pointer"
                                    v-if="props.contract.annex_contracts.data.length > 0">
                                    <tr v-for="(item, index) in props.contract.annex_contracts.data" :key="index"
                                        :class="{ 'active': index == indexAnnex || props.contract.id == 0 }">
                                        <td class="text-center">
                                            {{
                                                (index + 1)
                                            }}
                                        </td>
                                        <td><input type="text" :disabled="index != indexAnnex && props.contract.id != 0"
                                                class="form-control"
                                                :class="{ 'is-invalid': errors['annex_contracts.data.' + index + '.code'] }"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                :title="errors['annex_contracts.data.' + index + '.code']"
                                                v-model="item.code" />
                                        </td>
                                        <td><input type="date" :disabled="index != indexAnnex && props.contract.id != 0"
                                                class="form-control"
                                                :class="{ 'is-invalid': errors['annex_contracts.data.' + index + '.date'] }"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                :title="errors['annex_contracts.data.' + index + '.date']"
                                                v-model="item.date" />
                                        </td>
                                        <td><input type="text" :disabled="index != indexAnnex && props.contract.id != 0"
                                                class="form-control"
                                                :class="{ 'is-invalid': errors['annex_contracts.data.' + index + '.description'] }"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                :title="errors['annex_contracts.data.' + index + '.description']"
                                                v-model="item.description" />
                                        </td>

                                        <td class="text-center" v-if="props.contract.id != 0">
                                            <a href="#" class="btn btn-icon btn-edit btn-sm" v-if="index == indexAnnex"
                                                @click="unsetIndexAnnex()">
                                                <i class="fa-solid fa-check"></i>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-edit btn-sm" v-else
                                                @click="setIndexAnnex(index)">

                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-icon btn-delete btn-sm"
                                                :class="{ 'invisible': indexAnnex != -1 && indexAnnex == index }"
                                                @click="removeItemAnnexContract(index)">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td class="text-center" colspan="6">Không có dữ liệu hiển thị</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <button  type="button" class="btn btn-function me-4" @click="sendData()" v-if="props.action != 'view' && disabledEditContractFromNotification != true">
                <i class="fa-solid fa-floppy-disk"></i> Ghi lại
            </button>
            <button :class="{'check-permission' : !contract.canPermissionEditContract}" type="button"
             class="btn btn-function me-4" @click="emits('update-data', 'update')" v-else-if="disabledEditContractFromNotification != true && props.action == 'view'">
                <i class="fa-solid fa-floppy-disk"></i> Sửa
            </button>
            <button type="button"
              :class="disabledEditContractFromNotification != true? 'btn btn-secondary btn-sm btn-active-color-light':'btn btn-function me-4'"
              id="close-modal"
                data-bs-dismiss="modal" @click="closeModal(props.contract.id)">
                <i class="fa-solid fa-xmark"></i>Đóng
            </button>
        </template>
    </Modal>
</template>
<script setup>
import { defineProps, ref, defineEmits, watch, computed, onBeforeMount } from "vue";
import { create, update } from "../../helper/axiosConfig";
import { useToast } from '../../helper/toastMessage'
import { filterCodeInput, filterNumberInput, filterCodeInputNumber } from '../../helper/filterInput'
import { displayPrice, validateInputCode } from '../../../services/utils'
import InputSearch from "../input/InputSearch.vue";
import SelectSearch from "../input/SelectSearch.vue";
import Modal from '../modal/ScrollModal.vue'
import { useContractStore } from "../../stores/contract";
import { useCustomerStore } from "../../stores/customer";
import { useStoreProjects } from "../../stores/project";
import { useContracTypeStore } from "../../stores/contract";
import { useUsers } from "../../stores/user";

const projectStore = useStoreProjects();
const customerStore = useCustomerStore();
const contractTypeStore = useContracTypeStore();
const userStore = useUsers();


const contractStore = useContractStore();

const props = defineProps({
    contract: {
        type: Object,
        default: function () {
            return null;
        },
    },
    statuses: {
        type: Array,
        default: [],
    },
    types: {
        type: Array,
        default: []
    },
    action: {
        type: String,
    },
     disabledEditContractFromNotification: {
        type: Boolean,
        default:false
    },
    contractId: {
        type: Number
    }
});

const emits = defineEmits(["close-model"]);

const closeModal = (id) => {
    errors.value = [];
    indexModule.value = -1;
    indexAnnex.value = -1;
    indexPayment.value = -1;
    emits('close-model', id);
}
const permissionProjects = ref([]);
const projects = computed(() => {
     permissionProjects.value = projectStore.$state.projects?.permissionProjects
    if (projectStore.$state.projects.data) {


        return projectStore.$state.projects.data;
    } else {


        return projectStore.$state.projects;
    };
});

const customer = ref(null);

const contractType = computed(() => {
    return contractTypeStore.$state.types.data ?? [];
});

const users = computed(() => {
    return userStore.$state.users.data ?? [];
});

const getListProject = (key) => {
    projectStore.getAllProjectsData({
        getAll: true,
        name: key,
        not_loading: true,
        contractPermission: true,
        projectPermission: true
    });
};
const getListUser = (key) => {
    userStore.getUsersData({
        getAll: true,
        name: key,
        not_loading: true,
        contractPermission: true
    });
};

const errors = ref([]);

const indexModule = ref(-1);
const indexAnnex = ref(-1);
const indexPayment = ref(-1);

const setIndexModule = (index) => {
    indexModule.value = index;
}

const setIndexAnnex = (index) => {
    indexAnnex.value = index;
}

const setIndexPayment = (index) => {
    indexPayment.value = index;
}

const unsetIndexAnnex = () => {
    indexAnnex.value = -1;
}

const unsetIndexModule = () => {
    indexModule.value = -1;
}

const unsetIndexPayment = () => {
    indexPayment.value = -1;
}

const addItemContractModule = () => {
    props.contract.contract_modules.data.push(
        {
            id: 0,
            module_id: 0,
            module: '',
            contract_id: 0,
            value: '',
            note_module: '',
            status: true,
        }
    )
}

const addItemAnnexContract = () => {
    props.contract.annex_contracts.data.push(
        {
            id: 0,
            code: '',
            contract_id: 0,
            date: null,
            description: '',
        }
    )
}

const addItemPaymentDetail = () => {
    props.contract.payment_details.data.push(
        {
            id: 0,
            contract_id: 0,
            payment_times: '',
            amount: '',
            expected_payment_date: null,
            payment_date: null,
            note: '',
        }
    )
}

const removeItemContractModule = (index) => {
    props.contract.contract_modules.data.splice(index, 1);
}

const removeItemAnnexContract = (index) => {
    props.contract.annex_contracts.data.splice(index, 1);
}

const removeItemPaymentDetail = (index) => {
    props.contract.payment_details.data.splice(index, 1);
}

watch(() => props.contract?.code, (newValue, oldValue) => {
    props.contract.code = newValue.toUpperCase();
})

watch(() => props.contract?.project_id, (newValue, oldValue) => {
    const project = projects.value.find(x => x.id == newValue);
    if (project) {
        props.contract.customer_id = project.customer_id;
        customer.value = project.customer.data;
    } else {
        props.contract.customer_id = null;
        customer.value = null;
    }
})

watch(() => props.contract?.contract_modules?.data, (newValue, oldValue) => {
    newValue.map(e => {
        if(e.value == 0 && e.value) {
            e.value = 0;
            return e;
        }
        if (typeof (e.value) === "number") {
            e.value = displayPrice(e.value);
        } else {
            if (typeof (e.value) === "string") {
                e.value = displayPrice(e.value.replaceAll(".", ""));
            }
        }
        return e;
    })
    props.contract.contract_modules.data = newValue;
}, { deep: true })

watch(() => props.contract?.payment_details?.data, (newValue, oldValue) => {
    newValue.map(e => {

        if (e.amount == 0 && e.amount) {
           e.amount = 0;
        }

        if (typeof (e.amount) === "number") {
            e.amount = displayPrice(e.amount);

        } else {
            if (typeof (e.amount) === "string") {
                e.amount = displayPrice(e.amount.replaceAll(".", ""));
            }
        }

        if(e.actual_amount == 0 && e.actual_amount) {
            e.actual_amount = 0;
            return e;
        }
        if (typeof (e.actual_amount) === "number") {
            e.actual_amount = displayPrice(e.actual_amount);
        } else {
            if (typeof (e.actual_amount) === "string") {
                e.actual_amount = displayPrice(e.actual_amount.replaceAll(".", ""));
            }
        }
        return e;
    })
    props.contract.payment_details.data = newValue;
}, { deep: true })

watch(() => props.contract?.contract_value, (newValue, oldValue) => {
    if (typeof (newValue) === "number") {
        props.contract.contract_value = displayPrice(newValue);
    } else {
        if (typeof (newValue) === "string") {
            props.contract.contract_value = displayPrice(newValue.replaceAll(".", ""));
        }
    }

})

const sendData = () => {
    const data = props.contract;
    console.log(data);
    if (props.contract.id == 0) {
        create("/contracts/api", data)
            .then((res) => {
                console.log(res.data.data);
                contractStore.pushData(res.data.data);
                props.contract.id = res.data.data.id;
                const btnClose = document.getElementById("close-modal");
                btnClose.click();
                useToast.successToast('Thêm mới thành công!');
                // btnClose.dataset.bsDismiss = "modal"
            })
            .catch((err) => {
                console.log(err);
                if (err.response.data.errors) {
                    errors.value = err.response.data.errors;
                    for (var key in err.response.data.errors) {
                        console.log(key, err.response.data.errors[key]);
                    }
                }
            });
        return;
    }

    update("/contracts/api/" + props.contract.id, data)
        .then((res) => {
            console.log(res.data);
            const btnClose = document.getElementById("close-modal");
            btnClose.click();
            useToast.successToast('Cập nhật thành công!');
            // btnClose.dataset.bsDismiss = "modal"
        })
        .catch((err) => {
            if (err.response.data.errors) {
                errors.value = err.response.data.errors;
            }
        });
};
onBeforeMount(() => {
    getListProject();
    getListUser();
    customer.value = props.contract.customer ? props.contract.customer.data : null;
    props.contract.contract_value = displayPrice((props.contract.contract_value + '').replaceAll(".", ""));
    props.contract.payment_details.data = props.contract.payment_details.data.map(e => {
        if (typeof (e.amount) === "number") {
            e.amount = displayPrice(e.amount);
        } else {
            if (typeof (e.amount) === "string") {
                e.amount = displayPrice(e.amount.replaceAll(".", ""));
            }
        }

        if (typeof (e.actual_amount) === "number") {
            e.actual_amount = displayPrice(e.actual_amount);
        } else {
            if (typeof (e.actual_amount) === "string") {
                e.actual_amount = displayPrice(e.actual_amount.replaceAll(".", ""));
            }
        }
        return e;
    });
})
</script>
<style lang="scss" scoped>
.table {
    tr {
        &.active {
            td {
                background-color: rgb(255, 255, 255);
            }

            input {
                background-color: rgb(255, 255, 255) !important;
            }
        }

    }

    td {
        padding: 0 !important;
        background-color: #e9e9e9;
    }

    input {
        &:not(.is-invalid) {
            border: 0 !important;
        }

        width: 100% !important;
        height: 100% !important;
        box-sizing: border-box !important;
        color: #000000;
        background-color: #e9e9e9 !important;
        border-radius: 0;
        margin: 0 !important;

    }

    &.disable {
        a {
            visibility: hidden !important;
        }
    }

    .is-invalid {
        border: 0 !important;
        border-bottom: 1px solid !important;
        border-color: #ff0000ea !important;
        border-radius: 2px !important;
    }
}

.form-view {

    select:disabled,
    input:disabled,
    textarea:disabled {
        color: #3d3d3d;
        background-color: #f3eeee;
    }
}

.form-control {
    &.form-control-datetime {
        &.is-invalid {
            padding-right: 32px !important;
        }

    }
    select {
        background: #163fc5 !important;
    }
}
.check-permission {
    visibility: hidden;
}
.select-custom-valid {
    border: 1px solid red !important;
    border-radius: 5px;
}
</style>
