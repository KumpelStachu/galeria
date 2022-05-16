export default function useNsfw(onMounted: Function, onUnmounted: Function) {
	const v = ref<boolean>(false)

	const listener = () => (v.value = localStorage.nsfw === 'true')

	onMounted(() => {
		v.value = localStorage.nsfw === 'true'

		addEventListener('storage', listener)
	})

	onUnmounted(() => removeEventListener('storage', listener))

	return v
}
