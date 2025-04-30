<template>
    <tr>
        <td class="text-center" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-trigger="hover" :title="showError(props.errors)" v-if="props.errors.length > 0 "><i class="fa-sharp fa-solid fa-circle-exclamation text-danger fs-3"></i>
        </td>
        <td class="text-center" v-else>
            {{ index }}
        </td>
        <td class="max-w-100px">
            <SelectSearch :list-data="props.products" v-model="props.data.product_id" :key-display="['code', 'name']"
                :not-value="listProductSelected.filter(x => x !== props.data.product_id)" key-value="id" />
        </td>
        <td class="min-w-275px max-w-300px">
            <SelectSearch class="w-auto" :list-data="props.products" v-model="props.data.product_id"
                :key-display="['name', 'code']" :not-value="listProductSelected.filter(x => x !== props.data.product_id)"
                key-value="id" />
        </td>
        <td class="w-150px max-w-150px break-text" :title="props.data.product != null ? props.data.product.unit.data.name : ''">
            {{ props.data.product != null ? props.data.product.unit.data.name : '' }}
        </td>
        <td class="max-w-125px">
            <input type="text" class="form-control text-end" @keypress="filterNumberInput($event)"
                :disabled="props.data.edit_price == false" v-model="props.data.price" maxlength="12"/>
        </td>
        <td class="max-w-100px">
            <input type="text" class="form-control text-end" @keypress="filterNumberInput($event)" v-model="props.data.quantity" maxlength="3"/>
        </td>
        <td class="max-w-150px text-end">
            {{ displayPrice((props.data.price + '').replaceAll(".", "") * props.data.quantity)}}

        </td>
        <td class="w-50px">
            <a href="#" class="btn btn-icon btn-delete btn-sm" :class="{ 'disable': props.data.is_delete == false }"
                @click="deleteRow()">
                <i class="fa-solid fa-trash fs-4"></i>
            </a>
        </td>
    </tr>
</template>
<script setup>
import { ref, watch, onBeforeMount } from 'vue'
import SelectSearch from '../../components/input/SelectSearch.vue'
import { filterCodeInput, filterNumberInput } from '../../helper/filterInput'
import { displayPrice } from '../../../services/utils'

const props = defineProps({
    data: {
        type: Object,
        default: null,
    },
    products: {
        type: Array,
        default: [],
    },
    errors: {
        type: [Array, Object],
        default: [],
    },
    listProductSelected: {
        type: Array,
        default: [],
    },
    index: {
        type: [String, Number],
        default: 1,
    }
})

const emits = defineEmits(['delete-row']);

const deleteRow = () => {
    emits('delete-row');
}

const showError = (err) => {
    let msg = '';
    err.forEach(element => {
        msg += element + "\n";
    });
    return msg
}

watch(() => props.data.product_id, (newValue, oldValue) => {
    if (newValue != null) {
        const product = props.products.find(i => i.id == newValue);
        props.data.product = product;
        props.data.edit_price = product.edit_price;
        props.data.price = displayPrice(product.price);
    } else {
        props.data.product = null;
        props.data.edit_price = false;
        props.data.price = '';
        props.data.amount = '';
    }
})

watch(() => props.data.price, (newValue, oldValue) => {
    // if (newValue.length > 12) {
    //     props.data.price = oldValue;
    //     return;
    // }
    props.data.price = displayPrice((newValue + '').replaceAll(".", ""));
})
watch(() => props.data.quantity, (newValue, oldValue) => {
    if (isNaN(newValue) || newValue === '') {
        props.data.quantity = 1;
    } else {
        props.data.quantity = parseInt(newValue);
    }

})
onBeforeMount(() => {
    if (typeof (props.data.price) === 'string') {
        props.data.price = displayPrice(props.data.price.replaceAll(".", ""));
    } else {
        props.data.price = displayPrice(props.data.price);
    }
});
</script>
<style lang="">
</style>
