<script setup lang="ts">
import { LoginIcon, PencilAltIcon } from '@heroicons/vue/outline'
import { UserCircleIcon } from '@heroicons/vue/solid'
import { dicebear } from '~/utils/dicebear'

const user = await useUser()
</script>

<template>
	<div class="dropdown dropdown-end">
		<label tabindex="0" class="p-1 overflow-hidden border-2 btn btn-circle btn-outline">
			<img v-if="user" :src="dicebear('user.username')" />
			<UserCircleIcon v-else />
		</label>
		<ul tabindex="0" class="p-2 mt-4 shadow menu dropdown-content bg-neutral rounded-box w-52">
			<template v-if="user">
				<li><NuxtLink href="/g/32">32</NuxtLink></li>
				<li><NuxtLink href="/g/34">34</NuxtLink></li>
			</template>
			<template v-else>
				<li>
					<NuxtLink href="/login"><LoginIcon class="w-6" />Logowanie</NuxtLink>
				</li>
				<li>
					<NuxtLink href="/register"><PencilAltIcon class="w-6" />Rejestracja</NuxtLink>
				</li>
			</template>
		</ul>
	</div>
</template>
