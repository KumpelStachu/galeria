export const BASE_URL = 'https://api.ngallery.pics'

export default function useApi<T extends {}>(endpoint: `/${string}`) {
	return useFetch<T>(`${BASE_URL}/api${endpoint}`, {
		headers: {
			Accept: 'application/json',
		},
	})
}
