export interface Gallery {
	id?: string
	title?: string
	nsfw?: boolean
	profile?: string
	images?: string[]
	comments?: string[]
	tags?: string[]
	readonly createdAt?: Date
}
