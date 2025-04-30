import { defineStore } from "pinia";
import axios from "axios";

export const useDepartmentState = defineStore("departmentState", {
    state: () => ({
        departments: [],
    }),

    getters: {
        getParentDepartmentData:()=> this.departments.filter((item) => (item.parent_id === null)),
    },

    actions: {
        getAllDepartmentData(params = null) {
            axios.get("/departments/get-all", {params})
                .then((res) => {
                    const { getAllDepartment } = res.data;
                    this.departments = getAllDepartment;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        AddDepartment(item) {
           this.departments.unshift(item);
        },
        updateDepartment(item) {
            const index = this.departments.findIndex((obj) => obj.id === item.id);
            if(index !== -1) {
                this.departments[index] = item;
            }else {
                alert("Không tồn tại người dùng này !");
            }
        },
        removeDepartment(item) {
                const index = this.departments.findIndex((obj) => obj.id === item.id);
                if(index !== -1) {
                    this.departments.splice(index, 1)
                }else {
                    alert("Không tồn tại người dùng này !");
                }
        },
    },
});
