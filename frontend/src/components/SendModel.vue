<!-- @format -->

<template>
	<div class="modal-overlay" v-if="visible">
		<div class="modal-content">
			<slot></slot>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			visible: {
				type: Boolean,
				required: true,
			},
		},
	};
</script>

<style scoped>
	.modal-overlay {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.5);
		display: flex;
		justify-content: center;
		align-items: center;
		z-index: 1000;
	}
</style>
