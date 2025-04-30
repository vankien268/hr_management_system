<template>
    <div class="fv-plugins-message-container invalid-feedback mt-1 mb-2" :class="{
        'h-0': props.message && props.message.length > 0 && props.message[0] == null,
    }">
        <!-- <div class="error-message" data-field="text_input" data-validator="notEmpty" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-trigger="hover" :data-bs-original-title="err == null ? '&nbsp;' : err"
            v-for="(err, index) in props.message" :key="index">
            {{ err == null ? '&nbsp;' : err }}
        </div> -->
        <div class="error-message" :title="err == null ? '&nbsp;' : err"
            v-for="(err, index) in props.message" :key="index">
            {{ err == null ? '&nbsp;' : err }}
        </div>

    </div>
</template>
<script setup>
import { defineProps, computed } from "vue";

const props = defineProps({
    message: {
        type: Array,
        default: function () { return [null] },
    },
    hide: {
        type: Boolean,
        default: false
    }
});

const msg = computed(() => {
    return props.message;
})

</script>
<style lang="scss" scoped>
.h-0 {
    height: 0 !important;
    visibility: hidden;
}
</style>
