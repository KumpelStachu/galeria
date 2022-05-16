<script setup lang="ts">
import { BASE_URL } from '~~/composables/useApi'

const router = useRouter()
const route = useRoute()

const galleryId = route.params.galleryId as string
const page = parseInt(route.params.page as string)

const gallery = await useGallery(galleryId)
const image = await usePage(galleryId, page)

function handleClick(e: PointerEvent) {
	const delta = e.pageX > window.innerWidth / 2 ? 1 : -1
	const nextPage = page + delta

	if (nextPage + 1 === 1 || nextPage - 1 === gallery.images.length) return

	router.push(`/g/${galleryId}/${nextPage}`)
}
</script>

<template>
	<div class="card compact 1h-[calc(100vh-6rem)] bg-neutral">
		<div class="card-body">
			<PageNav :gallery-id="gallery.id" :page="page" :images="gallery.images.length" />
			<img
				v-on:click="handleClick"
				class="w-full object-contains rounded-box bg-neutral-content"
				:src="`${BASE_URL}${image.file}`"
			/>
			<PageNav :gallery-id="gallery.id" :page="page" :images="gallery.images.length" />
		</div>
	</div>
</template>
