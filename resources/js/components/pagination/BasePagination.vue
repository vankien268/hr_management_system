<template>
    <div class="w-100 d-flex justify-content-between col-lg-12 mt-3 mb-1" v-if="props.pagination.total > 0">
        <div class="row align-items-center min-w-450px w-auto d-none d-xl-flex">
            <div class="d-flex w-auto">
                <label for="currenPage" class="col-form-label">SL hiển thị</label>
            </div>
            <div class="d-flex w-auto p-0">
                <select class="form-select pe-10" data-placeholder="Select an option" v-model="perPage">
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="150">150</option>
                </select>
            </div>
            <div class="d-flex w-275px">
                <label for="currenPage" class="col-form-label">Hiển thị {{ (pagination.current_page - 1) *
                    (pagination.per_page) + 1 }} - {{ (pagination.current_page - 1) * (pagination.per_page) +
        pagination.count }} / {{ props.pagination.total }} bản ghi.</label>
            </div>
        </div>
        <ul class="pagination pagination-outline min-w-450px align-items-center">
            <li class="page-item previous" v-if="props.pagination.current_page != 1"
                @click.prevent="changePage(props.pagination.current_page -= 1)">
                <a href="#" class="page-link"><i class="previous"></i></a>
            </li>
            <li class="page-item" v-for="(page, index) in pageView(props.pagination.total_pages)" :key="index"
                :class="{ 'active': page == props.pagination.current_page, 'disable': typeof (page) == 'string' }"
                @click.prevent="changePage(page)">
                <a href="#" class="page-link">{{ page }}</a>
            </li>
            <li class="page-item next" v-if="props.pagination.current_page != props.pagination.total_pages"
                @click.prevent="changePage(props.pagination.current_page += 1)">
                <a href="#" class="page-link"><i class="next"></i></a>
            </li>
        </ul>
        <div class="row g-3 align-items-center min-w-150px d-none d-sm-flex">
            <div class="d-flex w-auto">
                <label for="toPage" class="col-form-label">Tới trang</label>
            </div>
            <div class="d-flex w-50px p-0">
                <input type="text" class="form-control pe-5" @keypress="filter($event)" v-model="currentPage" />
            </div>
        </div>
    </div>
</template>
<script setup>
import { watch, ref, toRefs } from "vue";
import debounce from 'lodash.debounce'

const props = defineProps({
    pagination: {
        type: Object,
        default: { current_page: 1, total_pages: 1, per_page: 30, total: 0 },
    },
});

const perPage = ref(props.pagination.per_page);
const currentPage = ref('');

const emits = defineEmits(["change-page"]);

const changePage = (page) => {
    if (page < 1) {
        return;
    }
    if (page > props.pagination.total_pages) {
        return;
    }
    props.pagination.current_page = page;
    emits("change-page", props.pagination);
};

watch(perPage, (newValue, oldValue) => {
    props.pagination.per_page = newValue;
    props.pagination.current_page = 1;
    emits("change-page", props.pagination);
})

watch(currentPage, debounce((newValue, oldValue) => {
    if (newValue > props.pagination.total_pages) {
        currentPage.value = oldValue;
    }
    else if (oldValue < props.pagination.total_pages) {
        props.pagination.current_page = newValue;
        emits("change-page", props.pagination);
    }
}, 500))

const pageView = (totalPages, delta = 1) => {
    const truncate = true;
    const curPage = parseInt(props.pagination.current_page);

    const range = delta + 4; // use for handle visible number of links left side

    let render = [];
    let renderTwoSide = [];
    let dot = '...';
    let countTruncate = 0; // use for ellipsis - truncate left side or right side

    // use for truncate two side
    const numberTruncateLeft = curPage - delta;
    const numberTruncateRight = curPage + delta;

    for (let pos = 1; pos <= totalPages; pos++) {
        // truncate
        if (totalPages >= 2 * range - 1 && truncate) {
            if (numberTruncateLeft > 3 && numberTruncateRight < totalPages - 3 + 1) {
                // truncate 2 side
                if (pos >= numberTruncateLeft && pos <= numberTruncateRight) {
                    renderTwoSide.push(pos);
                }
            } else {
                // truncate left side or right side
                if (
                    (curPage < range && pos <= range) ||
                    (curPage > totalPages - range && pos >= totalPages - range + 1) ||
                    pos === totalPages ||
                    pos === 1
                ) {
                    render.push(pos);
                } else {
                    countTruncate++;
                    if (countTruncate === 1) render.push(dot);
                }
            }
        } else {
            // not truncate
            render.push(pos);
        }
    };
    if (renderTwoSide.length > 0) {
        return [1, dot, ...renderTwoSide, dot, totalPages];
    } else {
        return render;
    }
}

const filter = (evt) => {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 13 && currentPage.value != props.pagination.current_page) {
        changePage(currentPage.value);
    }
    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();;
    } else {
        return true;
    }
}

</script>
<style lang="scss" scoped>
.disable {
    pointer-events: none;
}

.page-link {
    border-color: #7e7e7e !important;
}

label {
    &.col-form-label {
        font-size: 12px;
    }
}

input {
    &.form-control {
        font-size: 12px;
    }
}

li {
    &.page-item {
        padding: 0 !important;
        a {
            &.page-link {
                font-size: 12px;
                width: 2rem !important;
                min-width: 2rem !important;
                height: 2rem !important;
                padding: 0 !important;
            }
        }
    }
}</style>
