import { Gallery } from '~~/interfaces/gallery'
import useApi from './useApi'

export default async function useGallery(galleryId: string) {
	const res = await useApi<Gallery>(`/galleries/${galleryId}`)
	return res.data.value
}
