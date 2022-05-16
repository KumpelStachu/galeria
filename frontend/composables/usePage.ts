import { Image } from '~~/interfaces/image'
import useApi from './useApi'

export default async function usePage(galleryId: string, page: string | number = 1) {
	const res = await useApi<[Image]>(`/galleries/${galleryId}/images?items=1&page=${page}`)
	return res.data.value[0]
}
