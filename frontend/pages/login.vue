<script setup lang="ts">
definePageMeta({
	layout: 'auth',
})

const router = useRouter()
const route = useRoute()

const form = $ref({ username: 'szyszka', password: 'szyszka' })
let loading = $ref(false)
let error = $ref(false)

async function handleSubmit() {
	error = null
	loading = true

	try {
		const { token } = await $fetch<{ token: string }>(`${BASE_URL}/api/token`, {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: form,
		})

		localStorage.token = token
		console.log(route.fullPath.slice(12))
		router.push(route.fullPath.slice(12) || '/')
	} catch (_) {
		error = true
	}

	loading = false
}

watch([form], () => (error = false), { deep: true })
</script>

<template>
	<form v-on:submit.prevent="handleSubmit" class="card-body bg-neutral">
		<h2 class="card-title">Logowanie</h2>

		<div class="w-full form-control">
			<label v-if="error" class="label">
				<span class="label-text text-error">Nie udało się zalogować.</span>
			</label>

			<label for="username" class="label">
				<span class="label-text">Nazwa użytkownika</span>
			</label>
			<input
				v-model="form.username"
				v-on:click="error = false"
				type="text"
				id="username"
				autocomplete="username"
				class="w-full input input-bordered"
				required
			/>
		</div>
		<div class="w-full form-control">
			<label for="password" class="label">
				<span class="label-text">Hasło</span>
			</label>
			<input
				v-model="form.password"
				v-on:click="error = false"
				type="password"
				id="password"
				autocomplete="password"
				class="w-full input input-bordered"
				required
			/>
		</div>

		<div class="mt-3 card-actions">
			<NuxtLink to="/register">
				<input type="button" class="btn btn-outline" :class="{ loading }" value="Zarejestruj się" />
			</NuxtLink>
			<input type="submit" class="btn btn-primary" :class="{ loading }" value="Zaloguj się" />
		</div>
	</form>
</template>
