import { Profile } from '~~/interfaces/profile'

export default async function useUser(): Promise<Profile | null> {
	if (process.server) return null

	try {
		const res = await useApi<Profile>('/profiles/me')
		return res.data.value
	} catch (_) {
		return null
	}
}
