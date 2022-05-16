<script setup lang="ts">
import { BASE_URL } from '~~/composables/useApi'
import { Gallery } from '~~/interfaces/gallery'
import { Image } from '~~/interfaces/image'
import { Tag } from '~~/interfaces/tag'
import { getRelativeTime } from '~~/utils/date'

const { gallery, images, tags } = defineProps<{
	gallery: Gallery
	images: Image[]
	tags: Tag[]
}>()

const nsfw = useNsfw(onMounted, onUnmounted)
</script>

<template>
	<div class="card bg-neutral md:card-side md:grid md:grid-cols-7">
		<NuxtLink :href="`/g/${gallery.id}/1`" class="col-span-3 overflow-hidden">
			<img
				class="object-cover aspect-[7/5] scale-110 bg-neutral-content hover:scale-100 hover:duration-500 duration-200"
				:class="gallery.nsfw && !nsfw ? 'blur-xl hover:blur-none hover:delay-500' : 'blur-none'"
				:src="BASE_URL + images[0].file"
				:alt="gallery.title"
			/>
		</NuxtLink>
		<div class="col-span-4 card-body">
			<h2 class="card-title">{{ gallery.title }}</h2>
			<div class="flex flex-wrap gap-2 mt-3">
				<NuxtLink :to="`/g/${gallery.id}`" class="badge badge-outline whitespace-nowrap">
					<span class="opacity-50">#</span>
					{{ gallery.id }}
				</NuxtLink>
				<NuxtLink v-for="tag in tags" :to="`/tag/${tag['id']}`" class="badge badge-outline whitespace-nowrap">
					{{ tag.name }}
				</NuxtLink>
			</div>
			<span>{{ gallery.images.length }} zdjęć</span>
			<span>Dodano {{ getRelativeTime(new Date(gallery.createdAt)) }}</span>
		</div>
	</div>
</template>
