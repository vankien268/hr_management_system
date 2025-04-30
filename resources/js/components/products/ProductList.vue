<template>
    <div class="card">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5" style="justify-content: normal; padding-left:25px;">
           <div class="d-flex align-items-center flex-wrap me-8">
                    <div>
                        <label for="customerCode" class="col-form-label"
                            >Nhóm sản phẩm</label
                        >
                    </div>
                    <div class="w-200px">
                        <!-- <input type="text" placeholder="Tất cả" productGroups v-model="searchInfoProduct.code"
                        @keyup.enter="searchProduct()" class="form-control mb-lg-0 p-2"  /> -->
                        <select
                        style="height: 29px"
                        class="form-select"
                        data-hide-search="true"
                        data-placeholder="Chọn trạng thái"
                        name="target_assign"
                        v-model="searchInfoProduct.product_group_id"
                    >
                        <option :value="null">Chọn</option>
                          <option v-for="(item,index) in productGroups"
                           :key="index" :value="item.id"
                           :disabled="item.code== 'ROOT'"
                           :style="item.code== 'ROOT' ? 'background:lightgray': ''"
                        >                 {{  `${item.prefix} ${item.name}` }}
                        </option>
                    </select>
                    </div>
            </div>
            <div class="d-flex align-items-center flex-wrap" >
                    <div>
                        <label for="customerCode" class="col-form-label"
                            >Mã / tên sản phẩm</label
                        >
                    </div>
                    <div class="w-200px">
                        <input type="text" placeholder="Tất cả" v-model="searchInfoProduct.nameOrCode"
                        @keyup.enter="searchProduct()" class="form-control mb-lg-0 p-2"  />
                    </div>
            </div>
            <div
                class="d-flex align-items-center flex-wrap mb-3 mt-2 justify-content-start"
            >
                <div class="align-items-center me-1 flex-wrap mx-10">
                    <a
                        @click="searchProduct()"
                        tabindex="0"
                        href="#"
                        class="btn btn-function"
                    >
                        <i class="fa-solid fa-search"></i>Tìm kiếm</a
                    >
                </div>
                <div class="justify-content-end" style="padding-left:309px;">
                    <a @click="AddProduct()"
                        href="#"
                        class="btn btn-function me-2"
                        data-bs-target="#modalCreateProduct"
                        data-bs-toggle="modal"
                        v-if="props.btnAdd"
                    >
                        <i class="ki-duotone ki-plus fs-2"></i>Thêm</a
                    >
                </div>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3 text-nowrap">
            <!--begin::Table container-->
            <div class="table-responsive table-scroll">
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
                    <thead class="fs-6 text-gray-400">
                        <tr class="fw-bold text-muted">
                            <th class="w-40px text-content" style="text-align: center">
                                STT
                            </th>
                            <th style="width:80px;" class="text-content">Mã sản phẩm/dịch vụ</th>
                            <th class="w-100px text-content">Tên Sản phẩm/dịch vụ</th>
                            <th style="width: 100px" class="text-content">Đơn vị tính</th>
                            <th class="w-100px text-content"  style="text-align:left">Đơn giá</th>
                            <th class="w-40px text-content" >Giá mở</th>
                            <th class="w-40px text-content">Trạng thái</th>
                            <th class="w-200px text-content">Ghi chú</th>
                            <th class="w-100px text-center text-content" colspan="2">
                                Hành động
                            </th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody
                        v-for="(item, index) in products"
                        :key="index"
                        class="max-h-75 overflow-auto"
                    >
                        <td
                            class="h-40px fw-medium fs-6 table-bordered"
                            style="
                                background-color: rgb(243 237 179);
                                border-left: 1px solid;
                            "
                            colspan="10"
                        >
                            <span class="text-content">{{ index }}</span>
                        </td>
                         <tr v-for="(item2, index2) in item"
                            :key="index2">
                            <td style="text-align:center">
                                    <span class="text-dark text-hover-primary">{{ item2.stt + 1 }}</span></td>
                                <td class="text-dark text-hover-primary text-content break-text" style="text-align:left; max-width:80px;"
                                    title="item2.code"
                                >
                                    {{ item2.code }}
                                </td>
                                <td class="text-dark text-hover-primary text-content break-text max-w-100px"  :title="item2.name">
                                   {{  item2.name }}
                                </td>
                                <td :title="item2.unit.data.name"  class="text-dark text-hover-primary text-content max-w-150px break-text text-left">
                                     {{ item2.unit.data.name }}
                                </td>
                                <td style="text-align:right">
                                    <span class="text-dark text-hover-primary text-content" :title="displayPrice(item2.price)">
                                        {{ displayPrice(item2.price) }}
                                    </span>
                                </td>
                                <td>
                                    <!-- <span class="text-dark text-hover-primary text-content"
                                    :title="item2.edit_price ==1 ? 'Được phép sửa giá': 'Không được phép sửa giá'">
                                        <input type="checkbox" class="checkbox-price" style=" accent-color: #0049b0;pointer-events:none"
                                        :checked="item2.edit_price == 1? true: false">
                                    </span> -->
                                   <span style="padding-left:6px;">
                                          <i v-if="item2.edit_price == 1" class="fa-solid fa-check text-dark fs-2"></i>
                                   </span>
                                </td>
                                <td>
                                    <div  class="text-red text-hover-primary d-block mb-1" style="width:100px;"
                                        :class="item2.status == 0 ? 'status-badge-danger-color' : 'status-badge-active-color'"
                                    >{{ item2.status == 1? 'Sử dụng' : 'Ngừng sử dụng' }}</div>
                                    <!-- <span class="text-dark text-hover-primary text-content" :title="item2.status">
                                        {{ item2.status }}
                                    </span> -->
                                </td>
                                <td class="text-dark text-hover-primary text-content max-w-250px break-text" :title="item2.note">
                                    {{ item2.note }}
                                </td>
                                <td class="w-50px text-center">
                                    <!-- :class="{'disable': !item2.isEdit }" -->
                                    <a href="#" v-if="item2.isEdit" @click="editProduct(item2)" data-bs-target="#modalUpdateProduct"
                        data-bs-toggle="modal" class="btn btn-icon btn-edit btn-sm">
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </td>
                                <td class="w-50px">
                                    <a href="#" v-if="item2.is_delete_permission" :class="!item2.isDelete? 'disable': ''"
                                    @click="handleDeleteProduct(item2.id)" class="btn btn-icon btn-delete btn-sm me-1">
                                        <i class="fa-solid fa-trash fs-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </a>
                                </td>
                        </tr>
                    </tbody>
                     <tbody v-if="Object.keys(products).length == 0">
                            <tr>
                                <td class="text-center" colspan="9">
                                    Không có dữ liệu hiển thị
                                </td>
                            </tr>
                        </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
    <teleport to="#admin">
          <div class="modal fade" style="padding-top:5%;" id="modalCreateProduct"  data-bs-keyboard="true" data-bs-backdrop="static"  tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-centered">
				<div class="rounded modal-content">
					<div class="modal-header border-0 pb-0">
                            <h4 class="modal-title">
                               Thêm mới sản phẩm
                            </h4>
                            <div @click="closeModalProduct()" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <i class="ki-duotone ki-cross fs-1 text-white">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
					    </div>
					<div class="modal-body p-0 ps-2 pe-2 mb-3">
                         <product-form
                         :units="units"
                         :productGroups="productGroups"
                           :clickBtnIconClose="clickBtnIconClose"
                            :key="1"
                            @storeProduct="storeProduct"
                            @resetclickBtnIconClose="resetclickBtnIconClose"
                            :imageDefault="imageDefault"
                            :isModalUpdate="isModalUpdate"
                           ></product-form >
					</div>
				</div>
			</div>
		</div>

        <!-- sửa -->
        <div class="modal fade" style="padding-top:5%;" id="modalUpdateProduct"  data-bs-keyboard="true" data-bs-backdrop="static"  tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-centered">
				<div class="rounded modal-content">
					<div class="modal-header border-0 pb-0">
                            <h4 class="modal-title">
                               Sửa sản phẩm
                            </h4>
                            <div @click="closeModalProduct()" id="click-close-modal" class="btn btn-sm btn-icon btn-active-color-primary close-modal-x" data-bs-dismiss="modal">
                                <i class="ki-duotone ki-cross fs-1 text-white">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
					    </div>
					<div class="modal-body p-0 ps-2 pe-2 mb-3">
                         <product-form
                         :units="units"
                         :productGroups="productGroups"
                            :clickBtnIconClose="clickBtnIconClose"
                            :productItem="productItem"
                            :isModalUpdate="isModalUpdate"
                            :key="2"
                            @updateProduct="updateProduct"
                            :imageDefault="imageDefault"
                           ></product-form >
					</div>
				</div>
			</div>
		</div>
    </teleport>
</template>

<script setup>
import axios from "axios";
import { helperFunc } from "../../helper/heplerFunction.js";
import { computed, ref, onMounted, reactive } from "vue";
import { useToast } from "../../helper/toastMessage.js";
import productForm from '../products/ProductForm.vue'
import { sweetAlertMessage } from '../../helper/sweetAlert'
import imageDefault from '../../default-image/default-image.png'
import { displayPrice } from "../../../services/utils"

const props = defineProps({
    btnAdd: {
        type: Boolean,
        default: false,
    }
})
const getAllProducts = ref([]);
const productGroups = ref([]);
const units = ref([]);
const getAllProductsApi = (params = null) => {
    KTApp.showPageLoading();
    axios({
        url: "/products/get-all",
        method: "GET",
        params: params,
    })
        .then((res) => {
            const { data } = res.data;
            getAllProducts.value = data;
            const lengthGroups =  res.data.productGroups.length;
            productGroups.value = res.data.productGroups.data
            units.value = res.data.units
            // if (res.data?.message) {
            //     useToast.errorToast(res.data?.message);
            // }
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            KTApp.hidePageLoading();
        });
};

onMounted(() => {
    getAllProductsApi();
});

const products = computed(() => {
     getAllProducts.value = helperFunc.groupBy(getAllProducts.value,'product_group_name', true);
     return getAllProducts.value;
});


// edit sản phẩm
const productItem = ref({});
const isModalUpdate = ref(false);
const editProduct = (product) => {
    productItem.value = product;
    isModalUpdate.value = true;
}

const clickBtnIconClose= ref(false);
const closeModalProduct = () => {
    isModalUpdate.value = false;
    clickBtnIconClose.value = true;
};
const AddProduct =() => {
    isModalUpdate.value = false;
}
const resetclickBtnIconClose = (value) => {
    clickBtnIconClose.value = value;
}
const updateProduct = ()=> {
    //  $('#modalUpdateProduct').modal('hide');
    //           $('.modal-backdrop').remove();
    const btnClick = document.getElementById('click-close-modal');
    btnClick.click();
   getAllProductsApi(searchInfoProduct);
}
const storeProduct =()=> {
    getAllProductsApi(searchInfoProduct);
}
const handleDeleteProduct =(productId) => {
    sweetAlertMessage.messageWarning("Bạn có chắc chắn muốn xóa không?").then((result) => {
        if(result.value) {
            KTApp.showPageLoading();
            axios.delete(`/products/destroy/${productId}`)
            .then((res) => {
                const { message } = res.data;
                useToast.successToast(message);
                getAllProductsApi();
            }).catch((error) => {
                console.log(error);
            }).finally(() => {
                KTApp.hidePageLoading();
            })
        }
    })
}
// search
const searchInfoProduct = reactive({
    nameOrCode: "",
    product_group_id: null
});
const searchProduct = () => {
    getAllProductsApi(searchInfoProduct);
}
</script>

<style scoped>
.input-custom-valid {
    border: 1px solid red;
}
.modal-content {
    width: 85%;
}

.table-scroll table tbody td {
    padding: 0.8rem 0.8rem !important;
}
</style>
