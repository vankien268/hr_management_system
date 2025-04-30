<template>
    <div v-click-outside="() => toggleShow(false)">
        <div class="box">
            <div class="select-box" :class="{ 'active': showList, 'disabled': props.disabled }">
                <div class="selected" :id="props.idElement" :class="{ 'focus': showList == true }">
                    <input text="text" v-model="searchData" :placeholder="props.placeholder" @focus="showList = true" />
                    <div class="btn btn-icon btn-sm btn-active-light-info btn-color-gray-700 ms-2 position-absolute end-0 top-10 w-20px h-20px"
                        aria-label="Close" v-if="searchData.length > 0" @click="setDataSelect(null)">
                        <i class="fa-solid fa-xmark fs-4"></i>
                    </div>
                </div>
                <div class="options-container" v-if="showList && searchData.length > 0"
                    :style="{ top: top + 'px', left: left + 'px', minWidth: (right - left) + 'px' }">
                    <div class="list d-flex overflow-hidden justify-content-center p-2" v-if="props.loading">
                        <div class="spinner-border text-primary  w-20px h-20px" role="status" >
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="list" v-else>
                        <div class="option"
                            v-for="(item, index) in listData.filter(item => props.notValue.includes(item[props.keyValue]) == false)"
                            :id="index" :key="index"
                            :class="{ 'active': dataSelect && item[props.keyValue] == dataSelect[props.keyValue] }"
                            @click="setDataSelect(item)">
                            <span v-if="typeof (props.keyDisplay) === 'string'">{{ item[props.keyDisplay] }}</span>
                            <span v-else>
                                <span v-for="(key, i) in props.keyDisplay" :key="i"> {{ item[key] }} <span
                                        v-if="i < props.keyDisplay.length - 1">&nbsp;{{ props.prefix }} &nbsp;</span>
                                </span>
                            </span>
                        </div>
                        <div class="option disabled" v-if="listData.length == 0">
                            Không có dữ liệu
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, watch, computed, onMounted } from 'vue';
import debounce from 'lodash.debounce'

const props = defineProps({
    setNullValue: {
        type: Boolean,
        default: false,
    },
    placeholder: {
        type: String,
        default: '',
    },
    keyValue: {
        type: String,
        default: 'id',
    },
    keyDisplay: {
        type: [String, Array],
        default: 'id',
    },
    keyShow: {
        type: String,
        default: '',
    },
    listData: {
        type: Array,
        default: function () {
            return []
        }
    },
    prefix: {
        type: String,
        default: '-'
    },
    modelValue: {
        type: [String, Number],
        default: 0
    },
    notValue: {
        type: Array,
        default: [],
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    idElement: {
        type: [String, Number],
        default: function () {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const charactersLength = characters.length;
            let counter = 0;
            while (counter < 24) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
                counter += 1;
            }
            return result;
        }
    },
    loading: {
        type: Boolean,
        default: false,
    }
})

const emits = defineEmits(['search-data', "update:modelValue"])

const dataSelect = ref(props.listData.find(x => x[props.keyValue] == props.modelValue));
const searchData = ref('');

const listData = computed(() => {
    return props.listData;
})

const showList = ref(false);

const top = ref(0);
const left = ref(0);
const right = ref(0);

const keyDisplay = () => {
    if (props.keyShow.length > 0) {
        return props.keyShow;
    }
    if (typeof (props.keyDisplay) === 'string') {
        return props.keyDisplay;
    }
    return props.keyDisplay[0];
}

watch(() => props.modelValue, (newValue, oldValue) => {
    // console.log(props.listData.find(x => x[props.keyValue] == newValue));
    dataSelect.value = props.listData.find(x => x[props.keyValue] == newValue)
});

watch(searchData, debounce((newValue, oldValue) => {
    console.log('search....');
    emits('search-data', newValue)
}, 800))

watch(dataSelect, (newValue, oldValue) => {
    // console.log(newValue[keyDisplay()]);
    searchData.value = newValue == null ? '' : newValue[keyDisplay()]
    emits("update:modelValue", newValue == null ? null : newValue[props.keyValue]);
})

const toggleShow = (state = null) => {
    if (state === null) {
        showList.value = !showList.value;
    }
    else {
        showList.value = state;
    }
    // position();
}

const setDataSelect = (data) => {
    console.log(data);
    showList.value = !showList.value;
    if (data != null) {
        dataSelect.value = data;
    } else {
        dataSelect.value = null;
    }
}

const position = () => {
    let elem = document.getElementById(props.idElement);
    if (elem) {
        let rect = elem.getBoundingClientRect();
        // console.log(rect);
        top.value = rect.top + 30;
        left.value = rect.left;
        right.value = rect.right;
        showList.value = false;
    }

}

onMounted(() => {
    var divs = document.getElementsByTagName("div");
    for (var i = 0; i < divs.length; i++) {
        //do something to each div like
        divs[i].addEventListener("scroll", position);
        new ResizeObserver(position).observe(divs[i])
    }
    position();

})

</script>
<style lang="scss" scoped>
.select-box {
    position: relative;
    width: auto;
    flex-direction: column;

    .options-container {
        position: fixed;
        top: 700px;
        left: 100px;
        background: rgb(255, 255, 255);
        width: max-content;
        max-width: 350px;
        opacity: 1;
        border-radius: 4px;
        overflow: hidden;
        box-sizing: content-box;
        order: 1;
        color: rgb(56, 52, 52);
        z-index: 100;
        border: 1px solid #ebebeb;
        box-shadow: 0px 10px 70px 4px rgba(0, 0, 0, 0.13);

        .list {
            max-height: 250px;
            overflow: auto;
        }
    }
}

.select-box .option {
    padding: 6px 8px;
    cursor: pointer;
    text-align: left;
}

.selected {
    display: flex;
    align-items: center;
    cursor: pointer;
    width: 100%;
    max-height: 28px;
    background-color: rgb(248, 248, 248);
    border: 0 solid var(--bs-gray-600);
    padding: 1px !important;
    border-radius: 0.475rem;
    margin-bottom: 1px;
    color: rgb(56, 52, 52);
    position: relative;
    order: 0;
    box-shadow: 0px 10px 70px 4px rgba(0, 0, 0, 0.13);

    .content {
        width: 100% !important;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 1;
        /* number of lines to show */
        line-clamp: 1;
        -webkit-box-orient: vertical;
    }

    &.focus {
        background-color: rgb(255, 255, 255);
    }

    input {
        width: 100%;
        font-size: 12px;
        padding: 3px 18px 3px 6px;
        border-radius: 0.275rem;
        border: 1px solid var(--bs-gray-400);
        color: var(--bs-gray-700);

        &:focus{
            border: 1px solid var(--bs-gray-600);
            color: var(--bs-gray-900);
        }
    }
}

.option {
    &.active {
        background: #2c44b0;
        border-radius: 3px;
        color: #ffffff;
    }

    &.disabled {
        background: #f0f0f0;
        pointer-events: none;
    }
}

.select-box .option:hover {
    background: #2c44b0;
    border-radius: 3px;
    color: #ffffff;
}

.search-box {
    width: 100%;
    padding: 6px;
}

.icon {
    position: absolute;
    right: 10px;
    top: 20%;
}

.active {
    .icon {
        transform: rotate(90deg);
        transition: all 0.1s;
    }
}

.box {
    .disabled {
        // background-color: #e7e3e3 !important;
        pointer-events: none;

        .selected {
            background-color: #e0e4ec !important;
        }
    }
}
</style>
