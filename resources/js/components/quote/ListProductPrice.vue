<template>
    <div class="row col-lg-12 ps-5 mb-5">
        <div class="card-header border-0 d-flex justify-content-between align-items-center">
            <span class="card-label fw-bold fs-4 m-0">Danh mục sản phẩm, dịch vụ</span>
            <div class="card-toolbar m-0" :class="{'invisible' : props.disabled}">
                <button type="button" href="#" class="btn btn-function"  @click="addDataRow()" v-if="props.action != 'view'">
                    <i class="ki-duotone ki-plus fs-2"></i>Thêm</button>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive table-scroll-sm text-nowrap">
                <table class="table table-row-dashed table-bordered table-sm table-data "
                    :class="{ 'disable': props.action == 'view', 'table-disabled' : props.disabled == true }">
                    <thead>
                        <tr class="fs-6 text-gray-400">
                            <th class="w-50px text-center">STT </th>
                            <th class="w-150px">Mã sản phẩm</th>
                            <th class="min-w-275px max-w-275px">
                                Tên sản phẩm
                            </th>
                            <th class="w-125px">
                                Đơn vị tính
                            </th>
                            <th class="w-150px">
                                Đơn giá
                            </th>
                            <th class="w-100px">
                                Số lượng
                            </th>
                            <th class="w-150px">Thành tiền</th>
                            <th class="w-50px text-center">Xóa</th>
                        </tr>
                    </thead>
                    <tbody class="overflow-auto cursor-pointer">
                        <ProductPriceItem v-for="(item, index) in props.details.data" :key="index" :data="item"
                            :index="index + 1" :products="props.products" :list-product-selected="listProducts"
                            @delete-row="deleteDataRow(index)" :errors="errors[index] ?? []">

                        </ProductPriceItem>
                    </tbody>
                    <tbody class="max-h-25 overflow-auto cursor-pointer" v-if="props.details.data.length == 0">
                        <tr>
                            <td class="text-center" colspan="8">Không có dữ liệu
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, watch, onBeforeMount } from 'vue'
import SelectSearch from '../../components/input/SelectSearch.vue'
import { filterCodeInput, filterNumberInput } from '../../helper/filterInput'
import { displayPrice } from '../../../services/utils'
import ProductPriceItem from './ProductPriceItem.vue'

const props = defineProps({
    details: {
        type: Object,
        default: {
            data: []
        },
    },
    products: {
        type: Array,
        default: [],
    },
    errors: {
        type: [Array, Object],
        default: [],
    },
    disabled: {
        type: Boolean,
        default: false,
    }
})

const listProducts = ref(props.products);

watch(() => props.errors, (newValue, oldValue) => {

})

watch(() => props.details.data, (newValue, oldValue) => {
    console.log('..change...');
    listProducts.value = newValue.map(x => x.product_id);
}, { deep: true });

const addDataRow = () => {
    props.details.data.push(
        {
            id: 0,
            quote_id: null,
            product_id: null,
            price: '',
            product: null,
            quantity: 1,
            amount: '',
            edit_price: false,
        }
    )
}

const deleteDataRow = (index) => {
    props.details.data.splice(index, 1);
}
onBeforeMount( async() => {

})
</script>
<style lang="scss" scoped>
.table {
    td {
        padding: 4px !important;
        background-color: #fff;
    }

    input {
        &.form-control:disabled {
            border: 0 !important;
            background-color: #fff;
        }
    }
}

.table-scroll-sm {
    min-height: 15vh;
    height: calc(100vh - 660px) !important;
}
</style>
