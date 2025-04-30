import axios from "axios";
import { useToast } from './toastMessage';

const axiosDefaults = {}
const http = axios.create(axiosDefaults)
//register interceptor like this
http.interceptors.request.use(
    (response) => {
        // Do something before request is sent
        // console.log('send Data');
        // console.log('params', response.params);
        if (response.params && response.params.not_loading) {
            return response;
        }
        KTApp.showPageLoading();
        return response;
    },
    (error) => {
        // console.log('err Data');
        // KTApp.hidePageLoading();
        return Promise.reject(error);
    }
)

http.interceptors.response.use(response => {
    // console.log("success: ", response);
    KTApp.hidePageLoading();
    return response;
}, error => {
    console.log("error:", error);
    if (error.response.data.message) {
        useToast.errorToast(error.response.data.message);
        if (error.response.data.message === 'Unauthenticated.') {
            console.log('logout');
            window.location.href = "/login";
        }
    }
    KTApp.hidePageLoading();
    return Promise.reject(error);
});

export const getData = (url, params) => {
    // KTApp.showPageLoading();
    return http({
        url: url,
        method: "GET",
        params: params,
    });
}

export const create = (url, data) => {
    // KTApp.showPageLoading();
    return http({
        url: url,
        method: "POST",
        data: data,
    });
}

export const show = (url, params) => {
    // KTApp.showPageLoading();
    return http({
        url: url,
        method: "GET",
        params: params,
    });
}

export const update = (url, data) => {
    return http({
        url: url,
        method: "PUT",
        data: data,
    });
}

export const destroy = (url) => {
    // KTApp.showPageLoading();
    return http({
        url: url,
        method: "DELETE",
    });
}
