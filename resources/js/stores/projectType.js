import { defineStore } from "pinia";
import axios from "axios";

export const useProjectType = defineStore('projectType', {
    state() {
        return {
            projectTypes: {
                data: [],
                meta: null
            }
        }
    },
    getters: {
        getProjectTypeActive() {
            return this.projectTypes.data.filter(item =>  item.status == 1);
        }
    },
    actions: {

        getAllProjectType(params = null) {
            axios({
                'url': '/project-types/get-all',
                'method': "GET",
                params: params
            }).then((res) => {
                this.projectTypes = res.data;
            }).catch((error) => {
                console.log(error);
            })
        },

        storeProjectType(record) {
            this.projectTypes.unshift(record);
        },

        updateProjectType(record) {
            const index = this.projectTypes.findIndex((item) => item.id === record.id);
            if(index != -1) {
                this.projectTypes[index] = record;
            }else {
                alert("Loại dự án không tồn tại");
            }
        },

        destroyProjectType(record) {
            const index = this.projectTypes.findIndex((item) => item.id === record.id);
            if(index != -1) {
                this.projectType.splice(index, 1);
            }else {
                alert("Loại dự án không tồn tại");
            }
        }
    }
})
