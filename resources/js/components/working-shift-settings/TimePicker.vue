<template>
    <div class="time-picker-container">
        <input
            type="text"
            v-model="displayValue"
            class="time-input"
            placeholder="HH:mm"
            @blur="validateTime"
            @keyup.enter="validateTime"
        >
    </div>
</template>

<script setup>
    import { ref, watch, computed } from 'vue';

    const props = defineProps({
        modelValue: {
            type: String,
            default: null
        }
    });

    const emit = defineEmits(['update:modelValue']);

    // Giá trị hiển thị (có thể là null)
    const displayValue = ref(props.modelValue);

    // Theo dõi thay đổi từ bên ngoài
    watch(() => props.modelValue, (newVal) => {
        displayValue.value = newVal;
    });

    // Validate khi mất focus hoặc nhấn Enter
    const validateTime = () => {
        if (!displayValue.value) {
            // Giữ nguyên null nếu trống
            emit('update:modelValue', null);
            return;
        }

        const timeRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;

        if (!timeRegex.test(displayValue.value)) {
            // Reset về 00:00 nếu nhập sai
            displayValue.value = '00:00';
            emit('update:modelValue', '00:00');
        } else {
            // Chuẩn hóa định dạng (thêm số 0 nếu cần)
            const [hours, minutes] = displayValue.value.split(':');
            const formattedTime = `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
            displayValue.value = formattedTime;
            emit('update:modelValue', formattedTime);
        }
    };
</script>

<style>
    .time-picker-container {
        display: inline-block;
    }

    .time-input {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 80px;
        text-align: center;
    }

    .time-input:focus {
        outline: none;
        border-color: #409eff;
        box-shadow: 0 0 0 2px rgba(64, 158, 255, 0.2);
    }

    .time-input::placeholder {
        color: #c0c4cc;
        opacity: 1;
    }
</style>
