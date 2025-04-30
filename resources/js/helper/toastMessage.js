export const useToast = {
    successToast(message) {
        return toastr.success(message, {
            position: 'top-right',
            duration: 2000,
            onclose: true,
            dismissible: true,
        })
    },
    warningToast: (message)=>{
        return toastr.warning(message, {
            position: 'top-right',
            duration: 2000,
            onclose: true,
            dismissible: true,
        });
    },
    errorToast: (message)=>{
        return toastr.error(message, {
            position: 'top-right',
            duration: 2000,
            onclose: true,
            dismissible: true,
        });
    }
}

export const msgOnline = (message) => {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toastr-bottom-left",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      };

    toastr.success(message);
}

export const msgOffline = (message) => {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toastr-bottom-left",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      };

    toastr.warning(message);
}


