import { Profile } from '~~/interfaces/profile'

export default async function useUser(): Promise<Profile | null> {
	const res = await useApi<Profile>(`/profiles/me`).catch<null>(() => null)
	return res.data.value
}
