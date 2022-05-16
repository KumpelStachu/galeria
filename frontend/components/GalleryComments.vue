<script setup lang="ts">
import { Comment } from '~~/interfaces/comment'
import { Gallery } from '~~/interfaces/gallery'

const { gallery } = defineProps<{
	comments: Comment[]
	gallery: Gallery
}>()

const next = $computed(() => `?next=/g/${gallery.id}/#comments`)
</script>

<template>
	<div class="card bg-neutral">
		<div class="card-body" id="comments">
			<h2 class="card-title">Komentarze ({{ gallery?.comments.length }})</h2>

			<ClientOnly>
				<CommentInput>
					<div class="my-2">
						<NuxtLink :to="`/login${next}`" class="link">Zaloguj się</NuxtLink>
						<span> lub </span>
						<NuxtLink :to="`/register${next}`" class="link">zarejestruj się</NuxtLink>
						<span>, aby móc komentować.</span>
					</div>
				</CommentInput>
			</ClientOnly>

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
</template>
