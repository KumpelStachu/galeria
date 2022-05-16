<script setup lang="ts">
const route = useRoute()
const galleryId = route.params.galleryId as string

const comments = await useComments(galleryId)
const gallery = await useGallery(galleryId)
const images = await useImages(galleryId)
const tags = await useTags(galleryId)
</script>

<template>
	<div class="space-y-6">
		<GalleryHeader :gallery="gallery" :images="images" :tags="tags" />
		<GalleryDetails :gallery="gallery" />
		<GalleryComments :gallery="gallery" :comments="comments" />
	</div>
</template>
