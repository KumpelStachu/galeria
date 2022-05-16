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
</script>

<template>
	<div class="card bg-neutral lg:card-side lg:grid lg:grid-cols-7">
		<figure class="col-span-3 overflow-hidden">
			<img
				class="aspect-[7/5] scale-125 bg-neutral-content hover:scale-100 hover:duration-1000"
				:class="{
					'blur-xl hover:blur-none transition-[filter,transform] hover:delay-500': gallery.nsfw,
					'transition-[transform]': !gallery.nsfw,
				}"
				:src="BASE_URL + images[0].file"
				:alt="gallery.title"
			/>
		</figure>
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
