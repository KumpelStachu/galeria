<script setup lang="ts">
definePageMeta({
	layout: 'auth',
})

const username = $ref('')
const password = $ref('')
let loading = $ref(false)
let error = $ref(null)

async function handleSubmit() {
	error = null
	loading = true

	const res = await $fetch('/api/login', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify({
			username,
			password,
		}),
	})
	console.log(res)

	loading = false
}
</script>

<template>
	<form v-on:submit.prevent="handleSubmit" class="card-body bg-neutral">
		<h2 class="card-title">Logowanie</h2>

		<div class="form-control w-full">
			<label for="username" class="label">
				<span class="label-text">Nazwa użytkownika</span>
			</label>
			<input
				:v-model="username"
				type="text"
				id="username"
				autocomplete="username"
				class="input input-bordered w-full"
				required
			/>
		</div>
		<div class="form-control w-full">
			<label for="password" class="label">
				<span class="label-text">Hasło</span>
			</label>
			<input
				:v-model="password"
				type="password"
				id="password"
				autocomplete="password"
				class="input input-bordered w-full"
				required
			/>
		</div>

		<div class="card-actions mt-3">
			<NuxtLink to="/register">
				<button role="button" class="btn btn-outline">Zarejestruj się</button>
			</NuxtLink>
			<button class="btn btn-primary">Zaloguj się</button>
		</div>
	</form>
</template>
