<script setup lang="ts">
import { HomeIcon } from '@heroicons/vue/solid'

const route = useRoute()
const sticky = route.params.page === undefined
</script>

<template>
	<div class="z-10 mt-2 shadow top-2" :class="{ sticky }">
		<div class="flex-wrap shadow sm:flex-nowrap navbar bg-neutral rounded-box">
			<div class="navbar-start">
				<NuxtLink to="/">
					<button class="btn btn-square sm:hidden">
						<HomeIcon class="w-7" />
					</button>
					<button class="hidden normal-case btn sm:block">nGallery</button>
				</NuxtLink>
				<NavbarSearch class="hidden sm:flex" />
			</div>

			<div class="gap-2 navbar-end">
				<ClientOnly>
					<NsfwToggle />
					<NavbarUser />
				</ClientOnly>
			</div>

			<NavbarSearch class="w-full mt-2 sm:hidden" />
		</div>
	</div>
</template>
