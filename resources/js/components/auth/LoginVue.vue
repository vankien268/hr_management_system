<template>
    <div class="wrapper-custom bg-white">
        <div style="margin: auto" class="h4 text-muted text-center pt-2 text-title">
            PHẦN MỀM QUẢN LÝ DỰ ÁN
        </div>
        <div style="margin: auto" class="h4 text-muted text-center pt-2 text-title">
            NEWWAY PROJECTS MANAGEMENT
        </div>
        <form class="pt-3" @submit.prevent="loginAuth()">
            <div class="form-group py-1">
                <div class="input-field input-field-username">
                    <span class="far fa-user p-2"></span>
                    <input v-model="formLogin.username" type="text" placeholder="Tên tài khoản" class="" />
                </div>
            </div>

            <div class="w-50"></div>
            <span v-if="errors && errors.username" class="text-danger">{{ errors.username[0] }}
            </span>

            <div class="form-group py-1 mt-4">
                <div class="input-field">
                    <span class="fas fa-lock p-2"></span>
                    <input v-model="formLogin.password" :type="inputType" placeholder="Mật khẩu" class="" />
                    <span @click="toggleInputType" class="btn bg-white btn-eye text-muted">
                        <span v-if="inputType === 'password'" class="far fa-eye-slash"></span>
                        <span v-if="inputType === 'text'" class="far fa-eye"></span>
                    </span>
                </div>
            </div>

            <div class="w-100"></div>
            <span v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}
            </span>

            <div class="d-flex align-items-start mt-4 mb-2">
                <div class="remember">
                    <label for="remember" class="option text-muted text-note">
                        Ghi nhớ đăng nhập
                        <input type="checkbox" id="remember" name="remember" class="checkmark"
                            v-model="formLogin.remember" />
                        <!-- <span class="checkmark"></span> -->
                    </label>
                </div>
                <!-- <div class="ml-auto">
                    <a href="#" id="forgot">Forgot Password?</a>
                </div> -->
            </div>
            <button type="submit" class="btn btn-block text-center my-3 btn-login p-3">
                <span v-if="!loading">Đăng nhập</span>
                <div v-else>
                    <div class="spinner-grow text-primary spinner-grow-sm me-1" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="spinner-grow text-secondary spinner-grow-sm me-1" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="spinner-grow text-success spinner-grow-sm me-1" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="spinner-grow text-danger spinner-grow-sm me-1" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="spinner-grow text-warning spinner-grow-sm me-1" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </button>
            <div class="text-center pt-3 text-muted text-footed">
                Bản quyền thuộc về Công ty Cổ phần giải pháp công nghệ Newway
            </div>
            <div class="text-center pt-3 text-muted text-footed">
                Website: https://newwaypms.com/
            </div>
            <div class="text-center pt-3 text-muted text-footed">Tel: 1900.636116</div>
        </form>
    </div>
</template>
<script setup>
import { reactive, ref } from "vue";
import { useToast } from "../../helper/toastMessage";
import axios from "axios";

const inputType = ref("password");

const formLogin = reactive({
    username: "",
    password: "",
    remember: false,
});

const loading = ref(false);

const errors = ref([]);
const loginAuth = () => {
    // KTApp.showPageLoading();
    loading.value = true;
    axios
        .post("/check-login", formLogin)
        .then((res) => {
            useToast.successToast(res.data.message);
            console.log(res.data.user_info);
            window.location.href = "/dashboard";
            // setTimeout(() => {
            //     window.location.href = "/dashboard";
            // }, 1);
        })
        .catch((error) => {
            console.log(error);
            errors.value = error.response.data.errors;
            if (error.response.data.errors.message !== undefined) {
                useToast.errorToast(error.response.data.errors.message);
            }
        })
        .finally(() => {
            //  KTApp.hidePageLoading();
            loading.value = false;

        });
};

function toggleInputType() {
    inputType.value = inputType.value === "text" ? "password" : "text";
}


</script>
<style>
@import url("https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Poppins&display=swap");

* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

/* body{
    background-color: #eee;
    height: 100vh;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to top, #fff 10%, rgba(93, 42, 141, 0.4) 90%) no-repeat;
} */
.wrapper-custom {
    max-width: 490px;
    border-radius: 10px;
    margin: 100px auto;
    padding: 25px 40px;
    padding-left: 40px !important;
    /* box-shadow: 20px 20px 80px rgb(206, 206, 206); */
}

.h2 {
    font-family: "Kaushan Script", cursive;
    font-size: 3.5rem;
    font-weight: bold;
    color: #0049b0;
    font-style: italic;
}

.h4 {
    font-family: "Poppins", sans-serif;
}

.btn-login {
    background: #0049b0 !important;
}

.btn-login:hover {
    background: #0565ec !important;
}

.input-field {
    /* border: 1px solid #ddd; */
    border-radius: 5px;
    padding: 3px 5px;
    display: flex;
    align-items: center;
    cursor: pointer;
    border: 1px solid #0049b0;
    color: #0049b0;
}

.input-field-username {
    padding: 8px !important;
}

.input-field:hover {
    color: #0049b0;
    border: 1px solid #0049b0;
}

input {
    border: none;
    outline: none;
    box-shadow: none;
    width: 100%;
    padding: 0px 2px;
    font-family: "Poppins", sans-serif;
    font-size: 15px;
    font-weight: 500;
}

.fa-eye-slash.btn {
    border: none;
    outline: none;
    box-shadow: none;
}

a {
    text-decoration: none;
    color: #0049b0;
    font-weight: 700;
}

a:hover {
    text-decoration: none;
    color: #0049b0;
}

.option {
    position: relative;
    padding-left: 30px;
    cursor: pointer;
    font-size: 14px !important;
}

.option label.text-muted {
    display: block;
    cursor: pointer;
}

.text-note {
    padding-top: 2px;
    font-weight: 600;
    color: black;
    font-size: 14px !important;
}

.text-muted {
    color: gray !important;
}

.btn-eye {
    padding: 7px 10px !important;
}

.text-footed {
    font-size: 12px;
}

.option input {
    /* display: none; */
}

.checkmark {
    position: absolute;
    top: 0px;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    /* border-radius: 50%; */
    cursor: pointer;
}

.option input:checked~.checkmark:after {
    display: block;
}

.option .checkmark:after {
    content: "";
    width: 13px;
    height: 13px;
    display: block;
    background: #0049b0;
    position: absolute;
    top: 48%;
    left: 53%;
    border-radius: 50%;
    transform: translate(-50%, -50%) scale(0);
    transition: 300ms ease-in-out 0s;
}

.option input[type="radio"]:checked~.checkmark {
    background: #fff;
    transition: 300ms ease-in-out 0s;
    border: 1px solid #0049b0;
}

.option input[type="radio"]:checked~.checkmark:after {
    transform: translate(-50%, -50%) scale(1);
}

.btn.btn-block {
    border-radius: 20px;
    background-color: #0049b0;
    color: #fff;
}

.btn.btn-block:hover {
    background-color: #55268be0;
}

.text-title {
    color: #0c3c81 !important;
    font-size: 1.5rem;
}

@media (min-width: 1200px) {
    .wrapper-custom {
        margin: 160px auto;
    }
}

@media (min-width: 992px) {
    .wrapper-custom {
        margin: 100px auto;
    }
}

@media (max-width: 575px) {
    .wrapper-custom {
        margin: 10px;
    }
}

@media (max-width: 424px) {
    .wrapper-custom {
        padding: 30px 10px;
        margin: 5px;
    }

    .option {
        position: relative;
        padding-left: 22px;
    }

    .option label.text-muted {
        font-size: 0.95rem;
    }

    .checkmark {
        position: absolute;
        top: 2px;
    }

    .option .checkmark:after {
        top: 50%;
    }

    #forgot {
        font-size: 0.95rem;
    }
}
</style>
