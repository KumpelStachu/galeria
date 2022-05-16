import { Gallery } from '~~/interfaces/gallery'
import useApi from './useApi'

export default async function useSearch(query?: string, page = 1) {
	const res = await useApi<Gallery[]>(
		`/galleries?page=${page}&${
			query
				? query
						.split(' ')
						.map(q => `tags.name=${q}`)
						.join('&')
				: ''
		}`
	)
	return res.data.value
}
