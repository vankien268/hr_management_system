<script setup>
import { defineProps, ref, watch, onBeforeMount, onMounted, onUpdated, onBeforeUpdate } from 'vue'
const props= defineProps({
    idModal: String
})
// let modalNewId = ref('');
// onBeforeUpdate(() => {
//        modalNewId.value = props.idModal;
//        $('#'+ modalNewId.value).show('modal')
//         console.log("trc khi mounted", props.idModal ?'aaa' :'no')
// })
</script>

<template>
     <div class="modal fade" :id="idModal" tabindex="-1" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog modal-xl">
				<!--begin::Modal content-->
				<div class="modal-content rounded">
					<!--begin::Modal header-->
					<div class="modal-header justify-content-end border-0 pb-0">
						<!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<i class="ki-duotone ki-cross fs-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
						<!--end::Close-->
					</div>
					<!--end::Modal header-->
					<!--begin::Modal body-->
					<div class="modal-body pt-0 pb-15 px-5 px-xl-20">
                        <slot></slot>
					</div>
					<!--end::Modal body-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
</template>

<style></style>
