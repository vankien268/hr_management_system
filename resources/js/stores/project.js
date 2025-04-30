import { defineStore } from "pinia";
import axios from "axios";

export const useStoreProjects = defineStore('useStoreProjects', {
    state: () => ({
        projects: {
            data: [],
            getMetaPaginate: null,
            permissionProjects: []
        },
        projectNew: [],
        loading: false,
    }),
    actions: {
        getAllProjectsData(params = null) {
            this.loading = true;
            axios({
                'url': '/projects/get-all',
                'method': "GET",
                params: params
            }).then((res) => {
                // console.log(res.data);
                const { data, meta, permissionProjects} = res.data;

                this.projects = data;
                this.projectNew = this.projects
                this.getMetaPaginate = meta;
                this.projects.permissionProjects = permissionProjects
            }).catch((error) => {
                console.log(error);
            }).finally(() => {
                this.loading = false;
            })
        },

        storeProject(record) {
            this.projects.unshift(record);
        },

        updateProject(record) {
            const index = this.projects.findIndex((item) => (item.id == record.id));
            if(index != -1) {
                this.projects[index] = record;
            }else {
                alert("Dự án không tồn tại");
            }
        },

        destroyProject(record) {
            const index = this.projects.findIndex((item) => (item.id == record.id));
            if(index != -1) {
                this.projects.splice(index, 1);
            }else {
                alert("Dự án không tồn tại");
            }
        }
    }
})

export const formFieldProject =  {
        project: {
            data: [
                {
                    code: "",
                    name: "",
                    customer_id: null,
                    city_id: null,
                    status_id: null,
                    description: "",
                    project_type_id: null
                }
            ]
        },
        contact: {
           data: [
            {
                name: "",
                phone:"",
                email: "",
                position: "",
                note: "",
                status: 1
            }
           ]
        },
        user: {
           data: [
                {
                    user_id: null,
                    note: null
                }
           ]
        }
}

