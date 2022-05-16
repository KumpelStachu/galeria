<script setup lang="ts">
import { SearchIcon } from '@heroicons/vue/solid'

const route = useRoute()
const query = route.query.q as string
</script>

<template>
	<form action="/search" class="input-group">
		<input
			:value="query"
			type="text"
			class="grow sm:grow-0 sm:w-64 input input-bordered"
			placeholder="Szukaj..."
			name="q"
		/>
		<button type="submit" class="btn btn-square btn-secondary">
			<SearchIcon class="w-6 h-6" />
		</button>
	</form>
</template>
