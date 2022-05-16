export const BASE_URL = 'https://api.ngallery.pics' as const

export default function useApi<T extends {}>(endpoint: `/${string}`) {
	return useFetch<T>(`${BASE_URL}/api${endpoint}`, {
		credentials: 'same-origin',
		headers: {
			Accept: 'application/json',
		},
	})
}
