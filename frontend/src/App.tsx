import { Route, Router, Switch } from 'wouter'
import Navbar from './components/Navbar'
import Homepage from './pages/Homepage'
import NotFound from './pages/NotFound'

function App() {
	return (
		<Router>
			<Navbar />

			<Switch>
				<Route path="/" component={Homepage} />
				<Route path="/search" component={Homepage} />
				<Route path="/account" component={Homepage} />

				<Route path="/users" component={Homepage} />
				<Route path="/u/:userId" component={Homepage} />

				<Route path="/galleries" component={Homepage} />
				<Route path="/g/:galleryId" component={Homepage} />

				<Route path="/i/:imageId" component={Homepage} />

				<Route component={NotFound} />
			</Switch>
		</Router>
	)
}

export default App
