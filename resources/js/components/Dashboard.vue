<template>
    <h1>Xin chào {{ props.user.name }}!</h1>
    <p style="margin: 20px 0;">Vui lòng sử dụng các chức năng trong menu bên trái để quản lý dự án.</p>
</template>
<script setup>
const props = defineProps({
    user: {
        type: Object,
        default: null,
    }
})
</script>

<style lang="scss" scoped></style>
