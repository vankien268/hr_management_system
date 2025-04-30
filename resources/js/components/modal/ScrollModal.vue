<template>
    <div class="modal show">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered max-h-100" :class="props.size">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{
                            props.title
                        }}
                    </h4>

                    <div class="btn btn-icon btn-sm btn-active-light-primary btn-color-white ms-2" @click="closeModal()">
                        <i class="fa-solid fa-xmark fs-3"></i>
                    </div>
                </div>

                <div class="modal-body py-2">
                    <slot name="body"></slot>
                </div>

                <div class="modal-footer">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onBeforeMount, onBeforeUnmount } from 'vue'
const props = defineProps({
    title: {
        type: [String, Number],
        default: '',
    },
    size: {
        type: [String, Number],
        default: 'modal-xl',
    }
});

const emits = defineEmits(['close-modal']);

const closeModal = () => {
    emits('close-modal');
}

const componentMouted = () => {
    document.body.style.backgroundImage = "url('')";
    document.body.style.overflow = "hidden";
    document.body.style.paddingRight = "7px";
    document.body.classList.add("modal-open");
    document.body.setAttribute('data-bs-overflow', 'hidden');
    document.body.setAttribute('data-bs-padding-right', '7px');
}

const componentUnMouted = () => {
    console.log('... UnMounted...');
    document.body.style.removeProperty('background-image');
    document.body.style.removeProperty('overflow');
    document.body.style.removeProperty('padding-right');
    // document.body.style.overflow = null;
    // document.body.style.paddingRight = null;
    document.querySelector('body').classList.remove('modal-open');
    document.body.removeAttribute('data-bs-overflow');
    document.body.removeAttribute('data-bs-padding-right');
}

onBeforeMount(() => {
    componentMouted();
});

onBeforeUnmount(() => {
    componentUnMouted();
})

</script>
<style lang="scss" scoped>
.show {
    display: block;
    background-color: rgba(78, 78, 78, 0.692);
}

.modal-content {
    animation: loading 0.3s linear;
}

@keyframes loading {
    from {
        // transform: translateY(-10%);
        opacity: 0;
    }

    to {
        // transform: translateY(0);
        opacity: 1;
    }
}
</style>
