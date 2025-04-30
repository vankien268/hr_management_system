import { defineStore } from "pinia";
import { getData, destroy } from "../helper/axiosConfig";
import { sweetAlertMessage } from "../helper/sweetAlert";
import { useToast } from "../helper/toastMessage";

const url = (id = null) => {
    if (id === null) {
        return '/system-functions/api';
    }
    return '/system-functions/api/' + id;

};

export const useSystemFunction = defineStore("systemFunction", {
    state: () => ({
        functions: {
            data: [],
            meta: null,
            code: 200,
            message: '',
            list_role: [],
            role_name: '',
        },
        errors: [],
        showModel: false,
        statuses: {
            data: []
        }
    }),

    actions: {
        getData(roleId) {
            getData(url(), {
                role_id: roleId,
            }).then((res) => {
                console.log(res.data);
                this.functions = res.data;
                this.errors = [];
                })
                .catch((err) => {
                    this.errors = err.response.data.errors;
                    // window.location.href = "/404-page";
                    sweetAlertMessage.errorAlert(this.errors.id);
                });
        },
        pushData(value) {
            if (this.functions.data) {
                this.functions.data = [value].concat(this.functions.data);
            }
        },
    },
});
