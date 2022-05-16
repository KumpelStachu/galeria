<script setup lang="ts">
import { BASE_URL } from '~~/composables/useApi'
import { Gallery } from '~~/interfaces/gallery'

const { gallery } = defineProps<{
	gallery: Gallery
}>()

// const tags = await useTags(gallery.id)
const nsfw = useNsfw(onMounted, onUnmounted)
</script>

<template>
	<div class="card card-compact">
		<NuxtLink :href="`/g/${gallery.id}`" class="overflow-hidden bg-neutral-content aspect-[7/4]">
			<img
				class="object-cover w-full h-full transition-[filter]"
				:src="`${BASE_URL}${gallery.images[0]}/file`"
				:class="gallery.nsfw && !nsfw ? 'blur-xl hover:blur-none' : 'blur-none'"
			/>
		</NuxtLink>
		<div class="card-body bg-neutral">
			<NuxtLink :href="`/g/${gallery.id}`" class="card-title link-hover">{{ gallery.title }}</NuxtLink>
			<!-- <div class="flex flex-wrap gap-2 whitespace-nowrap">
				<NuxtLink v-for="tag in tags" :href="`/tag/${tag.id}`" class="badge badge-outline">
					{{ tag.name }}
				</NuxtLink> 
			</div> -->
		</div>
	</div>
</template>
