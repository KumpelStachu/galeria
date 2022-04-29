import { Comment } from '~~/interfaces/comment'
import useApi from './useApi'

export default async function useComments(galleryId: string) {
	const res = await useApi<Comment[]>(`/galleries/${galleryId}/comments`)
	return res.data.value
}
