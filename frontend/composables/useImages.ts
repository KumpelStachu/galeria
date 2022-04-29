import { Image } from '~~/interfaces/image'
import useApi from './useApi'

export default async function useImages(galleryId: string) {
	const res = await useApi<Image[]>(`/galleries/${galleryId}/images`)
	return res.data.value
}
