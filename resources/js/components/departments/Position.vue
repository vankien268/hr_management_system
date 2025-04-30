<template>
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4">Thêm / Sửa Phòng Ban</h2>

        <!-- Form Phòng Ban -->
        <div class="space-y-4">
            <div>
                <label class="block font-medium">Tên phòng ban <span class="text-red-500">*</span></label>
                <input v-model="form.department_name" type="text" class="form-input w-full" placeholder="VD: Phòng Kinh Doanh" />
            </div>

            <div>
                <label class="block font-medium">Mô tả</label>
                <textarea v-model="form.description" class="form-textarea w-full" rows="3" placeholder="Mô tả chức năng của phòng ban..."></textarea>
            </div>
        </div>

        <!-- Danh sách chức vụ -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-2">Chức vụ thuộc phòng ban</h3>

            <div v-for="(position, index) in form.positions" :key="index" class="flex items-center space-x-2 mb-2">
                <input
                    v-model="position.title"
                    type="text"
                    class="form-input w-full"
                    placeholder="Tên chức vụ"
                />
                <button
                    @click="removePosition(index)"
                    type="button"
                    class="text-red-500 hover:text-red-700"
                    title="Xoá chức vụ"
                >
                    🗑️
                </button>
            </div>

            <button @click="addPosition" type="button" class="mt-2 text-sm text-blue-600 hover:underline">
                ➕ Thêm chức vụ
            </button>
        </div>

        <!-- Nút lưu -->
        <div class="mt-6">
            <button @click="submitForm" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                💾 Lưu phòng ban
            </button>
        </div>
    </div>
</template>

<script setup>
    import { reactive } from 'vue'

    const form = reactive({
        department_name: '',
        description: '',
        positions: [
            { title: '' }
        ]
    })

    const addPosition = () => {
        form.positions.push({ title: '' })
    }

    const removePosition = (index) => {
        form.positions.splice(index, 1)
    }

    const submitForm = () => {
        // Bạn có thể gửi form bằng axios/fetch về backend Laravel
        console.log('Dữ liệu gửi đi:', form)
    }
</script>

<style scoped>
    .form-input,
    .form-textarea {
        @apply border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500;
    }
</style>
<?php
