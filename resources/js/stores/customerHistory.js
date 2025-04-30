import { defineStore } from "pinia";
import {getData} from "../helper/axiosConfig";
import moment from "moment";

export const useCustomerHistoryStore = defineStore("customerHistory", {
    state: () => ({
        customerHistories: {
            data: [],
            meta: null,
            code: 200,
            message: '',
        },
        customer: {
            id: 0,
            log_name: '',
            description: '',
            subject_type: '',
            event: '',
            subject_id: '',
            causer_type: '',
            causer_id: '',
            properties: '',
            batch_uuid: '',
        },
        loading: false,
        showModel: false,
    }),

    actions: {
        getData(page = 1, per_page = 30, search) {
            this.loading = true;
            getData("/customers/show", {
                page: page,
                per_page: per_page,
                ...search
            })
                .then((res) => {
                    console.log(res.data);
                    this.customerHistories = res.data;
                })
                .catch((err) => {
                    console.log(err);
                }).finally(() => {
                    this.loading = false;
                })
        },
        pushData(value) {
            if (this.customerHistories.data) {
                this.customerHistories.data = [value].concat(this.customerHistories.data);
            }
        },
        removeData(value) {
            if (this.customerHistories.data) {
                const index = this.customerHistories.data.findIndex((obj) => value.id === obj.id);
                this.customerHistories.data.splice(index, 1);
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

export const customer = {
    id: 0,
    log_name: '',
    description: '',
    subject_type: '',
    event: '',
    subject_id: '',
    causer_type: '',
    causer_id: '',
    properties: '',
    batch_uuid: '',
    updated_at: moment().format('YYYY-MM-DD'),
};
