import { Route } from "react-router-dom"
import { Login } from "./pages/Login"
import { Home } from "./pages/Home"
import { MainRouter } from "./routers/MainRouter"

function App() {

  return (
    <MainRouter>

      <Route
        path="/"
        element={<Login />}
      />

      <Route
        path="/home"
        element={<Home />}
      />
    </MainRouter>
  )
}

export default App
