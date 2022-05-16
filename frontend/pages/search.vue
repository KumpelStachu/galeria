<script setup lang="ts">
const PAGE_SIZE = 15 as const

const route = useRoute()
const query = route.query.q as string

let loading = $ref(false)
let page = $ref(1)

const galleries = await useSearch(query, page)

onMounted(() => addEventListener('scroll', listener, { passive: true }))
onUnmounted(() => removeEventListener('scroll', listener))

let grid = $ref<HTMLDivElement>()

async function listener() {
	if (loading || window.scrollY + window.innerHeight < grid.clientHeight + grid.offsetTop) return

	page++
	loading = true

	const next = await useSearch(query, page)
	galleries.push(...next)

	loading = false

	if (next.length !== PAGE_SIZE) removeEventListener('scroll', listener)
}
</script>

<template>
	<div ref="grid" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
		<GalleryCard v-for="gallery in galleries" :gallery="gallery" />
		<button v-if="loading" class="btn btn-lg btn-accent col-span-full loading"></button>
	</div>
</template>
