import { initializeIcons } from '@fluentui/font-icons-mdl2'
import { createTheme, ThemeProvider } from '@fluentui/react'
import React from 'react'
import ReactDOM from 'react-dom'
import '../styles/global.css'
import App from './App'

const myTheme = createTheme({
	palette: {
		themePrimary: '#c29f9f',
		themeLighterAlt: '#080606',
		themeLighter: '#1f191a',
		themeLight: '#3a3030',
		themeTertiary: '#745f60',
		themeSecondary: '#ab8c8c',
		themeDarkAlt: '#c8a8a8',
		themeDark: '#d0b4b4',
		themeDarker: '#ddc6c7',
		neutralLighterAlt: '#323130',
		neutralLighter: '#31302f',
		neutralLight: '#2f2e2d',
		neutralQuaternaryAlt: '#2c2b2a',
		neutralQuaternary: '#2a2928',
		neutralTertiaryAlt: '#282726',
		neutralTertiary: '#c8c8c8',
		neutralSecondary: '#d0d0d0',
		neutralPrimaryAlt: '#dadada',
		neutralPrimary: '#ffffff',
		neutralDark: '#f4f4f4',
		black: '#f8f8f8',
		white: '#323130',
	},
})

initializeIcons()

ReactDOM.render(
	<React.StrictMode>
		<ThemeProvider theme={myTheme} className="h-screen">
			<App />
		</ThemeProvider>
	</React.StrictMode>,
	document.getElementById('root')
)
