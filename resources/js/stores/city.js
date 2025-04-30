import { defineStore } from "pinia";
import axios from "axios";

export const useCity = defineStore('city', {
    state:()=> ({
        cities: []
    }),
    actions: {
        getCityData() {
            axios.get('/api/cities')
            .then(res => {
                const { data } = res.data;
                this.cities = data;
            }).catch((error) => {
                console.log(error);
            })
        }
    }
});
