import { ServerResponse } from 'h3'
import { defineNuxtConfig } from 'nuxt'

// https://v3.nuxtjs.org/api/configuration/nuxt.config
export default defineNuxtConfig({
	nitro: {
		// 	prerender: {
		// 		routes: ['/login', '/register'],
		// 	},
		devHandlers: [
			{
				route: '/api',
				handler: (req: ServerResponse['req'], res: ServerResponse, next: Function) => {
					res.writeHead(301, {
						location: new URL(req.originalUrl, 'https://api.ngallery.pics').toString(),
					})
					res.end()
				},
			},
		],
	},
	// ssr: false,
	runtimeConfig: {
		app: {
			// baseURL: 'https://ngallery.pics',
		},
		apiURL: 'https://api.ngallery.pics',
	},
	experimental: {
		reactivityTransform: true,
	},
	modules: ['@nuxtjs/tailwindcss'],
	tailwindcss: {
		viewer: false,
	},
})
