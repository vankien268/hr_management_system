<template>
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="d-flex flex-column align-items-center text-center"
                            >
                                <div
                                    class="col-lg-1 image-upload"
                                    style="
                                        width: 180px;
                                        cursor: pointer;

                                    "
                                >
                                    <input
                                        class="file-upload-input"
                                        title="chọn ảnh đại diện sản phẩm"
                                        type="file"
                                        name="image_link"
                                        @change="readURL($event)"
                                        accept="image/*"
                                        style="
                                            width: 180px;
                                            height: 180px;
                                        "
                                    />
                                    <img
                                        alt=""
                                        class="file-upload-image"
                                        :src="formProfile.avatarPathString? '../storage/'+formProfile.avatarPathString : imageDefaultForm"
                                        :style="errors.avatar ? 'border:1px solid red' :''"
                                        style="
                                            width: 100%;
                                            height: 180px;
                                            border-radius:90px;
                                        "
                                    />
                                </div>
                                  <div v-if="errors.avatar" class="text-danger pt-2">{{
                                    errors.avatar[0]
                                }}</div>
                                <div class="mt-3">
                                    <h4>{{ props.user.name }}</h4>
                                    <p class="text-muted font-size-sm mt-1">
                                        {{ props.user.username }}
                                    </p>
                                </div>
                            </div>
                            <hr class="my-5" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3 ">
                                    <h6 class="mb-0 required">Tên người dùng</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="formProfile.name"  :class="{'input-custom-valid': errors.name}"
                                    />
                                     <div v-if="errors.name" class="text-danger pt-2">{{
                                    errors.name[0]
                                }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0 required">Ngày sinh</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                        type="date"
                                        class="form-control"
                                        v-model="formProfile.birthday"
                                        :class="{'input-custom-valid': errors.birthday}"
                                    />
                                      <div v-if="errors.birthday" class="text-danger pt-2">{{
                                    errors.birthday[0]
                                }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0 required">Giới tính</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <div class="d-flex col-lg-6">
                                        <div
                                            class="col-lg-6 form-check form-check-custom form-check-solid me-2"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="customerType"
                                                :value="1"
                                                id="vip"
                                                v-model="formProfile.gender"
                                            />

                                            <label
                                                class="form-check-label"
                                                for="vip"
                                            >
                                                Nam
                                            </label>
                                        </div>
                                        <div
                                            class="col-lg-6 form-check form-check-custom form-check-solid ms-2"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="customerType"
                                                :value="2"
                                                id="normal"
                                                v-model="formProfile.gender"
                                            />
                                            <label
                                                class="form-check-label"
                                                for="normal"
                                            >
                                                Nữ
                                            </label>
                                        </div>
                                        <input
                                            type="date"
                                            class="form-control invisible"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0 required">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="formProfile.email"
                                         :class="{'input-custom-valid': errors.email}"
                                    />
                                      <div v-if="errors.email" class="text-danger pt-2">{{
                                    errors.email[0]
                                }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0 required">Điên thoại</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="formProfile.phone"
                                          :class="{'input-custom-valid': errors.phone}"
                                    />
                                      <div v-if="errors.phone" class="text-danger pt-2">{{
                                    errors.phone[0]
                                }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0 ">Skype</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="formProfile.skype"
                                          :class="{'input-custom-valid': errors.skype}"
                                    />
                                      <div v-if="errors.skype" class="text-danger pt-2">{{
                                    errors.skype[0]
                                }}</div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="w-auto text-secondary">
                                    <input
                                        type="button"
                                        class="btn btn-primary btn-sm"
                                        value="Lưu" @click="saveProfile"
                                    />
                                </div>
                            </div>
                        </div>
                        <!-- {{ props.user }} -->
                    </div>
                </div>
            </div>
        </div>
</template>
<script setup>
import imageDefaultForm from "../../default-image/avatar-default.png";
import { reactive, ref } from "vue";
import { useToast } from "../../helper/toastMessage.js";
const props = defineProps({
    user: {
        type: Object,
        default: null,
    },
});

const phone = ref(props.user.phone);
const email = ref(props.user.email);
const skype = ref(props.user.skype);
const avatar = ref(props.user.avatar);
const formProfile = reactive({
    name: props.user.name,
    phone: phone,
    email: email,
    skype:skype,
    birthday: props.user.birthday,
    gender: props.user.gender,
    avatar: null,
    avatarPathString: avatar
})
const readURL = (event, haveFile = true) => {
    if (haveFile) {
        let files = event.target.files[0];
        if (files) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(".image-upload-wrap").hide();

                $(".file-upload-image").attr("src", e.target.result);
                $(".file-upload-content").show();

                $(".image-title").html(files.name);
            };

            reader.readAsDataURL(files);
            formProfile.avatar = files;
            return;
        }
    }
    if (!haveFile) {
        $('.file-upload-image').attr('src', imageDefaultForm);
    }
};
const errors = ref([]);
const saveProfile = () => {
    //  if(typeof formProfile.avatar == 'string') {
    //     formProfile.avatar = null;
    // }
     KTApp.showPageLoading();
    axios
        .post(`/users/store-profile`,formProfile,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then((res) => {
            const { message } = res.data;
            useToast.successToast(message);
            errors.value = [];
            window.location.reload();
        })
        .catch((error) => {
            errors.value = error.response.data?.errors;
            useToast.errorToast('Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.')
        }).finally(() => {
             KTApp.hidePageLoading();
        });
}
</script>
<style scoped>
body {
    background: #f7f7ff;
    margin-top: 20px;
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid transparent;
    border-radius: 0.25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%),
        0 2px 6px 0 rgb(206 206 238 / 54%);
}

.me-2 {
    margin-right: 0.5rem !important;
}
.file-upload-input {
    position: absolute;
    outline: none;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}
.drag-text h3 {
    font-weight: 100;
    text-transform: uppercase;
    color: #15824b;
    padding: 60px 0;
}
.input-custom-valid {
    border: 1px solid red !important;
}
.select-custom-valid {
    border: 1px solid red !important;
}
</style>
