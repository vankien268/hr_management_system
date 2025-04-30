<template>
<form id="form-product">
    <div class="row col-lg-12 ms-3">
        <div class="col-lg-6">
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                                <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-3"
                            >
                                <span class="required text-content">Mã nhóm sản phẩm/dịch vụ</span>
                            </label>

                </div>
                <div class="col-lg-8">
                      <select @change="changeProductGroup($event)" style="height:29px;" class="form-select"
                       v-model="formProduct.product_group_id" :class="{ 'select-custom-valid' :  errors.product_group_id }" data-hide-search="true" data-placeholder="Chọn loại dự án" name="target_assign">
                                <option :value="null">Chọn</option>
                                <option v-for="(item, index) in productGroups"
                                :disabled="item.code== 'ROOT'"
                                :style="item.code== 'ROOT' ? 'background:lightgray': ''"
                                :tax-type="item.tax?.data.type"
                                :tax-rate="item.tax?.data.rate"
                                :fee-type="item.fee?.data.type"
                                :fee-rate="item.fee?.data.rate"
                                :key="index" :value="item.id">
                                    {{  `${item.prefix} ${item.name}` }}
                                </option>
                            </select>
                            <div v-if="errors.product_group_id" class="text-danger pt-2">{{
                                    errors.product_group_id[0]
                                }}</div>

                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-3"
                            >
                                <span class="required text-content">Mã sản phẩm/dịch vụ</span>
                            </label>

                </div>
                <div class="col-lg-8">
                    <input v-model="formProduct.code"
                                type="text"
                                class="form-control"
                                placeholder="Nhập sản phẩm/dịch vụ"
                                name="target_title"
                                :disabled="isModalUpdate"
                                :class="{'input-custom-valid': errors.code}"
                                @input="formProduct.code=textCode($event.target.value)"
                                      @keyup="validateInput($event)"
                            />
                            <div v-if="errors.code" class="text-danger pt-3">{{
                                    errors.code[0]
                                }}</div>
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                        <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-3"
                            >
                                <span class="required text-content">Tên sản phẩm/dịch vụ</span>
                            </label>
                </div>
                <div class="col-lg-8">
                         <input v-model="formProduct.name"
                                type="text"
                                class="form-control"
                                placeholder="Nhập tên sản phẩm/dịch vụ"
                                name="target_title"
                                :class="{'input-custom-valid': errors.name}"
                            />
                            <div v-if="errors.name" class="text-danger pt-2">{{
                                    errors.name[0]
                                }}</div>
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                        <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-3"
                            >
                                <span class="required text-content">Trạng thái</span>
                            </label>

                </div>
                <div class="col-lg-8">
                    <select style="height:29px;" class="form-select"
                    :class="{ 'select-custom-valid' :  errors.status}"
                     placeholder="Chọn trạng thái" v-model="formProduct.status" aria-label="Default select example">
                                <option value="1">Sử dụng</option>
                                <option value="0">Ngừng hoạt động</option>
                            </select>
                            <div v-if="errors.status" class="text-danger pt-2">{{
                                    errors.status[0]
                                }}</div>
                </div>
            </div>
                <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                        <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-3"
                            >
                                <span class="text-content">Ghi chú</span>
                            </label>
                </div>
                <div class="col-lg-8">
                    <textarea style="height:210px;" v-model="formProduct.note"
                                type="text"
                                class="form-control"
                                placeholder="Nhập ghi chú"
                                name="target_title"
                                :class="{'input-custom-valid': errors.note}"
                            />
                            <div v-if="errors.note" class="text-danger pt-2">{{
                                    errors.note[0]
                                }}</div>
                </div>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-3"
                            >
                                <span class="text-content">Thuế GTGT</span>
                            </label>
                </div>
                <div class="col-lg-6">
                    <input :disabled="true"
                                type="text"
                                class="form-control"
                                name="target_title"
                                :value="tax?.type == 1? 'Phí' : tax?.type == null? '':'Thuế'"
                            />
                </div>
                <div class="col-lg-2">
                    <input :disabled="true"
                                type="text"
                                :value="tax.rate != null? `${tax?.rate}%`: ''"
                                class="form-control text-content"
                                name="target_title"

                            />
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-3"
                            >
                                <span class="text-content">Phí dịch vụ</span>
                            </label>
                </div>
                <div class="col-lg-6">
                    <input :disabled="true"
                                type="text"
                                class="form-control"
                                name="target_title"
                                :value="fee.type == 0? 'Thuế' : fee.type == null? '':'Phí'"
                            />
                </div>
                <div class="col-lg-2">
                    <input :disabled="true"
                                type="text"
                                :value="fee.rate != null? `${fee.rate}%`: ''"
                                class="form-control text-content"
                                name="target_title"

                            />
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                        <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-3"
                            >
                                <span class="required text-content">Đơn vị tính</span>
                            </label>
                </div>
                <div class="col-lg-8">
                    <select style="height:29px;" class="form-select"
                    :class="{ 'select-custom-valid' :  errors.unit_id }"
                     data-hide-search="true" data-placeholder="Chọn loại dự án"
                     v-model="formProduct.unit_id" name="target_assign">
                                <option :value="null">Chọn</option>
                                <option v-for="(item, index) in units" :key="index" :value="item.id">{{ item.name }}</option>
                            </select>
                            <div v-if="errors.unit_id" class="text-danger pt-2">{{
                                    errors.unit_id[0]
                                }}</div>
                </div>
            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3">
                    <label
                                class="d-flex align-items-center fs-6 fw-semibold mb-3"
                            >
                                <span class="required text-content">Đơn giá</span>
                            </label>
                </div>
                <div class="col-lg-6">
                    <input :class="{'input-custom-valid': errors.price}"
                     v-model="formProduct.price"
                                type="text"
                                class="form-control"
                                style="text-align:right"

                                name="target_title"
                                @input="setFortmatNumber($event)"
                            />

                </div>
                <div class="col-lg-2">
                    <input :disabled="true"
                                type="text"
                                v-model="vnd"
                                class="form-control text-content"
                                name="target_title"

                            />
                </div>
                     <div style="margin-left:115px; margin-top:-1px;" v-if="errors.price" class="text-danger pt-2">{{
                                    errors.price[0]
                                }}</div>

            </div>
            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3 ">
                    <label
                                class="fs-6 fw-semibold mb-3 "
                            >
                                <span class="text-content">Giá mở</span>
                            </label>
                </div>
                <div class="col-lg-1">
                    <input v-model="formProduct.edit_price" type="checkbox" name="edit_price" id="edit_price" form="no-reset-form">
                </div>
            </div>

            <div class="row g-3 align-items-center col-lg-12 padding-bottom">
                <div class="col-lg-3 ">
                    <label
                                class="fs-6 fw-semibold mb-3 "
                            >
                                <span class="text-content">Ảnh đại diện sản phẩm</span>
                            </label>
                </div>
                <div class="col-lg-9">
                     <div class=" col-lg-1 image-upload" >
                        <input class="file-upload-input" id="file-upload-input" title="chọn ảnh đại diện sản phẩm" type='file'  name="image_link" @change="readURL($event)" accept="image/*" />
                        <img :src="formProduct.image_link != null && isModalUpdate? '../storage/'+formProduct.image_link : imageDefaultForm" alt=""
                         class="file-upload-image"
                        style="width: 280px;height: 180px;margin-bottom: 30px">
                    </div>
                    <div
                   v-if="errors.image_link" class="text-danger justify-content-start">{{
                                    errors.image_link[0]
                   }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
            <button @click.prevent="!isModalUpdate? storeProduct() : updateProduct()" type="button" class="btn btn-function me-4">
                <i class="fa-solid fa-floppy-disk"></i> Lưu
            </button>
            <button
                @click="closeModalProduct()"
                type="button"
                class="btn btn-secondary btn-sm btn-active-color-light"
                id="close-modal-product"
                data-bs-dismiss="modal"
            >
            <i class="fa-solid fa-xmark"></i>Đóng
            </button>
    </div>
 </form>
</template>

<script setup>
import { ref, watch, reactive, toRefs, onBeforeMount } from 'vue';
import { useToast } from "../../helper/toastMessage.js";
import { textCode, validateInput } from '../../../services/utils';
import imageDefaultForm from '../../default-image/default-image.png'
import { helperFunc } from "../../helper/heplerFunction.js";
import { displayPrice } from "../../../services/utils"

const props = defineProps({
    clickBtnIconClose: {
        type: Boolean,
    },
    productGroups: {
        type: Array,
        default: []
    },
    units: {
        type: Array,
        default: []
    },
    productItem: {
        type: Object,
        default: {}
    },
    isModalUpdate: {
        type: Boolean,
        default: false
    },
    imageDefault: {
        type: String
    }
})
const vnd = ref("VNĐ");
const errors = ref([]);
const emit = defineEmits(['updateProduct', 'storeProduct', 'resetclickBtnIconClose']);
let formProduct = reactive({
    code: "",
    name: "",
    product_group_id: null,
    unit_id: null,
    price: null,
    edit_price: true,
    image_link: null,
    note: "",
    status: 1
})
const productId = ref(0);
const tax = reactive({
    type: null,
    rate: null
})
const fee = reactive({
    type: null,
    rate: null
})
const { productItem } = toRefs(props);

const filterProductGroup = (id) => {
    let productGroup = props.productGroups.find((item) => (item.id == id));
    tax.type = productGroup?.tax_fee_rate?.type
    tax.rate = productGroup?.tax_fee_rate?.rate

    fee.type = productGroup?.fee?.type
    fee.rate = productGroup?.fee?.rate
}
const resetData=(product = {}) => {
    if(product.hasOwnProperty('code') ==false) {
        formProduct.code = ""
        formProduct.name = ""
        formProduct.product_group_id = null
        formProduct.note = ""
        formProduct.status = 1
        formProduct.price = null
        formProduct.unit_id = null
        formProduct.image_link = null
          formProduct.edit_price = true
    }else {
        formProduct.code = product.code
        formProduct.name = product.name
        formProduct.product_group_id = product.product_group_id
        formProduct.note = product.note
        formProduct.status = product.status
        formProduct.price = displayPrice(product.price)
        formProduct.unit_id = product.unit_id
        formProduct.edit_price = product.edit_price;
        filterProductGroup(product.product_group_id)
        formProduct.image_link = product.image_link
         tax.type = productItem.value?.product_group?.data.tax.data?.type
         tax.rate =  productItem.value?.product_group?.data.tax.data?.rate
        fee.type = productItem.value?.product_group?.data.fee.data?.type
        fee.rate =  productItem.value?.product_group?.data.fee.data?.rate
    }
}

const readURL = (event, haveFile = true) => {
        if(haveFile) {
            let files = event.target.files[0];
            if (files) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.image-upload-wrap').hide();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();

                    $('.image-title').html(files.name);
                };

                reader.readAsDataURL(files);
                formProduct.image_link = files
                return;
            }
        }
        if(!haveFile) {
            $('.file-upload-image').attr('src', imageDefaultForm);
        }
    }
const { clickBtnIconClose, isModalUpdate } = toRefs(props)
watch(clickBtnIconClose, (newValue) => {
      if(newValue) {
        closeModalProduct(false);
        emit('resetclickBtnIconClose', false)
    }
})

watch(isModalUpdate, (newValue) => {
      if(newValue == false) {
        readURL(null, false)
    }
})
const closeModalProduct=() => {
    errors.value = [];

    if(!isModalUpdate.value) {
        $('.file-upload-image').attr('src', imageDefaultForm)
    var form = document.getElementById("form-product");
     if(form) {
        // var edit_price = document.getElementById('edit_price').checked;
         form.reset();
        // document.getElementById('edit_price').checked = edit_price; // Khôi phục giá trị
     }
       resetData();
       return ;
    }else {
        console.log('edit', isModalUpdate, formProduct.image_link);
        // readURL(null, false)
        resetData(props.productItem);
    }
}

if(clickBtnIconClose) {
    closeModalProduct(false);
    emit('resetclickBtnIconClose', false)
}

watch(productItem, (newValue) => {
    let product = newValue;
    resetData(product);
    productId.value = product.id;
    console.log(newValue)
    tax.type = newValue.product_group.data.tax.data?.type
    tax.rate =  newValue.product_group.data.tax.data?.rate

    fee.type = newValue.product_group.data.fee.data?.type
    fee.rate =  newValue.product_group.data.fee.data?.rate
})

const changeProductGroup=(event) => {
    if(event.target.value == null) {
        tax.type = null;
        tax.rate = null;
    }
     tax.type = event.target.options[event.target.options.selectedIndex].getAttribute('tax-type');
     tax.rate = event.target.options[event.target.options.selectedIndex].getAttribute('tax-rate');

    fee.type = event.target.options[event.target.options.selectedIndex].getAttribute('fee-type');
    fee.rate = event.target.options[event.target.options.selectedIndex].getAttribute('fee-rate');
}

const storeProduct = () => {
    KTApp.showPageLoading();
    let formProductCopy = {...formProduct};
    console.log(formProduct)
    if(formProduct.price && formProduct.price.length > 0) {
      formProductCopy.price = formProduct.price.replaceAll(".", "");
    }
    axios
        .post("/products/store", formProductCopy, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then((res) => {
            const { message } = res.data;
            errors.value = [];
            resetData();
            useToast.successToast(message);
            const btnClose = document.getElementById('close-modal-product');
            btnClose.click();
            emit("storeProduct");
        })
        .catch((error) => {
            errors.value = error.response.data?.errors;
        }).finally(() => {
             KTApp.hidePageLoading();
        });
};
const updateProduct =()=> {
    if(typeof formProduct.image_link == 'string') {
        formProduct.image_link = null;
    }
    let formProductCopy = {...formProduct};
      if(formProduct.price && formProduct.price.length > 0) {
      formProductCopy.price = formProduct.price.replaceAll(".", "");
    }
    KTApp.showPageLoading();
    axios
        .post(`/products/update/${productId.value}`,formProductCopy,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then((res) => {
            const { message } = res.data;
            useToast.successToast(message);
            // const btnClose = document.getElementById('close-modal-product');
            // btnClose.click();
            errors.value = [];
            emit("updateProduct");
        })
        .catch((error) => {
            errors.value = error.response.data?.errors;
        }).finally(() => {
             KTApp.hidePageLoading();
        });
}

const setFortmatNumber =(event) => {
    let priceRoot = event.target.value.replaceAll(".", '');
    let price = event.target.value.replace(/,/g, '');
    if(isNaN(priceRoot)) {
        formProduct.price = 0;
        return ;
    }
     formProduct.price = displayPrice(price.replaceAll(".", ""))
    // formProduct.price = priceNew.replace(/,/g, '.');
}


</script>
<style scoped>
.input-custom-valid {
    border: 1px solid red !important;
}
.select-custom-valid {
    border: 1px solid red !important;
}
.file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        outline: none;
        width: 290px;
        height: 195px;
        opacity: 0;
        cursor: pointer;
    }
    .drag-text h3 {
        font-weight: 100;
        text-transform: uppercase;
        color: #15824B;
        padding: 60px 0;
    }
</style>
