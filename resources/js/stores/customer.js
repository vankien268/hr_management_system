import { defineStore } from "pinia";
import {getData} from "../helper/axiosConfig";
import moment from "moment";

export const useCustomerStore = defineStore("customer", {
    state: () => ({
        customers: {
            data: [],
            meta: null,
            code: 200,
            message: '',
        },
        customer: {
            id: 0,
            code: '',
            name: '',
            tax_code: '',
            address: '',
            city_id: '',
            district_id: '',
            ward_id: '',
            representative_name: '',
            representative_phone: '',
            status_id: '',
            bank_number: '',
            bank_id: '',
            note: '',
            customer_type: '',
        },
        loading: false,
        showModel: false,
    }),

    actions: {
        getData(page = 1, per_page = 30, search) {
            this.loading = true;
            getData("/customers/api", {
                page: page,
                per_page: per_page,
                ...search
            })
                .then((res) => {
                    console.log(res.data);
                    this.customers = res.data;
                })
                .catch((err) => {
                    console.log(err);
                }).finally(() => {
                    this.loading = false;
                })
        },
        pushData(value) {
            if (this.customers.data) {
                this.customers.data = [value].concat(this.customers.data);
            }
        },
        removeData(value) {
            if (this.customers.data) {
                const index = this.customers.data.findIndex((obj) => value.id === obj.id);
                this.customers.data.splice(index, 1);
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
    code: '',
    name: '',
    tax_code: '',
    address: '',
    city_id: '',
    district_id: '',
    ward_id: '',
    representative_name: '',
    representative_phone: '',
    representative_email: '',
    status_id: '',
    bank_username: '',
    bank_number: '',
    bank_id: '',
    note: '',
    customer_type: "0",
    created_at: moment().format('YYYY-MM-DD'),
};
