import { defineStore } from "pinia";
import { getData, show} from "../helper/axiosConfig";

export const useProductGroupStore = defineStore("productGroups", {
    state: () => ({
        groups: {
            data: [],
            meta: null,
            code: 200,
            message: '',
        },
        errors: [],
    }),

    actions: {
        getData(search) {
            getData("/products/groups/api", {
                ...search,
            }).then((res) => {
                    console.log(res.data);
                    this.groups = res.data;
                    console.log(this.groups)
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        pushData(value) {
            if (this.groups.data) {
                this.groups.data = [value].concat(this.groups.data);
            }
        },
        removeData(value) {
            if (this.groups.data) {
                const index = this.groups.data.findIndex((obj) => value.id === obj.id);
                this.groups.data.splice(index, 1);
                console.log(this.groups);
            }
        },
    },
});
