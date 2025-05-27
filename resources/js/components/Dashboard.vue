<template>


    <div class="card">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Tổng quan nhân sự</span>
            </h3>

            <div class="card-toolbar">
                <!--begin::Menu-->
                <div class="align-items-right">
                    <select v-model="type" @change="selectMonth($event.target.value)" class="form-select" data-placeholder="" aria-label="Default select example">
                        <option value="thisMonth">Tháng này</option>
                        <option value="lastMonth">Tháng trước</option>
                        <option value="thisYear">Năm nay</option>
                        <option value="lastYear">Năm trước</option>
                    </select>
                </div>
                <!--begin::Menu 2-->
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3 text-nowrap">
            <!--begin::Table container-->
            <!--end::Table container-->
            <div class="row col-lg-12 ms-3">
                <div><b>1. Biểu đồ thống kê nhân viên theo tháng, năm</b> </div>
                <Bar :data="chartData" :options="chartOptions" />
                </div>
            <div class="row col-lg-12 ms-3" style="margin-top: 50px;">
                <div><b>2. Biểu đồ thống nhân viên phòng ban theo tháng, năm</b> </div>
                <Bar :data="chartDataDepartments" :options="chartOptions" />
            </div>

        </div>
        <!--begin::Body-->
    </div>
</template>
<script setup>
import { onMounted, ref } from 'vue'

const props = defineProps({
    user: {
        type: Object,
        default: null,
    }
})
import { Bar } from 'vue-chartjs'
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js'
import axios from 'axios'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const chartData = ref({
    labels: [],
    datasets: [
        {
            label: 'Số lượng nhân viên',
            data: [],
            backgroundColor: '#4CAF50',
        },
    ],
})

const type = ref('thisMonth')

const getTitle = (type) => {
    switch (type) {
        case 'thisMonth':
            return 'Thống kê nhân viên theo tháng này'
        case 'lastMonth':
            return 'Thống kê nhân viên theo tháng trước'
        case 'thisYear':
            return 'Thống kê nhân viên theo năm nay'
        case 'lastYear':
            return 'Thống kê nhân viên theo năm trước'
        default:
            return 'Thống kê nhân viên'
    }
}

const chartOptions = ref({
    responsive: true,
    plugins: {
        legend: { position: 'top' },
        title: { display: true, text: `${getTitle(type.value)}` },
    },
})

const fetchChartData = async (value = 'thisMonth') => {
    try {
        const res = await axios.get('/user-statistics', {
            params: { filter:  value},
        });

        chartData.value = {
            labels: res.data.labels,
            datasets: [
                {
                    label: 'Số lượng nhân viên',
                    data: res.data.datasets[0].data,
                    backgroundColor: '#4CAF50',
                },
            ],
        }

       chartOptions.value ={
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: `${getTitle(type.value)}` },
            },
        }


    } catch (error) {
        console.error('Lỗi khi lấy dữ liệu biểu đồ:', error)
    }
}


const chartDataDepartments = ref({
    labels: [],
    datasets: [
        {
            label: 'Số lượng nhân viên',
            data: [],
            backgroundColor: '#4CAF50',
        },
    ],
})

const fetchChartDataUserDepartment = async (value = 'thisMonth') => {
    const res = await axios.get('/user-by-department-statistics', {
        params: { filter: value }
    });

    chartDataDepartments.value = {
        labels: res.data.labels,
        datasets: [
            {
                label: 'Số lượng nhân viên',
                data: res.data.datasets[0].data,
                backgroundColor: '#4CAF50',
            },
        ],
    }
}

const selectMonth = (value) => {
    console.log(value)
    type.value = value;
    fetchChartData(value )
    fetchChartDataUserDepartment(value)
}

onMounted(() => {
    fetchChartData();
    fetchChartDataUserDepartment()
})


</script>

<style lang="scss" scoped></style>
