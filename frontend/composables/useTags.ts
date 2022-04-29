import { Tag } from '~~/interfaces/tag'
import useApi from './useApi'

export default async function useComments(galleryId: string) {
	const res = await useApi<Tag[]>(`/galleries/${galleryId}/tags`)
	return res.data.value
}
