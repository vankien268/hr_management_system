import { defineStore } from "pinia";
import {getData} from "../helper/axiosConfig";

export const useSystemStatusStore = defineStore("systemStatus", {
    state: () => ({
        statuses: {
            data: [],
            meta: null,
            code: 200,
            message: '',
        },
        showModalCreate: false,
        showModalUpdate: false,
    }),
    getters: {
        getStatusesByProject() {
            return this.statuses.data.filter((item) => (item.type == 0 && item.status == 1))
        },
        getStatusesByTask() {
            return this.statuses.data.filter((item) => (item.type == 3 && item.status == 1))
        },
        getStatusesByDispatch() {
            return this.statuses.data.filter((item) => (item.type == 6 && item.status == 1))
        },
        getStatusesByAcceptance() {
            return this.statuses.data.filter((item) => (item.type == 4 && item.status == 1))
        },
        getStatusesByDeploymentRecords() {
            return this.statuses.data.filter((item) => (item.type == 5 && item.status == 1))
        },
        getStatusesByDeploymentSchedules() {
            return this.statuses.data.filter((item) => (item.type == 7 && item.status == 1))
        }
    },

    actions: {
        getSystemStatusData(type = null) {

            getData("/system-status/api", {
                type: type,
            })
                .then((res) => {
                    this.statuses = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
            //
        },
        getSystemStatusUsingData(type = null) {

            getData("/system-status/api", {
                type: type,
                using: true,
            })
                .then((res) => {
                    this.statuses = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
            //
        },
        pushData(values) {
            if (this.statuses.data) {
                this.statuses.data = values.concat(this.statuses.data);
                console.log(this.statuses);
            }
        },
        removeData(value) {
            if (this.statuses.data) {
                const index = this.statuses.data.findIndex((obj) => value.id === obj.id);
                this.statuses.data.splice(index, 1);
                console.log(this.statuses);
            }
        },
        toggleShowModalCreate(state = null) {
            if (state === null) {
                this.showModalCreate = !this.showModalCreate;
            } else {
                this.showModalCreate = state;
            }
        },
        toggleShowModalUpdate(state = null) {
            if (state === null) {
                this.showModalUpdate = !this.showModalUpdate;
            } else {
                this.showModalUpdate = state;
            }
        }
    },
});
