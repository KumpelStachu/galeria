export interface Profile {
	id?: string
	username?: string
	description?: string
	galleries?: string[]
	comments?: string[]
	readonly createdAt?: Date
	readonly roles?: any
}
