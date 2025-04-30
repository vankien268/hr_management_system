export const filterCodeInput = (evt) => {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode >= 48 && charCode <= 57) || (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122)) {
        // console.log(charCode);
        return true;
    }
    evt.preventDefault();
}

export const filterNumberInput = (evt) => {
    // Kiểm tra tham số có evt là 1 đối tượng sự kiện liên quan tới sự kiện nhấn phím(keypress event)
    // Nếu không tồn tại sẽ gán evt = window.event Là thuộc tính của ddtuong window chứa sự kiện hiện tại.
    evt = (evt) ? evt : window.event;
    // Gán biến charcode = mã ký tự của phím đc nhấn. nếu tồn tại evt.which nó sẽ trả về mã ký tự. Nếu không trả về evt.keyCode ttinh khác của đt chứa mã ký tự.
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    // charCode in (48->57) là mã ký tự tương ứng số 0-9, ngoài phạm vi này gọi pthuc evt.preventDefault để ngăn chặn sự kiện nhấn phón và k cho hiển thị ký tự đó nên màn hình
    // trong phạm vi sẽ trả về true cho phép nhấn tiếp tục
    if (charCode < 48 || charCode > 57) {
        evt.preventDefault();;
    } else {
        return true;
    }
}

export const filterInputOnlyAZ = (evt) => {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 32 || (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122)) {
        // console.log(charCode);
        return true;
    }
    evt.preventDefault();
}

export const filterCodeInputNumber = (evt) => {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    // tạo lớp ký tự [0-9a-zA-Z_/-]
    let regex = /^[0-9a-zA-Z_/-]+$/;
    // kiểm tra xem mã ký tự có bằng 32 (dấu cách) hoặc khớp với biểu thức chính quy hay không
    if (regex.test(String.fromCharCode(charCode))) {
        return true;
    }
    evt.preventDefault();
}
