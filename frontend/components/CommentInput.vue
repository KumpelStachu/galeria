<script setup lang="ts">
const user = await useUser()
console.log('user', process.server, user)
</script>

<template>
	<div v-if="user" class="">
		<input type="text" placeholder="Napisz komentarz..." />
	</div>
	<slot v-else></slot>
</template>
