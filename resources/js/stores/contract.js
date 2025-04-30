import { defineStore } from "pinia";
import { getData, show } from "../helper/axiosConfig";

export const useContracTypeStore = defineStore("contractType", {
    state: () => ({
        types: {
            data: [],
            meta: null,
            code: 200,
            message: '',
        },
        errors: [],
        loading: false,
        showModal: false,
    }),

    actions: {
        getContracTypeData(page = 1, per_page = 30, search) {
            this.loading = true;
            getData("/contracts/types/api", {
                page: page,
                per_page: per_page,
                ...search,
            }).then((res) => {
                console.log(res.data);
                this.types = res.data;
            })
                .catch((err) => {
                    console.log(err);
                }).finally(() => {
                    this.loading = false;
                });
        },
        pushData(value) {
            if (this.types.data) {
                this.types.data = [value].concat(this.types.data);
                console.log(this.statuses);
            }
        },
        removeData(value) {
            if (this.types.data) {
                const index = this.types.data.findIndex((obj) => value.id === obj.id);
                this.types.data.splice(index, 1);
                console.log(this.types);
            }
        },
        toggleShowModal(state = null) {
            if (state === null) {
                this.showModel = !this.showModel;
            } else {
                this.showModel = state;
            }
        }
    },
});

export const useContractStore = defineStore("contracts", {
    state: () => ({
        contracts: {
            data: [],
            meta: null,
            code: 200,
            message: '',
        },
        errors: [],
        showModal: false,
    }),

    actions: {
        getContractData(page = 1, per_page = 30, search) {
          return  getData("/contracts/api", {
                page: page,
                per_page: per_page,
                ...search,
            }).then((res) => {
                console.log(res.data);
                this.contracts = res.data;
                this.errors = [];
            })
                .catch((err) => {
                    console.log(err);
                    this.errors = err.response.data.errors;
                });
        },
        pushData(value) {
            if (this.contracts.data) {
                this.contracts.data = [value].concat(this.contracts.data);
                console.log(this.statuses);
            }
        },
        removeData(value) {
            if (this.contracts.data) {
                const index = this.contracts.data.findIndex((obj) => value.id === obj.id);
                this.contracts.data.splice(index, 1);
                console.log(this.contracts);
            }
        },
        toggleShowModal(state = null) {
            console.log(state);
            if (state === null) {
                this.showModal = !this.showModal;
            } else {
                this.showModal = state;
            }
        }
    },
});
