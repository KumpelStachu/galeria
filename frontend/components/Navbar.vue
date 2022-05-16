<script setup lang="ts">
import { UserCircleIcon } from '@heroicons/vue/solid'
</script>

<template>
	<div class="1sticky top-2 mt-2 z-10">
		<div class="navbar bg-neutral rounded-box">
			<div class="flex-1">
				<NuxtLink to="/">
					<button class="btn normal-case">nGallery</button>
				</NuxtLink>
			</div>
			<div class="flex-none">
				<button class="btn btn-circle btn-ghost">
					<UserCircleIcon class="w-8" />
				</button>
			</div>
		</div>
	</div>
</template>
