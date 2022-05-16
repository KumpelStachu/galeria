<script setup lang="ts">
let nsfw = $ref<boolean>(localStorage.nsfw === 'true')

watchEffect(() => {
	const event = new Event('storage')
	localStorage.nsfw = nsfw
	window.dispatchEvent(event)
})
</script>

<template>
	<button
		v-on:click="nsfw = !nsfw"
		class="font-bold btn btn-square btn-outline"
		:class="nsfw ? 'btn-error' : 'btn-success blur-[2px] hover:blur-none transition duration-300 delay-100'"
	>
		nsfw
	</button>
</template>
