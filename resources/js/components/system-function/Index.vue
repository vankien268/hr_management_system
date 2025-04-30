<template>
    <div class="col-xxl-7 col-xl-7">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch pt-5">
            <!--begin::Header-->

            <div class="d-flex align-items-center justify-content-between flex-wrap mx-7">
                <div class="d-flex align-items-center flex-wrap">
                    <h4 class="text-primary">NHÓM QUYỀN: {{ roleName }}</h4>
                </div>
                <div class="align-items-center">
                    <button class="btn btn-function btn-sm me-2" @click="goBack()">
                        <i class="fa-solid fa-arrow-left"></i>Quay lại</button>
                    <button class="btn btn-function me-2" @click="clickUpdate()">
                        <i class="fa-solid fa-floppy-disk"></i>Lưu</button>
                </div>
            </div>

            <div class="card-body py-3">
                <!--begin::Table container-->
                <div class="table-responsive table-scroll h-80vh text-nowrap pe-3">
                    <!--begin::Table-->
                    <table class="table table-row-dashed table-bordered table-sm table-data" cellspacing="0" cellpadding="0"
                        border="0" width="325" id="tableid">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fs-6 text-gray-400">
                                <th class="w-auto">Danh sách chức năng</th>
                                <th class="w-75px text-center">Quyền</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="">
                            <tr v-for="(item, index) in functions" :key="index">
                                <td class="position-relative"><span v-html="item.space"></span><span class="code-icon"
                                        v-if="item.id != 1"></span> <span class="ms-3 fs-5"><span
                                            class='material-symbols-outlined fs-3 me-1'>add_box</span>{{ item.name }}</span>
                                </td>
                                <td class="w-50px text-center"> <input class="form-check-input fs-2" type="checkbox"
                                        :value="item.id" :id="item.id" @click="toggleFunction"
                                        :checked="listSelect.indexOf(item.id) != -1" /></td>
                            </tr>
                            <tr v-if="functions.lenth == 0">
                                <td class="text-center" colspan="12">
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
        <!--end::Tables Widget 9-->
    </div>
</template>
<script setup>
import {
    defineProps,
    ref,
    computed,
    watch,
    onBeforeMount,
} from "vue";
import { useSystemFunction } from "../../stores/role";
import { update } from "../../helper/axiosConfig";
import moment from "moment";
import { useToast } from '../../helper/toastMessage';
import { sweetAlertMessage } from '../../helper/sweetAlert'

const systemFunctionStore = useSystemFunction();

const props = defineProps({

});

const listSelect = ref([]);
const roleName = ref('');
const roleId = ref(-1);

const functions = computed(() => {
    return systemFunctionStore.$state.functions.data.map(x => {
        let space = '&ensp;';
        for (let n = 0; n < x.depth; n++) {
            space += "&ensp;&ensp;&ensp;&ensp;"
        }
        x.space = space;
        // x.name = "<span class='fs-5'>" + space + "<span class='material-symbols-outlined fs-4'>add_box</span>" + x.name + "</span>";
        // x.name = "<span class='fs-5'>" + space + "<span class='material-symbols-outlined fs-4'>add_box</span>" + x.name + "</span>";
        return x;
    });
});
const getListRole = () => {
    listSelect.value = systemFunctionStore.$state.functions.list_role ?? [];
    roleName.value = systemFunctionStore.$state.functions.role_name ?? ''
}

const goBack = () => {
    console.log(window.history);
    if(window.history.length > 2 )
        window.history.go(-1);
}

watch(() => functions.value, getListRole);

const checker = (arr, target) => target.every(v => arr.includes(v));

const toggleFunction = (evt) => {
    console.log(evt.target.value);
    const func = functions.value.find(e => e.id == evt.target.value);
    if (func) {
        if (evt.target.checked == true) {
            var c = listSelect.value.concat([...func.descendants,...func.related_array_id, parseInt(evt.target.value)]);
            if (func.parent_id != null) {
                const funcParent = functions.value.find(e => e.id == func.parent_id);
                if (funcParent) {
                    if (checker(c, funcParent.childrents) == true) {
                         c.push(func.parent_id);
                    }
                }
            }
            listSelect.value = c.filter((item, pos) => c.indexOf(item) === pos);

        }
        if (evt.target.checked == false) {
            const parentId = listSelect.value.indexOf(func.parent_id);
            console.log(func);
            if (parentId > -1) {
                listSelect.value.splice(parentId, 1);
            }
            const cur = listSelect.value.indexOf(parseInt(evt.target.value));
            console.log(cur);
            if (cur > -1) {
                listSelect.value.splice(cur, 1);
            }
            if (func.descendants.length > 0) {
                func.descendants.forEach(x => {
                    const index = listSelect.value.indexOf(x);
                    if (index > -1) { // only splice array when item is found
                        listSelect.value.splice(index, 1); // 2nd parameter means remove one item only
                    }
                });
            }
            if (func.blocked_array_id.length > 0) {
                func.blocked_array_id.forEach(x => {
                    const index = listSelect.value.indexOf(x);
                    if (index > -1) { // only splice array when item is found
                        listSelect.value.splice(index, 1); // 2nd parameter means remove one item only
                    }
                });
            }
        }
    }
}

const clickUpdate = () => {
    update('/system-functions/api/' + roleId.value, { list_role: listSelect.value })
        .then(res => {
            getData(roleId.value);
            getListRole();
            useToast.successToast("Cập nhật thành công!");
        }).catch(err => {
            console.log(err);
            useToast.errorToast("Có lỗi xảy ra!");
        })
}

const getData = (roleId = roleId.value) => {
    systemFunctionStore.getData(roleId);
};

onBeforeMount(() => {
    const urlParams = new URLSearchParams(window.location.search);
    roleId.value = urlParams.get('role_id')
    getData(roleId.value);
});
</script>
<style lang="scss" scoped>
.code-icon {
    position: absolute;
    border-left: 1px solid #757171;
    border-bottom: 1px solid #757171;
    min-width: 15px !important;
    min-height: 15px !important;
    top: 0;
    z-index: 100;
}

.form-check-input {
    // --bs-form-check-bg: transparent;
    width: 18px;
    height: 18px;
    margin-top: -0.125rem;
    vertical-align: top;
    border: 1px solid var(--bs-gray-300);
    appearance: none;
    border-radius: 4px;
}
</style>
