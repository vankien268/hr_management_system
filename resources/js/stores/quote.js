import { defineStore } from "pinia";
import { getData, destroy, update } from "../helper/axiosConfig";
import { sweetAlertMessage } from "../helper/sweetAlert";
import { useToast } from "../helper/toastMessage";

const url = (id = null) => {
    if (id === null) {
        return '/quotes/api';
    }
    return '/quotes/api/' + id;

};

export const useQuoteStore = defineStore("quotes", {
    state: () => ({
        quotes: {
            data: [],
            meta: null,
            code: 200,
            message: '',
        },
        errors: [],
        showModel: false,
        statuses: {
            data: []
        }
    }),

    actions: {
        getData(page = 1, per_page = 30, search) {
            getData(url(), {
                page: page,
                per_page: per_page,
                ...search,
            }).then((res) => {
                console.log(res.data);
                this.quotes = res.data;
                this.errors = [];
            })
                .catch((err) => {
                    this.errors = err.response.data.errors;
                });
        },
        pushData(value) {
            if (this.quotes.data) {
                this.quotes.data = [value].concat(this.quotes.data);
                console.log(this.statuses);
            }
        },
        updateData(value) {
            if (this.quotes.data) {
                const index = this.quotes.data.findIndex((obj) => value.id === obj.id);
                // this.quotes.data.splice(index, 1);
                this.quotes.data[index] = value;
                console.log(this.quotes);
            }
        },
        removeData(value) {
            if (this.quotes.data) {
                const index = this.quotes.data.findIndex((obj) => value.id === obj.id);
                this.quotes.data.splice(index, 1);
                console.log(this.quotes);
            }
        },

        deleteRow(id) {
            sweetAlertMessage
                .messageWarning("Bạn có chắc chắn muốn xóa không?")
                .then((res) => {
                    console.log(res);
                    if (res.isConfirmed == true) {
                        destroy(url(id))
                            .then((res) => {
                                console.log(res.data);
                                this.removeData(res.data.data);
                                useToast.successToast("Xóa bản ghi thành công!");
                            })
                            .catch((err) => {
                                console.log(err);
                                getData();
                            });
                    }
                })
                .catch((err) => { });
        },

        toggleShowModal(state = null) {
            if (state === null) {
                this.showModel = !this.showModel;
            } else {
                this.showModel = state;
            }
        },
        getListStatus(status = 0) {
            getData(url('get_list_status'), {
                status: status,
                not_loading: true,
            }).then((res) => {
                console.log(res.data);
                this.statuses = res.data;
            })
                .catch((err) => {
                    console.log(err);
                });
        },

        changeStatus(id, status) {
            update(url('approve/' + id), {
                status: status,
                // not_loading: true,
            }).then((res) => {
                console.log(res.data);
                this.updateData(res.data.data)
                useToast.successToast("Đổi trạng thái thành công!");
                return true;
            })
                .catch((err) => {
                    console.log(err);
                    return true;
                }).finally(() => {
                    return false;
                });
        },
    },
});
