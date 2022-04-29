<script setup lang="ts">
import { BASE_URL } from '~~/composables/useApi'
import { getRelativeTime } from '~~/utils/date'

const route = useRoute()
const galleryId = route.params.galleryId as string

const gallery = await useGallery(galleryId)
const comments = await useComments(galleryId)
const images = await useImages(galleryId)
const tags = await useTags(galleryId)

const PAGE_SIZE = 15
let loadCount = $ref(PAGE_SIZE)
</script>

<template>
	<div class="space-y-6">
		<div class="card bg-neutral lg:card-side lg:grid lg:grid-cols-7">
			<figure class="col-span-3 overflow-hidden">
				<img
					class="scale-125 hover:scale-100 hover:duration-1000"
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
					<NuxtLink :to="`/g/${galleryId}`" class="badge badge-outline whitespace-nowrap">
						<span class="opacity-50">#</span>
						{{ galleryId }}
					</NuxtLink>
					<NuxtLink
						v-for="tag in tags"
						:to="`/tag/${tag['id']}`"
						class="badge badge-outline whitespace-nowrap"
					>
						{{ tag.name }}
					</NuxtLink>
				</div>
				<span>{{ gallery.images.length }} zdjęć</span>
				<span>Dodano {{ getRelativeTime(new Date(gallery.createdAt)) }}</span>
			</div>
		</div>

		<div class="card compact bg-neutral">
			<div
				class="grid grid-cols-1 gap-3 card-body sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5"
			>
				<NuxtLink
					v-for="(image, page) in gallery.images.slice(0, loadCount)"
					class="flex flex-1 overflow-hidden rounded-lg"
					:to="`/g/${galleryId}/${page + 1}`"
				>
					<img
						:src="`${BASE_URL}${image}/file`"
						class="object-cover scale-125 hover:scale-100 hover:delay-250 hover:duration-500"
						:class="{
							'blur-xl hover:blur-none transition-[filter,transform]': gallery.nsfw,
							'transition-[transform]': !gallery.nsfw,
						}"
					/>
				</NuxtLink>
				<div class="flex justify-center gap-3 col-span-full" v-if="loadCount <= gallery.images.length">
					<button class="btn btn-outline btn-block sm:btn-wide" v-on:click="loadCount += PAGE_SIZE">
						Załaduj więcej ({{ loadCount }}/{{ gallery.images.length }})
					</button>
					<button class="btn btn-outline btn-block sm:btn-wide" v-on:click="loadCount = Infinity">
						Załaduj wszystkie
					</button>
				</div>
			</div>
		</div>

		<div class="card bg-neutral">
			<div class="card-body">
				<h2 class="card-title">Komentarze ({{ gallery.comments.length }})</h2>

				<div class="my-2">
					<NuxtLink to="/login" class="link">Zaloguj się</NuxtLink>
					<span> lub </span>
					<NuxtLink to="/register" class="link">zarejestruj się</NuxtLink>
					<span>, aby móc komentować.</span>
				</div>

				<div
					v-for="comment in comments"
					class="flex items-center p-2 leading-none rounded-lg bg-base-100 max-w-max"
				>
					<NuxtLink :to="`/user/${comment.profile.split('/').pop()}`">
						<button class="mr-2 overflow-hidden btn btn-square">
							<img
								:src="`https://avatars.dicebear.com/api/pixel-art-neutral/${comment.profile
									.split('/')
									.pop()}.svg`"
								:alt="comment.profile.split('/').pop()"
							/>
						</button>
					</NuxtLink>
					<span>{{ comment.content }}</span>
				</div>
			</div>
		</div>
	</div>
</template>
