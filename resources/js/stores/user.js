import { defineStore } from "pinia";
import axios from "axios";

export const useUsers = defineStore('useUsers', {
    state: () => ({
        users: {
            data: [],
            meta: null
        },
        loading: false,
    }),

    getters: {
        getUserNotBlock() {
            return this.users.data.filter((item) => (item.status == 1))
        },
        getUserById:(state) => (userId) => {
            return state.users.data.find((item) => (item.id == userId));
        }
    },

    actions: {
        getUsersData(params) {
            this.loading = true;
            axios({
                'url': '/users/get-all',
                'method' : "GET",
                 params: params
            })
            .then(res => {
                this.users = res.data;
            }).catch((error) => {
                console.log(error);
            }).finally(() => {
                this.loading = false;
            })
        }
    }
});
