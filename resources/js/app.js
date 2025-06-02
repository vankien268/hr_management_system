import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
import { createPinia } from 'pinia';
import globalComponent from './importglobalcomponents/import-component.js';
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import { msgOffline, msgOnline } from './helper/toastMessage';
import print from 'vue3-print-nb';
import VueFileAgentNext from '@boindil/vue-file-agent-next'

import '@boindil/vue-file-agent-next/dist/vue-file-agent-next.css'


const app = createApp({});
const pinia = createPinia();
app.component('flat-pickr', flatPickr)
app.use(pinia);
app.use(print);
app.use(VueFileAgentNext);
Object.entries(globalComponent).forEach(([name, component]) => {
    app.component(name, component);
})

app.directive('click-outside', {
    mounted(el, binding, vnode) {
        el.clickOutsideEvent = function (event) {
            if (!(el === event.target || el.contains(event.target))) {
                binding.value(event, el);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent);
    },
    unmounted(el) {
        document.body.removeEventListener('click', el.clickOutsideEvent);
    }
});

app.mount('#admin');


window.addEventListener('online', () => {
    console.log('online');
    document.body.classList.add("show-toast-connect");
    document.querySelector('body').classList.remove('show-toast-disconnect');
    setTimeout(function(){ document.querySelector('body').classList.remove('show-toast-connect');; }, 3000);
    // msgOnline('Kết nối internet được khôi phục.')
});
window.addEventListener('offline', () => {
    console.log('offline');
    document.body.classList.add("show-toast-disconnect");
    document.querySelector('body').classList.remove('show-toast-connect');
    // msgOffline('Không có kết nối internet.')
});
