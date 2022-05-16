<script setup lang="ts">
import { BASE_URL } from '~~/composables/useApi'
import { Gallery } from '~~/interfaces/gallery'

const { gallery } = defineProps<{
	gallery: Gallery
}>()

const nsfw = useNsfw(onMounted, onUnmounted)

const PAGE_SIZE = 15
let loadCount = $ref(PAGE_SIZE)
</script>

<template>
	<div class="card compact bg-neutral">
		<div class="grid grid-cols-1 gap-3 card-body sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
			<NuxtLink
				v-for="(image, page) in gallery.images.slice(0, loadCount)"
				class="flex flex-1 overflow-hidden rounded-lg bg-neutral aspect-[7/5]"
				:href="`/g/${gallery.id}/${page + 1}`"
			>
				<img
					:src="`${BASE_URL}${image}/file`"
					class="object-cover scale-[115%] transition-[filter,transform] aspect-[7/5] bg-neutral-content hover:scale-100 hover:delay-250 hover:duration-500"
					:class="gallery.nsfw && !nsfw ? 'blur-xl hover:blur-none' : 'blur-none'"
				/>
			</NuxtLink>
			<div class="flex justify-center gap-3 col-span-full" v-if="loadCount <= gallery?.images.length">
				<button class="btn btn-outline btn-block sm:btn-wide" v-on:click="loadCount += PAGE_SIZE">
					Załaduj więcej ({{ loadCount }}/{{ gallery?.images.length }})
				</button>
				<button class="btn btn-outline btn-block sm:btn-wide" v-on:click="loadCount = Infinity">
					Załaduj wszystkie
				</button>
			</div>
		</div>
	</div>
</template>
