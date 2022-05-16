<script setup lang="ts">
import {
	ChevronDoubleLeftIcon,
	ChevronLeftIcon,
	ChevronRightIcon,
	ChevronDoubleRightIcon,
} from '@heroicons/vue/solid'

defineProps<{
	galleryId: string | number
	images: number
	page: number
}>()
</script>

<template>
	<div class="flex justify-center gap-3" :ref="(e?: Element) => e?.scrollIntoView()">
		<a :href="`/g/${galleryId}/1`" class="p-1 btn btn-square btn-sm" :class="{ invisible: page <= 1 }">
			<ChevronDoubleLeftIcon />
		</a>
		<a
			:href="`/g/${galleryId}/${page - 1}`"
			class="p-1 btn btn-square btn-sm"
			:class="{ invisible: page <= 1 }"
		>
			<ChevronLeftIcon />
		</a>
		<a :href="`/g/${galleryId}`" class="btn btn-sm">{{ page }}/{{ images }}</a>
		<a
			:href="`/g/${galleryId}/${page + 1}`"
			class="p-1 btn btn-square btn-sm"
			:class="{ invisible: page >= images }"
		>
			<ChevronRightIcon />
		</a>
		<a
			:href="`/g/${galleryId}/${images}`"
			class="p-1 btn btn-square btn-sm"
			:class="{ invisible: page >= images }"
		>
			<ChevronDoubleRightIcon />
		</a>
	</div>
</template>
